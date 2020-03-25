<?php
namespace ITM\MagB1\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    // php bin/magento module:disable ITM_MagB1
    // php bin/magento module:enable ITM_MagB1
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->addColumn($setup->getTable('sales_order'), 'itm_sbo_download_to_sap', [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length' => 1,
            'comment' =>'itm_sbo_download_to_sap'
        ]);

        $setup->getConnection()->addColumn($setup->getTable('sales_order'), 'itm_sbo_docentry',  [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length' => 255,
            'comment' =>'itm_sbo_docentry'
        ]);
        $setup->getConnection()->addColumn($setup->getTable('sales_order'), 'itm_sbo_docnum', [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length' => 255,
            'comment' =>'itm_sbo_docnum'
        ]);

        $setup->getConnection()->addColumn($setup->getTable('sales_invoice'), 'itm_sbo_docentry',  [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length' => 255,
            'comment' =>'itm_sbo_docentry'
        ]);
        $setup->getConnection()->addColumn($setup->getTable('sales_invoice'), 'itm_sbo_docnum', [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length' => 255,
            'comment' =>'itm_sbo_docnum'
        ]);

        $setup->getConnection()->addColumn($setup->getTable('sales_shipment'), 'itm_sbo_docentry',  [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length' => 255,
            'comment' =>'itm_sbo_docentry'
        ]);
        $setup->getConnection()->addColumn($setup->getTable('sales_shipment'), 'itm_sbo_docnum', [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length' => 255,
            'comment' =>'itm_sbo_docnum'
        ]);

        $setup->getConnection()->addColumn($setup->getTable('sales_creditmemo'), 'itm_sbo_docentry',  [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length' => 255,
            'comment' =>'itm_sbo_docentry'
        ]);
        $setup->getConnection()->addColumn($setup->getTable('sales_creditmemo'), 'itm_sbo_docnum', [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length' => 255,
            'comment' =>'itm_sbo_docnum'
        ]);

        $setup->endSetup();
    }
}
