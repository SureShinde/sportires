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

namespace Ced\SmsaShipping\Block\Adminhtml;

/**
 * Adminhtml shipment create
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class View extends \Magento\Shipping\Block\Adminhtml\View
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $registry, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $shipid = $this->_coreRegistry->registry('current_shipment')->getIncrementId(); 
        $oid = $this->_coreRegistry->registry('current_shipment')->getEntityId();
        $shipping_method = $this->_coreRegistry->registry('current_shipment')->getOrder()->getShippingMethod();
        $url = $this->getUrl("smsashipping/order/view",array('shipment_ids'=>$oid));
        
        if ($this->getShipment()->getId() && ($shipping_method == 'smsashipping_smsashipping')) {
            $this->buttonList->add(
                'smsa_label',
                [
                    'label' => __('Generate SMSA Label'),
                    'class' => 'savgfge',
                    'target'  =>  '_blank',
                    'onclick' => 'window.open(\'' . $url . '\')'
                ]
            );
        }
    }

    
}
