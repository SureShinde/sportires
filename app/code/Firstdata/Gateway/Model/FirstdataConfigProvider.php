<?php
namespace Firstdata\Gateway\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\Asset\Source;
use Firstdata\Gateway\Model\Adminhtml\Source\Localisation;
use \Firstdata\Gateway\Model\Tokendetails;


class FirstdataConfigProvider implements ConfigProviderInterface
{

    /**
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    protected $localisation;
    protected $scopeConfig;
    protected $assetRepo;
	
    /**
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;
    protected $savetoken;
    protected $checkoutSession;

    /**
     *
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Payment\Helper\Data $paymentHelper
     * @param \Firstdata\Gateway\Helper\Data $dataHelper
     * @param string $methodCode
     */
    public function __construct(
	\Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Payment\Helper\Data $paymentHelper,
        \Magento\Payment\Model\CcConfig $ccConfig,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Localisation $localisation,
        Tokendetails $savetoken       
         
    ) {
	
        $this->ccConfig = $ccConfig;
        $this->scopeConfig = $scopeConfig;       
        $this->storeManager = $storeManager;       
        $this->urlBuilder = $urlBuilder;
        $this->logger = $logger;  
        $this->assetRepo = $assetRepo;	
        $this->localisation = $localisation;
        $this->savetoken = $savetoken;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
            
	
    public function getConfig()
    {
        return [
            'payment' => [
                'firstdata' => [
                    'getLogoUrl' => $this->getLogoUrl(),
                    'getDescription' => $this->getDescription(),
                    'getEmi' => $this->getEmi(),
                    'getTokenization' => $this->getTokenization(),
                    'getAvailableOptions' => $this->getAvailableOptions(),
                    'getDisplayLogo' => $this->getDisplayLogo(),
                    'storedCards' => $this->getStoredCards(),
                    'getLocalpayments' => $this->getLocalpayments(),
                    'getLocalpaymentslist' => $this->getLocalpaymentslist(),
                    'getAuthorization' => $this->getAuthorization(),
                    'getcartsupport' => $this->getcartsupport(),
                    'geterrormessage' => $this->geterrormessage()
                ]      
            ] 
        ];
    }
	 
    protected function getLogoUrl()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $country = $this->scopeConfig->getValue("payment/firstdata/country", $storeScope);
        $reseller = $this->scopeConfig->getValue("payment/firstdata/reseller", $storeScope);            
        $reseller_details = $this->localisation->getCountryConfig($country,$reseller);

        return isset($reseller_details['logo'])? $reseller_details['logo'] : "";            		  
    }
    
    protected function getViewFileUrl($fileId, array $params = [])
    {
        try {
            return $this->assetRepo->getUrlWithParams($fileId, $params);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->logger->critical($e);
            return $this->urlBuilder->getUrl('', [
                '_direct' => 'core/index/notFound'
            ]);
        }
    }
	
    protected function getDescription()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;        
        $description = $this->scopeConfig->getValue("payment/firstdata/description", $storeScope);       
        return $description;        
    }
    
    //Tokenization	
    protected function getTokenization(){	
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $tokenization = $this->scopeConfig->getValue("payment/firstdata/tokenization", $storeScope);
        return $tokenization;		 
    }

    //Authorization	
    protected function getAuthorization(){	
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $auth_ux = $this->scopeConfig->getValue("payment/firstdata/auth_ux", $storeScope);
        return $auth_ux;		 
    }

    // Local Payments
    protected function getLocalpayments(){	
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $localpayments = $this->scopeConfig->getValue("payment/firstdata/localpayments", $storeScope);
        return $localpayments;		
    }

    //Local Payment List

    protected function getLocalpaymentslist(){
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;            
        $localpayments_list = explode(",", $this->scopeConfig->getValue("payment/firstdata/localpaymentslist", $storeScope)); 
        $localpayments = array();
        foreach($localpayments_list as $paymentmethod){
            $localpayments[] = array(
                'value' => $paymentmethod,					
                'label' => $this->localisation->getPaymentMethodValue($paymentmethod)
            );
        }
        return $localpayments;
    }


    //Emi
    protected function getEmi(){	
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $emi_active = $this->scopeConfig->getValue("payment/firstdata/emi_active", $storeScope);
        return $emi_active;		 
    }

    //Emi Options
    protected function getAvailableOptions(){
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $emi_active = $this->scopeConfig->getValue("payment/firstdata/emi_active", $storeScope);
        $emi_options = $this->scopeConfig->getValue("payment/firstdata/emi_options", $storeScope);


        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();   
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');                     
        $total_amt = number_format($cart->getQuote()->getGrandTotal(), 2, '.', '');

        //$total_amt = 500;
        $options = array();
        if($emi_active == 1){
            $emi_unserialize_data = unserialize($emi_options);
            foreach($emi_unserialize_data as $key => $emidata){                    				
                if (($total_amt >= $emidata['minamount']) && $total_amt <= $emidata['maxamount']) {
                    $options[] = array(
                        'value' => $emidata['count']."#".isset($emidata['period']),					
                        'label' => $emidata['Label']
                    );
                }
            }
        }  
        return $options;
    }


    public function getStoredCards(){	

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $customerSession = $objectManager->get('Magento\Customer\Model\Session');		
        $customer_id = $customerSession->getCustomer()->getId();
        $tokens =  $this->savetoken->load($customer_id)->getCollection()
                                   ->addFieldToFilter('customer_id', $customer_id);

        $savedcards = array();
        foreach($tokens as $token){                    							
                $savedcards[] = array(
                        'value' => $token['pseudo_cc_no'],
                        'label' => $token['alias']
                );
        }

        return $savedcards;
    }

    //Display Logo
    protected function getDisplayLogo(){	
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $display_logo = $this->scopeConfig->getValue("payment/firstdata/display_logo", $storeScope);
        return $display_logo;
    }
	
	protected function getcartsupport() {		 	
		 return $this->localisation->getcartsupportdetail();
    }
	
	protected function geterrormessage() {		 			
		return $this->localisation->getvalidationerror();		
	}
}
