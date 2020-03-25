<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Model\Catalog;

use Magento\Framework\Exception\InputException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Magb1LinkManagement extends \Magento\Bundle\Model\LinkManagement implements
    \Magento\Bundle\Api\ProductLinkManagementInterface
{

    /**
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @return \Magento\Bundle\Api\Data\OptionInterface[]
     */
    private function getOptions(\Magento\Catalog\Api\Data\ProductInterface $product)
    {
        /** @var \Magento\Bundle\Model\Product\Type $productTypeInstance */
        $productTypeInstance = $product->getTypeInstance();
        $productTypeInstance->setStoreFilter($product->getStoreId(), $product);
        
        $optionCollection = $productTypeInstance->getOptionsCollection($product);
        
        $selectionCollection = $productTypeInstance->getSelectionsCollection(
            $productTypeInstance->getOptionsIds($product),
            $product
        );
        
        $options = $optionCollection->appendSelections($selectionCollection);
        return $options;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function removeChild($sku, $optionId, $childSku)
    {
        $product = $this->productRepository->get($sku);
        
        if ($product->getTypeId() != \Magento\Catalog\Model\Product\Type::TYPE_BUNDLE) {
            throw new InputException(__('Product with specified sku: %1 is not a bundle product', $sku));
        }
        
        $excludeSelectionIds = [];
        $usedProductIds = [];
        $removeSelectionIds = [];
        $nonUsedProductIds = [];
        foreach ($this->getOptions($product) as $option) {
            /** @var \Magento\Bundle\Model\Selection $selection */
            if (!empty($option->getSelections())) {
                foreach ($option->getSelections() as $selection) {
                    if ((strcasecmp($selection->getSku(), $childSku) == 0)
                        && ($selection->getOptionId() == $optionId)) {
                            //Start
                        $removeSelectionIds[] = $selection->getSelectionId();
                        $nonUsedProductIds[] = $selection->getProductId();
                        continue;
                    }
                    $excludeSelectionIds[] = $selection->getSelectionId();
                    $usedProductIds[] = $selection->getProductId();
                }
            }
        }
        if (empty($removeSelectionIds)) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Requested bundle option product doesn\'t exist')
            );
        }
        
        $resource = $this->bundleFactory->create();
        $resource->dropAllUnneededSelections($product->getId(), $excludeSelectionIds);
        $resource->removeProductRelations($product->getId(), array_unique($nonUsedProductIds));
        
        return true;
    }
}
