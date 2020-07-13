<?php
declare(strict_types=1);

namespace Sportires\Walmart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Price extends AbstractHelper
{


	protected $_objectManager;

	protected $_scopeConfig;

	CONST URL = 'marketplaces/walmart/url_service';

	CONST CLIENT_ID = 'marketplaces/walmart/client_id';

	CONST SECRET_ID = 'marketplaces/walmart/client_secret';

	CONST METHOD = 'price';
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

 
    public function updatePrice($oAuth,$itemId){

    	$xml = $this->loadXmlByItem($itemId);

		return $this->runCurl($oAuth,NULL,'application/XML',$xml,'PUT', NULL);

    }

    public function updateBulkPrices($oAuth,$marca = NULL){

    	echo $xml = $this->loadXmlByBulk($marca);

		return $this->runCurl($oAuth,NULL,NULL,$xml,NULL,'feedType');    	
    }

    protected function runCurl($oAuth, $params = NULL, $applicationType = NULL, $xml = NULL, $method = NULL, $feedType){

    	if(!empty($feedType)){
    		echo $url = $this->getConfig(self::URL).self::METHOD.'?feedType='.self::METHOD;
    	}else{
    		echo $url = $this->getConfig(self::URL).self::METHOD;
    	}
		$auth = base64_encode($this->getConfig(self::CLIENT_ID).':'.$this->getConfig(self::SECRET_ID));

		if(empty($applicationType)){
			$applicationType = 'multipart/formdata';//'application/x-www-form-urlencoded';
		}

		$header = array(
			'Accept: application/json',
		    'Authorization: Basic '.$auth,
			'Content-Type: '.$applicationType,
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
		if(!empty($method)){
			curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, "PUT");
		}
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);
		if(!empty($xml)){
			curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $xml);
		}
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, true);
		$apiResponse = curl_exec($cURLConnection);
		$http_code = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
		curl_close($cURLConnection);

		$this->saveRequesteds(self::METHOD,$url,serialize($header),str_replace("'",'',$apiResponse),$http_code,'received');

		return json_decode($apiResponse);
    }

    public function loadXmlByItem($itemId){

		$fileSystem = $this->_objectManager->create('\Magento\Framework\Filesystem');
		$mediaPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
		$xsdstring = $mediaPath.'Marketplaces/Walmart/Feeds/Xsd/PriceUpdate.xml';

		$product = $this->_objectManager->get('Magento\Catalog\Model\Product')->load($itemId);

		$result = '';
		$tags = array('{{sku}}','{{price}}','{{tipePrice}}');
		$content = array($product->getSku(),$product->getCustomAttribute('walmart_price')->getValue(),'BASE');

		$fn = fopen($xsdstring,"r");
			while(! feof($fn))  {
			$result .= str_replace($tags,$content,fgets($fn));
		}

		fclose($fn);

		return $result;
    }

    public function loadXmlByBulk($marca = NULL){

		$fileSystem = $this->_objectManager->create('\Magento\Framework\Filesystem');
		$mediaPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
		$xsdstring = $mediaPath.'Marketplaces/Walmart/Feeds/Xsd/PriceObjectBulk.xml';

		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
 		$connection = $resource->getConnection();
 		$sql = " SELECT a.sku,b.value FROM catalog_product_entity a
					 INNER JOIN catalog_product_entity_varchar b
					 ON a.`entity_id` = b.`entity_id`
					 AND b.`attribute_id` = 263
					 INNER JOIN catalog_product_entity_int c
					 ON a.`entity_id` = c.`entity_id`
					 AND c.`attribute_id` = 162
					 AND c.`value` = $marca LIMIT 3;"; 

		$results = $connection->fetchAll($sql); 

		$result = '';
		$resultFull = '';

		foreach($results as $item){

			$tags = array('{{sku}}','{{price}}');
			$content = array($item['sku'],$item['value']);

			$fn = fopen($xsdstring,"r");
				while(! feof($fn))  {
				$result .= str_replace($tags,$content,fgets($fn));
			}

			fclose($fn);

		}

		$xsdstringBody = $mediaPath.'Marketplaces/Walmart/Feeds/Xsd/PriceBulk.xml';
		$fn2 = fopen($xsdstringBody,"r");
			while(! feof($fn2))  {
			$resultFull .= str_replace('{{contentPricesBulk}}',$result,fgets($fn2));
		}

		fclose($fn2);

		return $resultFull;
    }

    public function saveRequesteds($type,$url = NULL, $request = NULL, $response = NULL, $status = NULL, $proceced = NULL){
		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
 		$connection = $resource->getConnection();

    	$sql = "INSERT INTO sportires_marketplaces_walmart_api VALUES (NULL,'$type','$url','$request','$response',NOW(),'$status','$proceced')";
    	$connection->query($sql);
    }    

}

