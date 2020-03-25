<?php
    
namespace ITM\MagB1\Model\ResourceModel;
    
class Invoicefiles extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('itm_magb1_invoicefiles', 'entity_id');
    }
}
