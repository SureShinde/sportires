<?php
    
namespace ITM\Sportires\Model\System\Config;

 
use Magento\Framework\Option\ArrayInterface;
    
class Attributeoption implements ArrayInterface
{
    protected $helperdata;
    public function __construct(
        \ITM\Sportires\Helper\Data	$helperdata

    ) {
        $this->helperdata = $helperdata;
    }


    public function toOptionArray()
    {
		$options = [];
        //$option_list = $this->helperdata->getAttributeOptions($attribut_code);
		//foreach($option_list as $item) {
			//$options[$item["value"]] = $item["label"];
		//}
		
        return $options;
    }

    public function toCustomOptionArray($attribut_code)
    {
		$options = [""=>"--"];
        $option_list = $this->helperdata->getAttributeOptions($attribut_code);
		foreach($option_list as $item) {
			$options[$item["value"]] = $item["label"];
		}
		
        return $options;
    }

}
