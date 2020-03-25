<?php
    
namespace ITM\Sportires\Block\Adminhtml;
    
class Vehicletire extends \Magento\Backend\Block\Widget\Grid\Container
{

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_vehicletire'; /* block grid.php directory */
        $this->_blockGroup = 'ITM_Sportires';
        $this->_headerText = __('Vehicletire');
        $this->_addButtonLabel = __('Add New Entry');
        parent::_construct();
    }
}
