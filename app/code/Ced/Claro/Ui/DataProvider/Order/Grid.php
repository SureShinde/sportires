<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Ui\DataProvider\Order;

class Grid extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * Product collection
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public $objectManager;
    /**
     * @var \Ced\Claro\Model\ResourceModel\Order\Collection
     */
    public $collection;

    /**
     * @var \Magento\Ui\DataProvider\AddFieldToCollectionInterface[]
     */
    public $addFieldStrategies;

    /**
     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
     */
    public $addFilterStrategies;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param \Ced\Claro\Model\ResourceModel\Order\CollectionFactory $collectionFactory
     * @param array $addFieldStrategies
     * @param array $addFilterStrategies
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Ced\Claro\Model\ResourceModel\Order\CollectionFactory $collectionFactory,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
        $this->collection = $collectionFactory->create();
        $this->collection->getSelect()->joinLeft(
            ['sales' => $this->collection->getTable('sales_order_grid')],
            'main_table.magento_order_id = sales.entity_id',
            [
                'sales.increment_id as magento_increment_id',
                'sales.shipping_name',
                'sales.billing_name',
                'sales.base_grand_total',
                'sales.status as magento_status'
            ]
        );
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {

        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }

        $items = $this->getCollection()->getData();
        return [
            'totalRecords' =>  $this->getCollection()->getSize(),
            'items' => array_values($items),
        ];
    }
}
