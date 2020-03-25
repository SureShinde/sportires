<?php

namespace ITM\Sportires\Setup;


use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
 
/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
 
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
 
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        if (version_compare($context->getVersion(), '1.0.1') < 0){
			
			$eavSetup->addAttribute(
				\Magento\Catalog\Model\Product::ENTITY,
				'moto_tire_width',
				[
					'type' => 'int',
					'backend' => '',
					'frontend' => '',
					'label' => 'Moto Tire Width',
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
				'moto_tire_ratio',
				[
					'type' => 'int',
					'backend' => '',
					'frontend' => '',
					'label' => 'Moto Tire Ratio',
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
				'moto_tire_diameter',
				[
					'type' => 'int',
					'backend' => '',
					'frontend' => '',
					'label' => 'Moto Tire Diameter',
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



		 }
    }
}