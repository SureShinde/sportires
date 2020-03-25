<?php
    
namespace ITM\Sportires\Block\Adminhtml\Vehicletire\Edit;
    
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
            $this->setId('itm_sportires_vehicletire_edit_tabs');
            $this->setDestElementId('edit_form');
            $this->setTitle(__('Vehicletire'));
    }
}
