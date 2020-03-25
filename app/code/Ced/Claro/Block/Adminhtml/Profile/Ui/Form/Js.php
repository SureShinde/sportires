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
 * @category    Ced
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Block\Adminhtml\Profile\Ui\Form;

class Js extends \Magento\Backend\Block\Template
{

    protected $_template = 'Ced_Claro::profile/js.phtml';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    public $registry;

    /** @var \Magento\Framework\App\RequestInterface  */
    public $request;

    /** @var \Ced\Claro\Helper\Category  */
    public $category;

    public $profile;
    /**
     * Js constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Ced\Claro\Helper\Category $category,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->request = $context->getRequest();
        $this->category = $category;
        parent::__construct($context, $data);
    }
    public function getSelectedCategory()
    {
        $profile = $this->getProfile();
        $category = $profile->getData(\Ced\Claro\Model\Profile::COLUMN_CATEGORY);
        $category = !empty($category) ? json_decode($category,true) : ['category_level_0' => null];
        return $category;
    }

    /**
     * Get Profile
     * @return \Ced\Claro\Model\Profile|mixed
     */
    public function getProfile()
    {
        if (!isset($this->profile)) {
            /** @var \Ced\Claro\Model\Profile profile */
            $this->profile = $this->registry->registry('claro_profile');
        }
        return $this->profile;
    }

    /**
     * @return \Ced\Claro\Helper\Category
     */
    public function getCategoryHelper()
    {
        return $this->category;
    }

    public function getProfileId()
    {
        $id = $this->request->getParam('id');
        return $id;
    }
}
