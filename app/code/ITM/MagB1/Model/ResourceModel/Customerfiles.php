<?php
    
namespace ITM\MagB1\Model\ResourceModel;
    
class Customerfiles extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('itm_magb1_customerfiles', 'entity_id');
    }
}
