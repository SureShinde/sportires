<?php
namespace ITM\MagB1\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class ClearProductImages extends Command
{
    /**
     * Force run of static deploy
     */
    const FORCE_DELETE = 'force';

    protected $helper;

    private $objectManager;

    private $resource;

    private $_output;

    protected function configure()
    {
        $this->setName('magb1:clear-product-images'); // php bin/magento magb1:clear-product-images
        $this->setDescription('MagB1 : Clear Product Images');

        $options = [
            new InputOption(
                self::FORCE_DELETE,
                '-f',
                InputOption::VALUE_NONE,
                'Deploy files in any mode.'
            ),
        ];
         $this->setDefinition($options);
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setVariables();
        $this->_output = $output;

        if ($name = $input->getOption(self::FORCE_DELETE)) {
            $output->writeln("MagB1 : Clear Product Images: Delete Images");
            $this->DeleteImages($delete = true);
        } else {
            $this->DeleteImages($delete = false);
            $output->writeln("MagB1 : Clear Product Images: List Images");
        }

        $output->writeln("MagB1 : Clear Product Images: Done");
        return $this;
    }
    public function DeleteImages($delete = false) {
        $this->_output->writeln("MagB1 : Clear Product Images: Start");
        $connection =  $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);

        $imgsQuery = $connection->select()
            ->from(['imgs' =>  $this->resource->getTableName('catalog_product_entity_media_gallery')], ['value']
            );
        $result = $connection->fetchAll($imgsQuery);

        $store_images = array_column ($result, "value");
        $this->_output->writeln("MagB1 : Clear Product Images: Database Images Count = ".count($store_images));

        // get the Physical files
        $fileSystem = $this->objectManager->get('\Magento\Framework\Filesystem');
        $absoluteMediaPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
        $productImages  = $absoluteMediaPath."catalog/product";
        $realFiles = [];
        $scanned_directory = $this->getDirContents($productImages, $realFiles, $productImages);
        $to_be_deleted = array_diff($realFiles,$store_images);

        $this->_output->writeln( "The database images count = ".count($store_images).
            ", And the real images count =".count($realFiles).
            ", Images to be deleted ".count($to_be_deleted));

        if($delete == true) {
            foreach ($to_be_deleted as $item){
                $full_path = $productImages.$item;
                $this->_output->writeln($full_path);
                unlink($full_path);
            }
        }
    }
    public function setVariables() {
        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->state = $this->objectManager->get('\Magento\Framework\App\State');
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);
        $this->helper = $this->objectManager->get('\ITM\MagB1\Helper\Data');
        $this->resource = $this->objectManager->get('\Magento\Framework\App\ResourceConnection');

    }

    public function getDirContents($dir, &$results = array(), $productImages){
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
                // print  str_replace ('',"",$path)."<br>";
                $results[] =  str_replace ($productImages,"",$path);
            } else if($value != "." && $value != ".." && $value !="cache") {
                $this->getDirContents($path, $results, $productImages);
                //$results[] = $path;
            }
        }
        return $results;
    }
}