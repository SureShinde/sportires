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
namespace Ced\StorePickup\Block\Adminhtml\Stores\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('post_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Store Pickup Information'));
        
    }

    protected function _beforeToHtml() 
    {
        $this->addTab(
            'Store_basic_Information', array(
            'label'     => __('Store basic Information'),
            'content'   => $this->getLayout()->createBlock('Ced\StorePickup\Block\Adminhtml\Stores\Edit\Tab\Main')->toHtml().$this->getLayout()->createBlock('Ced\StorePickup\Block\Adminhtml\Stores\Edit\Tab\Storehour')->SetTemplate('ced/address.phtml')->toHtml(),
            )
        );
        /*$this->addTab(
            'Store_Hour_Information', array(
            'label'     => __('Store Hour Information '),
            'content'   => $this->getLayout()->createBlock('Ced\StorePickup\Block\Adminhtml\Stores\Edit\Tab\Storehour')->SetTemplate('ced/storehour.phtml')->toHtml(),
            )
        );*/
        return parent::_beforeToHtml();
    }
}
