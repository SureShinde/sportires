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

namespace Ced\Claro\Repository;

use Ced\Claro\Model\Profile\Product;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Ced\Claro\Api\Data\ProfileSearchResultsInterfaceFactory;
use Ced\Claro\Model\ResourceModel\Profile as ProfileResource;
use Ced\Claro\Model\ProfileFactory;
use Ced\Claro\Model\ResourceModel\Profile\CollectionFactory;

class Profile implements \Ced\Claro\Api\ProfileRepositoryInterface
{
    const CACHE_IDENTIFIER = "profile_";

    /** @var \Ced\Claro\Model\Cache  */
    private $cache;

    /**
     * @var \Ced\Claro\Model\ResourceModel\Profile
     */
    private $resource;

    /**
     * @var \Ced\Claro\Model\ProfileFactory
     */
    private $profileFactory;

    /**
     * @var \Ced\Claro\Model\ResourceModel\Profile\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Ced\Claro\Api\Data\ProfileSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /** @var \Ced\Claro\Model\Profile\ProductFactory  */
    private $profileProductFactory;

    /** @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory  */
    private $catalog;

    /** @var \Ced\Claro\Api\Data\ProfileSearchResultsInterface  */
    private $pool = null;

    /** @var array $relations, Product to profile ids relations */
    private $relations = [];

    public function __construct(
        \Ced\Claro\Model\Cache $cache,
        \Ced\Claro\Model\ResourceModel\Profile $resource,
        \Ced\Claro\Model\ProfileFactory $profileFactory,
        \Ced\Claro\Model\ResourceModel\Profile\CollectionFactory $collectionFactory,
        \Ced\Claro\Api\Data\ProfileSearchResultsInterfaceFactory $searchResultsFactory,
        \Ced\Claro\Model\Profile\ProductFactory $productFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $catalogCollectionFactory
    ) {
        $this->cache = $cache;
        $this->resource = $resource;
        $this->profileFactory = $profileFactory;
        $this->profileProductFactory = $productFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->catalog = $catalogCollectionFactory;
    }

    /**
     * Get object pool
     * @return \Ced\Claro\Api\Data\ProfileSearchResultsInterface
     */
    private function getPool()
    {
        if (!isset($this->pool)) {
            $this->pool = $this->searchResultsFactory->create();
        }

        return $this->pool;
    }

