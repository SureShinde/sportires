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
 * @category    Ced
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Setup;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    public $eavSetupFactory;
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    public $objectManager;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Eav\Attribute
     */
    public $eavAttribute;

    /**
     * InstallData constructor.
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $eavAttribute
     */
    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $eavAttribute
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->objectManager = $objectManager;
        $this->eavAttribute = $eavAttribute;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.0.1', '<')) {
            /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            /**
             * Add attributes to the eav/attribute
             */
            $groupName = 'Claro';
            $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
            $attributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);
            $eavSetup->addAttributeGroup($entityTypeId, $attributeSetId, $groupName, 1000);
            $eavSetup->getAttributeGroupId($entityTypeId, $attributeSetId, $groupName);

            // creating "claro_product_status" attribute
            if (!$this->eavAttribute->getIdByCode(
                'catalog_product',
                \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_STATUS
            )) {
                $eavSetup->addAttribute(
                    'catalog_product',
                    \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_STATUS,
                    [
                        'group' => 'Claro',
                        'note' => 'Product status on Claro Marketplace',
                        'input' => 'text',
                        'type' => 'text',
                        'label' => 'Claro Status',
                        'backend' => '',
                        'visible' => 1,
                        'required' => 0,
                        'sort_order' => 12,
                        'user_defined' => 1,
                        'searchable' => 0,
                        'visible_on_front' => 0,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                    ]
                );
            }

            // creating "claro_product_errors" attribute
            if (!$this->eavAttribute->getIdByCode(
                'catalog_product',
                \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_ERRORS
            )) {
                $eavSetup->addAttribute(
                    'catalog_product',
                    \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_ERRORS,
                    [
                        'group' => 'Claro',
                        'note' => "Claro Errors",
                        'input' => 'text',
                        'type' => 'text',
                        'label' => 'Claro Errors',
                        'backend' => '',
                        'visible' => 1,
                        'required' => 0,
                        'sort_order' => 14,
                        'user_defined' => 1,
                        'searchable' => 0,
                        'filterable' => 0,
                        'comparable' => 0,
                        'visible_on_front' => 0,
                        'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                    ]
                );
            }

            // creating "claro_profile_id" attribute
            if (!$this->eavAttribute->getIdByCode(
                'catalog_product',
                \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID
            )) {
                $eavSetup->addAttribute(
                    'catalog_product',
                    \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID,
                    [
                        'group' => $groupName,
                        'note' => 'Claro Profile Id',
                        'input' => 'text',
                        'type' => 'varchar',
                        'label' => 'Claro Profile Id ',
                        'backend' => '',
                        'visible' => 1,
                        'required' => 0,
                        'sort_order' => 1,
                        'user_defined' => 1,
                        'comparable' => 0,
                        'visible_on_front' => 0,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    ]
                );
            }

            // creating "claro_product_id" attribute
            if (!$this->eavAttribute->getIdByCode(
                'catalog_product',
                \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_ID
            )) {
                $eavSetup->addAttribute(
                    'catalog_product',
                    \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PRODUCT_ID,
                    [
                        'group' => $groupName,
                        'note' => 'Claro Product Id',
                        'input' => 'text',
                        'type' => 'varchar',
                        'label' => 'Claro Product Id ',
                        'backend' => '',
                        'visible' => 1,
                        'required' => 0,
                        'sort_order' => 1,
                        'user_defined' => 1,
                        'comparable' => 0,
                        'visible_on_front' => 0,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    ]
                );
            }

            // creating "claro_variant_id" attribute
            if (!$this->eavAttribute->getIdByCode(
                'catalog_product',
                \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_VARIANT_ID
            )) {
                $eavSetup->addAttribute(
                    'catalog_product',
                    \Ced\Claro\Helper\Product::ATTRIBUTE_CODE_VARIANT_ID,
                    [
                        'group' => $groupName,
                        'note' => 'Claro Variant Id',
                        'input' => 'text',
                        'type' => 'varchar',
                        'label' => 'Claro Variant Id ',
                        'backend' => '',
                        'visible' => 1,
                        'required' => 0,
                        'sort_order' => 1,
                        'user_defined' => 1,
                        'comparable' => 0,
                        'visible_on_front' => 0,
                        'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    ]
                );
            }
        }
    }
}
