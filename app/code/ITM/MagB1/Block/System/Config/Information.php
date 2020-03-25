<?php
namespace ITM\MagB1\Block\System\Config;

class Information extends \Magento\Config\Block\System\Config\Form\Field
{
    
    protected $_helper;
    
    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \ITM\MagB1\Helper\Data $helper,
        array $data = []
        ) {
            $this->_helper = $helper;
            parent::__construct($context, $data);
    }
    
    /**
     * @return string
     */
    protected function getAuthProviderLink()
    {
        return '';
    }
    /**
     * @return string
     */
    protected function getAuthProviderLinkHref()
    {
        return '';
    }
   
    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $html = "";
        $html .= "<ul  style='padding-left:2em'>
                    <li>Version: ".$this->_helper->getVersion()."</li>
                </ul>";
        
        return $html;
    }
}
