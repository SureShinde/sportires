<?php
/**
     * CedCommerce
     *
     * NOTICE OF LICENSE
     *
     * This source file is subject to the End User License Agreement (EULA)
     * that is bundled with this package in the file LICENSE.txt.
     * It is also available through the world-wide-web at this URL:
     * https://cedcommerce.com/license-agreement.txt
     *
     * @category  Ced
     * @package   Ced_StorePickup
     * @author    CedCommerce Core Team <connect@cedcommerce.com >
     * @copyright Copyright CEDCOMMERCE (https://cedcommerce.com/)
     * @license      https://cedcommerce.com/license-agreement.txt
     */
namespace Ced\StorePickup\Setup;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades Tables
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()
            ->addColumn(
                $setup->getTable('quote'),
                'store_pickup_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    '11',
                    'default' => 0,
                    'nullable' => false,
                    'comment' =>'Store Pickup Id'
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('quote'),
                'store_pickup_date',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                    'nullable' => false,
                    'comment' =>'Store Pickup Date'
                ]
            );

        $setup->getConnection()
            ->addColumn(
                $setup->getTable('sales_order'),
                'store_pickup_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    '11',
                    'default' => 0,
                    'nullable' => false,
                    'comment' =>'Store Pickup Id'
                ]
            );
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('sales_order'),
                'store_pickup_date',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                    'nullable' => false,
                    'comment' =>'Store Pickup Date'
                ]
            );
        $setup->endSetup();
    }
}