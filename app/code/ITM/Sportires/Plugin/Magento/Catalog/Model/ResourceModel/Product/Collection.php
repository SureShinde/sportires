<?php

namespace ITM\Sportires\Plugin\Magento\Catalog\Model\ResourceModel\Product;

class Collection
{

    protected $helper;
    protected $_collectionFactory;
    protected $_request;


    public function __construct(
        \ITM\Sportires\Helper\Data $helper,
        \ITM\Sportires\Model\ResourceModel\Vehicletire\CollectionFactory $collectionFactory,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->helper = $helper;
        $this->_request = $request;
    }

    public function beforeLoad(
        \Magento\Catalog\Model\ResourceModel\Product\Collection $subject
        //$function_params
    )
    {
        $cat_id = $this->_request->getParam('cat_id',0);
        if($cat_id>0) {
            $subject->addCategoriesFilter(array('in' => [$cat_id]));
        }

    }
    public function beforeLoad_old(
        \Magento\Catalog\Model\ResourceModel\Product\Collection $subject
        //$function_params
    )
    {
        return;
        $type = $this->_request->getParam('type');
        $size_array = [];
        $category = 0;

        if($type == "vehicle") {
            $make = $this->_request->getParam('make');
            $year = $this->_request->getParam('year');
            $model = $this->_request->getParam('model');
            $trim = $this->_request->getParam('trim');
            $category = $this->_request->getParam('category');

            $size_array = $this->helper->getSizes($make, $year, $model, $trim);

        }else if($type == "size") {
            $width = $this->_request->getParam('width');
            $ratio = $this->_request->getParam('ratio');
            $diameter = $this->_request->getParam('diameter');
          /*  $size_array[] = [
                "width"=>$width,
                "ratio"=>$ratio,
                "diameter"=>$diameter
            ];*/
        }
        if(count($size_array)>0) {
            foreach ($size_array as $size) {
                $tire_size = $this->helper->getTireSize($size["width"], $size["ratio"], $size["diameter"]);
                $subject->addAttributeToFilter('tire_size', $tire_size);
            }
        }

    }



}
