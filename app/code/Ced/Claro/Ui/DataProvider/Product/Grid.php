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

namespace Ced\Claro\Ui\DataProvider\Product;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\FilterBuilder;

/**
 * Class Grid
 * @package Ced\Claro\Ui\DataProvider\Product
 */
class Grid extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var array
     */
    public $addFieldStrategies;

    /**
     * @var array
     */
    public $addFilterStrategies;

    /**
     * @var FilterBuilder
     */
    public $filterBuilder;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        FilterBuilder $filterBuilder,
        \Ced\Claro\Model\ResourceModel\Profile\CollectionFactory $profiles,
        \Ced\Claro\Helper\Config $config,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->filterBuilder = $filterBuilder;
        $this->collection = $collectionFactory->create();
        $this->collection
            //->setStoreId($config->getStore())
            ->joinField(
                'qty',
                $this->collection->getTable('cataloginventory_stock_item'),
                'qty',
                'product_id = entity_id',
                '{{table}}.stock_id=1',
                null
            );
        $this->addField(\Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID);
        $this->addField(\Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_STATUS);
        $this->addField(\Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_ERRORS);

        /*$this->addFilter(
            $this->filterBuilder->setField(\Ced\Claro\Model\Profile::ATTRIBUTE_CODE_PROFILE_ID)
                ->setConditionType('notnull')
                ->setValue('true')
                ->create()
        );*/

        $profileIds = $profiles->create()
            ->addFieldToFilter(\Ced\Claro\Model\Profile::COLUMN_STATUS, ['eq' => 1])
            ->getAllIds();

        $this->addFilter(
            $this->filterBuilder->setField(\Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID)
                ->setConditionType('in')
                ->setValue($profileIds)
                ->create()
        );

        $this->addFilter(
            $this->filterBuilder->setField('type_id')->setConditionType('in')
                ->setValue(['simple','configurable'])
                ->create()
        );

        /* $this->addFilter(
            $this->filterBuilder->setField('visibility')->setConditionType('nin')
                ->setValue([1])
                ->create()
        );*/
        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
    }

    public function addField($field, $alias = null)
    {
        if (isset($this->addFieldStrategies[$field])) {
            $this->addFieldStrategies[$field]->addField($this->getCollection(), $field, $alias);
        } else {
            parent::addField($field, $alias);
        }
    }

    /**
     * @param \Magento\Framework\Api\Filter $filter
     * @return void
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        if (isset($this->addFilterStrategies[$filter->getField()])) {
            $this->addFilterStrategies[$filter->getField()]
                ->addFilter(
                    $this->getCollection(),
                    $filter->getField(),
                    [$filter->getConditionType() => $filter->getValue()]
                );
        } else {
            parent::addFilter($filter);
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $items = $this->getCollection()->toArray();
        return [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => array_values($items),
        ];
    }
}
