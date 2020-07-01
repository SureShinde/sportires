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

    public function getMarcasParaMSI(){
      return array('Michelin','Bfgoodrich');
    }

    public function showPriceInstallments($productId,$qty = null){
  
    
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $product = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);
    $request = $objectManager->get('Magento\Framework\App\Action\Context')->getRequest();

    $price = $product->getfinalPrice();
    $marca = $product->getAttributeText('autos_marcas');
    $type = '';
    $installments = explode(',',$this->getMsi());
      $priceTemp = 0;
      if($this->getIsActive() == 1){
        if($this->getMsiIsActive() == 1){
          if($qty == null){
            $qty = 1;
          }

            $commision = explode(',',$this->getMsiComission());
            $i = 0;
            while($i <= count($commision)-1){

              if(!in_array($marca,$this->getMarcasParaMSI())){
                echo '<strong style="color:#243774">COMPRA A MESES<br>CON INTERESES</strong><br>';
                $priceTemp += ($price * $commision[$i] / 100);
                $priceTemp += $priceTemp*0.16;
                $price = $price+$priceTemp;
                $type = 'MCI';
              }else{
                echo '<strong style="color:#E27C7C">COMPRA A MESES<br>SIN INTERESES</strong><br>';
                $type = 'MSI';
              }
            
              if($request->getFullActionName() == 'catalog_product_view'){
              echo '<strong>'.$installments[$i].'</strong> pagos de <strong>$'.number_format(($price/$installments[$i])*$qty,2,'.','').'</strong><br/><br/>'.$this->getConditions($type);
              }
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
    $marca = $product->getAttributeText('autos_marcas');
 
        if(!in_array($marca,$this->getMarcasParaMSI())){

              $priceTemp += ($price * $commision[$comisionPosition] / 100);
              $priceTemp += $priceTemp*0.16;
              
              $price = $price+$priceTemp;
        }
        
        return $price;     
      }
    }

    public function getIpsTest(){

      $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue('payment/classyllama_llamacoin/ips', $storeScope);     
    } 

    public function getConditions($type){
      if($type == 'MSI'){

        $out = '<small style="color:#E27C7C; position: absolute; margin-top: 150px; margin-left:-30px;">
              <ol>
              <li>MSI Promoción válida únicamente para compras en nuestro sitio web.</li>
              <li>Está no aplica para ventas en mostrador.</li>
              <li>Promoción aplica únicamente en llantas de la marca <a href="'.$this->getBaseUrlBlock().'marca/michelin.html">Michelin</a> y <a href="'.$this->getBaseUrlBlock().'marca/bfgoodrich.html">BfGoodrich.</a></li>
              </ol></small>';

      }else{

        $out = '<small style="color:#E27C7C; position: absolute; margin-top: 180px; margin-left:-30px;">
              <ol>
              <li>MCI Promoción válida únicamente para compras en nuestro sitio web.</li>
              <li>Está no aplica para ventas en mostrador.</li>
              </ol></small>';

      }

      echo $out;
    }
}
