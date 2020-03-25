<?php

namespace Firstdata\Gateway\Block\Adminhtml\Form\Field;

class ResponseURL extends \Magento\Config\Block\System\Config\Form\Field {

    protected $urlBuilder;

    public function __construct(\Magento\Backend\Block\Template\Context $context) {
        $this->urlBuilder = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Magento\Framework\UrlInterface');

        parent::__construct($context);
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element) {
        $id = $element->getId();
        $url = '';

        if (preg_match('/(success)/', $id)) {
            $url = $this->urlBuilder->getBaseUrl() . 'firstdata/response';
        } else {
            $url = $this->urlBuilder->getBaseUrl() . 'firstdata/response';
        }
        $value = $element->getData('value');
        if ($value == '') {
            $element->setData('value', $url);
        }

        return parent::_getElementHtml($element);
    }

}

?>