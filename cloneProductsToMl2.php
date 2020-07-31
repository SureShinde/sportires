<?php
error_reporting(0);
use Magento\Framework\App\Bootstrap;
use Psr\Log\LoggerInterface;
use Magento\Framework\ObjectManagerInterface;

require __DIR__ . '/app/bootstrap.php';
$params = $_SERVER;
$bootstrap = Bootstrap::create(BP, $params);
$obj = $bootstrap->getObjectManager();
$state = $obj->get('Magento\Framework\App\State');
$state->setAreaCode('frontend');
$obj = $bootstrap->getObjectManager();

$resource = $obj->get('Magento\Framework\App\ResourceConnection');
$connection = $resource->getConnection();

$fileSystem = $obj->create('\Magento\Framework\Filesystem');
$mediaPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();




	//$select = "SELECT * FROM `z_temp_duplicate_to_ml` WHERE created = 0;";
    //$tires = $connection->fetchAll($select);

	$productFactory = $obj->create('Magento\Catalog\Model\ProductFactory');

	$Products = $obj->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
			->addAttributeToSelect('*')
            ->addAttributeToFilter('autos_marcas',['in' => array(4,6,7)]);



$i = 1;
foreach($Products as $oldProduct){
$oldSku = $oldProduct->getSku();
$newSku = $oldProduct->getSku().'-01';
$oldProductId = $oldProduct->getId();

/*if($i == 3){
	die('cortamos con 3');
}*/

if(!$oldSku || !$newSku){
	die('missing argument');
}

$pos = strpos($oldSku, 'P');

if ($pos === false) {
    echo '['.$oldSku.']   ';
} else {
	continue;
}

	try{

			
			//$oldProduct = $obj->create('Magento\Catalog\Model\Product')->load($oldProductId);
			

			$websiteIds = $oldProduct->getWebsiteIds();
			$categoryIds = $oldProduct->getCategoryIds();
			$oldProductId = $oldProduct->getId();//$oldProduct->getId();
			
	
			$duplicate = null;

			$duplicate = $productFactory->create();
			//print_r($oldProduct->getData());
			$duplicate->setData($oldProduct->getData());

			$directory = $oldProduct->getSku();

			$duplicate->setIsDuplicate(true);

			$duplicate->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);
			$duplicate->setCreatedAt(null);
			$duplicate->setUpdatedAt(null);
			$duplicate->setId(null);
			$duplicate->setStoreId(\Magento\Store\Model\Store::DEFAULT_STORE_ID);
			$duplicate->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE);
			$duplicate->setStatus(1);
			$urlKey = 'producto-duplicado-ml-'.$oldProduct->getUrlKey();
			$urlKey = preg_match('/(.*)-(\d+)$/', $urlKey, $matches) ? $matches[1] . '-' . ($matches[2] + 1) : $urlKey . '';
			$duplicate->setUrlKey($urlKey);
			$name = trim(substr(str_replace('Llanta','Clasica',$oldProduct->getName()),0,60));

			$duplicate->setSku($newSku);
			$duplicate->setName($name);
			$duplicate->setUpc($oldProduct->getUpc());
			//$duplicate->setBarcodeEan('');

			$duplicate->setData('meta_title',str_replace('Llanta','Clasica',$oldProduct->getMetaTitle()));
			$duplicate->setData('meta_keyword',$oldProduct->getMetaKeyword());
			$duplicate->setData('meta_description',str_replace('Llanta','Clasica',$oldProduct->getMetaDescription()));

			$duplicate->setAmazonProfileId('');
			$duplicate->setAmazonPrice('');
			
			$duplicate->setMlibreProfileId('');
			$duplicate->setMlibreProductId('');
			$duplicate->setMlibreProductErrors('');

			$duplicate->setWalmartmxProfileId('');
			$duplicate->setWalmartmxFeedErrors('');

			$duplicate->setClaroProfileId('');
			$duplicate->setIdClaroshop('');

			$duplicate->setWebsiteIds($websiteIds);
			$duplicate->setCategoryIds($categoryIds);

			//$duplicate->setSpecialPrice(NULL);
			//$duplicate->setSpecialFromDate(NULL);
			//$duplicate->setSpecialToDate(NULL);
			//$duplicate->setPrice($mlPrice);
			//$duplicate->setMercadolibrePrice($mlPrice);

			$qty = 0;
			try{
				$stockItem = $obj->get('\Magento\CatalogInventory\Model\Stock\StockItemRepository');
				$productStock = $stockItem->get($oldProductId);
				$qty = $productStock->getQty();
			}catch(\Exception $e){
				echo ' * ';
			}



			$duplicate->setStockData(
			            array(
			                'use_config_manage_stock' => 1,
			                'manage_stock' => 1,
			                'is_in_stock' => 1,
			                'qty' => $qty,
			                'max_sale_qty' => 8,
			                'min_sale_qty' => 1
			            )
			    );



		    try{
		    	echo ' SE DUPLICA ';
			$id = $duplicate->save();

			$newArrayImages = array();
			$newArrayImages2 = array();

			//$sql = "UPDATE z_temp_duplicate_to_ml SET created = 1 WHERE sku = '$oldSku'";
			//$connection->query($sql);

		    $product = $obj->create('Magento\Catalog\Model\Product')->load($oldProductId);        
		    $images = $product->getMediaGalleryImages();
		    foreach($images as $child){ 

		        $img = explode('/pub/media/',$child->getUrl());
		        $newArrayImages[] = $img[1];
		    }

				$files = array_reverse($newArrayImages);
				$newArrayImages = array();
				foreach($files as $images){
					if($images != '006_Sportires_ML02.jpg'){
						$newArrayImages[] = $images;
					}

				}
				
				$newArrayImages2[] = 'catalog/Sportires_ML02.jpg';
				$newArrayImages2[] = 'catalog/Sportires_ML03_factura.jpg';

				//print_r($newArrayImages);


				$product = $obj->create('Magento\Catalog\Model\Product')->load($id->getId());
				$productRepository = $obj->create('Magento\Catalog\Api\ProductRepositoryInterface');
				$existingMediaGalleryEntries = $product->getMediaGalleryEntries();
				foreach ($existingMediaGalleryEntries as $key => $entry) {
				    unset($existingMediaGalleryEntries[$key]);
				}
				$product->setMediaGalleryEntries($existingMediaGalleryEntries);
				$productRepository->save($product);

				foreach($newArrayImages2 as $imagen){
					$product = $obj->create('Magento\Catalog\Model\Product')->load($id->getId());

					$imagePath = $mediaPath.$imagen;
					if(file_exists($imagePath)){
						$product->addImageToMediaGallery($imagePath, array('image', 'small_image', 'thumbnail'), false, false);	
						$product->save();
					}
				}

				foreach($newArrayImages as $imagen){
					$product = $obj->create('Magento\Catalog\Model\Product')->load($id->getId());

					$imagePath = $mediaPath.$imagen;
					if(file_exists($imagePath)){
						$product->addImageToMediaGallery($imagePath, array('image', 'small_image', 'thumbnail'), false, false);	
						$product->save();
					}
				}



			}catch(\Exception $e){
					echo 'ERROR PRODUCTO NO DUPLICABLE : '.$e->getMessage();
					continue;
			}
			echo $i.'-';
		
	}catch(\Exception $e){
	echo 'ERROR TOTAL : '.(string)$e->getMessage();
	}
	++$i;
}