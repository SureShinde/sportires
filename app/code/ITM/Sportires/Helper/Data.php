<?php
                
namespace ITM\Sportires\Helper;
        
use phpDocumentor\Reflection\Types\Parent_;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $eavConfig;
    protected $_collectionFactory;
    private $productFactory;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Eav\Model\Config $eavConfig,
        \ITM\Sportires\Model\ResourceModel\Vehicletire\CollectionFactory $collectionFactory,
        \Magento\Catalog\Model\ResourceModel\ProductFactory $productFactory
    ) {

        $this->_collectionFactory = $collectionFactory;
        $this->eavConfig = $eavConfig;
        $this->productFactory = $productFactory;
        parent::__construct($context);
    }

   public function getAttributeOptions($attribute_code) {

       $attribute = $this->eavConfig->getAttribute('catalog_product', $attribute_code);
       $options = $attribute->getSource()->getAllOptions(false);
       return $options;
   }
    public function getTireSize($width,$ratio,$diameter) {
        if(is_numeric ($width)) {
            $width = $width + 0;
        }
        $ratio = $ratio+0;

        if(is_numeric ($diameter)) {
            $diameter = $diameter + 0;
        }
        return sprintf("%s/%sR%s",$width,$ratio,$diameter );
    }
    public function getSizes($make, $year, $model, $trim)
    {
        $collection = $this->_collectionFactory->create();
        $poductReource = $this->productFactory->create();

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

        $attribute = $poductReource->getAttribute("tire_size");

        foreach ($collection as $item) {
            $front_tire_size = $this->getTireSize($item->getFrontWidth(),$item->getFrontRatio(),$item->getFrontDiameter());
            $rear_tire_size = $this->getTireSize($item->getRearWidth(),$item->getRearRatio(),$item->getRearDiameter());
            $options[$item->getFrontWidth() . "-" . $item->getFrontRatio() . "-" . $item->getFrontDiameter()] = [
                "width" => $item->getFrontWidth(),
                "ratio" => $item->getFrontRatio(),
                "diameter" => $item->getFrontDiameter(),
                "size" => $front_tire_size,
                "size_option_id" =>  $attribute->getSource()->getOptionId($front_tire_size)
            ];
            $options[$item->getRearWidth() . "-" . $item->getRearRatio() . "-" . $item->getRearDiameter()] = [
                "width" => $item->getRearWidth(),
                "ratio" => $item->getRearRatio(),
                "diameter" => $item->getRearDiameter(),
                "size" => $rear_tire_size,
                "size_option_id" =>  $attribute->getSource()->getOptionId($rear_tire_size)
            ];
        }

        return $options;
    }
}
