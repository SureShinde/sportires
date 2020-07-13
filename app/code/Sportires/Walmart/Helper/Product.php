<?php
declare(strict_types=1);

namespace Sportires\Walmart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Product extends AbstractHelper
{


	protected $_objectManager;

	protected $_scopeConfig;

	CONST URL = 'marketplaces/walmart/url_service';

	CONST CLIENT_ID = 'marketplaces/walmart/client_id';

	CONST SECRET_ID = 'marketplaces/walmart/client_secret';

	CONST METHOD = 'items';

	CONST METHOD_FEEDS = 'feeds';
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

    public function bulkFeed($oAuth,$idProduct,$action = NULL){

    	$xml = $this->prepareSquemaItem($action, $idProduct);

    	return $this->runCurl($oAuth,'?feedType=item','multipart/formdata', $xml);
    }

    public function getAllItems($oAuth){
		
		$params = '?sku=2792005&offset=2000&limit=20';

		return $this->runCurl($oAuth,$params);

    }

    public function getAnItem($oAuth,$itemSku){

		$params = '/'.$itemSku;

		return $this->runCurl($oAuth,$params);

    }


    protected function runCurl($oAuth,$params,$applicationType = NULL, $xml = NULL){

		$accepted = 'application/json';

		if($params == '?feedType=item'){

    		$url = $this->getConfig(self::URL).self::METHOD_FEEDS.$params;//'?sku=2792005&offset=2000&limit=20'
    		$accepted = 'application/xml';
    		$METHOD = self::METHOD_FEEDS;
		}else{
			$url = $this->getConfig(self::URL).self::METHOD.$params;//'?sku=2792005&offset=2000&limit=20'
			$METHOD = self::METHOD;
		}


		$auth = base64_encode($this->getConfig(self::CLIENT_ID).':'.$this->getConfig(self::SECRET_ID));

		if(empty($applicationType)){
			$applicationType = 'application/x-www-form-urlencoded';
		}

		$header = array(
			'Accept: '.$accepted,
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

		if($params == '?feedType=item'){

			curl_setopt($cURLConnection, CURLOPT_POST, true);
			curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $xml);
		}
		curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);
		curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($cURLConnection, CURLOPT_SSL_VERIFYPEER, true);
		$apiResponse = curl_exec($cURLConnection);
		$http_code = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE);
		curl_close($cURLConnection);
		
		$this->saveRequesteds($METHOD,$url,serialize($header),str_replace("'",'',$apiResponse),$http_code,'received');

		return json_decode($apiResponse);
    }

    public function prepareSquemaItem($action = NULL,$idProduct){
    	date_default_timezone_set('America/Mexico_City');
		$fileSystem = $this->_objectManager->create('\Magento\Framework\Filesystem');
		$mediaPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();



		$product = $this->_objectManager->create('Magento\Catalog\Model\Product')->load($idProduct);

		$positions = array('{{date}}','{{ACTION}}','{{sku}}','{{upc}}','{{name}}','{{walmart_price}}','{{rin}}','{{short_description_g}}','{{features}}','{{marca}}','{{modelo}}','{{url_imagen_1}}','{{url_image_2}}','{{velocidad}}','{{runflat}}','{{carga}}','{{treadwear}}','{{traccion}}','{{temperatura}}','{{modelos}}','{{weight}}','{{meta_keyword}}','{{warningText}}','{{modelo}}','{{tire_size}}','{{vehicleType}}','{{ts_dimensions_length}}','{{ts_dimensions_width}}','{{ts_dimensions_height}}','{{itemsIncluded}}','{{countryOfOriginAssembly}}','{{VehiclePartsAndAccessories}}','{{product_video}}','{{short_description}}','{{msi}}','{{walmart_price_msi}}','{{mpoffer_start}}','{{mpoffer_end}}','{{ts_dimensions_width_ship}}','{{ts_dimensions_height_ship}}','{{ts_dimensions_length_ship}}','{{weight_ship}}','{{tax}}','{{shipping_discount}}','{{garantia_sportires}}','{{conficiones_garantia}}','{{meses_garantia}}','{{pais_origen}}','{{dias_para_entrega}}');

		    $images = $product->getMediaGalleryImages();
		    $img1 = '';
		    $img2 = '';
		    $i = 0;
		    $find = 'http://localhost/sportires/';
		    $replace = 'https://sportires.com.mx/';
		    foreach($images as $child){ 


		        if($i == 0){
		        	$img1 = str_replace($find, $replace, $child->getUrl());
		        }else{
		        	$img2 = str_replace($find, $replace, $child->getUrl());
		        }

		        ++$i;
		    }

		    $runFlat = 'NO';
		    if(!empty($product->getRunflat())){
		    	$runFlat = 'YES';
		    }

		    $warningText = 'AQUI LOS WARNINGS';
		    $datePromotionStart = '2020-01-01';
		    $datePromotionEnd = date('Y-m-d');
		    $tax = 16;
		    $shipping_discount = 0.00;
		    $garantia_sportires = 'AQUI LA LEYENDA DE LA GARANTIA';
		    $conficiones_garantia = 'AQUI LAS CONDICIONES DE LA GARANTIA';
		    $meses_garantia = 3;
		    $pais_origen = 'México';
		    $dias_para_entrega = 4;

		$replace = array(date('Y-m-d\TH:i:s'),$action, $product->getSku(), $product->getUpc(), $product->getName(), $product->getWalmartPrice(), $product->getAttributeText('tire_diameter'), substr($product->getShortDescriptionG(),0,4000),substr($product->getDescriptionG(),0,4000),$product->getAttributeText('autos_marcas'),$product->getAttributeText('modelos'),$img1,$img2, 'J (100 km/h)'/*$product->getVelocidad()*/,$runFlat,/*$product->getCarga()*/12345,$product->getTreadwear(),$product->getTraccion(),$product->getTemperatura(),$product->getAttributeText('modelos'),round($product->getWeight()),$product->getMetaKeyword(),$warningText,$product->getAttributeText('modelos'),$product->getAttributeText('tire_size'),'Auto',round($product->getTsDimensionsLength()),round($product->getTsDimensionsWidth()),round($product->getTsDimensionsHeight()),$product->getName(),'México','Izquierda-Derecha','',substr($product->getShortDescription(),0,4000),'No',$product->getWalmartPrice(),$datePromotionStart,$datePromotionEnd,round($product->getTsDimensionsWidth()+5),round($product->getTsDimensionsHeight()+5),round($product->getTsDimensionsLength()+5),$product->getWeight()+5, $tax, $shipping_discount, $garantia_sportires, $conficiones_garantia, $meses_garantia, $pais_origen, $dias_para_entrega);

		$result = '';
		$attributes = array(); 
		$xsdstring = $mediaPath.'Marketplaces/Walmart/Feeds/Xsd/ProductBulk.xml';

		$fn = fopen($xsdstring,"r");
			while(! feof($fn))  {
			$result .= str_replace($positions,$replace,fgets($fn));
		}

		fclose($fn);

		return $result;
    }

    public function saveRequesteds($type,$url = NULL, $request = NULL, $response = NULL, $status = NULL, $proceced = NULL){
		$resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
 		$connection = $resource->getConnection();

    	$sql = "INSERT INTO sportires_marketplaces_walmart_api VALUES (NULL,'$type','$url','$request','$response',NOW(),'$status','$proceced')";
    	$connection->query($sql);
    }

}

