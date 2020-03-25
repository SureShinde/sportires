<?php
namespace ITM\Sportires\Block;  

use Magento\Catalog\Model\Product;
use \Magento\Catalog\Block\Product\View\Attributes;

class Template extends \Magento\Framework\View\Element\Template {
   
	protected $_product=null;
	
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
		\Magento\Swatches\Helper\Media $swatchHelper,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
		
        parent::__construct($context, $data);
    }
    
	public function getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->_coreRegistry->registry('product');
        }
        return $this->_product;
    }
	
	public function getmarka(){
		
		
		if (null !== $this->getProduct()->getCustomAttribute('autos_marcas')) {
			$attribute = $this->getProduct()->getResource()->getAttribute('autos_marcas')->getFrontend()->getValue($this->getProduct());
			return $attribute;
		}		
		
		if (null !== $this->getProduct()->getCustomAttribute('motos_marcas')) {
			$attribute = $this->getProduct()->getResource()->getAttribute('motos_marcas')->getFrontend()->getValue($this->getProduct());
			return $attribute; 
		}
		
	}
   
}
?>