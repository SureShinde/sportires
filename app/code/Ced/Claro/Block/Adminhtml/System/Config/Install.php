<?php

namespace Ced\Claro\Block\Adminhtml\System\Config;

class Install extends \Magento\Config\Block\System\Config\Form\Field
{
    protected $_template = 'Ced_Claro::system/config/install.phtml';

    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    public function getAjaxUrl()
    {
        return $this->getUrl('claro/config/save', ['form_key' => $this->getFormKey()]);
    }

    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Button::class
        )->setData(
            [
                'id' => 'claro-install',
                'label' => __('Install'),
                'class' => 'action-secondary scalable',
                'style' => 'float: right'
            ]
        );

        return $button->toHtml();
    }

    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_toHtml();
    }
}