    /**
     * Get a Profile by Id
     * @param string $id
     * @return \Ced\Claro\Api\Data\ProfileInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $profile = $this->getPool()->getItem($id);
        if (!isset($profile)) {
            $profile = $this->profileFactory->create();
            $data = $this->cache->getValue(self::CACHE_IDENTIFIER . $id);
            if (!empty($data)) {
                $profile->addData($data);
            } else {
                $this->refresh($id, $profile);
            }
        }

        if (!$profile->getId()) {
            throw new NoSuchEntityException(__('Profile does not exist.'));
        }

        return $profile;
    }

    /**
     * Get all Profiles
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Ced\Integrator\Api\Data\SearchResultsInterface|\Ced\Claro\Api\Data\ProfileSearchResultsInterface
     * @throws NoSuchEntityException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        /** @var \Magento\Framework\Api\Search\FilterGroup $group */
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }

        /** @var \Magento\Framework\Api\SortOrder $sortOrder */
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $field = $sortOrder->getField();
            if (isset($field)) {
                $collection->addOrder(
                    $field,
                    $this->getDirection($sortOrder->getDirection())
                );
            }
        }

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        // Not loading all data, mappings need to be decoded. get ids and taking data from cache
        $collection->addFieldToSelect('id');
        $collection->load();
        $profiles = [];
        /** @var \Ced\Claro\Model\Profile $profile */
        foreach ($collection as $profile) {
            $profiles[$profile->getId()] = $this->getById($profile->getId());
        }

        /** @var \Ced\Claro\Api\Data\ProfileSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($profiles);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param \Ced\Claro\Api\Data\ProfileInterface $profile
     * @return int
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(\Ced\Claro\Api\Data\ProfileInterface $profile)
    {
        if ($profile->getId() > 0) {
            $this->clean($profile->getId());
        }

        $this->resource->save($profile);
        return $profile->getId();
    }

    /**
     * @param \Ced\Claro\Api\Data\ProfileInterface $profile
     * @param int $id
     * @return \Ced\Claro\Api\Data\ProfileInterface $profile
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function load(\Ced\Claro\Api\Data\ProfileInterface $profile, $id)
    {
        $this->resource->load($profile, $id);
        return $profile;
    }

    /**
     * Delete a profile
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        $profile = $this->profileFactory->create();
        $profile->setId($id);
        if ($this->resource->delete($profile)) {
            if (isset($this->pool[$id])) {
                unset($this->pool[$id]);
            }
            $this->cache->removeValue(self::CACHE_IDENTIFIER.$id);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Clear cache for a Profile id
     * @param $id
     */
    public function clean($id)
    {
        if (isset($this->pool[$id])) {
            unset($this->pool[$id]);
        }

        $this->cache->removeValue(self::CACHE_IDENTIFIER.$id);
    }

    /**
     * Refresh profile in cache
     * @param $id
     * @param \Ced\Claro\Api\Data\ProfileInterface
     * @throws \Exception
     * @return \Ced\Claro\Api\Data\ProfileInterface
     */
    public function refresh($id, $profile = null)
    {
        if (!isset($profile)) {
            $profile = $this->profileFactory->create();
        }

        $this->resource->load($profile, $id);
        $this->cache->setValue(self::CACHE_IDENTIFIER.$id, $profile->getData());
        return $profile;
    }

    /**
     * @param \Magento\Framework\Api\Search\FilterGroup $group
     * @param \Ced\Claro\Model\ResourceModel\Profile\Collection $collection
     */
    private function addFilterGroupToCollection($group, $collection)
    {
        $fields = [];
        $conditions = [];
        foreach ($group->getFilters() as $filter) {
            $condition = $filter->getConditionType() ?: 'eq';
            $field = $filter->getField();
            $value = $filter->getValue();
            $fields[] = $field;
            $conditions[] = [$condition=>$value];
        }

        $collection->addFieldToFilter($fields, $conditions);
    }

    private function getDirection($direction)
    {
        return $direction == SortOrder::SORT_ASC ?: SortOrder::SORT_DESC;
    }

    /**
     * Get profile Product ids
     * @param int $id
     * @param array $productIds
     * @param int $storeId
     * @return array
     * @throws  \Exception
     */
    public function getAssociatedProductIds($id, $storeId = 0, array $productIds = [])
    {
        /** @var \Ced\Claro\Model\Profile\Product $profileProduct */
        $profileProduct = $this->profileProductFactory->create();
        $allIds = $profileProduct->getIds($id, $storeId);
        if (!empty($productIds)) {
            $allIds = array_intersect($allIds, $productIds);
        }

        return $allIds;
    }

    /**
     * Get profile products
     * @param int $id
     * @param int $storeId
     * @param array $productIds
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     * @throws  \Exception
     */
    public function getAssociatedProducts($id, $storeId = 0, array $productIds = [])
    {
        $allIds = $this->getAssociatedProductIds($id, $storeId, $productIds);
        $products = $this->catalog->create()
            ->setStoreId($storeId)
            ->addAttributeToFilter('entity_id', ['in' => $allIds]);

        return $products;
    }

    /**
     * Get a Profiles by Product Id
     * @param string $productId
     * @return \Ced\Integrator\Api\Data\ProfileSearchResultsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByProductId($productId)
    {
        // TODO: Implement getByProductId() method.
    }

    /**
     * Get distinct profile ids by Product ids
     * @param array $ids
     * @return array
     */
    public function getProfileIdsByProductIds(array $ids = [])
    {
        // TODO: Implement getProfileIdsByProductIds() method.
    }
}
