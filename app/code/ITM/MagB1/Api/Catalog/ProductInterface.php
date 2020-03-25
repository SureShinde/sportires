<?php

namespace ITM\MagB1\Api\Catalog;

interface ProductInterface extends \Magento\Catalog\Api\ProductRepositoryInterface
{

    /**
     * Create product
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @param int $store_id
     * @param int[] $website_ids
     * @param bool $saveOptions
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function saveProduct(
        \Magento\Catalog\Api\Data\ProductInterface $product,
        $store_id,
        $website_ids = [],
        $saveOptions = false
    );

    /**
     * Get product list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param int $store_id
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getProductList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, $store_id);

    /**
     * @param string $key
     * @param bool $useid
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\InputException
     */
    public function deleteProductImages(
        $key,
        $useid = false
    );

    /**
     * Remove bundle option
     *
     * @param string $sku
     * @param int $optionId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\InputException
     */
    public function deleteBundleOptionById($sku, $optionId);

    /**
     * Remove bundle option
     * @param string $sku
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\InputException
     */
    public function deleteBundleOptions($sku);

    /**
     * Add options
     * @param string $sku
     * @param \Magento\Catalog\Api\Data\ProductCustomOptionInterface[] $options
     * @return \Magento\Catalog\Api\Data\ProductCustomOptionInterface[]
     */
    public function saveOptions($sku, $options);

    /**
     * Get product count
     * @param int $store_id
     * @return int
     */
    public function getProductListCount($store_id);

    /**
     * Get SKU list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param int $store_id
     * @param string $method
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getSkuList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, $store_id, $method);

    /**
     * Remove bundle option
     *
     * @param int $id
     * @return bool
     */
    public function deleteProductById($id);
}
