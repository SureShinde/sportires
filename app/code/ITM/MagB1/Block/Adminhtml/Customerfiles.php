<?php
    
namespace ITM\MagB1\Block\Adminhtml;
    
class Customerfiles extends \Magento\Backend\Block\Widget\Grid\Container
{

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_customerfiles'; /* block grid.php directory */
        $this->_blockGroup = 'ITM_MagB1';
        $this->_headerText = __('Customer Files');
        $this->_addButtonLabel = __('Add New Entry');
        parent::_construct();
    }
}
