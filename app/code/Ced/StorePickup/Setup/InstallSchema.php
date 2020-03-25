<?php
namespace Ced\StorePickup\Setup;
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
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    
    
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context) 
    {
        
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()
            ->newTable($installer->getTable('store_pickup'))
                    
            ->addColumn(
                'pickup_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                array('identity' => true, 'nullable' => false, 'primary' => true),
                'Store Pickup ID'
            )
                    
            ->addColumn(
                'store_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                array('nullable' => false),
                'Store Name'
            )
                    
            ->addColumn(
                'store_manager_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                array('nullable' => false),
                'Store Manager Name'
            )
                    
            ->addColumn(
                'store_manager_email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                array('nullable' => false),
                'Store Manager Email'
            )
                    
            ->addColumn(
                'store_address',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                array('nullable' => false),
                'Address'
            )
                    
            ->addColumn(
                'store_city',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                array('nullable' => false),
                'City'
            )
                    
            ->addColumn(
                'store_city',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                array('nullable' => false),
                'City'
            )
                    
            ->addColumn(
                'store_country',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                array('nullable' => false),
                'Country'
            )
                    
            ->addColumn(
                'store_state',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                array('nullable' => false),
                'State/Province'
            )
                    
            ->addColumn(
                'store_zcode',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                array(),
                'Zip Code'
            )
                    
            ->addColumn(
                'latitude',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                array('nullable' => false),
                'Latitude'
            )
                    
            ->addColumn(
                'longitude',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                array('nullable' => false),
                'Longitude'
            )
                    
            ->addColumn(
                'store_phone',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                20,
                array(),
                'Contact No.'
            )
                    
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                array(),
                'Creation Time'
            )
                    
            ->addColumn(
                'update_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                array(),
                'Modification Time'
            )
                    
            ->addColumn(
                'is_active',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                array(),
                'Enable/Disable'
            )                    
            ->setComment('Store Pickup Information');
        
        $installer->getConnection()->createTable($table);

        $table = $installer->getConnection()
            ->newTable($installer->getTable('store_pickup_hour'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                array('identity' => true, 'nullable' => false, 'primary' => true),
                'ID'
            )
                
            ->addColumn(
                'pickup_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                array(),
                'Store Pickup ID'
            )
                
            ->addColumn(
                'days',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                array('nullable' => false),
                'Days'
            )
                
            ->addColumn(
                'start',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                array('nullable' => false),
                'Start'
            )
                
            ->addColumn(
                'end',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                array('nullable' => false),
                'End'
            )
                
            ->addColumn(
                'interval',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                array('nullable' => false),
                'Time Interval'
            )
                
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                array('nullable' => false),
                'Status'
            )
            ->setComment('Hours Information');
    
        $installer->getConnection()->createTable($table);
        $installer->endSetup();   
    }
}