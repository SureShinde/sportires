<?php
namespace Mageplaza\Simpleshipping\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;
use FedEx\RateService\Request;
use FedEx\RateService\ComplexType;
use FedEx\RateService\SimpleType;

define('FEDEX_ACCOUNT_NUMBER', '800784247');
define('FEDEX_METER_NUMBER', '250137929');
define('FEDEX_KEY', '4SVw2ztWvqzxYohU');
define('FEDEX_PASSWORD', 'Znp3NzzsT3vSo0nGQQdG4BsCR');


class Shipping extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    protected $_states = array(
        '577' => 'AG',
        '578' => 'BC',
        '579' => 'BS',
        '580' => 'CM',
        '581' => 'CS',
        '582' => 'CH',
        '584' => 'CO',
        '585' => 'CL',
        '583' => 'DF',
        '586' => 'DG',
        '588' => 'GT',
        '589' => 'GR',
        '590' => 'HG',
        '591' => 'JA',
        '587' => 'EM', 
        '592' => 'MI',
        '593' => 'MO',
        '594' => 'NA',
        '595' => 'NL',
        '596' => 'OA',
        '597' => 'PU',
        '598' => 'QE',
        '599' => 'QR',
        '600' => 'SL',
        '601' => 'SI',
        '602' => 'SO',
        '603' => 'TB',
        '604' => 'TM',
        '605' => 'TL',
        '606' => 'VE',
        '607' => 'YU',
        '608' => 'ZA'
    );
    /**
     * @var string
     */
    protected $_code = 'simpleshipping';

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    protected $_rateResultFactory;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    protected $_rateMethodFactory;

    protected $_productRepository;
    /**
     * Shipping constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface          $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory  $rateErrorFactory
     * @param \Psr\Log\LoggerInterface                                    $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory                  $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array                                                       $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    ) {
        $this->_productRepository = $productRepository;
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * get allowed methods
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }

    /**
     * @return float
     */
    private function getShippingPrice()
    {
        $configPrice = $this->getConfigData('price');

        $shippingPrice = $this->getFinalPriceWithHandlingFee($configPrice);

        return $shippingPrice;
    }

    /**
     * @param RateRequest $request
     * @return bool|Result
     */
    public function collectRates(RateRequest $request)
    {
        $packages = array();

        if (!$this->getConfigFlag('active') || !$request->getDestRegionId()) {
            return false;
        }

        $gratis =  array();
        
        $rateRequest = new ComplexType\RateRequest();

        $rateRequest->WebAuthenticationDetail->UserCredential->Key = FEDEX_KEY;
        $rateRequest->WebAuthenticationDetail->UserCredential->Password = FEDEX_PASSWORD;
        $rateRequest->ClientDetail->AccountNumber = FEDEX_ACCOUNT_NUMBER;
        $rateRequest->ClientDetail->MeterNumber = FEDEX_METER_NUMBER;

        $rateRequest->TransactionDetail->CustomerTransactionId = 'Orden de compra';

        $rateRequest->Version->ServiceId = 'crs';
        $rateRequest->Version->Major = 24;
        $rateRequest->Version->Minor = 0;
        $rateRequest->Version->Intermediate = 0;

        $rateRequest->ReturnTransitAndCommit = true;

        $rateRequest->RequestedShipment->PreferredCurrency = 'MXN';
        $rateRequest->RequestedShipment->Shipper->Address->StreetLines = ['San Borja 1031'];
        $rateRequest->RequestedShipment->Shipper->Address->City = 'Distrito Federal';
        $rateRequest->RequestedShipment->Shipper->Address->StateOrProvinceCode = 'MX';
        $rateRequest->RequestedShipment->Shipper->Address->PostalCode = '03100';
        $rateRequest->RequestedShipment->Shipper->Address->CountryCode = 'MX';
        
        $rateRequest->RequestedShipment->Recipient->Address->StreetLines = [$request->getDestStreet()];
        $rateRequest->RequestedShipment->Recipient->Address->City = $request->getDestCity();
        if (isset($this->_states[$request->getDestRegionId()])) {
            $rateRequest->RequestedShipment->Recipient->Address->StateOrProvinceCode = $this->_states[$request->getDestRegionId()];
        }
        $rateRequest->RequestedShipment->Recipient->Address->PostalCode = $request->getDestPostcode();
        $rateRequest->RequestedShipment->Recipient->Address->CountryCode = 'MX';

        $rateRequest->RequestedShipment
            ->ShippingChargesPayment->PaymentType = SimpleType\PaymentType::_SENDER;
        
        $rateRequest->RequestedShipment
            ->RateRequestTypes = [SimpleType\RateRequestType::_PREFERRED, SimpleType\RateRequestType::_LIST];
        
        $rateRequest->RequestedShipment->PackageCount = count($request->getAllItems());
        

        for ($i=0; $i < count($request->getAllItems()); $i++) { 
            $packages[$i] = new ComplexType\RequestedPackageLineItem();
        }

        $rateRequest->RequestedShipment
            ->RequestedPackageLineItems = $packages;
        
        $items = array();

        if ($request->getAllItems()) {
         foreach ($request->getAllItems() as $key => $item) {
            $items[] = $item->getSku();
            $product = $this->_productRepository->get($item->getSku());

         /*   if (!$product->getData('ts_dimensions_length') || 
                !$product->getData('ts_dimensions_width') || 
                !$product->getData('ts_dimensions_height') 
                || $item->getQty()) {
                return false;
            }*/


            $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]
                ->Weight->Value = $item->getWeight();

            $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]
                ->Weight->Units = SimpleType\WeightUnits::_KG;

            $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]
                ->Dimensions->Length = $product->getData('ts_dimensions_length');

            $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]
                ->Dimensions->Width = $product->getData('ts_dimensions_width');

            $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]
                ->Dimensions->Height = $product->getData('ts_dimensions_height');

            $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]
                ->Dimensions->Units = SimpleType\LinearUnits::_CM;

            $rateRequest->RequestedShipment->RequestedPackageLineItems[$key]
                ->GroupPackageCount = $item->getQty();


            if( (float) $product->getAttributeText('tire_diameter') < 17.0 ||  
            	$product->getAttributeText('autos_marcas') == 'Winda' ||
            	$product->getAttributeText('autos_marcas') == 'MICHELIN MOTO'
            	
            	 ) {
            	$gratis[] = 'false';
            }  else {
            	$gratis[] = 'true';
            }  

         }
        }

        $rateServiceRequest = new Request();
        $rateServiceRequest->getSoapClient()->__setLocation('https://ws.fedex.com:443/web-services'); 
        
        $rateReply = $rateServiceRequest->getGetRatesReply($rateRequest);

        $result = $this->_rateResultFactory->create();

        $method = $this->_rateMethodFactory->create();
       /* $method2 = $this->_rateMethodFactory->create();*/

        $method->setCarrier($this->_code);
        $method->setCarrierTitle('Fedex ');

      /*  $method2->setCarrier($this->_code);
        $method2->setCarrierTitle('Fedex ');*/

        $method->setMethod($this->_code);
        $method->setMethodTitle('Envío Standar');

       /* $method2->setMethod($this->_code);
        $method2->setMethodTitle('Envío Express');    */   

        $amount = $this->getShippingPrice();

        if (in_array( 'false', $gratis) && is_array($rateReply->RateReplyDetails)) {
        	$method->setPrice($rateReply->RateReplyDetails[
                    count($rateReply->RateReplyDetails) - 1
                ]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount);

        	$method->setCost($rateReply->RateReplyDetails[
                    count($rateReply->RateReplyDetails) - 1
                ]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount);


        } else {
			$method->setPrice(0);
			$method->setCost(0);
        }


        $result->append($method);


       /* $method2->setPrice($rateReply->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount);

        $method2->setCost($rateReply->RateReplyDetails[0]->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount);

        $result->append($method2);*/


        return $result;
    }
}