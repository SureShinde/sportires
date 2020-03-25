<?php

namespace Firstdata\Gateway\Model\Resource\Tokendetails;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection {

    protected function _construct() {
        $this->_init('Firstdata\Gateway\Model\Tokendetails', 'Firstdata\Gateway\Model\Resource\Tokendetails');
    }

}