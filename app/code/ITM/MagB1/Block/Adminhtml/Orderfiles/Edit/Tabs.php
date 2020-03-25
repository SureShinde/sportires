<?php
    
namespace ITM\MagB1\Block\Adminhtml\Orderfiles\Edit;
    
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
            $this->setId('itm_magb1_orderfiles_edit_tabs');
            $this->setDestElementId('edit_form');
            $this->setTitle(__('Order Files'));
    }
}
