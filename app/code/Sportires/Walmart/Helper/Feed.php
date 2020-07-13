<?php
declare(strict_types=1);

namespace Sportires\Walmart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Feed extends AbstractHelper
{

	protected $_objectManager;

	protected $_scopeConfig;

	CONST URL = 'marketplaces/walmart/url_service';

	CONST CLIENT_ID = 'marketplaces/walmart/client_id';

	CONST SECRET_ID = 'marketplaces/walmart/client_secret';

	CONST METHOD = 'feeds';

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

 
    public function getFeedStatus($oAuth,$feedId){

		return $this->runCurl($oAuth, '/'.$feedId);
    }

    public function getAllFeedsStatus($oAuth,$feedId){

		return $this->runCurl($oAuth, '?feedId='.$feedId.'&limit=10&offset=20');
    }

    public function getItemFeedStatus($oAuth,$feedId){

		return $this->runCurl($oAuth, '/?includeDetails=false&limit=50&offset=0');
    }

    protected function runCurl($oAuth, $params = NULL){


    	$url = $this->getConfig(self::URL).self::METHOD.$params;

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

		//print_r($header);
		$cURLConnection = curl_init();
		
		curl_setopt($cURLConnection, CURLOPT_USERPWD, $this->getConfig(self::CLIENT_ID).':'.$this->getConfig(self::SECRET_ID));
		curl_setopt($cURLConnection, CURLOPT_URL, $url);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, true);
		$apiResponse = curl_exec($cURLConnection);
		$http_code = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
		curl_close($cURLConnection);

		//print_r($apiResponse);

		$this->saveRequesteds(self::METHOD,$url,serialize($header),$apiResponse,$http_code,'received');

		return json_decode($apiResponse);
    }


    public function saveRequesteds($type,$url = NULL, $request = NULL, $response = NULL, $status = NULL, $proceced = NULL){
		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
 		$connection = $resource->getConnection();

    	$sql = "INSERT INTO sportires_marketplaces_walmart_api VALUES (NULL,'$type','$url','$request','$response',NOW(),'$status','$proceced')";
    	$connection->query($sql);
    }


    public function updateFeed($obj){
		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
 		$connection = $resource->getConnection();

 		foreach($obj as $feed){

 			$insert = "INSERT INTO sportires_marketplaces_walmart_feeds VALUES (NULL,'$feed->feedType','$feed->feedId',NOW(),NOW(),'$feed->feedStatus') ON DUPLICATE KEY UPDATE updated_at = NOW(), status = '$feed->feedStatus';";
 			$connection->query($insert);
 		}

    }

  
}

