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

namespace Ced\Claro\Model\Profile;

use Ced\Claro\Model\Cache;

/**
 * Class Product
 * @package Ced\Claro\Model\Profile
 */
class Product implements \Ced\Integrator\Model\Profile\ProductInterface
{
    const CACHE_KEY_PROFILE_PRODUCT = "profile_product_";
    const PROFILE_VALUE_NA = "na";

    /** @var \Magento\Catalog\Model\Product\ActionFactory */
    public $action;

    /** @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory */
    public $catalog;

    /** @var \Ced\Claro\Model\Cache */
    public $cache;

    /** @var array */
    public $pool;

    /** @var \Magento\Store\Model\StoreManagerInterface  */
    public $storeManager;

    /**
     * Product constructor.
     * @param Cache $cache
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\Product\ActionFactory $actionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $catalog
     */
    public function __construct(
        \Ced\Claro\Model\Cache $cache,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Product\ActionFactory $actionFactory,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $catalog
    ) {
        $this->cache = $cache;
        $this->storeManager = $storeManager;
        $this->action = $actionFactory;
        $this->catalog = $catalog;
    }

    /**
     * @param null $profileId
     * @param int $storeId
     * @param array $ids
     */
    public function remove($profileId = null, $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID, array $ids = [])
    {
        if (!empty($profileId)) {
            if ($this->storeManager->hasSingleStore()) {
                $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID;
            }

            if (!empty($ids)) {
                $this->action->create()
                    ->updateAttributes(
                        $ids,
                        [\Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID => null],
                        $storeId
                    );
            }

            if (isset($this->pool[$storeId][$profileId])) {
                unset($this->pool[$storeId][$profileId]);
            }

            $this->cache->removeValue(self::CACHE_KEY_PROFILE_PRODUCT . $storeId . "_" . $profileId);
        }
    }

    /**
     * Get Profile Product Ids
     * @param $profileId
     * @param int $storeId
     * @return array
     * @throws \Exception
     */
    public function getIds($profileId, $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID)
    {
        if ($this->storeManager->hasSingleStore()) {
            $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID;
        }

        if (isset($this->pool[$storeId][$profileId]) && is_array($this->pool[$storeId][$profileId])) {
            $ids = $this->pool[$storeId][$profileId];
        } else {
            $ids = $this->cache->getValue(self::CACHE_KEY_PROFILE_PRODUCT . $storeId . "_" . $profileId);
            if (!isset($ids)) {
                $ids = $this->get($profileId, $storeId)->getAllIds();
                $this->cache->setValue(self::CACHE_KEY_PROFILE_PRODUCT . $storeId . "_" . $profileId, $ids);
            }

            $this->pool[$storeId][$profileId] = $ids;
        }

        return $ids;
    }

    /**
     * @param $profileId
     * @param int $storeId
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function get($profileId, $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID)
    {
        if ($this->storeManager->hasSingleStore()) {
            $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID;
        }

        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection $collection */
        $collection = $this->catalog->create();
        $collection
            ->setStoreId($storeId)
            ->addFieldToFilter(
                \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID,
                [
                    'eq' => $profileId
                ]
            )
            ->addFieldToFilter(
                \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID,
                [
                    'neq' => self::PROFILE_VALUE_NA
                ]
            );
        return $collection;
    }

    /**
     * Note: In case of single store, values are set only on admin store ( i.e. 0 store)
     * Update profile id to Product ids
     * @param null $profileId
     * @param int $storeId
     * @param array $ids
     * @throws \Exception
     */
    public function add($profileId = null, $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID, $ids = [])
    {
        if ($this->storeManager->hasSingleStore()) {
            $storeId = \Magento\Store\Model\Store::DEFAULT_STORE_ID;
        } else {
            // Updating values to Admin store, for issue regarding inner join as admin store is used for default values.
            $this->action->create()
                ->updateAttributes(
                    $ids,
                    [\Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID => self::PROFILE_VALUE_NA],
                    \Magento\Store\Model\Store::DEFAULT_STORE_ID
                );
        }

        // Updating selected store
        $this->action->create()->updateAttributes(
            $ids,
            [\Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID => $profileId],
            $storeId
        );

        if (isset($this->pool[$storeId][$profileId])) {
            unset($this->pool[$storeId][$profileId]);
        }

        $this->cache->removeValue(self::CACHE_KEY_PROFILE_PRODUCT . $storeId . "_" . $profileId);

        $this->getIds($profileId, $storeId);
    }
}
