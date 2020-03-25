<?php


namespace ITM\Sportires\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class InstallData implements InstallDataInterface
{

    private $eavSetupFactory;

    /**
     * Constructor
     *
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'tire_width',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Tire Width',
                'input' => 'select',
                'class' => '',
                'source' => '',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => null,
                'searchable' => true,
                'filterable' => true,
                'comparable' => true,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => 'simple',
                'system' => 1,
                'group' => 'Sportire',
                'option' => ['values' => [""]]
            ]
        );
        /////
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'tire_ratio',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Tire Ratio',
                'input' => 'select',
                'class' => '',
                'source' => '',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => null,
                'searchable' => true,
                'filterable' => true,
                'comparable' => true,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => 'simple',
                'system' => 1,
                'group' => 'Sportire',
                'option' => ['values' => [""]]
            ]
        );
        ///
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'tire_diameter',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Tire Diameter',
                'input' => 'select',
                'class' => '',
                'source' => '',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => null,
                'searchable' => true,
                'filterable' => true,
                'comparable' => true,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => 'simple',
                'system' => 1,
                'group' => 'Sportire',
                'option' => ['values' => [""]]
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'tire_size',
            [
                'type' => 'int',
                'backend' => '',
                'frontend' => '',
                'label' => 'Tire Size',
                'input' => 'select',
                'class' => '',
                'source' => '',
                'global' => 1,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => null,
                'searchable' => true,
                'filterable' => true,
                'comparable' => true,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => 'simple',
                'system' => 1,
                'group' => 'Sportire',
                'option' => ['values' => [""]]
            ]
        );

        ///
        ///


    }
}
