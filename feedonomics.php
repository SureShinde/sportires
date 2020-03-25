<?php
/*
Copyright 2019 Feedonomics.com

This script will output CSV from a Magento2 website.

// See knowledge base for instructions for this version.

API Endpoint:
http://{yoursite}.com/..../{this_file_name}.php?auth_token=dmgh42Dj29dushth3gwkhD&mode=pull&filters={url-encoded_filters_json}&attributes={comma-separated_attribute_codes}
*/


$script_version = "4.0.9";


////////////////
// Cross Origin Request Validation - OPTIONS request preflights
////////////////
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: accept, origin, x-requested-with, content-type");


////////////////
// PHP and request settings
////////////////

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Set time out in seconds
// 30 minutes;
set_time_limit(30 * 60);


////////////////
// Script settings - global / logical
////////////////
$valid_auth_token = 'dmgh42Dj29dushth3gwkhD';
$platform = 'magento2';
$php_version = phpversion();


// $delimiter = ',';
// $enclosure_char = '"'; 
// $escape_char = "\\";

$impl_expl_char = ',';

$page_size = 100;

//////////////// Required GET params applicable to all modes ////////////////

// auth_token

if(isset($_GET['get_value_ids'])) {
	$get_value_ids = true;
}
else {
	$get_value_ids = false;
}

if (!isset($_GET['auth_token'])
	|| $_GET['auth_token'] !== $valid_auth_token)
{
	
	$response_bad = array(
		'success' => false,
		'message' => "Invalid auth_token",
		'data' => array(),
	);
	echo json_encode($response_bad);
	die;
}

// mode

$valid_modes = array(
	'info',
	'pull',
	'bundle_combinations_pull',
	'super_pull',
);
// require mode in query params
if ( !isset($_GET['mode']) ) {
	
	$response_bad = array(
		'success' => false,
		'message' => "Invalid mode",
		'data' => array(
			'allowed modes' => $valid_modes,
		),
	);
	echo json_encode($response_bad);
	die;
}
$mode = $_GET['mode'];
// validate
if (!in_array($mode, $valid_modes)) {
	
	$response_bad = array(
		'success' => false,
		'message' => "Invalid mode",
		'data' => array(
			'attempted_mode' => $mode,
			'valid_modes' => $valid_modes,
		),
	);
	echo json_encode($response_bad);
	die;
}

//////////////// Filters and Attributes Data - applicable to all modes ////////////////
// Filters

if ( !isset($_GET['filters']) ) {
	
	$response_bad = array(
		'success' => false,
		'message' => "Filters required",
		'data' => array(),
	);
	echo json_encode($response_bad);
	die;
}

$filters = json_decode($_GET['filters'], true);
if ($filters == false) {
	
	$response_bad = array(
		'success' => false,
		'message' => "Invalid filters",
		'data' => array(
			'attempted_filters' => $_GET['filters'],
		),
	);
	echo json_encode($response_bad);
	die;
}

// Attributes

if ( !isset($_GET['attributes']) ) {
	
	$response_bad = array(
		'success' => false,
		'message' => "attributes required",
		'data' => array(),
	);
	echo json_encode($response_bad);
	die;
}
$attributes = explode(',', $_GET['attributes']);
if ($attributes == false) {
	
	$response_bad = array(
		'success' => false,
		'message' => "Invalid attributes",
		'data' => array(),
	);
	echo json_encode($response_bad);
	die;
}

$valid_attributes = array();
$duplicate_attributes = array();
foreach($attributes as $attribute){
	if(!array_key_exists($attribute, $valid_attributes)){
		$valid_attributes[$attribute] = '';
	} else {
		$duplicate_attributes[] = $attribute;
	}
}
if(count($duplicate_attributes) > 0){
	
	$response_bad = array(
		'success' => false,
		'message' => "duplicate attributes: ",
		'data' => $duplicate_attributes,
	);
	echo json_encode($response_bad);
	die;
}
// fail early for problematic special attributes
// bundle_details expands to :
$bundle_details_for_parents_column_names = array(
	'bundle_family_tree',
	'bundle_min_price',
	'bundle_max_price',
	'bundle_parent_price',
	'bundle_parent_weight',
);
$bundle_details_for_children_column_names = array(
	'bundle_entity_ids',
	'bundle_option_id',
	'bundle_option_name',
	'bundle_option_type',
	'bundle_option_position',
	'bundle_option_selection_id',
	'bundle_option_selection_quantity',
	'bundle_option_selection_position',
	'bundle_selection_price_for_aggregation',
	'bundle_selection_weight_for_aggregation',
);
//validate
if ( array_intersect($bundle_details_for_parents_column_names,$attributes)) {
	
	$response_bad = array(
		'success' => false,
		'message' => "Invalid attribute(s)",
		'data' => array(
			'explanation' => "invalid bundle-related attribute_code attempted. Use bundle_details_for_parents instead",
			'disallowed'	=> implode(',', $bundle_details_for_parents_column_names),
		),
	);
	echo json_encode($response_bad);
	die;
}
//validate
if ( array_intersect($bundle_details_for_children_column_names,$attributes)) {
	
	$response_bad = array(
		'success' => false,
		'message' => "Invalid attribute(s)",
		'data' => array(
			'explanation' => "invalid bundle-related attribute_code attempted. Use bundle_details_for_children",
			'disallowed'	=> implode(',', $bundle_details_for_children_column_names),
		),
	);
	echo json_encode($response_bad);
	die;
}


$parent_types = array(
	'configurable',
	'grouped',
	'bundle',
);
$parent_types_flipped = array_flip($parent_types);

$children_types = array(
	'simple',
	'downloadable',
	'virtual',
);
$children_types_flipped = array_flip($children_types);


////////////////
// Dynamically find and assign magento base directory
////////////////
$magento_root_dir = find_magento_root_dir();
if ( $magento_root_dir == false ) {
	
	$response_bad = array(
		'success' => false,
		'message' => "Improper base directory. Place script in another directory underneath the magento root driectory.",
		'data' => array(),
	);
	echo json_encode($response_bad);
	die;
}
define('MAGENTO_ROOT', $magento_root_dir);

function find_magento_root_dir() {
	// The final base_location should look like:
	// '/var/stores/yourstorename/site/store'
	$dir = __DIR__;

	$max_dir_tries = 20;
	$dir_tries = 0;
	do {
		$dir_tries++;
		
		// set magento root if parent folder of 'app' folder

		$dir_app = $dir . '/app';
		if ( is_dir($dir_app) ) {
			return $dir;
			break;
		}
		
		// Trim off leaf folder for next run
		
		$explosion = explode('/', $dir);
		array_pop($explosion);
		$dir = implode('/', $explosion);
	}
	while ( !empty($dir) && $dir_tries<$max_dir_tries );
	
	// bad if didn't find and return from the loop
	return false;
}

//////////////// Require files ////////////////
use Magento\Framework\App\Bootstrap;

$mage_file_name = MAGENTO_ROOT . '/app/bootstrap.php';
require_once $mage_file_name;

global $objectManager;

$bootstrap = Bootstrap::create(BP, $_SERVER);

// Set object manager. I guess the equivalent of this in Magento 1 is "Mage::getModel()"
$objectManager = $bootstrap->getObjectManager();

// Important to set areacode to admin.
$state = $objectManager->get('\Magento\Framework\App\State');

// Load proper area code
try {
	$state->setAreaCode('adminhtml');
} catch(Exception $ex) {
	echo json_encode(array('success' => false, 'message' => 'error', 'value' => array('message' => 'error setting Magento 2 area code (technical)')));	
	die;
}

// Decalre the Magento core codes objects. If created in class, this will be the ones in the "_construct" function
$storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

//////////////// Functions ////////////////
/**
*
* @param 
* @return 
*/
function fput_delimited($fp, $fields, $delimiter=',', $enclosure='"', $escape_char='"', $strip_characters=array()) {
	// Remove strip_characters
	if ($strip_characters!=array()) {
		$fields = str_replace($strip_characters, '', $fields);
	}

	// Escape enclosure/escape_char with the escape_char
	if ($enclosure!='') {
		$enclosure_esc = preg_quote($enclosure, '#');
		$escape_char_esc = preg_quote($escape_char, '#');

		// Backslashes need to be escaped in the preg_replace replacement parameter
		$replace_escape = '';
		if ($escape_char=='\\') {
			$replace_escape='\\';
		}

		// Add the enclosure character to the beginning and end of every field
		foreach ($fields as &$field) {
			if ($field!='') {
				$field =
					$enclosure
					. preg_replace("#([{$enclosure_esc}{$escape_char_esc}])#", $replace_escape.$escape_char.'$1', $field)
					. $enclosure;
			}
		}
	}

	// Write
	fwrite($fp, implode($delimiter,$fields) . "\n");
}

/**
*
* @param 
* @return 
*/
function validate_and_assign_params($allowed_filters_schema, $filters) {
	$return = array();
	
	// loop over allowed filter configs and use to validate provided filter configs
	foreach ($allowed_filters_schema as $filter_name => $filter_configs) {
		////////////////
		// Handle required, whitelisted
		////////////////
		// stop if required and not set
		if ( $filter_configs['required'] == true ) {
			if ( !isset($filters[$filter_name]) ) {
				
				$response_bad = array(
					'success' => false,
					'message' => "Required filter was not valid.",
					'data' => array(
						'attempted_filters' => $filters,
						'required_filter' => $filter_name,
					),
				);
				echo json_encode($response_bad);
				die;
			}
		}
		// skip if optional and not set
		else {
			if ( !isset($filters[$filter_name]) ) {
				continue;
			}
		}
		
		// cache the provided value
		
		$value = $filters[$filter_name];
		
		//////////////// Handle as array ////////////////
		// normalize to array, assuming value is not array, so that it is compatible with element validation loop below.
		$array_required = $filter_configs['array_required'];
		if ($array_required) {
			// Dumbly explodes on comma if required to be an array.
			// Doing it the dumb way bypasses making sure the received JSON is a nested array
			$value_normalized = explode(',', $value);
		} else {
			$value_normalized = array($value);
		}
		
		// validate by specified restricted configs
		
		$values_validated = array();
		
		$validation_config = $filter_configs['validation'];
		
		// apply each validation requirements (usually only one)
		// to each value element
		foreach ($value_normalized as $k_vnc => $val_norm_ele) {
			
			if ( isset($validation_config['type']) ) {
				$options_config = $validation_config['type'];
				
				// specific type handling.
				if ($options_config == 'integer') {
					$val_norm_ele = filter_var($val_norm_ele, FILTER_VALIDATE_INT);
					if ($val_norm_ele===false) {
						
						$response_bad = array(
							'success' => false,
							'message' => "Filter was not valid.",
							'data' => array(
								'explanation' => 'failed type validation',
								'expected_type' => FILTER_VALIDATE_INT,
								'attempted_filter' => $filter_name,
								'attempted_filter_value' => $val_norm_ele,
							),
						);
						echo json_encode($response_bad);
						die;
					}
				}
				elseif ($options_config == 'string') {
					
				}
				// generic type handling catchall. (may be redundant);
				else { 
					$type = gettype($val_norm_ele);
					
					if ( $type != $options_config ) {
						
						$response_bad = array(
							'success' => false,
							'message' => "Filter was not valid.",
							'data' => array(
								'explanation' => 'value was invalid type',
								'expected_format' => $options_config,
								'attempted_filter' => $filter_name,
								'attempted_filter_value' => $val_norm_ele,
								'attempted_type' => $type,
							),
						);
						echo json_encode($response_bad);
						die;
					}
				}
				
			}
			elseif ( isset($validation_config['regex']) ) {
				$options_config = $validation_config['regex'];
				
				// value must fit the regex
				if ( preg_match($options_config, $val_norm_ele) !== 1) {
					
					$response_bad = array(
						'success' => false,
						'message' => "Filter was not valid.",
						'data' => array(
							'explanation' => 'value did not match regex',
							'expected_format' => $options_config,
							'attempted_filter' => $filter_name,
							'attempted_filter_value' => $val_norm_ele,
						),
					);
					echo json_encode($response_bad);
					die;
				}
			}
			elseif ( isset($validation_config['enumerated']) ) {
				$options_config = $validation_config['enumerated'];
				
				if ( !in_array($val_norm_ele, $options_config) ) {
					
					$response_bad = array(
						'success' => false,
						'message' => "Filter was not valid.",
						'data' => array(
							'explanation' => 'value was not whitelisted',
							'expected_format' => $options_config,
							'attempted_filter' => $filter_name,
							'attempted_filter_value' => $val_norm_ele,
						),
					);
					echo json_encode($response_bad);
					die;
				}
			}
			else { 
				
				$response_bad = array(
					'success' => false,
					'message' => "Filter was not valid.",
					'data' => array(
						'explanation' => 'something went wrong horribly. param config was not set',
						'expected_format' => $options_config,
					),
				);
				echo json_encode($response_bad);
				die;
			}
			
			// override value if transformed during validation
			// WARNING  potential order-dependent bug if multiple validation conditions need to be applied to a single field
			$values_validated[$k_vnc] = $val_norm_ele;
		} // end foreach element

		// de-arrayify values that the shcmea specified as non-array
		if ( !$array_required && count($values_validated) ) {
			$values_validated = $values_validated[0];
		}
		
		// append validated field to return list
		$return[$filter_name] = $values_validated;
	}
	
	return $return;
}

/**
* sorts options by position, then option_id ASC
*/
function sort_bundle_options($a, $b) {
	/*
	['options']
		$option_id => 
			'option_position'
			'option_id'
			'option_type'
			'option_name'
			['selections']
				$selection_id => 
					'selection_position'
					'selection_id'
					'selection_quantity'
					'selection_entity_id'
					'selection_sku'
					'selection_name'
	*/
	
	// first sorting diambiguation by position
	if ($a['option_position'] < $b['option_position']) {
		$position_comparison = -1;
		return $position_comparison;
	}
	elseif( $a['option_position'] > $b['option_position'] ) {
		$position_comparison = 1;
		return $position_comparison;
	} 
	// secondary sorting diambiguation by id, if position was equal
	else {
		$id_comparison = ($a['option_id'] < $b['option_id']) ? -1 : 1;
		return $id_comparison;
	}
	
}

function sort_bundle_option_selections($a, $b) {
	/*
	['selections']
		$selection_id => 
			'selection_position'
			'selection_id'
			'selection_quantity'
			'selection_entity_id'
			'selection_sku'
			'selection_name'
	*/
	
	// first sorting diambiguation by position
	if ($a['selection_position'] < $b['selection_position']) {
		$position_comparison = -1;
		return $position_comparison;
	}
	elseif( $a['selection_position'] > $b['selection_position'] ) {
		$position_comparison = 1;
		return $position_comparison;
	} 
	// secondary sorting diambiguation by id, if position was equal
	else {
		$id_comparison = ($a['selection_id'] < $b['selection_id']) ? -1 : 1;
		return $id_comparison;
	}
}
// -----------------------------------------------------------------------------------------------------------------------------------------
// returns mysqli connection
function mysqli_connection($database_name=null) {
	
	global $objectManager;
	
	// grab db credentials from the file on the server
	
	$deploymentConfig = $objectManager->get('\Magento\Framework\App\DeploymentConfig');
	$databaseConfig = $deploymentConfig->get('db/connection/default');

	// IMPORTANT NOTE:
	// $databaseConfig = $deploymentConfig->get('db');
	/*
		STRUCTURE
	
	    [table_prefix] => 
    	[connection] => Array
			(
				[default] => Array
					(
						[host] => 
						[dbname] => 
						[username] => 
						[password] => 
						[active] => 
					)
	
			)
	*/
		
	// This loads the whole Magento connection details. Magento can be setup using "Table Prefix".
	// When connecting to any Magento's tables via mysql or mysqli, be sure to include the "table_prefix"
	// "table not found" errors might be encountered
	
	$db_host = $databaseConfig['host'];
	$db_username = $databaseConfig['username'];
	$db_password = $databaseConfig['password'];
	$db_dbname = $databaseConfig['dbname'];

	// // DEBUG
	// var_dump($db_host);
	// var_dump($db_username);
	// var_dump($db_password);
	// var_dump($db_dbname);
	
	$cxn = mysqli_connect($db_host, $db_username, $db_password, $db_dbname);
	
	if (!!$cxn) {
		mysqli_set_charset($cxn, "utf8");
	}
	
	return $cxn;
}


