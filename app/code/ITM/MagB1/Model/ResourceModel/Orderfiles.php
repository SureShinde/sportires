<?php
    
namespace ITM\MagB1\Model\ResourceModel;
    
class Orderfiles extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('itm_magb1_orderfiles', 'entity_id');
    }
}
