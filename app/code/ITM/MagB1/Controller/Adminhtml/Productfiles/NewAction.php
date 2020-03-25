<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Productfiles;
    
class NewAction extends \ITM\MagB1\Controller\Adminhtml\Productfiles
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
