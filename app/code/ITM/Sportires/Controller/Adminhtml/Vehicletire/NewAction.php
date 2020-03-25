<?php
    
namespace ITM\Sportires\Controller\Adminhtml\Vehicletire;
    
class NewAction extends \ITM\Sportires\Controller\Adminhtml\Vehicletire
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
