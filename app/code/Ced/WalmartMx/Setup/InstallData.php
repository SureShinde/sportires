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

namespace Ced\WalmartMx\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{

    /**
     * @var EavSetupFactory
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
     *
     * @param EavSetupFactory                                    $eavSetupFactory
     * @param \Magento\Framework\ObjectManagerInterface          $objectManager
     * @param \Magento\Catalog\Model\ResourceModel\Eav\Attribute $eavAttribute
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $eavAttribute
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->objectManager = $objectManager;
        $this->eavAttribute = $eavAttribute;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface   $context
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
 		 * @var EavSetup $eavSetup 
		 */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        /**
         * Add attributes to the eav/attribute
         */
        $groupName = 'WalmartMx Marketplace';
        $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);
        $eavSetup->addAttributeGroup($entityTypeId, $attributeSetId, $groupName, 1000);
        $eavSetup->getAttributeGroupId($entityTypeId, $attributeSetId, $groupName);

        if (!$this->eavAttribute->getIdByCode('catalog_product', 'walmartmx_state')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'walmartmx_state',
                [
                    'group' => 'WalmartMx Marketplace',
                    'note' => 'Please Select State',
                    'input' => 'select',
                    'type' => 'varchar',
                    'label' => 'State',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 1,
                    'user_defined' => 1,
                    'source' => 'Ced\WalmartMx\Model\Source\State',
                    'comparable' => 0,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }

        if (!$this->eavAttribute->getIdByCode('catalog_product', 'logistic_class')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'logistic_class',
                [
                    'group' => 'WalmartMx Marketplace',
                    'note' => 'Please Select Logistic class',
                    'input' => 'select',
                    'type' => 'varchar',
                    'label' => 'Logistic Class',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 1,
                    'user_defined' => 1,
                    'source' => 'Ced\WalmartMx\Model\Source\LogisticClass',
                    'comparable' => 0,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }

        if (!$this->eavAttribute->getIdByCode('catalog_product', 'barcode_ean')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'barcode_ean',
                [
                    'group' => 'WalmartMx Marketplace',
                    'input' => 'text',
                    'type' => 'text',
                    'label' => 'Barcode',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 2,
                    'user_defined' => 1,
                    'searchable' => 1,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }

        if (!$this->eavAttribute->getIdByCode('catalog_product', 'brand')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'brand',
                [
                    'group' => 'WalmartMx Marketplace',
                    'note' => '1 to 50 characters',
                    'frontend_class' => 'validate-length maximum-length-50',
                    'input' => 'text',
                    'type' => 'text',
                    'label' => 'Brand',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 3,
                    'user_defined' => 1,
                    'searchable' => 1,
                    'filterable' => 0,
                    'comparable' => 0,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }

        if (!$this->eavAttribute->getIdByCode('catalog_product', 'walmartmx_product_status')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'walmartmx_product_status',
                [
                    'group' => 'WalmartMx Marketplace',
                    'note' => 'product status on WalmartMx',
                    'input' => 'select',
                    'source' => 'Ced\WalmartMx\Model\Source\Product\Status',
                    'type' => 'varchar',
                    'label' => 'WalmartMx Product Status',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 12,
                    'user_defined' => 1,
                    'searchable' => 1,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }

        if (!$this->eavAttribute->getIdByCode('catalog_product', 'package_length')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'package_length',
                [
                    'group' => 'WalmartMx Marketplace',
                    'note' => "Please enter package length. \n
                    Use only 'C.M.",
                    'input' => 'text',
                    'type' => 'text',
                    'label' => 'Package Length (cm)',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 14,
                    'user_defined' => 1,
                    'searchable' => 1,
                    'filterable' => 0,
                    'comparable' => 0,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }

        if (!$this->eavAttribute->getIdByCode('catalog_product', 'package_width')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'package_width',
                [
                    'group' => 'WalmartMx Marketplace',
                    'note' => "Please enter package width. \n
                    Use only 'C.M.",
                    'input' => 'text',
                    'type' => 'text',
                    'label' => 'Package Width (cm)',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 14,
                    'user_defined' => 1,
                    'searchable' => 1,
                    'filterable' => 0,
                    'comparable' => 0,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }

        if (!$this->eavAttribute->getIdByCode('catalog_product', 'package_height')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'package_height',
                [
                    'group' => 'WalmartMx Marketplace',
                    'note' => "Please enter package height. \n
                    Use only 'C.M.",
                    'input' => 'text',
                    'type' => 'text',
                    'label' => 'Package Height (cm)',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 14,
                    'user_defined' => 1,
                    'searchable' => 1,
                    'filterable' => 0,
                    'comparable' => 0,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }


        if (!$this->eavAttribute->getIdByCode('catalog_product', 'catch_club_eligibe')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'catch_club_eligibe',
                [
                    'group' => 'WalmartMx Marketplace',
                    'note' => "Please enter tax class",
                    'input' => 'select',
                    'type' => 'varchar',
                    'label' => 'WalmartMx Club Eligibe',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 14,
                    'user_defined' => 1,
                    'searchable' => 1,
                    'filterable' => 0,
                    'source' => 'Ced\WalmartMx\Model\Source\ClubEligibe',
                    'comparable' => 0,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }

        if (!$this->eavAttribute->getIdByCode('catalog_product', 'walmartmx_validation_errors')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'walmartmx_validation_errors',
                [
                    'group' => 'WalmartMx Marketplace',
                    'note' => "WalmartMx Validation Errors",
                    'input' => 'text',
                    'type' => 'text',
                    'label' => 'WalmartMx Validation Errors',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 14,
                    'user_defined' => 1,
                    'searchable' => 1,
                    'filterable' => 0,
                    'comparable' => 0,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }


        if (!$this->eavAttribute->getIdByCode('catalog_product', 'walmartmx_feed_errors')) {
            $eavSetup->addAttribute(
                'catalog_product',
                'walmartmx_feed_errors',
                [
                    'group' => 'WalmartMx Marketplace',
                    'note' => "WalmartMx Feed Errors",
                    'input' => 'text',
                    'type' => 'text',
                    'label' => 'WalmartMx Feed Errors',
                    'backend' => '',
                    'visible' => 1,
                    'required' => 0,
                    'sort_order' => 14,
                    'user_defined' => 1,
                    'searchable' => 1,
                    'filterable' => 0,
                    'comparable' => 0,
                    'visible_on_front' => 0,
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                ]
            );
        }
    }
}
