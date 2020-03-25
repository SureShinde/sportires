<?php
    
namespace ITM\MagB1\Controller\Adminhtml\Invoicefiles;
    
class NewAction extends \ITM\MagB1\Controller\Adminhtml\Invoicefiles
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
