<?php
    
namespace ITM\Sportires\Model\ResourceModel;
    
class Vehicletire extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('itm_sportires_vehicletire', 'entity_id');
    }
}
