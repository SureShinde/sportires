<?php
use Magento\Framework\App\Bootstrap;
use Psr\Log\LoggerInterface;
use Magento\Framework\ObjectManagerInterface;

require __DIR__ . '/app/bootstrap.php';
$params = $_SERVER;
$bootstrap = Bootstrap::create(BP, $params);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
$objectManager = $bootstrap->getObjectManager();

            $marca = $_POST['marca'];
            $filesystem = $objectManager->get('Magento\Framework\Filesystem');
            $mediaUrl = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
            $mediaUrl = $mediaUrl->getAbsolutePath('Catalogos/');

            if($marca == 'todas'){
            $productcollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
	            ->addAttributeToSelect('*');
            }else{
	            $productcollection = $objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
	            ->addAttributeToSelect('*')
	            ->addAttributeToFilter(
	            array(
	                array('attribute'=>'autos_marcas','eq'=> $marca)
	            ));
        	}

            $timestamp = time();
            $filename = 'Catalogo-'.$marca.'.xls';
            
            header("Content-Type: application/vnd.ms-excel charset=utf-8");
            header("Content-Disposition: attachment; filename=\"$filename\"");

            $productResult = array();
            foreach($productcollection  as $_product){


			$helperImport = $objectManager->get('\Magento\Catalog\Helper\Image');

			$imageUrl = $helperImport->init($_product, 'product_page_image_small')
                ->setImageFile($_product->getSmallImage()) // image,small_image,thumbnail
                ->resize(380)
                ->getUrl();

    		$StockState = $objectManager->get('\Magento\CatalogInventory\Api\StockStateInterface');
    		
                $productResult[] = array(
                    'Categoria_Fineline'   			=> 'Autos y Llantas/Llantas y Rines/Llantas Rin '.$_product->getAttributeText('tire_diameter'),
                    'AMM_UPC'   					=> $_product->getUpc(),
                    'AMM_TITULO'  					=> $_product->getName(),
                    'AMM_SKU'  						=> $_product->getSku(),
                    'AMM_MODELO'  					=> $_product->getAttributeText('modelos'),
                    'AMM_MARCA'  					=> strtoupper($_product->getAttributeText('autos_marcas')),
                    'AMM_DES_CORTA'  				=> strip_tags(str_replace(array(',',';'),'|',trim(preg_replace('/\s+/', ' ', $_product->getShortDescription())))),
                    'AMM_DES_LARGA'  				=> strip_tags(str_replace(array(',',';'),'|',trim(preg_replace('/\s+/', ' ', $_product->getDescription())))),
                    'AMM_CONT_CAJA'  				=> '1 Llanta (No Incluye Rin)',
                    'AMM_COLOR'						=> 'Negro',
                    'AMM_TALLA'						=> 'No Aplica',
                    'AMM_ALTO_PROD'					=> $_product->getTsDimensionsLength(),
                    'AMM_LARGO_PROD'				=> $_product->getTsDimensionsHeight(),
                    'AMM_ANCHO_PROD'				=> $_product->getTsDimensionsWidth(),
                    'AMM_PESO_PROD'					=> $_product->getWeight(),
                    'AMM_ALTO_EMPQ'					=> round($_product->getTsDimensionsLength()),
                    'AMM_LARGO_EMPQ'				=> round($_product->getTsDimensionsHeight()),
                    'AMM_ANCHO_EMPQ'				=> round($_product->getTsDimensionsWidth()),
                    'AMM_PESO_EMPQ'					=> round($_product->getWeight()),
                    'AMM_UNID_VENTA'				=> 'EA',
                    'AMM_UNIDADMEDIDA_CONT_NETO'	=> 1,
                    'Imagen 1'						=> $imageUrl,
                    'Medida del Rin'				=> $_product->getAttributeText('tire_diameter'),
                    'sku'							=> $_product->getSku(),
                    'product-id'					=> $_product->getUpc(),
                    'product-id-type'				=> 'UPC',
                    'description'					=> '',
                    'internal-description'			=> '',
                    'price'							=> '$'.$_product->getWalmartPrice(),
                    'price-additional-info'			=> '',
                    'quantity'						=> $StockState->getStockQty($_product->getId(), $_product->getStore()->getWebsiteId()),
                    'min-quantity-alert'			=> '',
                    'state'							=> 'Nuevo',
                    'available-start-date'			=> '',
                    'available-end-date'			=> '',
                    'discount-price'				=> '',
                    'discount-start-date'			=> '',
                    'discount-end-date'				=> '',
                    'leadtime-to-ship'				=> 2,
                    'update-delete'					=> 'UPDATE',
                    'tipo'							=> 16,
                    'msi'							=> 0,
                    'freeship'						=> 'No',
                    'subsidiodeenvio'				=> 0,
                    'largoemp'						=> round($_product->getTsDimensionsLength()),
                    'altoempaque'					=> round($_product->getTsDimensionsHeight()),
                    'anchodelempaque'				=> round($_product->getTsDimensionsWidth()),
                    'package-weight'				=> round($_product->getWeight()),
                    'garante'						=> strtoupper($_product->getAttributeText('autos_marcas')),
                    'condiciones'					=> 'Defectos de Fabrica',
                    'garantia'						=> 48,
                    'paisdeenvio'					=> 'México',
                    'claveprodserv'					=> ''
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
        
            exit();