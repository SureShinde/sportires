<?php
namespace ITM\MagB1\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class FlushCatalogImagesCache extends Command
{

    protected $helper;

    private $objectManager;

    private $eventManager;


    protected function configure()
    {
        $this->setName('magb1:flash-catalog-images-cache'); // php bin/magento magb1:flash-catalog-images-cache
        $this->setDescription('MagB1 : Flush Catalog Images Cache');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setVariables();
        $this->objectManager->create(\Magento\Catalog\Model\Product\Image::class)->clearCache();
        $this->eventManager->dispatch('clean_catalog_images_cache_after');
        $output->writeln("MagB1 : Flush Catalog Images Cache : Done");
    }

    public function setVariables() {
        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->eventManager = $this->objectManager->get('\Magento\Framework\Event\Manager');
        $this->state = $this->objectManager->get('\Magento\Framework\App\State');
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);

        $this->helper = $this->objectManager->get('\ITM\MagB1\Helper\Data');

    }




}