<?php
    
namespace ITM\MagB1\Model\ResourceModel\Categoryfiles ;
    
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('ITM\MagB1\Model\Categoryfiles', 'ITM\MagB1\Model\ResourceModel\Categoryfiles');
    }
}
