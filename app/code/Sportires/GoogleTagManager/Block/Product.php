<?php declare(strict_types=1);


namespace Sportires\GoogleTagManager\Block;


class Product extends \MagePal\GoogleTagManager\Block\Data\Product
{



    protected function _prepareLayout()
    {
        /** @var $tm DataLayer */
        $tm = $this->getParentBlock();

        /** @var $product CatalogProduct */
        $product = $this->getProduct();

        $productData = array();

        if ($product) {
            $productData = [
                'id' => $product->getId(),
                'sku' => $product->getSku(),
                'parent_sku' => $product->getData('sku'),
                'product_type' => $product->getTypeId(),
                'name' => $product->getName(),
                'price' => $product->getFinalPrice(),
                'attribute_set_id' => $product->getAttributeSetId(),
                'path' => implode(" > ", $this->getBreadCrumbPath()),
                'category' => $this->getProductCategoryName(),
                'marca' => $product->getAttributeText('autos_marcas'),
                'modelo' => $product->getAttributeText('modelos'),
                'modelo_ancho' => $product->getAttributeText('tire_width'),
                'perfil_serie' => $product->getAttributeText('tire_ratio'),
                'rin' => $product->getAttributeText('tire_diameter'),
                'treadwear' => $product->getAttributeText('treadwear'),
                'rango_carga' => $product->getAttributeText('carga_s'),
                'velocidad' => $product->getAttributeText('velocidad_s'),
                'run_flat' => $product->getAttributeText('run_flat')
            ];

            //$productData = $this->productProvider->setProduct($product)->setProductData($productData)->getData();

            $data = [
                'event' => 'show_product',
                'product' => $productData
            ];

            $tm->addVariable('list', 'detail');
            $tm->addCustomDataLayerByEvent('show_product', $data);
        }

        return $this;
    }

}

