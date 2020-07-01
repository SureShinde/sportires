<?php
error_reporting(0);
use Magento\Framework\App\Bootstrap;
use Psr\Log\LoggerInterface;
use Magento\Framework\ObjectManagerInterface;

require __DIR__ . '/app/bootstrap.php';
$params = $_SERVER;
$bootstrap = Bootstrap::create(BP, $params);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
$obj = $bootstrap->getObjectManager();

$resource = $obj->get('Magento\Framework\App\ResourceConnection');
$connection = $resource->getConnection();

$fileSystem = $obj->create('\Magento\Framework\Filesystem');
$mediaPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
echo '<pre>';

	$select = 'SELECT * FROM `store_pickup` WHERE  is_active = 1 ORDER BY pickup_id ASC;';
    $tires = $connection->fetchAll($select);

    $address = array();
    foreach($tires as $tire){

    	$address[] = array(
    		'geometry' => array(
    		'type' => 'Point',
    		'coordinates' => array(
	    			(float)$tire['longitude'],
	    			(float)$tire['latitude']
	    		)
    		),
    		'type' => 'Feature',
    		'properties' => array(
    			'category' => 'patisserie',
    			'ci' => $tire['is_home'],
    			'hours' => "Lunes a Viernes 9:00-18:00 hrs. Sábados 9:00-14:00 hrs.",
    			'description' => utf8_encode($tire['store_address'].', '.$tire['store_city'].', '.$tire['store_state'].', C.P. '.$tire['store_zcode']),
    			'name'	=>  utf8_encode($tire['store_name'])
    		)
    	);

    }

    $arreglo['type'] = 'FeatureCollection';
    $arreglo['features'] = $address;



$fp = fopen('pub/media/sportires/map/stores.json', 'w');
fwrite($fp, json_encode($arreglo,JSON_UNESCAPED_UNICODE));
fclose($fp);
