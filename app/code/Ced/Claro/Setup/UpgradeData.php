<?php

namespace Ced\Claro\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

/**
 * Class UpgradeData
 * @package Ced\Claro\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Eav\Attribute
     */
    private $eavAttribute;

    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $eavAttribute
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavAttribute = $eavAttribute;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $setup->startSetup();
            /** @var \Magento\Eav\Setup\EavSetup $eavSetup*/
            $eavSetup = $this->eavSetupFactory->create();
            $groupName = 'Claro';
            $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
            $attributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);
            $eavSetup->addAttributeGroup($entityTypeId, $attributeSetId, $groupName, 500);
            $eavSetup->getAttributeGroupId($entityTypeId, $attributeSetId, $groupName);

            //drop down for claro product
            if (!$this->eavAttribute->getIdByCode(
                'catalog_product',
                \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_PRICING
            )) {
                $eavSetup->addAttribute(
                    'catalog_product',
                    \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_PRICING,
                    [
                        'group' => $groupName,
                        'input' => 'select',
                        'type' => 'int',
                        'label' => 'Price Variations Type',
                        'visible' => 1,
                        'required' => 0,
                        'sort_order' => 90,
                        'user_defined' => 1,
                        'source' => 'Ced\Claro\Ui\Component\Listing\Columns\Product\Options',
                        'global'=> \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    ]
                );
            }
            
            //price field for claro product
            if (!$this->eavAttribute->getIdByCode(
                'catalog_product',
                \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRICING_FIELD
            )) {
                $eavSetup->addAttribute(
                    'catalog_product',
                    \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRICING_FIELD,
                    [
                        'group' => $groupName,
                        'note' => 'Enter increment/decrement value. Do not include any special character like % etc.',
                        'input' => 'text',
                        'type' => 'varchar',
                        'label' => 'Increment\Decrement Value ',
                        'visible' => 1,
                        'required' => 0,
                        'sort_order' => 100,
                        'user_defined' => 1,
                        'comparable' => 0,
                        'visible_on_front' => 0,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    ]
                );
            }
            $setup->endSetup();
        }
    }
}