// Use Magento's MySQL connection for SQL queries
function getConnection(){
	global $objectManager;
	
	$res = $objectManager->get('\Magento\Framework\App\ResourceConnection');
	$conn = $res->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);

	return $conn;
}
 
// Get Magento's tables. Important specially if installation uses table prefix.
function getTableName($tableName){
	global $objectManager;

	$res = $objectManager->get('\Magento\Framework\App\ResourceConnection');
	return $res->getTableName($tableName);
}

// Check if Table exists
function checkTable($tableName) {
	return getConnection()->isTableExists($tableName);
}

// Get attribute ID using attribute codes
function getAttributeId($attribute_code = 'price'){
    $connection = getConnection('core_read');
    $sql = "SELECT attribute_id
			FROM " . getTableName('eav_attribute') . 
			" WHERE entity_type_id = ?
			AND attribute_code = ?"
		;
    $entity_type_id = getEntityTypeId();
    return $connection->fetchOne($sql, array($entity_type_id, $attribute_code));
}
 
 // get entity type id
function getEntityTypeId($entity_type_code = 'catalog_product'){
    $connection = getConnection('core_read');
    $sql = "SELECT entity_type_id 
			FROM " . getTableName('eav_entity_type') . 
			" WHERE entity_type_code = ?"
		;
    return $connection->fetchOne($sql, array($entity_type_code));
}
// -----------------------------------------------------------------------------------------------------------------------------------------


################################  Mode info - retrieve info used to build import  ################################
if ($mode == "info") {
	$return = array();
	
	////////////////
	// Filters - Required and Optional
	////////////////
	$allowed_filters_schema = array(
		'store_id' => array(
			'required' => true,
			'array_required' => false,
			'validation'	=> array(
				'type' => "integer",
			),
		),
		// 'status' => array(
		// 	'required' => false, // false?
		// 	'array_required'	=> false,
		// 	'validation'	=> array(
		// 		'enumerated' => array(
		// 			"enabled",
		// 			"disabled",
		// 			"all",
		// 		),
		// 	),
		// ),
	);

	
	$filters_validated = validate_and_assign_params($allowed_filters_schema, $filters);
	
	//////////////// Apply Filters ////////////////
	
	// Store Id
	
	// Specifying an invalid store id will result in 500 error.
	// Magento default store value is 0.
	// Magento mandates at least one store, usually with store id 1.
	// Values of store 1 are fall back to values based on the default, 0.
	// Not specifying a store value will result in grabbing the available store, usually 1.
	// the function can accept string or integer numeric values.
	
	// We get the target store data by populating using the provided store_id. 
	// For now we only need the website_id, but more data can be used. See $store->getData()
	// NOTE: We are not loading the actual stores, we're just getting the store data
	
	$store = $storeManager->getStore()->load($filters_validated['store_id']);

	// Zero (0) ID is admin store view
	if (!$store->getId() && $filters_validated['store_id'] != 0) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid store id.",
			'data' => array(
				'explanation' => 'specified store does not exist',
				'applied_store_id' => $store->getId(),
				'attempted_store_id' => $filters_validated['store_id'],
			),
		);
		echo json_encode($response_bad);
		die;
	}
	
	$store_id = $store->getStoreId(); // Don't really know why I did this
	$website_id = $store->getWebsiteId();

	// check that the actual applied value matches the (filtered) provided value to check against bad value transformation (e.g. "asdf" becoming 1 or turning into a bad default)
	if ($store_id != $filters_validated['store_id']) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid store id.",
			'data' => array(
				'explanation' => 'the attempted store_id did not match the applied store_id did not match',
				'applied_store_id' => $store_id,
				'attempted_store_id' => $filters_validated['store_id'],
			),
		);
		echo json_encode($response_bad);
		die;
	}


	// This is where the major data difference comes in. If we loaded the actual store, we are viewing data the way customers see them.
	// On Magento, there's a setting called "Flat Catalog", and some owners enable that for performance purposes. However the downside of it in our situation is that it only save/index
	// data of products which have "Enabled Status". So if we view the data via a store view, it'll only give us the products which are enabled because it goes directly to the "Flat" tables.
	// Im not sure what's the behavior if "Flat Catalog" is disabled, but i assume it'll still produce inaccurate results.
	// If we view the store via an "Admin View", it will show both enabled and disabled products.
	// Try disabling this and see the difference with the data result
	$storeManager->getStore()->setCurrentStore(0);
	// I've decided to do a different approach and set the store id being filtered instead of using the "admin" view/store. As mentioned above, only admim view can show both enabled and disabled products. 
	// However, the downside of using this is the inability to get the proper value of attributes per store view. Setting the store id will allow us to get the right product attribute values for the store 
	// currently being filtered. But we need to get how many disabled products are there n a different way.
	//  * OBSOLETE * - but was left for reference. can be deleted after review. Issue resolved by using EAV models and applying "setStoreId($store_id)"
	
	
	// status
	
	$statuses = array();
	
	// $status = $filters_validated['status'];
	// if ($status == 'enabled') {
	// 	$statuses[] = 1;
	// }
	// elseif ($status == 'disabled') {
	// 	$statuses[] = 2;
	// }
	// else {
	$statuses[] = 1;
	$statuses[] = 2;
	// }
	
	//////////////// Versions ////////////////
	$productMetadata = $objectManager->get('\Magento\Framework\App\ProductMetadata');
	$magento_version = $productMetadata->getVersion();
	
	$return['versions']['php'] = $php_version;
	$return['versions']['platform'] = $platform;
	$return['versions']['magento'] = $magento_version;
	$return['versions']['script'] = $script_version;
	
	//////////////// File ////////////////
	$return['file']['name'] = __FILE__;
	$return['file']['directory'] = __DIR__;
	$return['file']['magento_base_directory'] = MAGENTO_ROOT;
	$return['file']['page_size'] = $page_size;
	
	////////////////  Stores - Available ////////////////
	$stores = array();
	
	$allStores = $storeManager->getStores();
	foreach ($allStores as $_storeIndex => $val) {
		$storeId = $store->getStoreId();
		
		$storeViewName = $store->getName();
		
		
		
		
		
		
		
		
		
		
		
		
		$stores[$_storeIndex]['store_id'] = $storeId;
		$stores[$_storeIndex]['store_view_name'] = $storeViewName;
		// $stores[$_storeIndex]['website_name'] = $websiteName;
	}
	
	// convert stores to array before writing
	$stores_data = array();
	foreach ($stores as $s_i => $st) {
		$stores_data[] = $st;
	}
	
	// write stores data
	$return['stores'] = $stores_data;
	
	//////////////// Filters Applied ////////////////
	$return['filtered_by'] = array(
		'store_id' => null,
	);
	
	// store id
	
	// replace store id with actually loaded store id, for increased accuracy.
	// default is store id 1
	$filtered_by = $filters_validated;
	$filtered_by['store_id'] = $store_id;
	
	
	// other filters applied
	
	$return['filtered_by'] = $filtered_by;
	
	
	//////////////// Counts ////////////////
	$return['counts'] = array();
	
	$return['counts']['disabled'] = null;
	
	$return['counts']['enabled']['downloadable'] = null; 
	$return['counts']['enabled']['virtual'] = null;
	$return['counts']['enabled']['simple'] = null;
	
	$return['counts']['enabled']['configurable'] = null;
	$return['counts']['enabled']['bundle'] = null;
	$return['counts']['enabled']['grouped'] = null;
	
	$return['counts']['enabled']['pairs']['downloadable_configurable'] = null;
	$return['counts']['enabled']['pairs']['downloadable_bundle'] = null;
	$return['counts']['enabled']['pairs']['downloadable_grouped'] = null;
	$return['counts']['enabled']['pairs']['virtual_configurable'] = null;
	$return['counts']['enabled']['pairs']['virtual_bundle'] = null;
	$return['counts']['enabled']['pairs']['virtual_grouped'] = null;
	$return['counts']['enabled']['pairs']['simple_configurable'] = null;
	$return['counts']['enabled']['pairs']['simple_bundle'] = null;
	$return['counts']['enabled']['pairs']['simple_grouped'] = null;
	
	$return['counts']['enabled']['sold_individually']['downloadable'] = null;
	$return['counts']['enabled']['sold_individually']['virtual'] = null;
	$return['counts']['enabled']['sold_individually']['simple'] = null;
	$return['counts']['enabled']['sold_individually']['configurable'] = null;
	$return['counts']['enabled']['sold_individually']['bundle'] = null;
	$return['counts']['enabled']['sold_individually']['grouped'] = null;
	
	$return['counts']['enabled']['unpaired']['downloadable'] = null;
	$return['counts']['enabled']['unpaired']['virtual'] = null;
	$return['counts']['enabled']['unpaired']['simple'] = null;
	$return['counts']['enabled']['unpaired']['configurable'] = null;
	$return['counts']['enabled']['unpaired']['bundle'] = null;
	$return['counts']['enabled']['unpaired']['grouped'] = null;
	
	// TODO
	$return['counts']['enabled']['bundle_combinations'][''] = null;
	
	// TODO
	$return['counts']['enabled']['super_attribute_utilizing']['configurable'] = null;
	$return['counts']['enabled']['super_attribute_utilizing']['simple'] = null;
	$return['counts']['enabled']['super_attribute_utilizing']['downloadable'] = null;
	$return['counts']['enabled']['super_attribute_utilizing']['virutal'] = null;
	
	//////////////// Counts of Super Attribute utilizing products ////////////////
	// Super attribute data holder (merging of super_info mode)
	$superAttributeData = array();
	
	
	// List of paired parent product IDs (configurable, bundle, grouped)
	$parentList = array();
	// List of paired child product IDs (simple, downloadable, virtual)
	$childList = array();
	
	
	// configurable products relationships.
	
	// Moved from raw SQL to Magento native codes. Filtering is easier with the native codes.
	// It is important tho to use the EAV way (catalog/product_collection) instead of the FLAT way (catalog/product)
	// The flat way will rule out disabled parents, and will make their children shows as sold_individually
	
	
	
	//////////////// Cached static model data ////////////////

	// Get product types list
	$productTypes = array_keys($objectManager->create('\Magento\Catalog\Model\Product\Type')->getOptionArray());
	$productTypesFlipped = array_flip($productTypes);
	//////////////// Cached static model data ////////////////

	
	//////////////// Counts ////////////////
	
	//// Counts - Disabled ////
	
	$productsDisabled = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
		->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED)
	;
	
	$count_disabled			= $productsDisabled->getSize();
	
	// write data
	$return['counts']['disabled']	= $count_disabled;
	
	
	//// Counts - Basic By Type  ////
	
	$productsSimple = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
		->addAttributeToFilter('type_id', 'simple')
		->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
	;
	$productsDownloadable = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
		->addAttributeToFilter('type_id', 'downloadable')
		->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
	;
	$productsVirtual = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
		->addAttributeToFilter('type_id', 'virtual')
		->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
	;
	$productsConfigurable = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
		->addAttributeToFilter('type_id', 'configurable')
		->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
	;
	$productsBundle = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
		->addAttributeToFilter('type_id', 'bundle')
		->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
	;
	$productsGrouped = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
		->addAttributeToFilter('type_id', 'grouped')
		->addAttributeToFilter('status', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
	;
	
	$count_simple				= $productsSimple->getSize();
	$count_downloadable	= $productsDownloadable->getSize();
	$count_virtual			= $productsVirtual->getSize();
	$count_configurable	= $productsConfigurable->getSize();
	$count_bundle				= $productsBundle->getSize();
	$count_grouped			= $productsGrouped->getSize();
	
	// write data
	$return['counts']['enabled']['simple']				= $count_simple;
	$return['counts']['enabled']['downloadable']	= $count_downloadable;
	$return['counts']['enabled']['virtual']				= $count_virtual;
	$return['counts']['enabled']['configurable']	= $count_configurable;
	$return['counts']['enabled']['bundle']				= $count_bundle;
	$return['counts']['enabled']['grouped']				= $count_grouped;
	
	
	// $parentProducts = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
	// 	// As it turns out, using "addStoreFilter" isn't enough to get the right attribute values. It only returns which products are assigned to the store, but
	// 	// will return "admin" view values for the attributes unless we use "setStoreId"
	// 	->setStoreId($store_id)
	// 	// NOTE (This is OK. both the parent and child must be in the filtered store to count as a pair for this store): 
	// 	// What if the parent products aren't assigned in the filtered store, but some or all of the children are?
	// 	// Then the pairing records won't be pulled (since we get that from the parent) and the children will then appear to be as sold_individually products.
	// 	// A potential way of dealing with this is by getting the pairing records via each child. That will consume more resources and will be theoretically slow.
	// 	->addStoreFilter($store_id)
	// 	// All parent product types as opposed to each one separately
	// 	->addAttributeToFilter(
	// 		'type_id', array(
	// 			'in' => array('configurable', 'bundle', 'grouped')
	// 		)
	// 	)
	// 
	// 	// TODO There's a dilemma going on here. Configurable child product's visbility are set to "Not visible individually" most of the time in a lot of stores i've encountered,
	// 	// so when the parent product has been disabled, the child products are just left ignored and not set to disabled status.
	// 	// The issue with here is that pairing for the child is lost when the parent product is filtered out by status
	// 	// when we filtered only a single status, either enabled or disabled, and the child products are of the same status as whats being filtered, the child products will register as a sold_individually result instead of a paired product.
	// 	// For now, I thought of just disabling the status filter with anything related to pairings. I'm still analyzing the logic to it.
	// 	// We might need to filter via visibility as well.
	// 	//
	// 	// I ended up filtering both statuses so we can use it later.
	// 	->addAttributeToFilter('status', array('gt' => 0))
	// 
	// 	->addAttributeToSelect(array('visibility'), 'left')
	// ;
	// // Grouped and Bundled products on the other hand have children with normal visibility
	// 
	// 
	// foreach ($parentProducts as $parent) {
	// 
	// 	$pTypeId = $parent->getTypeId();
	// 	$parent_id = $parent->getId();
	// 
	// 	// Parent product status will be used for other purposes
	// 	$pStatus = $parent->getStatus();
	// 
	// 	$childProducts = array();
	// 
	// 	if ($pTypeId == 'configurable') {
	// 
	// 		$saData = $parent->getTypeInstance(true)->getConfigurableAttributesAsArray($parent);
	// 
	// 		$superAttributesToSelect = array();		
	// 
	// 		if (count($saData) > 0) {
	// 			foreach ($saData as $sa => $sb) {
	// 
	// 				$attributeCode = $sb['attribute_code'];
	// 				$superAttributesToSelect[] = $attributeCode;
	// 				// newly encountered
	// 				if (!isset($superAttributeData[$attributeCode])) { 
	// 					$superAttributeData[$attributeCode] = array();
	// 					$superAttributeData[$attributeCode]['attribute_code'] = $attributeCode;
	// 					$superAttributeData[$attributeCode]['attribute_id'] = (int) $sb['attribute_id'];
	// 
	// 					// Solely for getting the backend type (could use other data)
	// 					$attData = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Eav\Attribute')->load($sb['attribute_id']);
	// 
	// 					// $superAttributeData[$attributeCode]['backend_type'] = $attData->getBackendType();
	// 					$superAttributeData[$attributeCode]['frontend_input'] = $attData->getFrontendInput();
	// 
	// 					$superAttributeData[$attributeCode]['child_product_count'] = 0;
	// 					$superAttributeData[$attributeCode]['parent_product_count'] = 1;
	// 				}
	// 				// already encountered
	// 				else {
	// 					$superAttributeData[$attributeCode]['parent_product_count']++;	
	// 				}
	// 
	// 			}
	// 		}
	// 
	// 		// Configurable product's pairings are Global in Magento, so pairing changes from one store will reflect in all stores.
	// 		// However, adding store filter will only output child products assigned to the store being filtered
	// 		// NOTE: The above scenario is fine, since a product will not show up in one store if it is not in that store anyway.
	// 		$childProducts = $parent->getTypeInstance(true)->getUsedProductCollection($parent)
	// 			->setStoreId($store_id)
	// 			->addStoreFilter($store_id)
	// 			->addAttributeToSelect($superAttributesToSelect)
	// 			// Shall we ONLY count enabled children?
	// 			->addAttributeToFilter('status', 1)
	// 		; 
	// 
	// 		if (count($childProducts) > 0) {
	// 			foreach ($childProducts as $child) {
	// 
	// 				$childData = $child->getData();
	// 				if (count($childData) > 0) {
	// 					$child_id = $child->getId();
	// 
	// 					foreach ($superAttributesToSelect as $i => $attributeCode) {
	// 						if (isset($childData[$attributeCode])) {
	// 							$superAttributeData[$attributeCode]['child_product_count']++;
	// 						}
	// 					}
	// 
	// 					$parentList[$parent_id]['configurable'][$child_id] = $pStatus;
	// 					$childList[$child_id]['configurable'][$parent_id] = $pStatus;
	// 				}
	// 
	// 			}
	// 		}
	// 
	// 	}
	// 	elseif ($pTypeId == 'bundle') {
	// 		// Bundle product's pairings are Global in Magento. Changes from one store will reflect in all stores.
	// 		// However, adding store filter will only output child products assigned to the store being filtered
	// 		$childProducts = $parent->getTypeInstance(true)
	// 			->getSelectionsCollection($parent->getTypeInstance(true)->getOptionsIds($parent), $parent)
	// 			->setStoreId($store_id)
	// 			->addStoreFilter($store_id)
	// 			// Shall we ONLY count enabled children?
	// 			->addAttributeToFilter('status', 1)
	// 		;
	// 
	// 		if (count($childProducts) > 0) {						  
	// 			foreach ($childProducts as $child) {
	// 
	// 				$child_id = $child['product_id'];
	// 
	// 				if (strlen(trim($child_id)) > 0) {
	// 					$parentList[$parent_id]['bundle'][$child_id] = $pStatus;
	// 					$childList[$child_id]['bundle'][$parent_id] = $pStatus;
	// 				}
	// 			}
	// 		}
	// 	}
	// 	elseif ($pTypeId == 'grouped') {
	// 		// Grouped product's pairings are Global in Magento. Changes from one store will reflect in all stores.
	// 		// Store and status filter are somehow already added on this. We can't count disabled products.
	// 		$childProducts = $parent->getTypeInstance(true)->getAssociatedProducts($parent);
	// 
	// 		if (count($childProducts) > 0) {						  
	// 			foreach ($childProducts as $child) {
	// 				$child_id = $child->getEntityId();
	// 				if (strlen(trim($child_id)) > 0) {
	// 					$parentList[$parent_id]['grouped'][$child_id] = $pStatus;
	// 					$childList[$child_id]['grouped'][$parent_id] = $pStatus;
	// 				}
	// 			}
	// 		}
	// 	}
	// }
	// 
	// // format super attributes data before writing
	// 
	// $super_attribute_data = array();
	// 
	// foreach ($superAttributeData as $sa_key => $sa_datum) {
	// 	$super_attribute_data[] = $sa_datum;
	// }
	// 
	// // write super attributes data
	// 
	// $return['super_attributes'] = $super_attribute_data;
	// 
	// 
	// // count pairs
	// 
	// 
	// // Fetch all product data using Magento native code. This uses the EAV tables instead of flat, so disabled products will be included.
	// $productsCollection = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')						
	// 	// As it turns out, using "addStoreFilter" isn't enough to get the right attribute values. It only returns which products are assigned to the store, but
	// 	// will return "admin" view values for the attributes unless we use "setStoreId" 
	// 	->setStoreId($store_id)
	// 	->addStoreFilter($store_id)
	// 
	// 	// // !!! For some reason, the order of filtering affects the results in some way. Adding status filter after the store filter produces accurate results.
	// 	->addAttributeToFilter('status', array('in' => $statuses))
	// 
	// 	// "left" means left join
	// 	->addAttributeToSelect(array('visibility'), 'left')
	// ;
	// 
	// // NOTE: We might need to filter via visibility as well to resolve the "parent-child status" conundrum
	// 
	// $productsTmp = $productsCollection->getData();
	// 
	// //$products = array();
	// if (count($productsTmp) > 0) {
	// 	foreach ($productsTmp as $pa => $pb) {
	// 
	// 		// handle only default product types, not idiosyncratic custom ones.
	// 		if ( array_key_exists($pb['type_id'], $productTypesFlipped)) {
	// 			$pStatus = $pb['status'];
	// 			$pVisibility = $pb['visibility'];
	// 
	// 			$pEntityId = $pb['entity_id'];
	// 			$pTypeId = $pb['type_id'];
	// 
	// 
	// 			// parent
	// 			if ( array_key_exists($pTypeId, $parent_types_flipped) ) {
	// 
	// 				// disabled
	// 				if ($pStatus == 2) {
	// 					$return['counts']['disabled']++;
	// 				}
	// 				// enabled
	// 				elseif ($pStatus == 1) {
	// 					$return['counts']['enabled'][$pTypeId]++;
	// 
	// 					// if no children
	// 					if ( !isset($parentList[$pEntityId]) ) {
	// 						// unpaired
	// 						$return['counts']['enabled']['unpaired'][$pTypeId]++;
	// 					}
	// 				}
	// 
	// 			}
	// 			// child
	// 			elseif ( array_key_exists($pTypeId, $children_types_flipped) ) {
	// 				// This code adds the count of however many relationships there were for the child product.
	// 				// But the problem with doing it that way is that the number of relationships were obtained via queries that did not filter by  store id or status.
	// 				// So it will add the counts of all pairings across all stores and all product statuses.
	// 				// This results in overcounting for potentially all of the pairs.
	// 				//
	// 				// TODO Make sure this doesn't over-fetch.
	// 				// Either filter the initial parentList and childList by store id and status, or validate that the associated parent product is of the store id and status here. The prior most likely better than the latter.
	// 				//
	// 
	// 
	// 				// if has no parents
	// 				if ( !isset($childList[$pEntityId]) ) {
	// 					// disabled
	// 					if ($pStatus == 2) {
	// 						$return['counts']['disabled']++;
	// 					}
	// 					// enabled
	// 					else {
	// 						$return['counts']['enabled'][$pTypeId]++;
	// 						$return['counts']['enabled']['unpaired'][$pTypeId]++;
	// 
	// 						// check visibility
	// 						if ($pVisibility != '1') {
	// 							$return['counts']['enabled']['sold_individually'][$pTypeId]++;
	// 						}
	// 
	// 					}
	// 
	// 				}
	// 				// if has parent(s)
	// 				else {
	// 
	// 					// NOTE TODO a disabled child of a configurable parent may still be sold and shown on the frontend.
	// 					//
	// 					// default the product to not belonging to a configurable parent.
	// 
	// 					// this is to decide whether the child being disabled is of consequence or not.
	// 					$belongs_to_configurable = array_key_exists('configurable', $childList[$pEntityId]);
	// 
	// 					// belongs to configurable becomes an exception against child product being disabled... treat it as enabled.
	// 					if ($pStatus == 1 || $belongs_to_configurable) {
	// 						$return['counts']['enabled'][$pTypeId]++;
	// 
	// 						// count each pair
	// 
	// 						// foreach parent type
	// 						foreach ($childList[$pEntityId] as $parentType => $parentTypePairs) {
	// 
	// 							// initialize pair_type
	// 							$pair_type = $pTypeId . '_' . $parentType;
	// 
	// 							// foreach parent of a particular parent type
	// 							foreach ($parentTypePairs as $parentId => $parentStatus) {
	// 
	// 								// in order to count as enabled pair, the parent must be enabled.
	// 								if ($parentStatus == 1) {
	// 									$return['counts']['enabled']['pairs'][$pair_type]++;
	// 								}
	// 
	// 							}
	// 
	// 						}
	// 
	// 						// also count the child product as sold_individually if sold separately
	// 						if ($pVisibility > \Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE) {
	// 							$return['counts']['enabled']['sold_individually'][$pTypeId]++;
	// 						}
	// 					}
	// 					// disabled
	// 					else { 
	// 						$return['counts']['disabled']++;
	// 					}
	// 
	// 				} // end has / has no parents
	// 
	// 			} // end child vs parent
	// 
	// 		}
	// 
	// 	}
	// }
	
	
	
	////////////////  Attribute Sets ////////////////
	/*
		Getting list of attribute sets. The source table includes all the attribute sets being used in Magento like 
		"customer = 1"
		"customer_address = 2" 
		"catalog_category = 3" 
		"catalog_product = 4" 
		"order = 5" 
		"invoice = 6" 
		"creditmemo = 7" 
		"shipment = 8" 
		
		We'll filter 4 for "catalog_product"
	*/
	
	$entityType = getEntityTypeId(); // catalog_product
	
	// Get each attribute set under the filtered entity_type
	$attributeSetsCollection = $objectManager->get('\Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory')->create()
		->addFieldToFilter('entity_type_id', $entityType)
		->load()
	;
	
	// build attribute sets data from native
	$attributeSets = array();
	foreach ($attributeSetsCollection as $attrSetId => $attributeSet) {
		$tmpSet = array();
		
		$tmpSet['id'] = $attrSetId;
		$tmpSet['name'] = $attributeSet->getAttributeSetName();
		
		$attributes = array();
		
		// Get all attributes for each attribute sets
		$attrsOfAset = $objectManager
			->get('\Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory')
			->create()
			->setAttributeSetFilter($attrSetId)
			->load()
		;
	
		if (count($attrsOfAset) > 0) {
			foreach ($attrsOfAset as $attrOfAset) {

				// Get ALL data of an attribute. This one includes "used_in_product_listing" and "is_super_attribute"
				$attributeDetails = $objectManager
					->create("\Magento\Eav\Model\Entity\Attribute")
					->loadByCode('catalog_product', $attrOfAset['attribute_code']);

				$attributes[$attrOfAset['attribute_code']] = $attributeDetails->getData();
			}
		}	

		if (count($attributes) > 0) {
			$tmpSet['attributes'] = $attributes;
		}

		$attributeSets[] = $tmpSet;
	}
	
	// Final stage of processing
	$attribute_sets = array();
	foreach ($attributeSets as $k_as => $attrSet) {
		$attrSetName = $attrSet['name'];
		
		$attr_set = array();
		$attr_set['name'] = $attrSetName;
		$attr_set['id'] = $attrSet['id'];
		
		$attributes = array();
		$attributesData = $attrSet['attributes'];
		foreach ($attributesData as $attributeCode => $attributeProps) {

			$attribute = array();
			$attribute['name'] = $attributeCode;
			$attribute['attribute_id'] = $attributeProps['attribute_id'];
			$attribute['used_in_product_listing'] = $attributeProps['used_in_product_listing'];
			
			 // 0 means its a system attribute, but not neccesarily an "out of the box" attribute of Magento,
			 // since  3rd party extensions mark their own made attribute as system attribute as well
			$attribute['is_user_defined'] = $attributeProps['is_user_defined'];
			
			// This is to only specify if an attribute is "super_attribute", 
			// but not to know if the "super_attribute" has been used in making 
			// at least 1 configurable product.
			if (in_array($attributeProps['frontend_input'], array('select')) 
			&& $attributeProps['is_global'] == 1 
			&& $attributeProps['is_user_defined'] == 1 ) {
				$attribute['is_super_attribute'] = 1;
			}
			else {
				$attribute['is_super_attribute'] = 0;
			}
			
			
			$attribute['frontend_label'] = $attributeProps['frontend_label'];
			$attribute['frontend_input'] = $attributeProps['frontend_input'];
			$attribute['backend_type'] = $attributeProps['backend_type'];
			
			$attributes[] = $attribute;
		}
		
		$attr_set['attributes'] = $attributes;
		
		$attribute_sets[] = $attr_set;
	}
	
	$return['attribute_sets'] = $attribute_sets;
	
	
	
	//////////////// Attributes ////////////////
	$all_unique_attr_set_attrs = array();
	foreach ($attribute_sets as $i_as => $attribute_set) {
		$as_id = $attribute_set['id'];
		$as_name = $attribute_set['name'];
		$attributes = $attribute_set['attributes'];
		foreach ($attributes as $attr_value) {
			$attr_name = $attr_value['name'];
			$all_unique_attr_set_attrs[$attr_name] = $attr_value;
		}
	}
	// write data - attributes
	$return['attributes'] = array_values($all_unique_attr_set_attrs);
	
	// attribute model loading if necessary
	//
	
	
	
	
	//////////////// Super Attributes ////////////////
	
	// Select the subset of super attributes from unique attributes
	$super_attributes = array();
	
	foreach ($all_unique_attr_set_attrs as $attr) {
		if (array_key_exists('is_super_attribute', $attr)
		&& $attr['is_super_attribute']==true) {
			$super_attributes[] = $attr;
		}
	}
	
	// example of old super attribute data interface.
	/*
	  "attribute_code": "asliquid",
	  "attribute_id": 140,
	  "frontend_input": "select",
	  "child_product_count": 20,
	  "parent_product_count": 9
	*/
	// Rename some keys Changes "name" key to "attribute_code" key.
	foreach ($super_attributes as $i => $super_attr) {
		$new_sa = $super_attr;
		// for backwards compatibility,
		// 'name' needs to be 'attribute_code'
		$new_sa['attribute_code'] = $super_attr['name'];
		
		$super_attributes[$i] = $new_sa;
	}
	
	// write data
	$return['super_attributes'] = array_values($super_attributes);
	
	
	//////////////// Output ////////////////
	echo json_encode($return);
	
	exit;
}

