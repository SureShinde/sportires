<?php
declare(strict_types=1);

namespace Sportires\WalmarCatalog\Block\Adminhtml\Index;

class Index extends \Magento\Backend\Block\Template
{
    protected $eavConfig;
    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Eav\Model\Config $eavConfig,
        array $data = []
    ) {
        $this->eavConfig = $eavConfig;
        parent::__construct($context, $data);
    }

    public function getAutosMarcas(){
        $attribute = $this->eavConfig->getAttribute('catalog_product', 'autos_marcas');
        return $attribute->getSource()->getAllOptions();
    }

    public function urlBase($url,$params){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $key_form = $objectManager->get('Magento\Framework\Data\Form\FormKey');
        $form_Key = $key_form->getFormKey(); // this will give you from key
        $urlBuinterf = $objectManager->get('\Magento\Framework\UrlInterface');
        $urlsecret = $urlBuinterf->getUrl($url,$params);// this will give you admin secret key

        return $urlsecret;
    }

    public function getMediaUrl(){

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();       
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');

        return $storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);        
    }

    public function getBaseUrl(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        return $storeManager->getStore()->getBaseUrl();
    }

    public function getKeyForm(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $key_form = $objectManager->get('Magento\Framework\Data\Form\FormKey');
        return  $key_form->getFormKey(); // this will give you from key        
    }

}

