<?php
    
namespace ITM\MagB1\Model;
    
class Invoicefiles extends \Magento\Framework\Model\AbstractModel
{

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('ITM\MagB1\Model\ResourceModel\Invoicefiles');
    }
}
