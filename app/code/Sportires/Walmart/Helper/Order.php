<?php
declare(strict_types=1);

namespace Sportires\Walmart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Order extends AbstractHelper
{

	protected $_objectManager;

	protected $_scopeConfig;

	CONST URL = 'marketplaces/walmart/url_service';

	CONST CLIENT_ID = 'marketplaces/walmart/client_id';

	CONST SECRET_ID = 'marketplaces/walmart/client_secret';

	CONST METHOD = 'orders';

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

 
    public function getAllReleasedOrders($oAuth,$params){

		return $this->runCurl($oAuth, '?statusCodeFilter=Created&limit=100&offset=0');
    }

    public function getAllOrders($oAuth,$params){

		return $this->runCurl($oAuth, '?customerOrderId=&purchaseOrderId=&statusCodeFilter=&createdStartDate=&createdEndDate=&limit=10&offset=10');
    }

    public function getAnOrder($oAuth,$orderId){

		return $this->runCurl($oAuth, '?purchaseOrderId='.$orderId);
    }

    public function acknowledgeOrders($oAuth,$orderId){

		return $this->runCurl($oAuth, '/'.$orderId.'/acknowledge', $orderId, 'acknowledge', 'POST');
    }

    public function cancelOrderLines($oAuth,$orderId,$lines){

    	return $this->runCurl($oAuth, '/'.$orderId.'/cancel', $orderId, 'cancelorderlines', 'POST', $lines);
    }

    public function shippingUpdates($oAuth,$orderId){

		return $this->runCurl($oAuth, '/'.$orderId.'/ship', $orderId, 'ship', 'POST');
    }


    /**
    *	TODO ERROR NO RESPONDE NADA VALIDAR CON PERSONAL DE WALMART
    **/
    public function getLabel($oAuth,$orderId,$trackingNumber){

		return $this->runCurl($oAuth, '/label/'.$trackingNumber, $orderId, 'label');    	
    }


    public function getBulkShippinglabel($oAuth){

		return $this->runCurl($oAuth, '/labels', NULL, 'labels');
    }


    protected function runCurl($oAuth, $params = NULL, $orderId = NULL, $action = NULL, $method = NULL, $lines = NULL){


    	$url = $this->getConfig(self::URL).self::METHOD.$params;
   

		$auth = base64_encode($this->getConfig(self::CLIENT_ID).':'.$this->getConfig(self::SECRET_ID));


		if($action == 'label' || $action == 'labels'){
			$ContentType = 'application/octet-stream';
		}else{
			$ContentType = 'application/json';
		}

		$header = array(
			'Accept: '.$ContentType,
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
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, true);

		if(!empty($method)){

			switch($action){
				case 'acknowledge':
				$obj = json_encode($this->getAcknowledgeOrders($orderId));
				break;
				case 'cancelorderlines':
				$obj = json_encode($this->getCancel($orderId,$lines));
				break;	
				case 'ship':
				$obj = json_encode($this->getShip($orderId));
				break;	
				case 'labels':
				$obj = json_encode($this->getTracks());
				break;				
											
			}

			curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $obj);
		}


		$apiResponse = curl_exec($cURLConnection);
		$http_code = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
	
		curl_close($cURLConnection);

		$this->saveRequesteds(self::METHOD,$url,serialize($header),str_replace("'",'',$apiResponse),$http_code,'received');	

		return json_decode($apiResponse);
    }

    /**
    *	TODO ajustar una ves que la orden este en Magento para aceptar las lineas de la misma
    **/
    protected function getAcknowledgeOrders($orderId){

    	$array = array(
    		'orderAcknowledge' => array(
    			'orderLines'	=> array(
    				'orderLine' => array(
    					'lineNumber' 		=> 1,
    					'orderLineStatuses'	=> array(
    						'status'			=> 'Acknowledged',
    						'statusQuantity'	=> array(
    							'unitOfMeasurement'	=> 'EACH',
    							'amount'			=> 4
    						)
    					)
    				)
    			)
    		)
    	);

    	return $array;
    }

    /**
    *	TODO, preparar para poder cancelar productos  y  lineas en la orden
    **/
    protected function getCancel($orderId,$lines){

    	$array = array(
    		'orderCancellation' => array(
    			'orderLines'	=> array(
    				'orderLine'	=> array(
    					'lineNumber'		=> $lines,
    					'orderLineStatuses'	=>array(
    						'orderLineStatus'	=> array(
    							'status'			=> 'Cancelled',
    							'cancellationReason'=> 'CUSTOMER_REQUESTED_SELLER_TO_CANCEL',
    							'statusQuantity'	=> array(
    								'statusQuantity'	=> array(
    									'unitOfMeasurement'	=> 'EACH',
    									'amount'			=> 2
    								)
    							)
    						)
    					)
    				)
    			)
    		)
    	);

    	return $array;
    }

    public function getShip($orderId){

    	$array = array(
    		'shipments' => array(
    			array(
    				'shipmentLines' => array(
    					'primeLineNo'		=> 2,
    					'shipmentLineNo'	=> '1001',
    					'quantity'			=> array(
    						'unitOfMeasurement'	=> 'EACH',
    						'amount'			=> 1
    					)
    				),
    				'shipDateTime'	=> 1540845015000,
    				'carrierName'	=> array(
    					'otherCarrier'	=> NULL,
    					'carrier'		=> 'UPS'
    				),
    				'methodCode'		=> 'Standard',
    				'carrierMethodCode'	=> NULL,
    				'trackingNumber'	=> '499902537770',
    				'trackingURL'		=> 'http://www.fedex.com'
    			)
    		)
    	);

    	return $array;
    }

    public function getTracks(){

		$array = array(
			'trackingNumbers' => array(
				'499903935503','477502530976'
			)
		);

		return $array;
    }

    public function saveRequesteds($type,$url = NULL, $request = NULL, $response = NULL, $status = NULL, $proceced = NULL){
		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
 		$connection = $resource->getConnection();

    	$sql = "INSERT INTO sportires_marketplaces_walmart_api VALUES (NULL,'$type','$url','$request','$response',NOW(),'$status','$proceced')";
    	$connection->query($sql);
    }

}

