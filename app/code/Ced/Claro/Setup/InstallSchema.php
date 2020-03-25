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
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package Ced\Claro\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '0.0.1', '<')) {
            $installer = $setup;
            $installer->startSetup();

            // Creating `ced_claro_profile` table
            if (!$installer->getConnection()->isTableExists($installer->getTable(\Ced\Claro\Model\Profile::NAME))) {
                /**
                 * Create table 'ced_claro_profile'
                 */
                $table = $installer->getConnection()->newTable($installer->getTable(\Ced\Claro\Model\Profile::NAME))
                    ->addColumn(
                        \Ced\Claro\Model\Profile::COLUMN_ID,
                        Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'unsigned' => true,
                            'nullable' => false,
                            'primary' => true
                        ],
                        'ID'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Profile::COLUMN_STATUS,
                        Table::TYPE_BOOLEAN,
                        null,
                        [
                            'nullable' => true,
                        ],
                        'Profile Status'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Profile::COLUMN_NAME,
                        Table::TYPE_TEXT,
                        255,
                        [
                            'nullable' => false,
                        ],
                        'Profile Name'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Profile::COLUMN_CATEGORY,
                        Table::TYPE_TEXT,
                        500,
                        [
                            'nullable' => true,
                        ],
                        'Profile Category'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Profile::COLUMN_REQUIRED_ATTRIBUTES,
                        Table::TYPE_TEXT,
                        '2M',
                        [
                            'nullable' => true
                        ],
                        'Profile Required Attributes'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Profile::COLUMN_OPTIONAL_ATTRIBUTES,
                        Table::TYPE_TEXT,
                        '2M',
                        [
                            'nullable' => true,
                        ],
                        'Profile Optional Attributes'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Profile::COLUMN_SHIPPING_METHODS,
                        Table::TYPE_TEXT,
                        '2M',
                        [
                            'nullable' => true,
                        ],
                        'Profile Shipping Methods'
                    )
                    ->setComment('Profile Table');
                $installer->getConnection()->createTable($table);
            }

            // Creating `ced_claro_order` table
            if (!$installer->getConnection()->isTableExists($installer->getTable(\Ced\Claro\Model\Order::NAME))) {
                /**
                 * Create table 'ced_claro_order'
                 */
                $table = $installer->getConnection()->newTable($installer->getTable(\Ced\Claro\Model\Order::NAME))
                    ->addColumn(
                        \Ced\Claro\Model\Order::COLUMN_ID,
                        Table::TYPE_INTEGER,
                        null,
                        [
                            'identity' => true,
                            'unsigned' => true,
                            'nullable' => false,
                            'primary' => true
                        ],
                        'ID'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Order::COLUMN_MARKETPLACE_ORDER_ID,
                        Table::TYPE_TEXT,
                        255,
                        [
                            'nullable' => true,
                        ],
                        'Claro Order Id'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Order::COLUMN_MARKETPLACE_SHIPMENT_ID,
                        Table::TYPE_TEXT,
                        255,
                        [
                            'nullable' => true,
                        ],
                        'Claro Shipment Id'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Order::COLUMN_MAGENTO_ORDER_ID,
                        Table::TYPE_TEXT,
                        100,
                        [
                            'nullable' => true,
                            'default' => ''
                        ],
                        'Magento Order Id'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Order::COLUMN_MARKETPLACE_DATE_CREATED,
                        Table::TYPE_DATE,
                        null,
                        [
                            'nullable' => true
                        ],
                        'Order Date'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Order::COLUMN_STATUS,
                        Table::TYPE_TEXT,
                        50,
                        [
                            'nullable' => true,
                        ],
                        'Claro Order Status'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Order::COLUMN_FAILURE_REASON,
                        Table::TYPE_TEXT,
                        null,
                        ['nullable' => true],
                        'Reasons'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Order::COLUMN_ORDER_DATA,
                        Table::TYPE_TEXT,
                        '2M',
                        ['nullable' => true],
                        'Order Data'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Order::COLUMN_SHIPMENT_DATA,
                        Table::TYPE_TEXT,
                        '2M',
                        ['nullable' => true],
                        'Order Shipments'
                    )
                    ->addColumn(
                        \Ced\Claro\Model\Order::COLUMN_CANCELLATION_DATA,
                        Table::TYPE_TEXT,
                        '2M',
                        ['nullable' => true],
                        'Order Cancellations'
                    )
                    ->addIndex(
                        $setup->getIdxName(
                            $setup->getTable(\Ced\Claro\Model\Order::NAME),
                            [\Ced\Claro\Model\Order::COLUMN_MARKETPLACE_ORDER_ID],
                            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                        ),
                        [\Ced\Claro\Model\Order::COLUMN_MARKETPLACE_ORDER_ID],
                        ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                    )
                    ->setComment('Claro Order');

                $installer->getConnection()->createTable($table);
            }
        }
    }
}