################################  Mode pull - Generate Feed  ################################

if ($mode == "pull") {

	//////////////// Get other params - attributes ////////////////
	$attribute_codes = $attributes;
	$attribute_codes_flipped = array_flip($attribute_codes);
	
	//////////////// Filters - Required and Optional ////////////////
	$allowed_filters_schema = array(
		'store_id' => array(
			'required' => true,
			'array_required'	=> false,
			'validation'	=> array(
				'type' => "integer",
			),
		),
		'product_type' => array(
			'required' => true,
			'array_required'	=> false,
			'validation'	=> array(
				'enumerated' => array(
					"virtual",
					"downloadable",
					"simple",
					"configurable",
					"bundle",
					"grouped",
				),
			),
		),
		'status' => array(
			'required' => true,
			'array_required'	=> false,
			'validation'	=> array(
				'enumerated' => array(
					"enabled",
					"disabled",
					"all",
				),
			),
		),
		'attribute_set_id' => array(
			'required' => false,
			'array_required'	=> false,
			'validation'	=> array(
				'type'	=> 'integer'
			),
		),
		'visibility' => array(
			'required' => false,
			// depends on product_type
			'array_required'	=> true,
			'validation'	=> array(
				'type'	=> 'integer',
				'enumerated' => array(
					1, // Not Visible Individually
					2, // Catalog
					3, // Search
					4, // Catalog and Search
				),
			),
		),
		'blacklist_category_ids' => array(
			'required' => false,
			'array_required'	=> true,
			'validation'	=> array(
				'type'	=> 'integer',
			),
		),
		'starting_page' => array(
			'required' => false,
			'array_required'	=> false,
			'validation'	=> array(
				'type' => 'integer',
			),
		),
		'max_pages' => array(
			'required' => false,
			'array_required'	=> false,
			'validation'	=> array(
				'type' => 'integer',
				// TODO value range restriction
				// Complex and not worth coding just yet.
				// handled downstream for now.
			),
		),
	);

	$filters_validated = validate_and_assign_params($allowed_filters_schema, $filters);
	
	////////////////  Filter Validation for complex, interacting elements ////////////////
	
	// only allow attribute 'bundle_details_for_parents_column_names' for filter status = {bundle type}
	// only allow attribute 'bundle_details_for_children_column_names' for filter status = {children types}
	// done downstream in the attribute if-else branch.
	// Consider refactoring to do it more upstream.
	
	////////////////  Apply Filters ////////////////
	
	// Store Id
	
	// Specifying an invalid store id will result in 500 error.
	// Magento default store value is 0.
	// Magento mandates at least one store, usually with store id 1.
	// Values of store 1 are fall back to values based on the default, 0.
	// Not specifying a store value will result in grabbing the available store, usually 1.
	// the function can accept string or integer numeric values.
	
	// We get the target store data by populating using the provided store_id. 
	// For now we only need the website_id, but more data can be used. See $store->getData()
	// NOTE: We are not loading the actual stores, we're just getting the store data
	$store = $storeManager->getStore()->load($filters_validated['store_id']);
	
	// Zero (0) ID is admin store view. Consider this bad. We want store id specified rather than store ID 0 which will overfetch.
	if (!$store->getId() && $filters_validated['store_id'] != 0) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid store ID",
			'data' => array(
				'explanation' => 'the resultant store id ended up as the admin store id, which would lead to inaccurate product fetching',
				'attempted_store_id' => $filters_validated['store_id'],
				'applied_store_id' => $store->getId(),
			),
		);
		echo json_encode($response_bad);
		die;
	}
	
	
	$store_id = $store->getStoreId(); // Necessary?
	$website_id = $store->getWebsiteId();

	// check that the actual applied value matches the (filtered) provided value to check against bad value transformation (e.g. "asdf" becoming 1 or turning into a bad default)
	if ($store_id != $filters_validated['store_id']) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid store ID",
			'data' => array(
				'explanation' => 'the attempted and applied store ids did not match',
				'attempted_store_id' => $filters_validated['store_id'],
				'applied_store_id' => $store->getId(),
			),
		);
		echo json_encode($response_bad);
		die;
	}


	// This is where the major data difference comes in. If we loaded the actual store, we are viewing data the way customers see them.
	// On Magento, there's a setting called "Flat Catalog", and some owners enable that for performance purposes. However the downside of it in our situation is that it only save/index
	// data of products which have "Enabled Status". So if we view the data via a store view, it'll only give us the products which are enabled because it goes directly to the "Flat" tables.
	// Im not sure what's the behavior if "Flat Catalog" is disabled, but i assume it'll still produce inaccurate results.
	// If we view the store via an "Admin View", it will show both enabled and disabled products.
	// Try disabling this and see the difference with the data result
	$storeManager->getStore()->setCurrentStore(0);


	//////////////// Load Necessary Models and Data  depending on selected attribute codes ////////////////
	
	$productsCollection = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
		// As it turns out, using "addStoreFilter" isn't enough to get the right attribute values. It only returns which products are assigned to the store, but
		// will return "admin" view values for the attributes unless we use "setStoreId" 
		->setStoreId($store_id)
		->addStoreFilter($store_id);

	// media_gallery_images model
	
	//if (in_array('media_gallery_images', $attribute_codes)) {
	//	$mediaGalleryBackend = $productsCollection->getResource()->getAttribute('media_gallery')->getBackend();
	//}

	// For product images URL
	$catalogMediaUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA). 'catalog/product';

	// Made a loop for filters. Excluded some that requires the non usual way.
	// The benefit of using a loop is that you can POST more filters or product attributes.
	// Malicious code injection prevention bit needed.
	// Disabled as it might not be preferable.
	
	/*
	$attributesExcluded = array('store_id', 'blacklist_category_ids');
	
	foreach ($filters_validated as $att => $toFilter) {
		if (!in_array($attribute, $attributesExcluded)) {
	
			$values = $toFilter;
			$attribute = $att;
	
			if ($att == 'status') {
				$statuses = array();
	
				if ($toFilter == 'enabled') {
					$statuses[] = 1;
				}
				elseif ($toFilter == 'disabled') {
					$statuses[] = 2;
				}
				else {
					$statuses[] = 1;
					$statuses[] = 2;
				}
				$values = $statuses;
			}else if ($att == 'product_type') {
				$attribute = 'type_id';
			}
	
			${$att} = $values;
	
			if (is_array($toFilter)) {
				// We can turn 'in' as a param value as well so we can use other conditions mentioned here:
				// https://devdocs.magento.com/guides/v2.2/rest/performing-searches.html 
				$productsCollection->addAttributeToFilter($attribute, array('in' => $values));
			}else{
				$productsCollection->addAttributeToFilter($attribute, $values);
			}
		}
	}*/
	
	
	$statuses = array();

	if ($filters_validated['status'] == 'enabled') {
		$statuses[] = 1;
	}
	elseif ($filters_validated['status'] == 'disabled') {
		$statuses[] = 2;
	}
	else {
		$statuses[] = 1;
		$statuses[] = 2;
	}

	// attribute_set_id
	
	if (isset($filters_validated['attribute_set_id'])) {
		$attribute_set_id = $filters_validated['attribute_set_id'];
		
		if (is_array($attribute_set_id)) {
			$productsCollection->addAttributeToFilter('attribute_set_id', array('in' => $attribute_set_id) );
		}
		else {
			$productsCollection->addAttributeToFilter('attribute_set_id', $attribute_set_id);
		}
	}
	

	// visibility
	
	if (isset($filters_validated['visibility'])) {
		$visibility = $filters_validated['visibility'];
		
		if (is_array($visibility)) {
			$productsCollection->addAttributeToFilter('visibility', array('in' => $visibility) );
		}
		else {
			$productsCollection->addAttributeToFilter('visibility', $visibility);
		}
	}
	
	// type_id-s (aliased to product types)
	
	if ( isset($filters_validated['product_type']) ) {
		$product_type = $filters_validated['product_type'];
		
		$productsCollection->addAttributeToFilter('type_id', $product_type);
	}

	// Status of product

	if (count($statuses) > 0) {
		$productsCollection->addAttributeToFilter('status', array('in' => $statuses));
	}
	
	// prepare stockitem model, sourceitembysku if necessary

	$stockitem_model_necessary = false;
	if ( in_array('is_in_stock', $attribute_codes) 
		|| in_array('quantity', $attribute_codes) )
	{
		$stockitem_model_necessary = true;
	}

	$sourceitembysku_model_necessary = false;
	if ( in_array('multi_source_inventory', $attribute_codes) ) {
		$sourceitembysku_model_necessary = true;
	}
	
	// blacklist category ids
	
	if ( isset($filters_validated['blacklist_category_ids']) ) {
		$blacklist_category_ids = $filters_validated['blacklist_category_ids'];
		# validate. array format
		if (!is_array($blacklist_category_ids) ) {
			
			$response_bad = array(
				'success' => false,
				'message' => "Invalid blacklist_category_ids filter value",
				'data' => array(
					'explanation' => 'blacklist_category_ids did not end up as an array',
					'attempted_value' => $blacklist_category_ids,
				),
			);
			echo json_encode($response_bad);
			die;
		}
		# validate. only int allowed
		foreach ($blacklist_category_ids as $i => $bl_id) {
			if ( !is_int($bl_id) || $bl_id<0 ) {
				
				$response_bad = array(
					'success' => false,
					'message' => "Invalid blacklist_category_ids filter value",
					'data' => array(
						'explanation' => 'blacklist_category_ids was not type int',
						'index' => $i,
						'attempted_value' => $bl_id,
					),
				);
				echo json_encode($response_bad);
				die;
			}
		}
		$blacklist_category_ids_flipped = array_flip($blacklist_category_ids);
	}
	
	/*
	 * Retrieves category tree defined in magento
	 * This script is common for all the products and can be placed
	 * before the loop into the productsCollection
	 *
	 * It inizialized structures used later for creating the category list:
	 *      - level of the category in the tree
	 *      - id of parent category
	 *      - category label
	 */
	$categoriesArray = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Category\Collection')
		->addAttributeToSelect('name')
		->addAttributeToSelect('parent_id')
		->addAttributeToSort('path', 'asc')
		->addIsActiveFilter()
		->load()
		->toArray();
	$traverse = array();

	// this accounts for different magento installations
	if (isset($categoriesArray['items'])) {
		$traverse = $categoriesArray['items'];
	}
	else {
		$traverse = $categoriesArray;
	}

	foreach ($traverse as $cat_id => $category_info) {
		$cat_map[$cat_id] = explode("/", $category_info['path']);

		if (count($cat_map[$cat_id]) <= 1) {
			$cat_array[$cat_id] = $traverse[implode($cat_map[$cat_id])];
			continue;
		}
		$first = true;
		foreach ($cat_map[$cat_id] as $parent_cat_id) {
			if($first) {
				if(!isset($traverse[$parent_cat_id])) {
					continue;
				}
				$cat_array[$cat_id] = $traverse[$parent_cat_id]['name'];
				$first = false;
				continue;
			}
			$cat_array[$cat_id] = $cat_array[$cat_id] . " > " . $traverse[$parent_cat_id]['name'];
		}
	}
	unset($traverse);

	////////////////
	// start products collection model and apply specified filters
	////////////////
	// include certain attributes in attributesToSelect() if certain other attributes are in $attribute_codes
	$attribute_to_select = $attribute_codes;
	
	if (!in_array('visibility', $attribute_to_select)) {
		$attribute_to_select[] = 'visibility';
	}

	
	if ( in_array('bundle_details_for_parents',$attribute_to_select) 
 	|| in_array('bundle_details_for_children',$attribute_to_select) ) {
		$attributes_to_include_for_bundle = array(
			'price_type',
			'price',
			'weight_type',
			'weight',
		);
		foreach ($attributes_to_include_for_bundle as $additional_attr) {
			if (!in_array($additional_attr, $attribute_to_select)) {
				$attribute_to_select[] = $additional_attr;
			}
		}
	}
	
	$productsCollection->addAttributeToSelect($attribute_to_select);
	$productsCollection->setPageSize($page_size);
	
	////////////////  Pagination Management ////////////////
	// starting_page

	// default initialized starting page
	$currentPage = 1;
	
	if ( isset($filters_validated['starting_page']) ) {
		$starting_page = $filters_validated['starting_page'];
	}
	
	// Override starting page if valid page number
	if (isset($starting_page) && $starting_page >= 1) {
		$currentPage = $starting_page;
	}


	// ending page
	
	// default initialized last page
	$pagesAvailable = $productsCollection->getLastPageNumber();
	
	// NOTE this must 
	// Check that starting page < pages available.
	if ( $currentPage > $pagesAvailable ) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid starting page",
			'data' => array(
				'explanation' => 'The starting page was greater than pages available.',
				'attempted_starting_page' => $currentPage,
				'pages_available' => $pagesAvailable,
			),
		);
		echo json_encode($response_bad);
		die;
	}
	
	// hard max pages
	$hard_max_pages = 5000;
	
	// max_pages
	if ( isset($filters_validated['max_pages']) ) {
		$max_pages = $filters_validated['max_pages'];
	}
	// validate
	if ( isset($max_pages) && $max_pages<1 ) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid max_pages",
			'data' => array(
				'explanation' => 'max_pages must be 1 or greater.',
				'attempted_max_pages' => $max_pages,
			),
		);
		echo json_encode($response_bad);
		die;
	}
	if ( isset($max_pages) && $max_pages>$hard_max_pages ) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid max_pages",
			'data' => array(
				'explanation' => 'max_pages must be less than or equal to the hard_max_pages.',
				'attempted_max_pages' => $max_pages,
				'hard_max_pages' => $hard_max_pages,
			),
		);
		echo json_encode($response_bad);
		die;
	}
	
	// pick appropriate last page value.
	$potential_last_pages = array();
	$potential_last_pages[] = $pagesAvailable;
	$potential_last_pages[] = $hard_max_pages;
	if ( isset($max_pages) ) {
		$potential_last_pages[] = $currentPage-1 + $max_pages;
	}

	$endingPage = min($potential_last_pages);
	
	
	//////////////// Modify attribute codes header if necessary, to bundle_details with specific detail columns ////////////////
	$attribute_codes_header = $attribute_codes;

	$bundle_details_index = array_search('bundle_details_for_parents', $attribute_codes_header);
	if ($bundle_details_index!==false) {
		array_splice($attribute_codes_header, 
			$bundle_details_index, 
			1,
			$bundle_details_for_parents_column_names
		);
	}
	
	$bundle_details_index = array_search('bundle_details_for_children', $attribute_codes_header);
	if ($bundle_details_index!==false) {
		array_splice($attribute_codes_header, 
			$bundle_details_index, 
			1,
			$bundle_details_for_children_column_names
		);
	}
	
	//////////////// Write Output Header ////////////////
	$fp = fopen('php://output', 'w');
	
	// fput_delimited($fp, $attribute_codes, $delimiter, $enclosure_char, $escape_char);
	fputcsv($fp, $attribute_codes_header);

	if ($stockitem_model_necessary) {
		$stockItemModel = $objectManager->create('\Magento\CatalogInventory\Api\Data\StockStatusInterface');
	}

	if ($sourceitembysku_model_necessary) {
		$sourceItemsBySkuModel = $objectManager->create('Magento\Inventory\Model\SourceItem\Command\GetSourceItemsBySku');
	}

	//////////////// Pull Pages ////////////////
	while ($currentPage <= $endingPage) {
		$productsCollection->setCurPage($currentPage);
		$productsCollection->load();
		
		$currentPage++;

		foreach ($productsCollection as $_product) {

			// For reference
			// $data = array(
			//     'sku'                      => $_product->getSKU(),
			//     'title'                    => $_product->getName(),
			//     'description'              => $_product->getDescription(),
			//     'short_description'        => $_product->getShortDescription(),
			//     'link'                     => $_product->getProductUrl(),
			//     'image_link'               => $_product->getImageUrl(),
			//     'thumbnail_image_link'     => $_product->getThumbnailUrl(),
			//     'is_in_stock''             => $_product->getIsInStock()
			//     'quantity'                 => quantity,
			//     'price'                    => $_product->getPrice(),
			//     'special_price'            => $_product->getFinalPrice(),
			//     'manufacturer_part_number' => $_product->getId(),
			//     'shipping_weight'          => $_product->getWeight(),
			//     'categories'               => $categories,
			// );
			
			$entity_id = $_product->getEntityId();
			$type_id = $_product->getTypeId();
			
			// Use a reflector to get access to private data
			
			$reflector = new \ReflectionClass($_product);
			$classProperty = $reflector->getProperty('_data');
			$classProperty->setAccessible(true);
			$accessible_product = $classProperty->getValue($_product);
			
			if ($stockitem_model_necessary) {
				$stockItem = $stockItemModel->setProductId($_product->getId())->getStockItem();
			}
			
			// collection of parent ids for potential row expansion for children
			$parent_ids = array(); // ok to run even if not children
			
			$data = array();
			// get each attribute for the current product
			foreach ($attribute_codes as $attribute) {

				// if subcategory and ancestor categories are selected, ancestor strings are not produced.
				if ($attribute == 'store_ids') {
					$storeIds = $_product->getStoreIds();
					$storeIds = implode($impl_expl_char, $storeIds);
					
					$data[$attribute] = $storeIds;
				}
				elseif ($attribute == 'attribute_set_name') {
					$attributeSetModel = $objectManager->create('\Magento\Eav\Model\Entity\Attribute\Set');
					$attributeSetModel->load($_product->getAttributeSetId());
					$attributeSetName  = $attributeSetModel->getAttributeSetName();
					
					$data[$attribute] = $attributeSetName;
				}
				elseif ($attribute == 'visibility') {
					$visibility = $_product->getData('visibility');
					$data[$attribute] = (int)$visibility;
				}
				elseif ($attribute == 'category_ids') {
					$categoryIds = $_product->getCategoryIds();
					$categoryIdsString = implode($impl_expl_char, $categoryIds);
					
					$data[$attribute] = $categoryIdsString;
				}
				elseif ($attribute == 'categories') {
					// get categories (filters by specified store id)
					$categoryIds = $_product->getCategoryIds();
					$categoryIdsFlipped = array_flip($categoryIds);

					$categories = array();
					foreach ($categoryIdsFlipped as $categoryId => $categoryIndex) {
						$categories[] = $cat_array[$categoryId];
					}

					$data[$attribute] = implode(" | ", $categories);
				}
				elseif ($attribute == 'bundle_details_for_parents') {
					// allow only if the pull import is for parents
					if ($type_id != 'bundle') {
						
						$response_bad = array(
							'success' => false,
							'message' => "Invalid attribute_code and/or product_type",
							'data' => array(
								'explanation' => "The attribute_code 'bundle_details_for_parents' can only be used with product_type = 'bundle'",
							),
						);
						echo json_encode($response_bad);
						die();
					}
					
					////////////////
					// Model
					////////////////
					// initialize / document the output data to be populated.
					// NOTE ! this code is crucial to keeping the column count and row expansion accurate.
					foreach ($bundle_details_for_parents_column_names as $b_col_name) {
						$data[$b_col_name] = '';
					}
					
					// Construct master data structure
					$bundleDataforParent = array();
					
					$bundleParentId = $entity_id;
					// Get parent of current product
					$bundleParent = $objectManager->create('\Magento\Catalog\Model\Product')->load($bundleParentId);
					$bundleParentSku = $bundleParent->getSku();
					
					$bundleParentOptions = $bundleParent->getTypeInstance(true)->getOptions($bundleParent);
					
					$bundleDataforParent['parents'][$bundleParentId]['sku'] = $bundleParentSku;
					
					
					foreach ($bundleParentOptions as $bpo) {
						// var_dump($bpo);
						$optionId = $bpo->getOptionId();
						$optionTitle = $bpo->getDefaultTitle();
						$optionType = $bpo->getType();
						$optionPosition = $bpo->getPosition();
						$optionRequired = $bpo->getRequired();
						
						$bundleDataforParent['parents'][$bundleParentId]['options'][$optionId]['bundle_option_name'] = $optionTitle;
						$bundleDataforParent['parents'][$bundleParentId]['options'][$optionId]['bundle_option_type'] =$optionType;
						$bundleDataforParent['parents'][$bundleParentId]['options'][$optionId]['bundle_option_position'] =$optionPosition;
						$bundleDataforParent['parents'][$bundleParentId]['options'][$optionId]['bundle_option_is_required'] =$option_required;
						
					}
					
					$bundleParentOptionIds = $bundleParent->getTypeInstance(true)->getOptionsIds($bundleParent);
					
					// Get children of particular parent of current product (only children)
					$childrenOfBundle = $bundleParent->getTypeInstance(true)
					->getSelectionsCollection($bundleParentOptionIds, $bundleParent)
					->setStoreId($store_id)
					->addStoreFilter($store_id)
					;
					// DEBUG
					// var_dump($childrenOfBundle);
					
					// foreach children of parent of current product
					foreach ($childrenOfBundle as $cpA => $cpB) {
						$selection_id = $cpB->getSelectionId();
						$selection_option_id = $cpB->getOptionId();
						
						$bundleDataforParent['parents'][$bundleParentId]['options'][$selection_option_id]['selections'][$selection_id]['entity_id'] 
						= $cpB->getEntityId();
						
						// (Mainly for identifiaction debugging)
						$bundleDataforParent['parents'][$bundleParentId]['options'][$selection_option_id]['selections'][$selection_id]['sku'] 
						= $cpB->getSku();
						
						// bundle_option_selection_quantity
						$bundleDataforParent['parents'][$bundleParentId]['options'][$selection_option_id]['selections'][$selection_id]['bundle_option_selection_id'] 
						= (int) $cpB->getSelectionId();
						
						// bundle_option_selection_quantity
						$bundleDataforParent['parents'][$bundleParentId]['options'][$selection_option_id]['selections'][$selection_id]['bundle_option_selection_quantity'] 
						= (int) $cpB->getSelectionQty();
						
						// bundle_option_selection_position
						$bundleDataforParent['parents'][$bundleParentId]['options'][$selection_option_id]['selections'][$selection_id]['bundle_option_selection_position'] 
						= (int) $cpB->getPosition();
						
						// omitting child price for now.
						
						// omitting child weight for now.
					}
					// var_dump($bundleDataforParent);
					
					// bundle price model for max price and min price
					$bundlePriceModel = $objectManager->create('\Magento\Bundle\Model\Product\Price');
					
					$optionIds = $_product->getTypeInstance(true)->getOptionsIds($_product);
					// defunct, but may be useful in the future
					// $productOptions = $_product->getTypeInstance(true)->getOptions($_product);
					
					$children = $_product->getTypeInstance(true)
						->getSelectionsCollection($optionIds, $_product)
						->setStoreId($store_id)
						->addStoreFilter($store_id)
					;
					
					$selectionIds = array();
					$childrenIds = array();
					
					foreach ($children as $child) {
						$selectionIds[] = $child->getSelectionId();
						$childrenIds[] = $child->getEntityId();
					}
					
					//////////////// View ////////////////
					// bundle_option_ids
					$data['bundle_family_tree'] = json_encode($bundleDataforParent);
					
					// bundle_min_price
					$data['bundle_min_price'] = $bundlePriceModel->getTotalPrices($_product, "min", 0);
					
					// bundle_max_price
					$data['bundle_max_price'] = $bundlePriceModel->getTotalPrices($_product, "max", 0);
					
					// NOTE
					// The formula for the correct final bundle price of a particular combination. is:
					// Parent Price + Each child's final calculated price = The Final selected Bundle product pricing
					// If parent bundle price type is "dynamic", then the parent price type is effectively 0.
					
					// Price
					
					// Price Type
					// (0 = Dynamic, 1 = Fixed)
					$b_price_type = $_product->getPriceType() == 0 ? 'Dynamic' : 'Fixed';
					if ($b_price_type == 'Dynamic') {
						$b_price = 0.0;
					}
					else {
						// Nominal price of bundle product.
						// Price Type dependent (Dynamic price_type will produce price = 0 or NULL)
						$b_price = $_product->getPrice();
					}
					$data['bundle_parent_price'] = number_format($b_price, 2);;
					
					// Weight
					
					// Weight Type
					// (0 = Dynamic, 1 = Fixed)
					$b_weight_type = $_product->getWeightType() == 0 ? 'Dynamic' : 'Fixed';
					if ($b_weight_type == 'Dynamic') {
						$b_weight = 0.0;
					}
					else {
						// Nominal weight of bundle product
						// Weight Type dependent (Dynamic weight_type will produce weight = 0 or NULL)
						$b_weight = $_product->getData('weight');
					}
					$data['bundle_parent_weight'] = $b_weight;
					
				}
				elseif ($attribute == 'bundle_details_for_children') {
					// allow only if the pull is for children
					if ( !array_key_exists($type_id, $children_types_flipped) ) {
						
						$response_bad = array(
							'success' => false,
							'message' => "Invalid attribute_code and/or product_type",
							'data' => array(
								'explanation' => "The attribute_code 'bundle_details_for_children' can only be used with children product_type: 'simple | downloadalbe | virtual'",
							),
						);
						echo json_encode($response_bad);
						die();
					}
					
					//////////////// Model ////////////////
					// initialize / document the output data to be populated.
					// NOTE ! this code is crucial to keeping the column count and row expansion accurate.
					foreach ($bundle_details_for_children_column_names as $b_col_name) {
						$data[$b_col_name] = '';
					}
				
					// get fresh parents data for each product
					
					/*
						$bundleDataForChild
						---
						"parent_ids': [
							parent_id
								"option_ids": [
									option_id
										"selection_ids": [
											selection_id
												entity_id
												sku
												selection_quantity
												bundle_selection_price_for_aggregation
					*/
					// NOTE This contains occluded data (like a Merkle tree) for the given current collection product
					// It does NOT build up incrementally over all the collection products.
					$bundleDataForChild = array();
					
					$bundleParentIds = array();
					$bundleParentIds = $objectManager->create('\Magento\Bundle\Model\Product\Type')
						->getParentIdsByChild($_product->getId())
					;
					
					if (count($bundleParentIds) > 0) {
						// foreach parent of current product
						foreach($bundleParentIds as $b_parentId) {
							// append parent id to $parent_ids to properly acount for row expansion
							$parent_ids['bundle'][] = $b_parentId;
							// for associative arrays
							$b_parentId_string = (string)$b_parentId;

							// Get parent of current product
							$bundleParent = $objectManager
								->create('\Magento\Catalog\Model\Product')
								->load($b_parentId)
							;
							
							$bundleParentOptions = $bundleParent->getTypeInstance(true)->getOptions($bundleParent);
							
							$bundleParentOptionIds = $bundleParent
								->getTypeInstance(true)
								->getOptionsIds($bundleParent)
							;
					
							// Get children of particular parent of current product (only children)
							$childrenOfBundle = $bundleParent->getTypeInstance(true)
								->getSelectionsCollection($bundleParentOptionIds, $bundleParent)
								->setStoreId($store_id)
								->addStoreFilter($store_id)
								// Added child product filter here to avoid extra looping
								->addAttributeToFilter('entity_id', $_product->getId())
							;
							
							// foreach children of parent of current product
							foreach ($childrenOfBundle as $cpA => $cpB) {
								
								//// option id ////
								$b_optionId = $cpB->getOptionId();
								// for associative arrays
								$b_optionId_string = (string)$b_optionId;
								
								
								$b_selectionId = $cpB->getSelectionId();
								// for associative arrays
								$b_selectionId_string = (string)$b_selectionId;
								
								//NOTE: $bundleParentOptions index keys are the actual option_id and they have already been sorted according to their Position and option_id (low to high) sorting
								
								// bundle_option_id
								
								// bundle_option_name
								$bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['bundle_option_name'] 
									= $bundleParentOptions[$b_optionId_string]->getDefaultTitle();
								
								// bundle_option_type
								$bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['bundle_option_type'] 
									= $bundleParentOptions[$b_optionId_string]->getType();
								
								// bundle_option_position
								$bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['bundle_option_position'] 
									= $bundleParentOptions[$b_optionId_string]->getPosition();
								
								// bundle_option_selection_id
								
								// (Mainly for identifiaction debugging)
								$bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['selections'][$b_selectionId_string]['entity_id'] 
									= $cpB->getEntityId();
								
								// (Mainly for identifiaction debugging)
								$bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['selections'][$b_selectionId_string]['sku'] 
									= $cpB->getSku();
								
								// bundle_option_selection_quantity
								$bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['selections'][$b_selectionId_string]['bundle_option_selection_quantity'] 
									= (int) $cpB->getSelectionQty();
								
								// bundle_option_selection_position
								$bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['selections'][$b_selectionId_string]['bundle_option_selection_position'] 
									= (int) $cpB->getPosition();
								
								// Price
								
								// price values need to be output such that the parent output summed with the children output results in the proper bundle price.
								
								// The bundle child price depends on the bundle parent price_type. 
								// Dynamic: type will technically make children's selection_price disabled (basically just 0) but instead uses children product's own price.
								// Fixed: the children's bundle selection_price will be enabled, and will just ignore the children's actual price.
								
								// nominal child price $bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['selections'][$b_selectionId_string]['actual_child_price'] = $cpB->getPrice();
								
								// adjustment value of the child product
								// If adjustment type is percent, then the new price is based on the parent price.
								// If adjustment type is not percent, then the value IS the new price.
								// $bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['selections'][$b_selectionId_string]['selection_price_value'] = $cpB->getSelectionPriceValue();
								
								// $bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['selections'][$b_selectionId_string]['selection_price_is_percent'] = $cpB->getSelectionPriceType();
								
								
								// (0 = Dynamic)
								// sum of actual price of children
								if ($bundleParent->getPriceType() == 0) {
									// In this mode, parent price is completely ignored, hence parent price = 0
									// Also in this mode, we use the child product's actual price instead of the "selection_price"
									// Also in this mode, selection_price is disabled, so we can't use it anyway
									$finalChildPrice = $cpB->getPrice(); // nominal child price
								}
								// (1 = Fixed)
								// sum of bundle-parent-scoped overriden price of children
								// may be replacement or percentage of parent
								else {
									$parentPrice = $bundleParent->getPrice();
									// if percent, unit value is 1%. So needs to be divided by 100 before applying multiplication.
									$pricingValue = $cpB->getSelectionPriceValue(); // adjustment value if parent price type is "fixed"
									
									// 1 = Percentage
									$isPercent = $cpB->getSelectionPriceType();
									if ( (bool)$isPercent ) {
										$finalChildPrice = (float)$parentPrice * (float)($pricingValue / 100);
										
									}
									// 0 = Fixed
									else {
										$finalChildPrice = (float)$pricingValue;
									}
								}
								
								// This child component price is something to be summed with its siblings and the parent in order to obtain the true bundle price.
								
								// parent price. (for reference. not needed here) $bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['selections'][$b_selectionId_string]['parent_price'] = $parentPrice;
								
								// bundle_selection_price_for_aggregation
								$bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['selections'][$b_selectionId_string]['bundle_selection_price_for_aggregation'] = number_format($finalChildPrice, 2);
								
								
								// Weight
								
								// Weight values need to be output such that the parent output summed with the children output results in the proper bundle weight.
								
								// (0 = Dynamic)
								if ($bundleParent->getWeightType() == 0) {
									// With dynamic weight, it should be the total weight of the selected child products
									// Therefore, make child weight the child weight
									$finalChildWeight = $_product->getData('weight');
								}
								// (1 = Fixed)
								else {
									// With fixed weight, the weight of the parent bundle product will be used instead,
									// Therefore, make child weight should be 0
									$finalChildWeight = 0.0;
								}
								
								// grab the data in such a format that when  the data structure to have this value accurate
								// "accurate" = the weight value that will produce the right total weight when the parent product tries to sum its children.
								
								// bundle_selection_weight_for_aggregation
								$bundleDataForChild['parents'][$b_parentId_string]['options'][$b_optionId_string]['selections'][$b_selectionId_string]['bundle_selection_weight_for_aggregation'] = $finalChildWeight;

							} // end foreach child
							
						} // end foreach parent
					} // end if
					
					// // DEBUG See if the data being gathered are the intended ones.
					// var_dump($_product->getSku());
					// var_dump('$bundleDataForChild');
					// var_dump($bundleDataForChild);
					// var_dump('----------------------------------------');
					
					
					//////////////// View ////////////////
					
					// Do row expansion  afterwards.
					// Expansion relies on $bundleDataForchild being set and populated
				}
				elseif ($attribute == 'configurable_entity_ids') {
					$configurable_ids = $objectManager->create('\Magento\ConfigurableProduct\Model\Product\Type\Configurable')->getParentIdsByChild($_product->getId());
					if (is_array($configurable_ids)) {
						$configurable_ids_unique = array_unique($configurable_ids);
						if ($type_id == 'simple') {
							$parent_ids['configurable'] = $configurable_ids_unique;
						}
						$data[$attribute] = implode($impl_expl_char, $configurable_ids_unique);
					} else {
						$data[$attribute] = '';
					}
				}
				elseif ($attribute == 'grouped_entity_ids') {
					$grouped_ids = $objectManager->create('\Magento\GroupedProduct\Model\Product\Type\Grouped')->getParentIdsByChild($_product->getId());
					if (is_array($grouped_ids)) {
						$grouped_ids_unique = array_unique($grouped_ids);
						if ($type_id == 'simple') {
							$parent_ids['grouped'] = $grouped_ids_unique;
						}
						$data[$attribute] = implode($impl_expl_char, $grouped_ids_unique);
					} else {
						$data[$attribute] = '';
					}
				}
				elseif ($attribute == 'link') {
					$data[$attribute] = $_product->getProductUrl();
				}
				elseif ($attribute == 'media_gallery_images') {
					//$mediaGalleryBackend->afterLoad($_product);
					// These will be the direct URL for the original images and not the cached ones which are resized accordingly to the store's images 
					// dimension configurations.
					$objectManager->get('\Magento\Catalog\Model\Product\Gallery\ReadHandler')->execute($_product);

					$galleryImageObjects = $_product->getMediaGalleryImages();
					
					$galleryImages = array();

					if(count($galleryImageObjects) > 0) {
						foreach ($galleryImageObjects as $g_image) {
							$galleryImages[] = $g_image['url'];
						}
					}

					$implodedString = implode($impl_expl_char, $galleryImages);
					
					$data[$attribute] = $implodedString;
				}
				elseif ($attribute == 'image_link') {
					$data[$attribute] = $catalogMediaUrl.$_product->getImage();
				}
				elseif ($attribute == 'thumbnail_image_link') {
					// We can use codes that will resize the thumbnail to an actual thumbnail dimension size. Either our own size or from the store's configuration.
					// Using getThumbnail() will only supply the actual file URL which was assigned to be a thumbnail.
					// It won't provide the actual optimised thumbnail.
					$data[$attribute] = $catalogMediaUrl.$_product->getThumbnail();
					
					// But this will. Emulation is needed to generate the thumbnail cache image, based from the store settings, for the current store.
					//$emulation = $objectManager->create('\Magento\Store\Model\App\Emulation');
					//$emulation->startEnvironmentEmulation($store_id, \Magento\Framework\App\Area::AREA_FRONTEND, true);
					//$data[$attribute] = $objectManager->get('\Magento\Catalog\Helper\ImageFactory')->create()->init($_product, 'product_thumbnail_image')->getUrl();
					//$emulation->stopEnvironmentEmulation();
				}
				elseif ($attribute == 'is_in_stock') {
					$inStock = $stockItem['is_in_stock'];
					// "0" or "1"
					if ($inStock) {
						$is_in_stock = "true";
					}
					else {
						$is_in_stock = "false";
					}
					$data[$attribute] = $is_in_stock;
				}
				elseif ($attribute == 'quantity') {
					// parents never contain quantity information.
					if (!array_key_exists($type_id, $children_types_flipped) ) {
						$quantity = '';
					}
					// is a child type product
					else {
						$quantity = (int) $stockItem['qty'];
					}
					$data[$attribute] = $quantity;
				}
				elseif ($attribute == 'price') {
					$value = '';
					
					if( array_key_exists($attribute, $accessible_product) 
					&& is_numeric($accessible_product[$attribute]) ) {
						$price = $accessible_product[$attribute];
						$value = number_format($price, 2);
					}
					
					$data[$attribute] = $value;
				}
				elseif ($attribute == 'multi_source_inventory') {
					$sourceItemsBySku = $sourceItemsBySkuModel->execute($_product->getSku());

					$sourceInventory = array();
					foreach ($sourceItemsBySku as $sourceItem) {
						$sourceInventory[$sourceItem->getSourceCode()] = $sourceItem->getQuantity(); 
					}

					$data[$attribute] = json_encode($sourceInventory);

					// $grouped_ids = $objectManager->create('\Magento\GroupedProduct\Model\Product\Type\Grouped')->getParentIdsByChild($_product->getId());
					// if (is_array($grouped_ids)) {
					// 	$grouped_ids_unique = array_unique($grouped_ids);
					// 	if ($type_id == 'simple') {
					// 		$parent_ids['grouped'] = $grouped_ids_unique;
					// 	}
					// 	$data[$attribute] = implode($impl_expl_char, $grouped_ids_unique);
					// } else {
					// 	$data[$attribute] = '';
					// }
				}
				else {
					// Obsolete
					// $data[$attribute] = $accessible_product[$attribute];

					$attr = $_product->getResource()->getAttribute($attribute);
					$attrvalue = $_product->getData($attribute);
					$data[$attribute] = ""; // DEFAULT VALUE
					if ($attr) {
						$type = $attr->getFrontendInput();
						switch($type) {
							case "select":
							case "boolean":
								$data[$attribute] = $_product->getAttributeText($attribute);
								break;
							case "multiselect":
								$arrayValues = $_product->getAttributeText($attribute);
								if (is_array($arrayValues))
									$data[$attribute] = implode($impl_expl_char, $arrayValues);
								else
									$data[$attribute] = $arrayValues;
								break;
							default:
								if (array_key_exists($attribute, $accessible_product)) {
									$data[$attribute] = $attrvalue;
								} else {
									$data[$attribute] = '';
								}
						}
					}
					if($data[$attribute] !== '' && $attribute !== 'entity_id' && $get_value_ids) {
						$attr_data = array(
							'attribute'	=> $attribute,
							'attr_value'	=> $data[$attribute],
							'attr_value_id'	=> $_product->getData($attribute),
						);
						$data[$attribute] = json_encode($attr_data);
					}
				} // end if-else attribute_code values
				
			} // end foreach attribute
			
			
			//////////////// Write Output ////////////////
			// Row expansion for children if multiple in the set of 
			// (belonging to multiple parents &U& sold individually)
			
			$has_parents = false;
			// determine if there are any parent ids.
			foreach ($parent_ids as $p_type => $ids_by_type) {
				if ( !empty($ids_by_type) ) {
					$has_parents = true;
					break;
				}
			}
			
			// turn bundle details columns to empty if no bundle parents
			if (!$has_parents) {
				
				// don't set $bundle_details_for_children_column_names columns if it wasn't specified as an attribute column for the feed to begin with.
				// use 'bundle_option_id' as an indicator for whether bundle_details_for_children was specified as an attriutes
				if (array_key_exists('bundle_option_id', $data)) {
					// bundle_option_id is just one key 
					foreach ($bundle_details_for_children_column_names as $b_c_col_name) {
						$data[$b_c_col_name] = '';
					}
				}
				
				// write data
				fputcsv($fp, $data);
			}
			// row expansion when multiple parent ids present and/or when a child product is also a standalone product
			// ensures that each parent id shows up in the correct parent type column and clear out the other types.
			else {
				// if is also standalone. output an extra row for it, scrubbing parent association data
				$visibility = $_product->getData('visibility');
				if ( $visibility == 2.0 
				|| $visibility == 4.0 ) {
					
					$data_copy_standalone = $data;
					
					if (array_key_exists('configurable_entity_ids', $data)) {
						$data_copy_standalone['configurable_entity_ids'] = '';
					}
					if (array_key_exists('grouped_entity_ids', $data)) {
						$data_copy_standalone['grouped_entity_ids'] = '';
					}
					if (array_key_exists('bundle_entity_ids', $data)) {
						$data_copy_standalone['bundle_entity_ids'] = '';
					}
					
					// detect if a signature column of bundle_details_for_children is present, 
					// and empty out those fields if so
					// account for all the bundle entity fields to preserve column count
					if (array_key_exists('bundle_option_id', $data)) {
						foreach ($bundle_details_for_children_column_names as $b_c_col_name) {
							$data_copy_standalone[$b_c_col_name] = '';
						}
					}
					
					// write row
					fputcsv($fp, $data_copy_standalone);
				}
				
				
				// also output each child row, containing 1 parent id at a time (i.e. per row)
				// foreach parent type
				foreach ($parent_ids as $p_type => $p_ids) {
					// foreach parent within the type
					foreach ($p_ids as $p_id) {
						
						$data_copy_per_parent = $data;

						if ($p_type=='configurable') {
							
							if (array_key_exists('configurable_entity_ids', $data)) {
								$data_copy_per_parent['configurable_entity_ids'] = $p_id;
							}
							if (array_key_exists('grouped_entity_ids', $data)) {
								$data_copy_per_parent['grouped_entity_ids'] = '';
							}
							// account for all the bundle entity fields to preserve column count
							// includes 'bundle_entity_ids'
							if (array_key_exists('bundle_option_id', $data)) {
								foreach ($bundle_details_for_children_column_names as $b_c_col_name) {
									$data_copy_per_parent[$b_c_col_name] = '';
								}
							}
							
							// write row
							fputcsv($fp, $data_copy_per_parent);
						}
						elseif ($p_type=='grouped') {
							
							if (array_key_exists('configurable_entity_ids', $data)) {
								$data_copy_per_parent['configurable_entity_ids'] = '';
							}
							if (array_key_exists('grouped_entity_ids', $data)) {
								$data_copy_per_parent['grouped_entity_ids'] = $p_id;
							}
							// account for all the bundle entity fields to preserve column count
							// includes 'bundle_entity_ids'
							if (array_key_exists('bundle_option_id', $data)) {
								foreach ($bundle_details_for_children_column_names as $b_c_col_name) {
									$data_copy_per_parent[$b_c_col_name] = '';
								}
							}
							
							// write row
							fputcsv($fp, $data_copy_per_parent);
						}
						elseif ($p_type=='bundle') {
							
							if (array_key_exists('configurable_entity_ids', $data)) {
								$data_copy_per_parent['configurable_entity_ids'] = '';
							}
							if (array_key_exists('grouped_entity_ids', $data)) {
								$data_copy_per_parent['grouped_entity_ids'] = '';
							}
							if (array_key_exists('bundle_entity_ids', $data)) {
								$data_copy_per_parent['bundle_entity_ids'] = $p_id;
							}
							
							
							// If no bundle parent product data for some reason, just output as-is (options and selections fields as empty)
							if ( !isset($bundleDataForChild['parents'][$p_id])
							|| !is_array($bundleDataForChild)
							|| empty($bundleDataForChild) ) {
								fputcsv($fp, $data_copy_per_parent);
							}
							// parent id for this child exists
							else {
								
								//////////////// Bundle-specific stuff ////////////////
								// Potentially expand rows again for each bundle option id.
								//
								// if no option ids, output the row once
								// Actually, if the bundle child has bundle parent but no option ids available, then something is seriously wrong. refactor for better validation, or throw error.
								if ( !isset($bundleDataForChild['parents'][$p_id]['options']) 
								|| empty($bundleDataForChild['parents'][$p_id]['options']) ) {
									fputcsv($fp, $data_copy_per_parent);
								} 
								else {
								
									$b_option_ids = array_keys($bundleDataForChild['parents'][$p_id]['options']);
									
									// options empty
									if (empty($b_option_ids)) {
										fputcsv($fp, $data_copy_per_parent);
									} 
									// options present
									else {
										
										// NOTE
										// Expansion per option_id is necessary because a child product can be used multiple times in different bundle options within a single parent bundle product.
										//
										// For example - same child product in two options of the same parent bundle:
										// The child is "DDR4 32GB RAM" to a parent bundle product, "Desktop Computer"
										// Option 1 is "Ram Slot #1" with one of the selections is "DDR4 32GB RAM"
										// Option 2 is "Ram Slot #2" with one of the selections is "DDR4 32GB RAM"
										foreach ($b_option_ids as $b_opt_id) {
											
											$data_copy_per_option = $data_copy_per_parent;
											
											// if bundle field exists in data, populate it with the actual value from $bundleDataForChild
											
											if ( array_key_exists('bundle_option_id', $data)
											&& isset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['bundle_option_id']) ) {
												// Array key is just normal array key and the values are the option_id
												$data_copy_per_option['bundle_option_id'] = $value;
											}
											
											if ( array_key_exists('bundle_option_name', $data)
											&& isset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['bundle_option_name']) ) {
												$data_copy_per_option['bundle_option_name'] = $bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['bundle_option_name'];
											}
											
											if ( array_key_exists('bundle_option_type', $data)
											&& isset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['bundle_option_type']) ) {
												$data_copy_per_option['bundle_option_type'] = $bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['bundle_option_type'];
											}
											
											if ( array_key_exists('bundle_option_position', $data)
											&& isset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['bundle_option_position']) ) {
												$data_copy_per_option['bundle_option_position'] = $bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['bundle_option_position'];
											}
											
											
											// NOTE no need to write one row per selection of a given option because
											// a given product can only ever exist once per option.
											
											// NOTE It would seem that the selection_id is required to pick the proper selection of the option,
											// but in actuality, only the single child of concern will ever be in the $bundleDataForChild structure.
											
											
											//// Validate that 'selections' key exists ////
											
											// no selections
											if ( !isset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections'])
											|| empty($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']) ) {
												fputcsv($fp, $data_copy_per_option);
											}
											else {
												
												if ( array_key_exists('bundle_option_selection_id', $data) 
												&& isset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']['bundle_option_position'])
												&& is_array($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']) ) {
													$data_copy_per_option['bundle_option_selection_id'] = key($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']);
												}
												
												// NOTE use reset to get the first (and only) selection element.
												
												if ( array_key_exists('bundle_option_selection_quantity', $data) 
												&& isset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections'])
												&& is_array($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']) ) {
													// TODO reset assumes the first value is fine.
													// but actually need to specify the correct selection id.
													// but the selection id is not on-hand from the $parent_ids at this point...
													// $data_copy_per_option['bundle_option_selection_quantity'] = reset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections'])['bundle_option_selection_quantity'];

													$temp_reset = reset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']);
													if(isset($temp_reset['bundle_option_selection_quantity'])) {
														$data_copy_per_option['bundle_option_selection_quantity'] = $temp_reset['bundle_option_selection_quantity'];
													}
													unset($temp_reset);
												}
												
												if ( array_key_exists('bundle_option_selection_position', $data) 
												&& isset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']) 
												&& is_array($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']) ) {

													$temp_reset = reset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']);

													if(isset($temp_reset['bundle_option_selection_position'])) {
														$data_copy_per_option['bundle_option_selection_position'] = $temp_reset['bundle_option_selection_position'];
													}
													// $data_copy_per_option['bundle_option_selection_position'] = reset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections'])['bundle_option_selection_position'];
													unset($temp_reset);
												}
												
												if ( array_key_exists('bundle_selection_price_for_aggregation', $data) 
												&& isset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']) 
												&& is_array($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections'])) {

													$temp_reset =  reset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']);
													if(isset($temp_reset['bundle_selection_price_for_aggregation'])) {
														$data_copy_per_option['bundle_selection_price_for_aggregation'] = $temp_reset['bundle_selection_price_for_aggregation'];
													}
													// $data_copy_per_option['bundle_selection_price_for_aggregation'] = reset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections'])['bundle_selection_price_for_aggregation'];
													unset($temp_reset);
												}
												
												if ( array_key_exists('bundle_selection_weight_for_aggregation', $data) 
												&& isset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']) 
												&& is_array($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections'])) {

													$temp_reset = reset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections']);
													if(isset($temp_reset['bundle_selection_weight_for_aggregation'])) {
														$data_copy_per_option['bundle_selection_weight_for_aggregation'] = $temp_reset['bundle_selection_weight_for_aggregation'];
													}
													// $data_copy_per_option['bundle_selection_weight_for_aggregation'] = reset($bundleDataForChild['parents'][$p_id]['options'][$b_opt_id]['selections'])['bundle_selection_weight_for_aggregation'];
													unset($temp_reset);
												}
												
												// write row for each option whether or not selection data was successfully overridden.
												fputcsv($fp, $data_copy_per_option);
											} // end if 'selections' key exists
											
										} // end foreach option
										
									} // end if option ids present
									
								} // end if 'options' key exists
								
							} // end if parent id exists
							
						} // end parent type if-else
						else {
							
							$response_bad = array(
								'success' => false,
								'message' => "Something went seriously wrong.",
								'data' => array(
									'explanation' => "parent type while row-expanding was not an expected parent type",
									"parent type" => "{$p_type}",
								),
							);
							echo json_encode($response_bad);
							die();
						}
						
					} // end parent ids loop for a given parent type
				} // end parent types loop
			} // end if-else has parent
			
			// clear product data so it doesn't pollute next product
			unset($bundleDataForChild);
		} // end foreach $_product

		//clear collection and free memory
		$productsCollection->clear();

	} // end pages loop

	
	exit;
}

################################  Mode bundle_combinations_pull - Generate super attributes Feed  ################################

if ($mode == "bundle_combinations_pull") {
	
	$cxn = mysqli_connection();
	
	//////////////// Get other params - attributes ////////////////
	$attribute_codes = $attributes;
	$attribute_codes_flipped = array_flip($attribute_codes);
	
	//////////////// Filters - Required and Optional ////////////////
	$allowed_filters_schema = array(
		'store_id' => array(
			'required' => true,
			'array_required'	=> false,
			'validation'	=> array(
				'type' => "integer",
			),
		),
		// 'product_type' => array(
		// 	'required' => true,
		// 	'array_required'	=> false,
		// 	'validation'	=> array(
		// 		'enumerated' => array(
		// 			"virtual",
		// 			"downloadable",
		// 			"simple",
		// 			"configurable",
		// 			"bundle",
		// 			"grouped",
		// 		),
		// 	),
		// ),
		'status' => array(
			'required' => true,
			'array_required'	=> false,
			'validation'	=> array(
				'enumerated' => array(
					"enabled",
					"disabled",
					"all",
				),
			),
		),
	);

	$filters_validated = validate_and_assign_params($allowed_filters_schema, $filters);
	//////////////// Apply Filters ////////////////
	
	// Store Id
	
	// Specifying an invalid store id will result in 500 error.
	// Magento default store value is 0.
	// Magento mandates at least one store, usually with store id 1.
	// Values of store 1 are fall back to values based on the default, 0.
	// Not specifying a store value will result in grabbing the available store, usually 1.
	// the function can accept string or integer numeric values.
	
	// We get the target store data by populating using the provided store_id. 
	// For now we only need the website_id, but more data can be used. See $store->getData()
	// NOTE: We are not loading the actual stores, we're just getting the store data
	$store = $storeManager->getStore()->load($filters_validated['store_id']);
	
	$website_id = $store->getWebsiteId();
	$store_id = $store->getStoreId();

	// check that the actual applied value matches the (filtered) provided value to check against bad value transformation (e.g. "asdf" becoming 1 or turning into a bad default)
	// NOTE: Zero (0) ID is admin store view. Consider this bad. We want store id specified rather than store ID 0 which will overfetch.
	if ($store_id != $filters_validated['store_id']) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid store ID",
			'data' => array(
				'explanation' => 'the attempted and applied store ids did not match',
				'attempted_store_id' => $filters_validated['store_id'],
				'applied_store_id' => $store->getId(),
			),
		);
		echo json_encode($response_bad);
		die;
	}


	// This is where the major data difference comes in. If we loaded the actual store, we are viewing data the way customers see them.
	// On Magento, there's a setting called "Flat Catalog", and some owners enable that for performance purposes. However the downside of it in our situation is that it only save/index
	// data of products which have "Enabled Status". So if we view the data via a store view, it'll only give us the products which are enabled because it goes directly to the "Flat" tables.
	// Im not sure what's the behavior if "Flat Catalog" is disabled, but i assume it'll still produce inaccurate results.
	// If we view the store via an "Admin View", it will show both enabled and disabled products.
	// Try disabling this and see the difference with the data result
	$storeManager->getStore()->setCurrentStore(0);
	
	
	//////////////// Load Models and Data  depending on selected attribute codes ////////////////
	
	//////////////// Bundle Parents ////////////////
	
	$collection = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
		// As it turns out, using "addStoreFilter" isn't enough to get the right attribute values. 
		// It only returns which products are assigned to the store, but
		// will return "admin" view values for the attributes unless we use "setStoreId" 
		->setStoreId($store_id)
		->addStoreFilter($store_id);

	// Status of product
	
	$statuses = array();
	if ($filters_validated['status'] == 'enabled') {
		$statuses[] = 1;
	}
	elseif ($filters_validated['status'] == 'disabled') {
		$statuses[] = 2;
	}
	else {
		$statuses[] = 1;
		$statuses[] = 2;
	}
	
	if (count($statuses) > 0) {
		$collection->addAttributeToFilter('status', array('in' => $statuses));
	}

	// visibility
	
	if (isset($filters_validated['visibility'])) {
		$visibility = $filters_validated['visibility'];
		
		// account for input being array or not array
		if (is_array($visibility)) {
			$visibility_value = array('in' => $visibility);
		}
		else {
			$visibility_value = $visibility;
		}
		$collection->addAttributeToFilter('visibility', $visibility_value);
	}
	
	// type_id-s (aliased to product types)
	
	$collection->addAttributeToFilter('type_id', 'bundle');
	

	//////////////// Start products collection model and apply specified filters ////////////////
	// include certain attributes in attributesToSelect() if certain other attributes are in $attribute_codes
	$attribute_to_select = array(
		'entity_id',
		'sku',
	);
	
	$collection->addAttributeToSelect($attribute_to_select);
	$collection->setPageSize($page_size);
	
	//////////////// Pagination Management ////////////////
	// starting_page

	// default initialized starting page
	$currentPage = 1;
	
	if ( isset($filters_validated['starting_page']) ) {
		$starting_page = $filters_validated['starting_page'];
	}
	
	// Override starting page if valid page number
	if (isset($starting_page) && $starting_page >= 1) {
		$currentPage = $starting_page;
	}


	// ending page
	
	// default initialized last page
	$pagesAvailable = $collection->getLastPageNumber();
	$pagesAvailable = (int)$pagesAvailable;
	
	// NOTE this must 
	// Check that starting page < pages available.
	if ( $currentPage > $pagesAvailable ) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid starting page",
			'data' => array(
				'explanation' => 'The starting page was greater than pages available.',
				'attempted_starting_page' => $currentPage,
				'pages_available' => $pagesAvailable,
			),
		);
		echo json_encode($response_bad);
		die;
	}
	
	// hard max pages
	$hard_max_pages = 5000;
	
	// max_pages
	if ( isset($filters_validated['max_pages']) ) {
		$max_pages = $filters_validated['max_pages'];
	}
	// validate
	if ( isset($max_pages) && $max_pages<1 ) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid max_pages",
			'data' => array(
				'explanation' => 'max_pages must be 1 or greater.',
				'attempted_max_pages' => $max_pages,
			),
		);
		echo json_encode($response_bad);
		die;
	}
	if ( isset($max_pages) && $max_pages>$hard_max_pages ) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid max_pages",
			'data' => array(
				'explanation' => 'max_pages must be less than or equal to the hard_max_pages.',
				'attempted_max_pages' => $max_pages,
				'hard_max_pages' => $hard_max_pages,
			),
		);
		echo json_encode($response_bad);
		die;
	}
	
	// pick appropriate last page value.
	$potential_last_pages = array();
	$potential_last_pages[] = $pagesAvailable;
	$potential_last_pages[] = $hard_max_pages;
	if ( isset($max_pages) ) {
		$potential_last_pages[] = $currentPage-1 + $max_pages;
	}

	$endingPage = min($potential_last_pages);
	$endingPage = (int)$endingPage;
	
	
	////////////////
	// Obtain max options count
	////////////////
	$greatest_options_count = 0;
	while ($currentPage <= $endingPage) {
		$collection->setCurPage($currentPage);
		$collection->load();
		
		$currentPage++;
		
		foreach ($collection as $_parent) {
			$options_ids = $_parent->getTypeInstance(true)->getOptionsIds($_parent);
			$options_count = count($options_ids);
			
			if ($options_count > $greatest_options_count)  {
				$greatest_options_count = $options_count;
			}
		}
	}
	// reset currentPage for next loop iteration
	$currentPage = 1;
	
	
	//////////////// Build Header Based on Dependencies ////////////////
	$header = array();
	$header[] = 'combination_id';
	$header[] = 'combination_salt';
	$header[] = 'bundle_entity_id';
	$header[] = 'bundle_sku';
	for ($i=0; $i<$greatest_options_count; $i++) {
		$header[] = "{$i}_o_rank";
		$header[] = "{$i}_option_position";
		$header[] = "{$i}_option_id";
		$header[] = "{$i}_option_type";
		$header[] = "{$i}_option_name";
		$header[] = "{$i}_option_is_required";
		
		$header[] = "{$i}_s_rank";
		$header[] = "{$i}_selection_position";
		$header[] = "{$i}_selection_id";
		$header[] = "{$i}_selection_quantity";
		$header[] = "{$i}_selection_entity_id";
		$header[] = "{$i}_selection_sku";
		$header[] = "{$i}_selection_name";
	}
	// // DEBUG
	// print_r($header);
	
	
	// used for empty row to ensure column count and sequence by prepopulating keys.
	$row_template = array();
	foreach ($header as $i => $name) {
		$row_template[$name] = '';
	}
	
	
	# Write header
	$fp = fopen('php://output', 'w');
	// fput_delimited($fp, $attribute_codes, $delimiter, $enclosure_char, $escape_char);
	fputcsv($fp, $header);
	
	
	//////////////// Pull Pages Data ////////////////
	while ($currentPage <= $endingPage) {
		$collection->setCurPage($currentPage);
		$collection->load();
		
		$currentPage++;

		foreach ($collection as $_parent) {
			// For reference
			// $data = array(
			//     'sku'                      => $_parent->getSKU(),
			//     'title'                    => $_parent->getName(),
			//     'description'              => $_parent->getDescription(),
			//     'short_description'        => $_parent->getShortDescription(),
			//     'link'                     => $_parent->getProductUrl(),
			//     'image_link'               => $_parent->getImageUrl(),
			//     'thumbnail_image_link'     => $_parent->getThumbnailUrl(),
			//     'is_in_stock''             => $_parent->getIsInStock()
			//     'quantity'                 => quantity,
			//     'price'                    => $_parent->getPrice(),
			//     'special_price'            => $_parent->getFinalPrice(),
			//     'manufacturer_part_number' => $_parent->getId(),
			//     'shipping_weight'          => $_parent->getWeight(),
			//     'categories'               => $categories,
			// );
			
			
			// Use a reflector to get access to private data
			
			$reflector = new \ReflectionClass($_parent);
			$classProperty = $reflector->getProperty('_data');
			$classProperty->setAccessible(true);
			$accessible_parent = $classProperty->getValue($_parent);
			
			// First master data structure
			$data_model = array();
			
			// parent data properties
			
			$entityId = $_parent->getEntityId();
			$sku = $_parent->getSku();
			
			$data_model[$entityId] = array();
			$data_model[$entityId]['sku'] = $sku;
			
			
			# OPTIONS
			$options = $_parent->getTypeInstance(true)->getOptions($_parent);
			// initialize to avoid assumption error due to not being set
			$data_model[$entityId]['options'] = array();
			// first append options data without regard to sorting.
			foreach ($options as $opt) {
				// DEBUG
				// var_dump($opt);
				// exit;
				$optionId = $opt->getOptionId();
				$optionTitle = $opt->getDefaultTitle();
				$optionType = $opt->getType();
				$optionPosition = $opt->getPosition();
				$optionRequired = (int)$opt->getRequired();
				
				// build entry
				$row_option = array(
					'option_position' => $optionPosition,
					'option_id' => $optionId,
					'option_type' => $optionType,
					'option_name' => $optionTitle,
					'option_is_required' => $optionRequired,
				);
				// append entry
				$data_model[$entityId]['options'][$optionId] = $row_option;
				
			}
			// DEBUG
			// var_dump($data_model[$entityId]['options']);
			// exit;
			
			
			// cache option ids to be used to select children
			$option_ids = array_keys($data_model[$entityId]['options']);
			
			
			# CHILDREN PRODUCTS
			
			$children = $_parent->getTypeInstance(true)
				->getSelectionsCollection($option_ids, $_parent)
				->setStoreId($store_id)
				->addStoreFilter($store_id)
				->addAttributeToFilter('status', array('in' => $statuses))
			;
			
			# SELECTIONS
			
			// attach children by matching option id match
			
			foreach ($children as $child) {
				// DEBUG
				// var_dump($child);
				$child_optionId = $child->getOptionId();
				
				$child_position = $child->getPosition();
				$child_entityId = $child->getEntityId();
				
				$child_selectionId = $child->getSelectionId();
				$child_selectionQuantity = (int)$child->getSelectionQty();
				
				$child_sku = $child->getSku();
				$child_name = $child->getName();
				
				// if child's option id was not already encountered during the parent option phase, bad
				if ( !array_key_exists($child_optionId, $data_model[$entityId]['options']) ) {
					
					$response_bad = array(
						'success' => false,
						'message' => "Unaccounted for option id encountered",
						'data' => array(
							'explanation' => 'Option id obtained from a child bundle product was not already captured during the parent product options phase.',
							'child_selection_id' => $child_selectionId,
							'child_sku' => $child_sku,
							'child_option_id' => $child_optionId,
							'parent_option_ids' => $option_ids,
						),
					);
					echo json_encode($response_bad);
					die;
				}
				
				// build entry
				$row_selection = array(
					'selection_position' => $child_position,	
					'selection_id' => $child_selectionId,
					'selection_quantity' => $child_selectionQuantity,
					'selection_entity_id' => $child_entityId,
					'selection_sku' => $child_sku,
					'selection_name' => $child_name,
				);
				
				// append entry (each selection)
				$data_model[$entityId]['options'][$child_optionId]['selections'][$child_selectionId] = $row_selection;
			}
			// // DEBUG
			// print_r($data_model);
			// print_r($data_model[$entityId]['options']);
			// exit;
			
			
			# SORTING
			
			# SORT SELECTIONS OF EACH OPTION
			
			// (handle deeply nested things first)
			foreach ($data_model[$entityId]['options'] as $opt_id => $opt) {
				// // DEBUG before sorting
				// var_dump($data_model[$entityId]['options'][$opt_id]['selections']);
				
				if ( !isset($data_model[$entityId]['options'][$opt_id]['selections']) 
				|| empty($data_model[$entityId]['options'][$opt_id]['selections']) 
				) {
					continue;
				}

				$sort_result = usort($data_model[$entityId]['options'][$opt_id]['selections'], 'sort_bundle_option_selections');
				
				// // DEBUG after sorting
				// var_dump($data_model[$entityId]['options'][$opt_id]['selections']);
				
				if (!$sort_result) {
					
					$response_bad = array(
						'success' => false,
						'message' => "sort failed for selections",
						'data' => array(
							'explanation' => 'sort failed for selections',
							'selections' => $data_model[$entityId]['options'][$opt_id]['selections'],
							'option' => $opt_id,
							'bundle_parent' => $entityId,
						),
					);
					echo json_encode($response_bad);
					die;
				}
				// // DEBUG
				// var_dump('-----------------');
			}
			// // DEBUG
			// var_dump($data_model[$entityId]['options'][$opt_id]['selections']);
			// exit;
			
			
			# SORT OPTIONS
			
			// // DEBUG before sorting
			// var_dump($data_model[$entityId]['options']);
			$sort_result = usort($data_model[$entityId]['options'], 'sort_bundle_options');
			if (!$sort_result) {
				
				$response_bad = array(
					'success' => false,
					'message' => "sort failed for options",
					'data' => array(
						'explanation' => 'sort failed for selections',
						'options' => $data_model[$entityId]['options'],
						'bundle_parent' => $entityId,
					),
				);
				echo json_encode($response_bad);
				die;
			}
			// // DEBUG after sorting
			// var_dump($data_model[$entityId]['options']);
			// print_r($data_model);
			// exit;
			
			
			# cache option greatest index
			// move pointer to end of array
			end($data_model[$entityId]['options']);
			$options_last_index = key($data_model[$entityId]['options']);
			reset($data_model[$entityId]['options']);
			if ($options_last_index === false) {
				// This means there were no options set tup for the bundle product.
				// move to next bundle parent product.
				continue;
			}
			# validate index and count
			$options_count = count($data_model[$entityId]['options']);
			if ($options_last_index+1 != $options_count) {
				// something horribly wrong.
				// Means sorting and re-indexing code had a bug
				
				$response_bad = array(
					'success' => false,
					'message' => "Something went horribly wrong.",
					'data' => array(
						'explanation' => 'sorting had a bug that should have already been accounted for',
						'options' => $data_model[$entityId]['options'],
					),
				);
				echo json_encode($response_bad);
				die;
			}
			

			# INSERT OPTIONS INTO TEMPORARY DATABASE
			
			# load each option as a temp table to be cross joined later to produce combinations
			// sorted by this point by position, then option id / selection id, ASC.
			
			// natural index based on position -> option id sorting
			foreach ($data_model[$entityId]['options'] as $i_opt => $opt) {
				
				# drop table if exists
				$query = "DROP TEMPORARY TABLE IF EXISTS fdnm_option_{$i_opt}";
				$result = mysqli_query($cxn, $query);
				if (!$result) {
					
					$response_bad = array(
						'success' => false,
						'message' => "SQL query failed.",
						'data' => array(
							'explanation' => 'Failed to drop table prior to loading new bundle parent',
							'options' => $data_model[$entityId]['options'],
							'option' => $i_opt,
							'bundle_parent' => $entityId,
						),
					);
					echo json_encode($response_bad);
					die;
				}
				
				
				# create temp table(s) for each pre-sorted option
				$query = "CREATE TEMPORARY TABLE fdnm_option_{$i_opt} (
					{$i_opt}_o_rank INT NOT NULL,
					{$i_opt}_option_position INT NOT NULL,
					{$i_opt}_option_id INT NOT NULL,
					{$i_opt}_option_type VARCHAR(64) NOT NULL,
					{$i_opt}_option_name VARCHAR(256) NOT NULL,
					{$i_opt}_option_is_required INT NOT NULL,
					
					{$i_opt}_s_rank INT NOT NULL,
					{$i_opt}_selection_position INT NOT NULL,
					{$i_opt}_selection_id INT NOT NULL,
					{$i_opt}_selection_quantity VARCHAR(32) NOT NULL,
					{$i_opt}_selection_entity_id INT NOT NULL,
					{$i_opt}_selection_sku VARCHAR(64) NOT NULL,
					{$i_opt}_selection_name VARCHAR(512) NOT NULL
				)";
				$result = mysqli_query($cxn, $query);
				if (!$result) {
					
					$response_bad = array(
						'success' => false,
						'message' => "SQL query failed",
						'data' => array(
							'explanation' => 'Failed to create option table.',
							'database_error' => mysqli_error($cxn),
							'option' => $i_opt,
							'query' => $query,
						),
					);
					echo json_encode($response_bad);
					die;
				}
				
				
				# insert pre-sorted selections into its option's table
				foreach ($opt['selections'] as $i_sel => $sel) {
					
					$selection_quantity = mysqli_real_escape_string($cxn, $sel['selection_quantity']);
					$opt_type = mysqli_real_escape_string($cxn, $opt['option_type']);
					$opt_name = mysqli_real_escape_string($cxn, $opt['option_name']);
					$sel_sku = mysqli_real_escape_string($cxn, $sel['selection_sku']);
					$sel_name = mysqli_real_escape_string($cxn, $sel['selection_name']);
					
					$query = "INSERT INTO fdnm_option_{$i_opt} 
					VALUES (
						{$i_opt},
						{$opt['option_position']},
						{$opt['option_id']},
						'{$opt_type}',
						'{$opt_name}',
						'{$opt['option_is_required']}',

						
						{$i_sel},
						{$sel['selection_position']},
						{$sel['selection_id']},
						'{$selection_quantity}',
						{$sel['selection_entity_id']},
						'{$sel_sku}',
						'{$sel_name}'
					)";
					// shouldn't need "on duplicate key update", since table is cleared for each bundle parent.
					$result = mysqli_query($cxn, $query);
					if (!$result) {
						
						$response_bad = array(
							'success' => false,
							'message' => "SQL query failed",
							'data' => array(
								'explanation' => 'Failed to insert selections data into option table.',
								'database_error' => mysqli_error($cxn),
								'selections' => $data_model[$entityId]['options'][$i_opt]['selections'],
								'option' => $i_opt,
								'query' => $query,
							),
						);
						echo json_encode($response_bad);
						die;
					}
				}
				
			}
			

			# CROSS JOIN to produce combination rows, combination id, concat string
			
			// build query string based on dynamic options count
			$query = "SELECT";
			$query .= "*";
			
			# generating salt and hash from sql
			// NOTE not suitable because we want the combination_salt to have the bundle parent entity id.
			// We don't want to put a field that is the same everywhere.
			// Also, concatenated column selections are forced to come afterwards, which causes problems because when options are not in a combination, the dynamic row output immediately appends the concatenated fields, which become annoying to place back into the correct position.
			// Actually, it's doable as the 2nd argument of array_merge...
			// And name-based mapping can be used in the platform
			// But it's also completely doable in php after getting cross joined rows too.
			/*
			// $query .= ", ";
			// $query .= "SHA1(CONCAT(";
			// for ($i=0; $i<=$options_last_index; $i++) {
			// 	$query .= " selection_id_{$i},'|',selection_quantity_{$i},'|',";
			// }
			// $query = rtrim($query, ",'|',");
			// $query .= ")) as `combination_id`";
			//
			// $query .= ", ";
			// $query .= "CONCAT(";
			// for ($i=0; $i<=$options_last_index; $i++) {
			// 	$query .= " selection_id_{$i},'|',";
			// }
			// $query = rtrim($query, ",'|',");
			// $query .= ") as `combination_salt`";
			*/
			
			$query .= " FROM fdnm_option_0 as o_0";
			// select aggregate columns cross join all option tables
			for ($i=1; $i<=$options_last_index; $i++) {
				$query .= " CROSS JOIN fdnm_option_{$i} as o_{$i}";
			}
			// // DEBUG
			// var_dump($query);
			$result = mysqli_query($cxn, $query);
			if (!$result) {
				
				$response_bad = array(
					'success' => false,
					'message' => "SQL query failed",
					'data' => array(
						'explanation' => 'Failed to get cross joins of selections of each option.',
						'database_error' => mysqli_error($cxn),
						'query' => $query,
						'selections' => $data_model[$entityId]['options'][$opt_id]['selections'],
						'option' => $i_opt,
						'bundle_parent' => $entityId,
					),
				);
				echo json_encode($response_bad);
				die;
			}
			
			
			$combo_rows = array();
			while ($row=mysqli_fetch_assoc($result)) {
				// Needs pre-filled array keys to reserve column ordering, since concatenated sql columns must be appended rather than prepended.
				
				$row_prefilled = $row_template;
				$row = array_merge($row_prefilled, $row);
				
				$combo_rows[] = $row;
			}
			
			// populate aggregate and parent fields
			foreach ($combo_rows as $name => $combo_row) {
				
				$row_output = $combo_row;
				
				$combination_salt = "{$entityId}";
				for ($i=0; $i<=$options_last_index; $i++) {
					$selection_id = $combo_row["{$i}_selection_id"];
					$selection_quantity = $combo_row["{$i}_selection_quantity"];
					$combination_salt .= "|{$selection_id}-{$selection_quantity}";
				}
				
				$row_output['combination_id'] = sha1($combination_salt);
				$row_output['combination_salt'] = $combination_salt;
				$row_output['bundle_entity_id'] = $entityId;
				$row_output['bundle_sku'] = $sku;
				
				fputcsv($fp, $row_output);
			}
			
			# DROP TEMP OPTION TABLES for the next parent product.
			foreach ($data_model[$entityId]['options'] as $i_opt => $opt) {
				# drop table if exists
				$query = "DROP TEMPORARY TABLE IF EXISTS fdnm_option_{$i_opt}";
				$result = mysqli_query($cxn, $query);
				if (!$result) {
					
					$response_bad = array(
						'success' => false,
						'message' => "SQL query failed",
						'data' => array(
							'explanation' => 'Failed to drop option table after procsesing for current ubndle product.',
							'database_error' => mysqli_error($cxn),
							'query' => $query,
							'option' => $i_opt,
							'bundle_parent' => $entityId,
						),
					);
					echo json_encode($response_bad);
					die;
				}
			}
			
			// // DEBUG
			// fputcsv($fp, array($sku, $entityId, count($combo_rows)) );
			// var_dump('----');
			// exit;
			
		} // end foreach product (parent)
		
		// clear current page so that the next page loads
		$collection->clear();
	} // end while pages
	
	
	exit;
}

