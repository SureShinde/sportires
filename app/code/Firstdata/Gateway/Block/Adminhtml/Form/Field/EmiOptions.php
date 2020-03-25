<?php

namespace Firstdata\Gateway\Block\Adminhtml\Form\Field;



class EmiOptions extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray {
	
 
 

    /**
     * @var $_attributesRenderer \Magently\Tutorial\Block\Adminhtml\Form\Field\Activation
     */
    public function _toHtml() {
        return '<div id="' . $this->getElement()->getId() . '">' . parent::_toHtml() . '</div>';
    }

    /**
     * Get activation options.
     *
     * @return \Magently\Tutorial\Block\Adminhtml\Form\Field\Activation
     */

    /**
     * Prepare to render.
     *
     * @return void
     */
   protected function _prepareToRender() 
   {
	   
		
        $this->addColumn('Label', ['label' => __('Name')]);
        $this->addColumn('minamount', ['label' => __('MinAmount')]);
        $this->addColumn('maxamount', ['label' => __('MaxAmount')]);
        $this->addColumn('count', ['label' => __('Count')]);
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $scopeConfig = $objectManager->create('Magento\Framework\App\Config\ScopeConfigInterface');
        $country = $scopeConfig->getValue("payment/firstdata/country", \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $reseller =$scopeConfig->getValue("payment/firstdata/reseller", \Magento\Store\Model\ScopeInterface::SCOPE_STORE);	
			
				if($country == "mex" && $reseller=="firstdatamexico")
			{
				
				$this->addColumn('period', ['label' => __('Period')]);

			}
				$this->_addAfter = false;
				$this->_addButtonLabel = __('Add');
	}

    
}