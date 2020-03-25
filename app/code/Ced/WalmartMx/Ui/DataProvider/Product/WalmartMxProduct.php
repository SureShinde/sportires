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
 * @package   Ced_WalmartMx
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\WalmartMx\Ui\DataProvider\Product;

use Ced\WalmartMx\Model\ProfileProduct;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Api\FilterBuilder;
use Ced\WalmartMx\Model\Profile;

/**
 * Class WalmartMxProduct
 * @package Ced\WalmartMx\Ui\DataProvider\Product
 */
class WalmartMxProduct extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var FilterBuilder
     */
    public $filterBuilder;

    /**
     * @var Profile
     */
    public $profile;
    /**
     * @var array
     */
    public $addFieldStrategies;

    /**
     * @var array
     */
    public $addFilterStrategies;


    public function __construct(
        CollectionFactory $collectionFactory,
        FilterBuilder $filterBuilder,
        ProfileProduct $profileProduct,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->filterBuilder    = $filterBuilder;
        $this->collection       = $collectionFactory->create();

        $this->collection->joinField(
            'qty',
            'cataloginventory_stock_item',
            'qty',
            'product_id = entity_id',
            '{{table}}.stock_id=1',
            null
        );
        $this->addField('walmartmx_product_status');
        $this->addField('walmartmx_profile_id');
        $this->addField('walmartmx_validation_errors');
        $this->addField('walmartmx_feed_errors');
        $this->addFilter(
            $this->filterBuilder->setField('walmartmx_profile_id')->setConditionType('notnull')
                ->setValue('true')
                ->create()
        );
        $this->addFilter(
            $this->filterBuilder->setField('type_id')->setConditionType('in')
                ->setValue(['simple','configurable'])
                ->create()
        );
        $this->addFilter(
            $this->filterBuilder->setField('visibility')->setConditionType('nin')
                ->setValue([1])
                ->create()
        );
        $this->addFieldStrategies   = $addFieldStrategies;
        $this->addFilterStrategies  = $addFilterStrategies;
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
            if($filter->getField() == 'walmartmx_product_status' && $filter->getValue() == 'NOT_UPLOADED') {
                $filterData = array(
                    array(
                        'attribute' => $filter->getField(),
                        'null' => true),
                    array(
                        'attribute' => $filter->getField(),
                        'eq' => $filter->getValue())
                );
                $this->getCollection()->addAttributeToFilter($filterData);
            } else {
                parent::addFilter($filter);
            }
        }
    }

    /**
     * Add field to select
     *
     * @param  string|array $field
     * @param  string|null  $alias
     * @return void
     */
    public function addField($field, $alias = null)
    {
        if (isset($this->addFieldStrategies[$field])) {
            $this->addFieldStrategies[$field]->addField($this->getCollection(), $field, $alias);
        } else {
            parent::addField($field, $alias);
        }
    }
}