################################  Mode super_pull - Generate super attributes Feed  ################################

if ($mode == "super_pull") {
	// Mode Super_Pull redevelopment
	// Rewriting using Magento native codes with store and multiple attributes filter
	
	//////////////// Get other params - attributes ////////////////
	// Due to the way super attribute validation is implemented, need to blacklist keys that may create false positives.
	
	$disallowed_attribute_codes = array(
		"entity_id",
		"entity_type_id",
		"attribute_set_id",
		"type_id",
		"sku",
		"has_options",
		"required_options",
		"created_at",
		"updated_at",
		"parent_id",
		"status",
	);
	$disallowed_attribute_codes_flipped = array_flip($disallowed_attribute_codes);
	foreach ($attributes as $attr) {
		if (array_key_exists($attr, $disallowed_attribute_codes_flipped)) {
			
			$response_bad = array(
				'success' => false,
				'message' => "Invalid attributes",
				'data' => array(
					'explanation' => 'the chosen attribute disallowed when pulling super attribute data.',
					'attempted_attribute' => $attr,
				),
			);
			echo json_encode($response_bad);
			die;
		}
	}
	$attribute_codes = $attributes;
	if ( !is_array($attribute_codes) || count($attribute_codes) <= 0 ) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid attributes",
			'data' => array(
				'explanation' => 'no attributes specified.',
				'attempted_attributes' => $attribute_codes,
			),
		);
		echo json_encode($response_bad);
		die;
	}
	
	////////////////  Filters - Required and Optional ////////////////
	$allowed_filters_schema = array(
		'store_id' => array(
			'required' => true,
			'array_required'	=> false,
			'validation'	=> array(
				'type' => "integer",
			),
		),
		'status' => array(
			'required' => true,
			'array_required'	=> false,
			'validation'	=> array(
				'enumerated' => array(
					"enabled",
					"disabled",
					"all",
				),
			),
		),
	);
	$filters_validated = validate_and_assign_params($allowed_filters_schema, $filters);
	
	$statuses = array();
	$status = $filters_validated['status'];
	if ($status == 'enabled') {
		$statuses[] = 1;
	}
	elseif ($status == 'disabled') {
		$statuses[] = 2;
	}
	else {
		$statuses[] = 1;
		$statuses[] = 2;
	}
	
	
	$store = $storeManager->getStore()->load($filters_validated['store_id']);
	
	// Zero (0) ID is admin store view
	if (!$store->getId() && $filters_validated['store_id'] != 0) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid store id.",
			'data' => array(
				'explanation' => 'specified store does not exist',
				'applied_store_id' => $store->getId(),
				'attempted_store_id' => $filters_validated['store_id'],
			),
		);
		echo json_encode($response_bad);
		die;
	}
	
	$store_id = $store->getStoreId(); // Don't really know why I did this
	$website_id = $store->getWebsiteId();
	
	// check that the actual applied value matches the (filtered) provided value to check against bad value transformation (e.g. "asdf" becoming 1 or turning into a bad default)
	if ($store_id != $filters_validated['store_id']) {
		
		$response_bad = array(
			'success' => false,
			'message' => "Invalid store id.",
			'data' => array(
				'explanation' => 'the attempted store_id did not match the applied store_id did not match',
				'applied_store_id' => $store_id,
				'attempted_store_id' => $filters_validated['store_id'],
			),
		);
		echo json_encode($response_bad);
		die;
	}
	
	
	// This is where the major data difference comes in. If we loaded the actual store, we are viewing data the way customers see them.
	// On Magento, there's a setting called "Flat Catalog", and some owners enable that for performance purposes. However the downside of it in our situation is that it only save/index
	// data of products which have "Enabled Status". So if we view the data via a store view, it'll only give us the products which are enabled because it goes directly to the "Flat" tables.
	// Im not sure what's the behavior if "Flat Catalog" is disabled, but i assume it'll still produce inaccurate results.
	// If we view the store via an "Admin View", it will show both enabled and disabled products.
	// Try disabling this and see the difference with the data result
	$storeManager->getStore()->setCurrentStore(0);
	
	
	
	$fp = fopen('php://output', 'w');
	
	$header = array();
	
	//////////////// Load Necessary Models and Data  depending on selected attribute codes ////////////////
	// prepare haeder parent identifier as well as fields for each attempted super attribute
	
	$header[] = "parent_entity_id";
	$header[] = "parent_sku";
	$header[] = "entity_id";
	$header[] = "sku";
	
	foreach ($attribute_codes as $attr_code) {
		$header[] = "{$attr_code}_option_id";
		$header[] = "{$attr_code}_option_value";
		$header[] = "{$attr_code}_super_price";
	}
	
	fputcsv($fp, $header);
	
	// parent products
	
	$parentProducts = $objectManager->create('\Magento\Catalog\Model\ResourceModel\Product\Collection')
	// As it turns out, using "addStoreFilter" isn't enough to get the right attribute values. It only returns which products are assigned to the store, but
	// will return "admin" view values for the attributes unless we use "setStoreId" 
	->setStoreId($store_id)
	->addStoreFilter($store_id)
	->addAttributeToFilter('type_id', array('in' => array('configurable')))
	->addAttributeToFilter('status', array('in' => $statuses))
	//->addAttributeToSelect('price', 'left') - Empty on Magento 2
	;

	// Load actual configurable products first filtered by product status
	foreach ($parentProducts as $parent) {
		$parentId = $parent->getId();
		$parentSku = $parent->getSku();
		$parentPrice = $parent->getPrice();
		
		$superAttributesProps = array();
		
		$saData = $parent->getTypeInstance(true)
			->getConfigurableAttributesAsArray($parent);
		
		// obtain and filter super attribute properties data
		
		// if super attribute data exists for this parent product
		if (!empty($saData) && is_array($saData) && count($saData) > 0) {
			// Select only the attributes filtered
			foreach ($saData as $saDatumKey => $saDatum) {
				
				// pick only attribute codes that were specified in the input
				if ( in_array($saDatum['attribute_code'], $attribute_codes) 
				&& count($saDatum['values']) > 0 ) {
					
					foreach ($saDatum['values'] as $i_v => $valueData) {
						$superAttributesProps[$saDatum['attribute_code']][$valueData['value_index']] = $valueData;
					}
				}
				
			}
		}
		
		
		$childProducts = array();
		
		// Configurable product's pairings are Global in Magento. Changes from one store will reflect in all stores.
		// However, child products can be filtered by store id
		$childProducts = $parent->getTypeInstance(true)
		->getUsedProductCollection($parent)
		->setStoreId($store_id)
		->addStoreFilter($store_id)
		->addAttributeToSelect(array_keys($superAttributesProps))
		->addAttributeToFilter('status', array('in' => $statuses))
		->addAttributeToSelect('price', 'left')
		;
		
		if (count($childProducts) > 0) {
			foreach ($childProducts as $child) {
				
				$childData = $child->getData();
				// Note: getData array access values can alternatively be obtained by $child->get*()
				
				$row_data = array();
				
				$row_data['configurable_entity_id'] = $parentId;
				$row_data['configurable_sku'] = $parentSku;
				
				$row_data['entity_id'] = $childData['entity_id'];
				$row_data['sku'] = $childData['sku'];
				
				foreach ($attribute_codes as $i => $attr_code) {
					if ( array_key_exists($attr_code, $superAttributesProps) ) {
						
						if (isset($childData[$attr_code])) {
							// model
							
							$saValue = $superAttributesProps[$attr_code][$childData[$attr_code]];
							
							// processing
							
							// NOTE In Magento 2, parent configurable products doesn't hold any price and the super attribute prices (percentage or fixed) was removed as well.
							// The children product's prices will be used directly instead.
							
							// normalize to a numeric value
							/*$pricingValue = $saValue['pricing_value'];
							if (empty($pricingValue)) {
								$pricingValue = "0.00";
							}
							
							$isPercent = $saValue['is_percent'];
							if ( (bool)$isPercent ) {
								$super_price = (float)$parentPrice * (float)(1 + $pricingValue/100);
							}
							else {
								$super_price = (float)$parentPrice + (float)$pricingValue;
							}*/
							
							// dollar formatting
							$super_price = number_format($childData['price'], 2);
							
							// view
							
							$row_data["{$attr_code}_option_id"] = $childData[$attr_code];
							$row_data["{$attr_code}_option_value"] = $saValue['store_label'];
							$row_data["{$attr_code}_super_price"] = $super_price;
						}
						else {
							$row_data["{$attr_code}_option_id"] = '';
							$row_data["{$attr_code}_option_value"] = '';
							$row_data["{$attr_code}_super_price"] = '';
						}
						
					}
					else {
						$row_data["{$attr_code}_option_id"] = '';
						$row_data["{$attr_code}_option_value"] = '';
						$row_data["{$attr_code}_super_price"] = '';
					}
					
				}
				
				fputcsv($fp, $row_data);
			}
		}
	}
	
	
	exit;
}
