<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_AbandonedCart
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\AbandonedCart\Model\ResourceModel\Logs;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package Mageplaza\AbandonedCart\Model\ResourceModel\Logs
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mageplaza\AbandonedCart\Model\Logs', 'Mageplaza\AbandonedCart\Model\ResourceModel\Logs');
    }

    /**
     * @return $this
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->addFieldToFilter('display', ['eq' => 1]);

        return $this;
    }

    /**
     * @return void
     */
    protected function _afterLoad()
    {
        parent::_afterLoad();
        foreach ($this->_items as $item) {
            if ($item->getRecovery() == 1) {
                $item->setStatus(2);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if ($field == 'status' && $condition['eq'] == 2) {
            $field = 'recovery';
            $condition = ['eq' => 1];
        }

        return parent::addFieldToFilter($field, $condition);
    }
}
