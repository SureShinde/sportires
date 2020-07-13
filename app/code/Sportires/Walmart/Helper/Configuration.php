<?php
declare(strict_types=1);

namespace Sportires\Walmart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Configuration extends AbstractHelper
{

	protected $_objectManager;

	protected $_scopeConfig;

	CONST URL = 'marketplaces/walmart/url_service';

	CONST CLIENT_ID = 'marketplaces/walmart/client_id';

	CONST SECRET_ID = 'marketplaces/walmart/client_secret';

	CONST METHOD = 'token';
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

    public function getConfiguraion(){

    	return array(
    		'url' 		=> $this->getConfig(self::URL),
    		'client_id'	=> $this->getConfig(self::CLIENT_ID),
    		'secret_id'	=> $this->getConfig(self::SECRET_ID),
    		'auth0' => base64_encode($this->getConfig(self::CLIENT_ID).':'.$this->getConfig(self::SECRET_ID)),
    		'auth2' => 'ODBjMTJiMDAtZmZjMi00ZThmLWJkNDEtZTdkNzg3OTIyODI5OkFNNlYyd08welNfZTkxWEVQbW5TSWtJRTk3Tm1wMnA5RGtWTEpvWE5rYjB0c3l6dTRNa3dBa1dsNEVaNmpvRkNzUTNMbkFHaXZBb2R3X2lLSWdGU2ZCRQ=='

    	);
    }

    protected function getConfig($param){
    	return $this->scopeConfig->getValue($param, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getToken(){
		
    	$url = $this->getConfig(self::URL).self::METHOD;

		$postRequest = 'grant_type=client_credentials';

		$auth = base64_encode($this->getConfig(self::CLIENT_ID).':'.$this->getConfig(self::SECRET_ID));

		$header = array(
			'Accept: application/json',
		    'Authorization: Basic '.$auth,
			'Content-Type: application/x-www-form-urlencoded',
			'WM_SVC.NAME: Walmart Marketplace',
			'WM_QOS.CORRELATION_ID: '.base64_encode('sportires').'-'.rand(1000000,9999999).'-'.date('YmdHis'),
			'WM_SVC.VERSION: 1.0.0',
			'WM_CONSUMER.CHANNEL.TYPE: 0f3e4dd4-0514-4346-b39d-af0e00ea066d',
			'WM_MARKET: mx'
		);

		$cURLConnection = curl_init();
		
		curl_setopt($cURLConnection, CURLOPT_USERPWD, $this->getConfig(self::CLIENT_ID).':'.$this->getConfig(self::SECRET_ID));
		curl_setopt($cURLConnection, CURLOPT_URL, $url);
		curl_setopt($cURLConnection, CURLOPT_POST, true);
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);
		curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postRequest);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, true);
		$apiResponse = curl_exec($cURLConnection);
		curl_close($cURLConnection);

		return json_decode($apiResponse);
    }

    public function saveRequesteds($type,$request = NULL, $response = NULL, $status = NULL, $proceced = NULL){
		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
 		$connection = $resource->getConnection();

    	$sql = "INSERT INTO sportires_marketplaces_walmart_api VALUES (NULL,'$type','$request','$response',NOW(),'$status','$proceced')";
    	$connection->query($sql);
    }
}

