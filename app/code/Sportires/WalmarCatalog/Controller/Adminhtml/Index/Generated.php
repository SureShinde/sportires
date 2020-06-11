<?php
declare(strict_types=1);

namespace Sportires\WalmarCatalog\Controller\Adminhtml\Index;

class Generated extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(){
        
            $marca = $this->getRequest()->getParam('marca');
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
            $filesystem = $objectManager->get('Magento\Framework\Filesystem');
            $mediaUrl = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
            $mediaUrl = $mediaUrl->getAbsolutePath('Catalogos/');

            $productcollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
            ->addAttributeToSelect('*')
            ->addAttributeToFilter(
            array(
                array('attribute'=>'autos_marcas','eq'=> $marca)
            ));

            $timestamp = time();
            $filename = $mediaUrl.'nombre_archivo.xls';
            
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\".$filename\"");

            $productResult = array();
            foreach($productcollection  as $_product){
                //$out .= $_product->getAttributeText('tire_diameter').' '.$_product->getAttributeText('upc').' '.$_product->getName().' '.$_product->getSku().' '.$_product->getAttributeText('modelos').' '.$marca.' '.$_product->getShortDescription().' '.$_product->getDescription();

                $productResult[] = array(
                    'rin'   => $_product->getAttributeText('tire_diameter'),
                    'upc'   => $_product->getAttributeText('upc'),
                    'name'  => $_product->getName()
                );
            }           
            $isPrintHeader = false;

            foreach ($productResult as $row) {

                if (!$isPrintHeader ) {

                    echo implode("\t", array_keys($row)) . "\n";
                    $isPrintHeader = true;

                }

                echo implode("\t", array_values($row)) . "\n";

            }
            return $this->resultPageFactory->create();
            exit();
    }
}


