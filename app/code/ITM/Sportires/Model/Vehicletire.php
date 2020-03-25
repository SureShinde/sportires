<?php
    
namespace ITM\Sportires\Model;
    
class Vehicletire extends \Magento\Framework\Model\AbstractModel
{

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('ITM\Sportires\Model\ResourceModel\Vehicletire');
    }
}
