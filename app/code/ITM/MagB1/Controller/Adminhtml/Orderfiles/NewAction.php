<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Orderfiles;
    
class NewAction extends \ITM\MagB1\Controller\Adminhtml\Orderfiles
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
