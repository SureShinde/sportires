<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Categoryfiles;
    
class NewAction extends \ITM\MagB1\Controller\Adminhtml\Categoryfiles
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
