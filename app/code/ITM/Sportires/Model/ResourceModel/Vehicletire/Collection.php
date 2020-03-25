<?php
    
namespace ITM\Sportires\Model\ResourceModel\Vehicletire ;
    
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ITM\Sportires\Model\Vehicletire', 'ITM\Sportires\Model\ResourceModel\Vehicletire');
    }
}
