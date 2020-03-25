<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement(EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category  Ced
 * @package   Ced_Claro
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Ui\DataProvider\Profile;

use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class Form
 */
class Form extends AbstractDataProvider
{
    const NAMESPACE_VALUE = "claro_profile_products";

    /**
     * Product collection
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public $objectManager;

    /**
     * @var \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
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

    /** @var \Ced\Claro\Model\Profile\Product  */
    public $product;

    /** @var array  */
    public $filter = [
        "selected" => [],
        "namespace" => self::NAMESPACE_VALUE
    ];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Ced\Claro\Model\ResourceModel\Profile\CollectionFactory $collectionFactory,
        \Ced\Claro\Model\Profile\Product $product,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->product = $product;
        $this->collection = $collectionFactory->create();
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
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

        $data = [];

        foreach ($items as $item) {
            //$this->filter["selected"] = $this->Product->getIds($item['id'], $item['store_id']);
            //$item['filter'] = json_encode($this->filter);
            //$item['child_category'] = '';
            $data[$item['id']] = $item;
        }

        return $data;
    }
}
