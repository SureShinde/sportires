<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Customerfiles;
    
class NewAction extends \ITM\MagB1\Controller\Adminhtml\Customerfiles
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
