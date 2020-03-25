<?php

namespace ITM\Sportires\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();


        $table = $setup->getConnection()
            ->newTable($setup->getTable('itm_sportires_vehicletire'))
            ->addColumn( 'entity_id', \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
                'Id'
            )
            ->addColumn('make', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '64', ['nullable' => false ], 'Make' )
            ->addColumn('year', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, ['nullable' => false ], 'Year')
            ->addColumn('model', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '64', ['nullable' => false ], 'Model' )
            ->addColumn('trim', \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, '128', ['nullable' => false ], 'Trim' )

           /* ->addColumn('front_width', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, ['nullable' => false ],  'Front Width' )
            ->addColumn('front_ratio', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, ['nullable' => false ],  'Front Ratio' )
            ->addColumn('front_diameter', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, ['nullable' => false ],  'Front Diameter' )
            ->addColumn('rear_width', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, ['nullable' => false ], 'Rear Width' )
            ->addColumn('rear_ratio', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, ['nullable' => false ],  'Rear Ratio' )
            ->addColumn('rear_diameter', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, ['nullable' => false ],  'Rear Diameter' )
*/
            ->addColumn('front_width', \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, '12,4', ['nullable' => false, 'default' => '0.0000'], 'Front Width' )
            ->addColumn('front_ratio', \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, '12,4', ['nullable' => false, 'default' => '0.0000'], 'Front Ratio' )
            ->addColumn('front_diameter', \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, '12,4', ['nullable' => false, 'default' => '0.0000'], 'Front Diameter' )
            ->addColumn('rear_width', \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, '12,4', ['nullable' => false, 'default' => '0.0000'], 'Rear Width' )
            ->addColumn('rear_ratio', \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, '12,4', ['nullable' => false, 'default' => '0.0000'], 'Rear Ratio' )
            ->addColumn('rear_diameter', \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL, '12,4', ['nullable' => false, 'default' => '0.0000'], 'Rear Diameter' )

            ->addColumn('status', \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, null, ['default' => null], 'Status');
        $setup->getConnection()->createTable($table);


        $setup->endSetup();
    }
}
