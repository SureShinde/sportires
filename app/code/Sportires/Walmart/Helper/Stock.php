<?php
declare(strict_types=1);

namespace Sportires\Walmart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Stock extends AbstractHelper
{

	protected $_objectManager;

	protected $_scopeConfig;

	CONST URL = 'marketplaces/walmart/url_service';

	CONST CLIENT_ID = 'marketplaces/walmart/client_id';

	CONST SECRET_ID = 'marketplaces/walmart/client_secret';

	CONST METHOD = 'inventory';

	CONST METHOD_FEED = 'feeds';
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
    	\Magento\Framework\ObjectManagerInterface $objectmanager,
    	\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Helper\Context $context
    ) {
    	$this->_objectManager = $objectmanager;
    	$this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    protected function getConfig($param){
    	return $this->scopeConfig->getValue($param, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

 
    public function getInventory($oAuth,$itemSku){

		return $this->runCurl($oAuth,'?sku='.$itemSku,'inventory');
    }

    public function updateInventory($oAuth,$itemSku){

    	$inventory = $this->createJsonToStock($itemSku);
    	return $this->runCurl($oAuth, '?sku='.$itemSku, 'inventory', 'PUT', $inventory);
    }

    public function bulkUpdate($oAuth, $marca = NULL){

    	$inventory = $this->createJsonToStockBulk($oAuth);
    	return $this->runCurl($oAuth, '?feedType=inventory', 'feed', NULL, $inventory);
    }


    protected function runCurl($oAuth, $params = NULL, $method, $typeRequest = NULL, $objStock = NULL){

    	if($method == 'inventory'){
    		$url = $this->getConfig(self::URL).self::METHOD.$params;
    		$METHOD = self::METHOD;
    	}else{
    		$url = $this->getConfig(self::URL).self::METHOD_FEED.$params;
    		$METHOD = self::METHOD_FEED;
    	}
		$auth = base64_encode($this->getConfig(self::CLIENT_ID).':'.$this->getConfig(self::SECRET_ID));

		$header = array(
			'Accept: application/json',
		    'Authorization: Basic '.$auth,
			'Content-Type: application/json',
			'WM_SVC.NAME: Walmart Marketplace',
			'WM_QOS.CORRELATION_ID: '.base64_encode('sportires').'-'.rand(1000000,9999999).'-'.date('YmdHis'),
			'WM_SVC.VERSION: 1.0.0',
			'WM_SEC.ACCESS_TOKEN: '.$oAuth->access_token,
			'WM_CONSUMER.CHANNEL.TYPE: 0f3e4dd4-0514-4346-b39d-af0e00ea066d',
			'WM_MARKET: mx'
		);

		$cURLConnection = curl_init();
		
		curl_setopt($cURLConnection, CURLOPT_USERPWD, $this->getConfig(self::CLIENT_ID).':'.$this->getConfig(self::SECRET_ID));
		curl_setopt($cURLConnection, CURLOPT_URL, $url);
		if($typeRequest == 'PUT'){
			curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "PUT");
		}
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);
		if(!empty($objStock)){
			curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $objStock);
		}
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, true);
		$apiResponse = curl_exec($cURLConnection);
		$http_code = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
		curl_close($cURLConnection);

		$this->saveRequesteds($METHOD,$url,serialize($header),str_replace("'",'',$apiResponse),$http_code,'received');

		return json_decode($apiResponse);
    }

    public function createJsonToStock($itemSku){


    	$productQty = 0;
		$productModel = $this->_objectManager->get('\Magento\Catalog\Model\Product');
		$product = $productModel->loadByAttribute('sku', $itemSku);
		$StockState = $this->_objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
		$stock = $StockState->getStockQty($product->getId(), $product->getStore()->getWebsiteId());
			
		$objStock = array(
			'sku' => $itemSku,
			'quantity' => array(
				'unit' 		=> 'EACH',
				'amount'	=> $stock
			)
		);

		return json_encode($objStock);
    }

    public function createJsonToStockBulk($marca = NULL){
		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
 		$connection = $resource->getConnection();

 		$sql = "SELECT sku,stock FROM sportires_marketplaces_walmart_stock WHERE status = 'PREPARE';";

		$results = $connection->fetchAll($sql);

		$objStock = array();
		$product_id = '';
		foreach($results as $item){

			$objStock[] = array(
				'sku' => $item['sku'],
				'quantity' => array(
					'unit' 		=> 'EACH',
					'amount'	=> (int)$item['stock']
				)
			);

			$sku = $item['sku'];

			$product_id .= "'$sku',";

		} 


		$updateTemp = "UPDATE sportires_marketplaces_walmart_stock SET status = 'PROCCESS', updated_at = NOW() WHERE sku IN ($product_id '');";
		$connection->query($updateTemp);
		$stock = array('InventoryHeader' => array('version' => '1.4'),'Inventory' => $objStock);

		return json_encode($stock);	 
    }

    public function saveRequesteds($type,$url = NULL, $request = NULL, $response = NULL, $status = NULL, $proceced = NULL){
		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
 		$connection = $resource->getConnection();

    	$sql = "INSERT INTO sportires_marketplaces_walmart_api VALUES (NULL,'$type','$url','$request','$response',NOW(),'$status','$proceced')";
    	$connection->query($sql);
    } 

    public function saveFeed($feed){
		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
 		$connection = $resource->getConnection();

    	$sql = "INSERT INTO `sportires_marketplaces_walmart_feeds` VALUES (NULL,'inventory','$feed',NOW(),NOW(),'SEND');";
    	$connection->query($sql);
    } 
}

