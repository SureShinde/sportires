<?php
/**
 * Copyright © 2016 Scommerce Mage. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Scommerce\GoogleRemarketing\Block;

/**
 * Google Remarketing Page Block
 */
class Script extends \Magento\Framework\View\Element\Template
{

    /**
     * Google Remarketing Allowed Page Types
     * @see https://support.google.com/adwords/answer/3103357?hl=en
     */
    private $_allowedPageTypes 	= array('home','searchresults','category','product','cart','purchase','other');

    /**
     * Default product attribute to use for
     */
    private $_productAttribute 	= 'sku';

    /**
     * Default pagetype
     */
    private $_pagetype			= 'other';
	
	/**
	 * Default cart and sales attribute to use 
	 */
	private $_saleAttribute 	= 'product_id';

    /**
     * @var \Magento\Framework\Registry
     */

    protected $_registry;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_salesFactory;

    /**
     * Checkout session
     *
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Scommerce\GoogleRemarketing\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $_jsonHelper;

    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $_pricingHelper;
	
	/**
     * @var \Magento\Catalog\Model\ProductFactory
     */
	protected $_productLoader;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Scommerce\GoogleRemarketing\Helper\Data $helper
     * @param \Magento\Sales\Model\OrderFactory $salesOrderFactory
	 * @param \Magento\Catalog\Model\ProductFactory $productLoader
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Framework\Pricing\Helper\Data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Scommerce\GoogleRemarketing\Helper\Data $helper,
        \Magento\Sales\Model\Order $salesOrderFactory,
		\Magento\Catalog\Model\ProductFactory $productLoader,
        \Magento\Framework\Registry $registry,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        array $data = []
    ) {
        $this->_salesFactory = $salesOrderFactory;
		$this->_productLoader = $productLoader;
        $this->_checkoutSession = $checkoutSession;
		$this->_layout = $context->getLayout();
        $this->_helper = $helper;
        $this->_registry = $registry;
        $this->_jsonHelper = $jsonHelper;
        $this->_pricingHelper = $pricingHelper;
		$this->_productAttribute 	= $this->_helper->getProductAtributeKey();
        parent::__construct($context, $data);
    }

    /**
     * Return catalog product object
     *
     * @return \Magento\Catalog\Model\Product
     */

    public function getProduct()
    {
        return $this->_registry->registry('product');
    }

    /**
     * Return catalog category object
     *
     * @return \Magento\Catalog\Model\Category
     */

    public function getCategory()
    {
        return $this->_registry->registry('current_category');
    }

    /**
     * Retrieve current order
     *
     * @return \Magento\Sales\Model\Order\OrderFactory
     */
    public function getOrder()
    {
        $orderId = $this->_checkoutSession->getLastOrderId();
        return $this->_salesFactory->load($orderId);
    }

    /**
     * Set current pagetype
     * @param string
     */
    public function setPageType($pagetype){
        if(in_array(strtolower($pagetype),$this->_allowedPageTypes)){
            $this->_pagetype = strtolower($pagetype);
        }
    }

    /**
     * Set product attribute to use for Google Product Key
     * @param string
     */
    public function setProductAttributeName($attributename){
        $this->_productAttribute = strtolower($attributename);
    }

    /**
     *
     */
    public function getJsConfigParams(){

        /**
         * Default parameters
         */		
		if ($this->_helper->isOtherSiteEnabled()){
			$_params = array(
				'dynx_pagetype' => $this->_pagetype,
				'dynx_itemid' => '',
				'dynx_totalvalue' => 0
			);
		}
		else{
			$_params = array(
				'ecomm_pagetype' => $this->_pagetype,
				'ecomm_prodid' => '',
				'ecomm_totalvalue' => 0
			);
		}

        switch($this->_pagetype){
            default:
                break;

            case 'product':
                $_params = array_merge($_params,$this->collectCurrentProductData());
                break;
				
			case 'category':
				$_params = array_merge($_params,$this->collectCurrentCategoryData());
				break;
				
            case 'cart':
                $_params = array_merge($_params,$this->collectCurrentCartData());
                break;

            case 'purchase':
                $_params = array_merge($_params,$this->collectCurrentOrderData());
                break;
        }

        $param = preg_replace('/"([^"]+)"s*:s*/', '$1: $2',$this->_jsonHelper->jsonEncode($_params));
        $param = str_replace(',',','.chr(13),$param);
        $param = str_replace('{','{'.chr(13),$param);
        $param = str_replace('}',chr(13).'}',$param);
        // Return parameters as an json encoded string
        return $param;
    }
	
	/**
	 * Collect the data from current category
	 */
	private function collectCurrentCategoryData(){
		$_category = $this->getCategory();
		$_params = array();
		if($_category && $_category instanceof \Magento\Catalog\Model\Category){
			$products = array();
			$prices = array();
			$total = 0;
			$_productCollection = $this->_layout->getBlockSingleton('Magento\Catalog\Block\Product\ListProduct')->getLoadedProductCollection();
			foreach ($_productCollection as $_product){
				 $products[] = $this->getProdId($_product, 'catalog');
				 $total = $total + (float)$_product->getFinalPrice();
			}
			
			if ($this->_helper->isOtherSiteEnabled()){
				$_params['dynx_pagetype'] 	 = 'other';
				$_params['dynx_itemid'] 	 = $products;
				$_params['dynx_totalvalue']  = $total;
			}else{
				$_params['ecomm_prodid'] = $products;
				$_params['ecomm_totalvalue'] = $total;
			}
		}
		return $_params;
	}

    /**
     * Collect the data from current product
     */
    private function collectCurrentProductData(){
        $_product = $this->getProduct();
		$_params = array();
        if($_product && $_product instanceof \Magento\Catalog\Model\Product){
			if ($this->_helper->isOtherSiteEnabled()){
				$_params['dynx_pagetype'] 	 = 'offerdetail';
				$_params['dynx_itemid'] 	 = $this->getProdId($_product, 'catalog');
				$_params['dynx_totalvalue']  = $this->formatPrice($_product->getFinalPrice());
			}else{
				$_params['ecomm_prodid'] 	 = $this->getProdId($_product, 'catalog');
				$_params['ecomm_totalvalue'] = $this->formatPrice($_product->getFinalPrice());
				$_params['ecomm_pvalue'] 	 = $this->formatPrice($_product->getFinalPrice());

				if($this->getCategory()){
					$_params['ecomm_category'] = $this->getCategory()->getName();
				}
			}
        }
		return $_params;
    }

    /**
     * Collect data from the shopping cart page
     */
    private function collectCurrentCartData(){
        $_quotation = $this->_checkoutSession->getQuote();
        if($_quotation && $_quotation instanceof \Magento\Quote\Model\Quote){

            $qtys		= array();
            $products 	= array();

            foreach($_quotation->getAllVisibleItems() as $_product){
                $qtys[] 	= number_format($_product->getQty(),0);
                $products[] = $this->getProdId($_product, 'sales');
            }
			$_params = array();
			if ($this->_helper->isOtherSiteEnabled()){
				$_params['dynx_pagetype'] 	 = 'conversionintent';
				$_params['dynx_itemid'] 	 = $products;
				$_params['dynx_totalvalue']  = $this->formatPrice($_quotation->getGrandTotal());
				$_params['dynx_quantity'] 	 = $qtys;
			}
			else{			
				$_params['ecomm_prodid']	 = $products;
				$_params['ecomm_totalvalue'] = $this->formatPrice($_quotation->getGrandTotal());
				$_params['ecomm_quantity'] 	 = $qtys;
			}
            return $_params;
        }
    }

    /**
     * Collect data from the current order
     */
    private function collectCurrentOrderData(){
        $_order = $this->getOrder();
        if($_order && $_order instanceof \Magento\Sales\Model\Order){

            $total = $_order->getGrandTotal();
            $qtys = array();
            $products = array();
            $prices = array();

            foreach($_order->getAllVisibleItems() as $_product){
                $products[] = $this->getProdId($_product, 'sales');
                $qtys[] = number_format($_product->getQtyOrdered(),0);
                $prices[] = number_format($_product->getPrice(),2);

            }

            $_params = array();
			if ($this->_helper->isOtherSiteEnabled()){
				$_params['dynx_pagetype'] 	 = 'conversion';
				$_params['dynx_itemid'] 	 = $products;
				$_params['dynx_totalvalue']  = $this->formatPrice($total);
				$_params['dynx_quantity'] 	 = $qtys;
			}
			else{
				$_params['ecomm_prodid'] 	 = $products;
				$_params['ecomm_totalvalue'] = $this->formatPrice($total);
				$_params['ecomm_quantity']   = $qtys;
				$_params['ecomm_pvalue']     =  $prices;
			}
			
			$_params['hasaccount'] 		 = ($_order->getCustomerIsGuest() == 1) ? 'N' : 'Y';
			
            return $_params;

        }

        return false;
    }

    /**
     * Formats a price in store currency settings
     */
    private function formatPrice($price){
        return $this->_pricingHelper->currency($price,false,false);
    }

    /**
     * Return helper object
     *
     * @return \Scommerce\GoogleRemarketing\Helper\Data
     */
    public function getHelper()
    {
        return $this->_helper;
    }
	
	/**
     * Gets prodid attribute string from product object
     */
    private function getProdId($_product, $type){
		if ($type =="sales"){
			$product = $this->_productLoader->create()->load($_product->getData($this->_saleAttribute));
			return $product->getData($this->_productAttribute);
		}
		else{
			return $_product->getData($this->_productAttribute);
		}
    }

    /**
     * Render block html if google remarketing is active
     *
     * @return string
     */
    protected function _toHtml()
    {
       return $this->_helper->isEnabled() ? parent::_toHtml() : '';
    }
}
