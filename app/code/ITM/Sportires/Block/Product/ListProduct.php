<?php 

namespace ITM\Sportires\Block\Product;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
/*
 	protected $_productCollectionFactory;
    protected $_collectionFactory;
  

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Framework\Url\Helper\Data $urlHelper,
		\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \ITM\Sportires\Model\ResourceModel\Vehicletire\CollectionFactory $collectionFactory,

        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $postDataHelper,$layerResolver, $categoryRepository, $urlHelper, $data);
    }

    protected function _getProductCollection()
    {
        $make = $this->getRequest()->getParam('make');
        $year = $this->getRequest()->getParam('year');
        $model = $this->getRequest()->getParam('model');
        $trim = $this->getRequest()->getParam('trim');
        $category = $this->getRequest()->getParam('category');


        if ($this->_productCollection === null) {
            $this->_productCollection = $this->initializeProductCollection();
        }

        return $this->_productCollection;
    }
    private function initializeProductCollection()
    {


        $type = $this->getRequest()->getParam('type');
        $size_array = [];
        $category = 0;

        if($type == "vehicle") {
            $make = $this->getRequest()->getParam('make');
            $year = $this->getRequest()->getParam('year');
            $model = $this->getRequest()->getParam('model');
            $trim = $this->getRequest()->getParam('trim');
            $category = $this->getRequest()->getParam('category');

            $size_array = $this->getSizes($make, $year, $model, $trim);

        }else if($type == "size") {
            $width = $this->getRequest()->getParam('width');
            $ratio = $this->getRequest()->getParam('ratio');
            $diameter = $this->getRequest()->getParam('diameter');
            $size_array[] = [
                "width"=>$width,
                "ratio"=>$ratio,
                "diameter"=>$diameter
            ];
        }
        $productCollection = $this->_productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');

        if(count($size_array)>0) {
            foreach ($size_array as $size) {
                $productCollection->addAttributeToFilter(array(
                    ['attribute' => 'tire_width', 'eq' => $size["width"]],
                    ['attribute' => 'tire_ratio', 'eq' => $size["ratio"]],
                    ['attribute' => 'tire_diameter', 'eq' => $size["diameter"]],

                ));
            }
        }


        $selectString = $productCollection->getSelect()->__toString();
        $whereCond = substr( $selectString, strpos( strtolower($selectString) , "where" ) + 6);

        // exchange AND- and OR-conditions and get new where condition:
        $whereCond = str_replace( array('AND','OR') , array('!&&!','!||!') , $whereCond );
        $newWhereCond = str_replace( array('!&&!','!||!') , array('OR','AND') , $whereCond );

        $productCollection->getSelect()->reset(\Zend_Db_Select::WHERE);
        $productCollection->getSelect()->where($newWhereCond);


        //print json_encode($productCollection->getData());
        if($category!=0) {

        }
        return $productCollection;
    }
    public function getSizes($make, $year, $model, $trim)
    {

        $collection = $this->_collectionFactory->create();
        $collection->addFieldtoFilter("make", $make);
        $collection->addFieldtoFilter("year", $year);
        $collection->addFieldtoFilter("model", $model);
        $collection->addFieldtoFilter("trim", $trim);
        $collection->addFieldtoSelect("rear_width");
        $collection->addFieldtoSelect("front_width");
        $collection->addFieldtoSelect("rear_ratio");
        $collection->addFieldtoSelect("front_ratio");
        $collection->addFieldtoSelect("rear_diameter");
        $collection->addFieldtoSelect("front_diameter");
        $options = [];

        foreach ($collection as $item) {
            $options[$item->getFrontWidth()."-".$item->getFrontRatio()."-".$item->getFrontDiameter()] = [
                "width"=>$item->getFrontWidth(),
                "ratio"=>$item->getFrontRatio(),
                "diameter"=>$item->getFrontDiameter()];

            $options[$item->getRearWidth()."-".$item->getRearRatio()."-".$item->getRearDiameter()] = [
                "width"=>$item->getRearWidth(),
                "ratio"=>$item->getRearRatio(),
                "diameter"=>$item->getRearDiameter()];

        }

        return $options;
    }
  */
}
