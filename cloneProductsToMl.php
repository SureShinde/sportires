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


	$select = "SELECT sku FROM catalog_product_entity WHERE sku NOT LIKE '%P%' AND sku in ('18502300','16741003') ORDER BY 1 ASC";
    $tires = $connection->fetchAll($select);

$productFactory = $obj->create('Magento\Catalog\Model\ProductFactory');


//$oldSku = '92296';
//$newSku = '92296P';
$i = 1;
foreach($tires as $tire){
$oldSku = $tire['sku'];
$newSku = $tire['sku'].'-01';

if(!$oldSku || !$newSku){
	die('missing argument');
}
	try{

			$oldProduct = $productFactory->create()->loadByAttribute('sku',$oldSku);


			$websiteIds = array(1);//$oldProduct->getWebsiteIds();
			$categoryIds = array(2);//$oldProduct->getCategoryIds();
			$oldProductId = $oldProduct->getId();
			
	
			$duplicate = null;

			$duplicate = $productFactory->create();
			$duplicate->setData($oldProduct->getData());

			$directory = $oldProduct->getSku();

			$duplicate->setIsDuplicate(true);

			$duplicate->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);
			$duplicate->setCreatedAt(null);
			$duplicate->setUpdatedAt(null);
			$duplicate->setId(null);
			$duplicate->setStoreId(\Magento\Store\Model\Store::DEFAULT_STORE_ID);
			$duplicate->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_NOT_VISIBLE);

			$urlKey = 'producto-duplicado-ml-'.$oldProduct->getUrlKey();
			$urlKey = preg_match('/(.*)-(\d+)$/', $urlKey, $matches) ? $matches[1] . '-' . ($matches[2] + 1) : $urlKey . '';
			$duplicate->setUrlKey($urlKey);
			$name = trim(substr(str_replace('Llanta','',$oldProduct->getName()),0,60));

			$duplicate->setSku($newSku);
			$duplicate->setName($name);
			$duplicate->setUpc($oldProduct->getUpc());
			//$duplicate->setBarcodeEan('');

			$duplicate->setData('meta_title',str_replace('Llanta','',$oldProduct->getMetaTitle()));
			$duplicate->setData('meta_keyword',$oldProduct->getMetaKeyword());
			$duplicate->setData('meta_description',str_replace('Llanta','',$oldProduct->getMetaDescription()));

			//$duplicate->setAmazonProfileId('');
			$duplicate->setAmazonPrice('');
			
			//$duplicate->setMlibreProfileId('');
			$duplicate->setMlibreProductId('');
			$duplicate->setMlibreProductErrors('');

			//$duplicate->setWalmartmxProfileId('');
			$duplicate->setWalmartmxFeedErrors('');

			//$duplicate->setClaroProfileId('');
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
			                'qty' => $qty
			            )
			    );

		   $images = $oldProduct->getMediaGalleryImages();
		   foreach ($images as $image) {
		       if( $path = $image->getPath() ) {
		           $duplicate->addImageToMediaGallery($path, array('image','thumbnail','small_image'), false, false);
		       }
		   }


		    try{

			$id = $duplicate->save();
			
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