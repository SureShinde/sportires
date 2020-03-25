<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category  Ced
 * @package   Ced_Claro
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE (http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Block\Adminhtml\Product;

class Processor extends \Magento\Backend\Block\Widget\Container
{
    /**
     * Registry
     *
     * @var \Magento\Framework\Registry
     */
    public $registry;

    public $key;

    public $type;

    public $total;

    /**
     * BatchUpload constructor.
     *
     * @param \Magento\Backend\Block\Widget\Context     $context
     * @param \Magento\Framework\Registry               $registry
     * @param array                                     $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        $data = []
    ) {
        parent::__construct($context, $data);
        $this->_getAddButtonOptions();
        $this->registry = $registry;
        $this->key = $this->registry->registry(\Ced\Claro\Helper\Config::PRODUCT_ACTION_KEY);
        $this->type = $this->registry->registry(\Ced\Claro\Helper\Config::PRODUCT_ACTION_TYPE);
        $this->total = $this->registry->registry($this->key);
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getType()
    {
        return $this->type;
    }

    public function _getAddButtonOptions()
    {
        $splitButtonOptions = [
            'label' => __('Back'),
            'class' => 'action-secondary',
            'onclick' => "setLocation('" . $this->_getCreateUrl() . "')"
        ];
        $this->buttonList->add('add', $splitButtonOptions);
    }

    public function _getCreateUrl()
    {
        return $this->getUrl('claro/Product/index');
    }

    public function getAjaxUrl()
    {
        return $this->getUrl('claro/Product/processor');
    }
}
