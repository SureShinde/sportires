<?php
    
namespace ITM\MagB1\Block\Adminhtml;
    
class Productfiles extends \Magento\Backend\Block\Widget\Grid\Container
{

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_productfiles'; /* block grid.php directory */
        $this->_blockGroup = 'ITM_MagB1';
        $this->_headerText = __('Product Files');
        $this->_addButtonLabel = __('Add New Entry');
        parent::_construct();
    }
}
