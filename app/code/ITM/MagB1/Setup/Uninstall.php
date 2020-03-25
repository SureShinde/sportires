<?php
namespace ITM\MagB1\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class Uninstall implements UninstallInterface
{
    // php bin/magento module:uninstall ITM_MagB1
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        
        // uninstall code; Little Bobby Tables we call him ..
        
        $setup->endSetup();
    }
}
