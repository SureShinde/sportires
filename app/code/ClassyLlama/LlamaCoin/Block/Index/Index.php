<?php


namespace ClassyLlama\LlamaCoin\Block\Index;
use ClassyLlama\LlamaCoin\Helper\FirstData;
class Index extends \Magento\Framework\View\Element\Template
{
   /**
   * @var \Magento\Framework\App\Config\ScopeConfigInterface
   */
   protected $scopeConfig;

    protected $_helperFirstData;
  /**
   * Constructor
   *
   * @param \Magento\Framework\View\Element\Template\Context  $context
   * @param ClassyLlama\LlamaCoin\Helper\FirstData $firstData;
   * @param array $data
   */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        FirstData $firstData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
    	$this->_helperFirstData = $firstData;
    	$this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function renderFormToBbva($msi){
      //$getDataBank = $this->_helperBancomer->getParamsBanck($msi);
      return 1;//$getDataBank;
    }

    public function getBaseUrlBlock(){
    	return $this->getBaseUrl();
    }

    public function getUrlFirstData(){
    	$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
      	return $this->scopeConfig->getValue('payment/classyllama_llamacoin/url_service', $storeScope);
    }

    public function getIsActive(){
      $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue('payment/classyllama_llamacoin/active', $storeScope);
    }

    public function getStoreIdFirstData(){
    	$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
      	return $this->scopeConfig->getValue('payment/classyllama_llamacoin/store_id', $storeScope);
    }

    public function getSharedFirstData(){
    	$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
      	return $this->scopeConfig->getValue('payment/classyllama_llamacoin/sharedsecret', $storeScope);
    }

    public function getUrlFail(){
		
    	$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
      	return $this->getBaseUrl().$this->scopeConfig->getValue('payment/classyllama_llamacoin/url_fail', $storeScope);
    }

    public function getUrlSuccess(){

    	$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
      	return $this->getBaseUrl().$this->scopeConfig->getValue('payment/classyllama_llamacoin/url_return', $storeScope);    	
    }

    public function getMsiIsActive(){

    	$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
      	return $this->scopeConfig->getValue('payment/classyllama_llamacoin/active_installments', $storeScope);    	
    }

    public function getMsi(){

    	$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
      	return $this->scopeConfig->getValue('payment/classyllama_llamacoin/installments', $storeScope);    	
    }    

    public function getMsiComission(){

      $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue('payment/classyllama_llamacoin/installments_comision', $storeScope);     
    } 

    public function getReservedId(){
    	return $this->_helperFirstData->updateReservedOrderId();
    }

    public function getTotalToPay(){
    	$dataOrder = $this->_helperFirstData->getOrderDetail();
    	return $dataOrder->getGrandTotal();
    }

    public function getKeytoForm(){
      $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
      $FormKey = $objectManager->get('Magento\Framework\Data\Form\FormKey'); 
      return $FormKey->getFormKey();
    }

    public function urlBaseCC($url,$params){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $key_form = $objectManager->get('Magento\Framework\Data\Form\FormKey');
        $form_Key = $key_form->getFormKey(); // this will give you from key
        $urlBuinterf = $objectManager->get('\Magento\Framework\UrlInterface');
        $urlsecret = $urlBuinterf->getUrl($url,$params);// this will give you admin secret key

        return $urlsecret;
    }    

    public function showPriceInstallments($productId,$qty = null){
  
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $product = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);
    $price = $product->getfinalPrice();
    $installments = explode(',',$this->getMsi());

      $priceTemp = 0;
      if($this->getIsActive() == 1){
        if($this->getMsiIsActive() == 1){
          if($qty == null){
            $qty = 1;
          }
          echo '<strong>Compra a meses</strong><br>';
            $commision = explode(',',$this->getMsiComission());
            $i = 0;
            while($i <= count($commision)-1){
              $priceTemp += ($price * $commision[$i] / 100);
              $priceTemp += $priceTemp*0.16;
              
              $price = $price+$priceTemp;
              echo '<strong>'.$installments[$i].'</strong> pagos de <strong>$'.number_format(($price/$installments[$i])*$qty,2,'.','').'</strong><br/>';
              ++$i;
            }
        }

      }
    }

    public function recalculateCostInQuote($productId,$installment){

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $product = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);
    if($installment == 0){
      return $product->getfinalPrice();
    }else{
    $price = $product->getfinalPrice();
    $installments = explode(',',$this->getMsi());
    $commision = explode(',',$this->getMsiComission());
    $priceTemp = 0;
    $comisionPosition = array_search($installment,$installments);
 
              $priceTemp += ($price * $commision[$comisionPosition] / 100);
              $priceTemp += $priceTemp*0.16;
              
              $price = $price+$priceTemp;
        
        return $price;     
      }
    }

    public function getIpsTest(){

      $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue('payment/classyllama_llamacoin/ips', $storeScope);     
    } 
}
