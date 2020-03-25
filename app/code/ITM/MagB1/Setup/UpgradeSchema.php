<?php
namespace ITM\MagB1\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    private function doUpgrade()
    {
        return null;
    }
    private function doUpgrade1_0_5($setup)
    {
        $table = $setup->getConnection()
        ->newTable($setup->getTable('itm_magb1_orderfiles'))
        ->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ], 'Id')
            ->addColumn('increment_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '32', [
                'nullable' => false
            ], 'Increment ID')
            ->addColumn('path', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', [
                'nullable' => false
            ], 'Path')
            ->addColumn('description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', [
                'nullable' => false
            ], 'Description')
            ->addColumn('store_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'nullable' => false
            ], 'Store ID')
            ->addColumn('position', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'nullable' => false
            ], 'Position')
            ->addColumn('status', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 1, [
                'default' => null
            ], 'Status');
            $setup->getConnection()->createTable($table);
            
            $table = $setup->getConnection()
            ->newTable($setup->getTable('itm_magb1_invoicefiles'))
            ->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ], 'Id')
                ->addColumn('increment_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '32', [
                    'nullable' => false
                ], 'Increment ID')
                ->addColumn('path', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', [
                    'nullable' => false
                ], 'Path')
                ->addColumn('description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', [
                    'nullable' => false
                ], 'Description')
                ->addColumn('store_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                    'nullable' => false
                ], 'Store ID')
                ->addColumn('position', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                    'nullable' => false
                ], 'Position')
                ->addColumn('status', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 1, [
                    'default' => null
                ], 'Status');
                $setup->getConnection()->createTable($table);
                
                $table = $setup->getConnection()
                ->newTable($setup->getTable('itm_magb1_shipmentfiles'))
                ->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ], 'Id')
                    ->addColumn('increment_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '32', [
                        'nullable' => false
                    ], 'Increment ID')
                    ->addColumn('path', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', [
                        'nullable' => false
                    ], 'Path')
                    ->addColumn('description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', [
                        'nullable' => false
                    ], 'Description')
                    ->addColumn('store_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                        'nullable' => false
                    ], 'Store ID')
                    ->addColumn('position', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                        'nullable' => false
                    ], 'Position')
                    ->addColumn('status', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 1, [
                        'default' => null
                    ], 'Status');
                    $setup->getConnection()->createTable($table);
                    
                    $table = $setup->getConnection()
                    ->newTable($setup->getTable('itm_magb1_customerfiles'))
                    ->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null,
                        [
                            'identity' => true,
                            'unsigned' => true,
                            'nullable' => false,
                            'primary' => true
                        ], 'Id')
                        ->addColumn('customer_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                            'nullable' => false
                        ], 'Customer ID')
                        ->addColumn('path', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', [
                            'nullable' => false
                        ], 'Path')
                        ->addColumn('description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', [
                            'nullable' => false
                        ], 'Description')
                        ->addColumn('position', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                            'nullable' => false
                        ], 'Position')
                        ->addColumn('status', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 1, [
                            'default' => null
                        ], 'Status');
                        $setup->getConnection()->createTable($table);
    }
    
    private function doUpgrade1_0_7($setup)
    {
        $table = $setup->getConnection()
        ->newTable($setup->getTable('itm_magb1_categoryfiles'))
        ->addColumn( 'entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true
        ],
            'Id'
            )
            ->addColumn('code', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', ['nullable' => false ], 'Code' )
            ->addColumn('category_id', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, null, ['nullable' => false ], 'Category IDs' )
            ->addColumn('path', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', ['nullable' => false ], 'Path' )
            ->addColumn('description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', ['nullable' => false ], 'Description' )
            ->addColumn('store_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false ], 'Store ID')
            ->addColumn('position', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, ['nullable' => false ], 'Position')
            ->addColumn('status', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 1, ['default' => null], 'Status');
            $setup->getConnection()->createTable($table);
            
    }
    // php bin/magento setup:upgrade
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        
        // handle all possible upgrade versions
        
        if (! $context->getVersion()) {
            // no previous version found, installation, InstallSchema was just executed
            // be careful, since everything below is true for installation !
            $this->doUpgrade();
        }
        
        if (version_compare($context->getVersion(), '1.0.1') < 0) {
            $table = $setup->getConnection()
                ->newTable($setup->getTable('itm_magb1_productfiles'))
                ->addColumn('entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, 
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ], 'Id')
                ->addColumn('sku', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '64', [
                'nullable' => false
            ], 'SKU')
                ->addColumn('description', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', [
                'nullable' => false
            ], 'Description')
                ->addColumn('path', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '255', [
                'nullable' => false
            ], 'Path')
                ->addColumn('store_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'nullable' => false
            ], 'Store ID')
                ->addColumn('position', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'nullable' => false
            ], 'Position')
                ->addColumn('status', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 1, [
                'default' => null
            ], 'Status');
            $setup->getConnection()->createTable($table);
        }
        
        if (version_compare($context->getVersion(), '1.0.5') < 0) {
            $this->doUpgrade1_0_5($setup);
        }
        if (version_compare($context->getVersion(), '1.0.7') < 0) {
            $this->doUpgrade1_0_7($setup);
        }
        if (version_compare($context->getVersion(), '1.0.8') < 0) {
            $this->doUpgrade1_0_8($setup);
        }
        
        $setup->endSetup();
    }
    private function doUpgrade1_0_8($setup)
    {
        $quote = 'quote';
        $orderGridTable = 'sales_order_grid';
        
        $setup->getConnection()->addColumn($setup->getTable($quote),'itm_sbo_docentry',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'itm_sbo_docentry'
            ]);
        
        //Order Grid table
        $setup->getConnection()->addColumn($setup->getTable($orderGridTable),'itm_sbo_docentry',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'itm_sbo_docentry'
            ]);
        
        $setup->getConnection()->addColumn($setup->getTable($quote),'itm_sbo_docnum',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'itm_sbo_docnum'
            ]);
        
        //Order Grid table
        $setup->getConnection()->addColumn($setup->getTable($orderGridTable),'itm_sbo_docnum',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'itm_sbo_docnum'
            ]);
        $setup->getConnection()->addColumn($setup->getTable($quote),'itm_sbo_download_to_sap',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'itm_sbo_download_to_sap'
            ]);
        
        //Order Grid table
        $setup->getConnection()->addColumn($setup->getTable($orderGridTable),'itm_sbo_download_to_sap',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'itm_sbo_download_to_sap'
            ]);
            
    }
}
