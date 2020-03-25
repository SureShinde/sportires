<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_StorePickup
 * @author      CedCommerce Core Team <connect@cedcommerce.com >
 * @copyright   Copyright CEDCOMMERCE (https://cedcommerce.com/)
 * @license      https://cedcommerce.com/license-agreement.txt
 */
namespace Ced\StorePickup\Observer;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ObserverInterface;

class Filterpaymentmethod implements ObserverInterface
{

    /**
     * Catalog category
     *
     * @var \Magento\Catalog\Helper\Category
     */
    protected $catalogCategory;

    /**
     * @var \Magento\Catalog\Model\Indexer\Category\Flat\State
     */
    protected $categoryFlatState;

    /**
     * @var MenuCategoryData
     */
    protected $menuCategoryData;

    
    protected $_view;
   
    protected $_eventManager;
    /**
     * @param \Magento\Catalog\Helper\Category                   $catalogCategory
     * @param \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState
     * @param \Magento\Catalog\Observer\MenuCategoryData         $menuCategoryData
     */
    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventmanager,
        \Magento\Quote\Api\Data\CartInterface $quote,
        \Magento\Catalog\Helper\Category $catalogCategory,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Catalog\Observer\MenuCategoryData $menuCategoryData,
        \Magento\Framework\App\ViewInterface $view,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Ced\StorePickup\Model\StoreHour $storeTime,
        \Ced\StorePickup\Model\StoreInfo $storeinfo,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeconfig = $scopeConfig;
        $this->_eventManager=$eventmanager;
        $this->checkoutSession = $checkoutSession;
        $this->storeTime = $storeTime;
        $this->storeinfo = $storeinfo;
        $this->_view =$view;   
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $method = $observer->getEvent()->getMethodInstance();
        $result = $observer->getEvent()->getResult();       
        $shippingMethod = $this->checkoutSession->getQuote()->getShippingAddress()->getShippingMethod();
        $flag = false;
        if(strpos($shippingMethod,'storepickupshipping_storepickupshipping') !== false){
            $flag = true;
        }
        //var_dump($shippingMethod);die('=-=-=-');
        $showPaymentMethods=$this->scopeconfig->getValue('carriers/storepickupshipping/allowed_payment_methods');
        $showPaymentMethods=explode(',', $showPaymentMethods);

        if (!empty($showPaymentMethods) && $flag) {
            if (!in_array($method->getCode(), $showPaymentMethods)) {
                $result->setData('is_available',false);
            }
        }   
    }
}