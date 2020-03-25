<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Shipmentfiles;
    
class NewAction extends \ITM\MagB1\Controller\Adminhtml\Shipmentfiles
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
