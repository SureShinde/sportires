<?php

namespace Ced\WalmartMx\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            // Get module table
            $tableName = $setup->getTable('walmartmx_product_change');
            // Check if the table already exists
            if ($setup->getConnection()->isTableExists($tableName) != true) {
                $table = $setup->getConnection()
                    ->newTable($tableName)
                    ->addColumn(
                        'product_id',
                        Table::TYPE_INTEGER,
                        null,
                        ['unsigned' => true, 'nullable' => false],
                        'Profile Status'
                    )
                    ->addColumn(
                        'old_value',
                        Table::TYPE_TEXT,
                        100,
                        ['nullable' => true, 'default' => ''],
                        'Old Value'
                    )
                    ->addColumn(
                        'new_value',
                        Table::TYPE_TEXT,
                        100,
                        ['nullable' => true, 'default' => ''],
                        'New Value'
                    )
                    ->addColumn(
                        'action',
                        Table::TYPE_TEXT,
                        50,
                        ['nullable' => true, 'default' => ''],
                        'Action'
                    )
                    ->addColumn(
                        'type',
                        Table::TYPE_TEXT,
                        50,
                        ['nullable' => true, 'default' => ''],
                        'Type'
                    )
                    ->setComment('WalmartMx Product Change')
                    ->setOption('type', 'InnoDB')
                    ->setOption('charset', 'utf8');
                $setup->getConnection()->createTable($table);

            }

            $tableName = $setup->getTable('walmartmx_profile');
            $connection = $setup->getConnection();

            if (!$connection->tableColumnExists($tableName, 'profile_products_filters')) {
                $connection->addColumn(
                    $tableName,
                    'profile_products_filters',
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Products Filters',
                        'after' => 'profile_optional_attributes'
                    ]
                );
            }


            $setup->endSetup();

        }

        if (version_compare($context->getVersion(), '0.0.4', '<')) {
            // Get module table
            $tableName = $setup->getTable('walmartmx_logs');
            // Check if the table already exists
            if ($setup->getConnection()->isTableExists($tableName) != true) {
                // Create ced_logs table
                $table = $setup->getConnection()
                    ->newTable($tableName)
                    ->addColumn(
                        'id',
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
                        'message',
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => true
                        ],
                        'Message'
                    )
                    ->addColumn(
                        'context',
                        Table::TYPE_TEXT,
                        '2M',
                        [
                            'nullable' => true
                        ],
                        'Context'
                    )
                    ->addColumn(
                        'level',
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => true
                        ],
                        'Level'
                    )
                    ->addColumn(
                        'level_name',
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => true
                        ],
                        'Level Name'
                    )
                    ->addColumn(
                        'channel',
                        Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => true
                        ],
                        'Channel'
                    )
                    ->addColumn(
                        'datetime',
                        Table::TYPE_DATETIME,
                        null,
                        [
                            'nullable' => true
                        ],
                        'Date'
                    )
                    ->setComment('WalmartMx Logs');
                $setup->getConnection()->createTable($table);
            }

            $setup->endSetup();

        }
    }
}