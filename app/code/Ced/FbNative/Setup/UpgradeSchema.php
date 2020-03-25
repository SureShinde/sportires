<?php
/**
 * Created by PhpStorm.
 * User: cedcoss
 * Date: 3/5/19
 * Time: 2:31 AM
 */

namespace Ced\FbNative\Setup;


use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    public function upgrade
    (
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        try {
            $setup->startSetup();
            if (version_compare($context->getVersion(), '1.0.4') < 0) {
                $tableName = $setup->getTable('ced_fbnative_account');

                if (!$setup->getConnection()->isTableExists($setup->getTable($tableName))) {
                    $table = $setup->getConnection()->newTable($setup->getTable($tableName))
                        ->addColumn(
                            'id',
                            Table::TYPE_INTEGER,
                            null,
                            array(
                                'identity' => true,
                                'unsigned' => true,
                                'nullable' => false,
                                'primary' => true,
                                'auto_increment' => true,
                            ),
                            'Id'
                        )
                        ->addColumn(
                            'page_name',
                            Table::TYPE_TEXT,
                            255,
                            ['unique' => true, 'nullable' => false],
                            'Page Name'
                        )
                        ->addColumn(
                            'account_store',
                            Table::TYPE_TEXT,
                            50,
                            ['nullable' => true, 'default' => ''],
                            'Account Store'
                        )
                        ->addColumn(
                            'account_status',
                            Table::TYPE_BOOLEAN,
                            null,
                            ['nullable' => true],
                            'Account Status'
                        )
                        ->addColumn(
                            'export_csv',
                            Table::TYPE_TEXT,
                            null,
                            ['nullable' => true],
                            'Export CSV Url'
                        );
                    $setup->getConnection()->createTable($table);
                    $setup->endSetup();
                }
            }

            if (version_compare($context->getVersion(), '1.0.5') < 0) {
                $tableName = $setup->getTable('ced_fbnative_feed');

                if (!$setup->getConnection()->isTableExists($setup->getTable($tableName))) {
                    $table = $setup->getConnection()->newTable($setup->getTable($tableName))
                        ->addColumn(
                            'id',
                            Table::TYPE_INTEGER,
                            null,
                            array(
                                'identity' => true,
                                'unsigned' => true,
                                'nullable' => false,
                                'primary' => true,
                                'auto_increment' => true,
                            ),
                            'Id'
                        )
                        ->addColumn(
                            'account',
                            Table::TYPE_TEXT,
                            50,
                            ['nullable' => true, 'default' => ''],
                            'Account'
                        )
                        ->addColumn(
                            'uploaded_time',
                            Table::TYPE_TIMESTAMP,
                            null,
                            ['nullable' => true, 'default' => ''],
                            'Uploaded Time'
                        )
                        ->addColumn(
                            'source',
                            Table::TYPE_TEXT,
                            50,
                            ['nullable' => true, 'default' => ''],
                            'Action Type'
                        )
                        ->addColumn(
                            'feed_status',
                            Table::TYPE_TEXT,
                            50,
                            ['nullable' => true, 'default' => ''],
                            'Feed Status'
                        )
                        ->addColumn(
                            'product_ids',
                            Table::TYPE_TEXT,
                            null,
                            ['nullable' => true],
                            'Product Ids'
                        );
                    $setup->getConnection()->createTable($table);
                    $setup->endSetup();
                }

                $tableName = $setup->getTable('ced_fbnative_account');
                if ($setup->getConnection()->isTableExists($tableName)) {
                    $connection = $setup->getConnection();//->newTable($setup->getTable($tableName))
                    $connection->changeColumn(
                        $tableName,
                        'page_name',
                        'page_name',
                            ['type' => Table::TYPE_TEXT, 'length' => 255, 'nullable' => false]
                        );
                    $connection->addIndex(
                                $tableName,
                                'page_name',
                                'page_name',
                                AdapterInterface::INDEX_TYPE_UNIQUE
                        );
                    $setup->endSetup();
                }
            }
        } catch (\Exception $e) {
            /*echo "<pre>";
            print_r($e->getMessage());
            die(" Terminate Setup Upgrade Contact with CEDCommerce Team");*/
        }
    }
}