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
 * @copyright Copyright CedCommerce (http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Controller\Adminhtml\Profile\Attribute;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;
use Ced\Claro\Model\Profile;

/**
 * Class Update
 * @package Ced\Claro\Controller\Adminhtml\Profile
 */
class Update extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public $resultPageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    public $coreRegistry;

    /** @var Profile */
    public $profile;

    /** @var \Ced\Claro\Helper\Category */
    public $category;

    /** @var \Ced\Claro\Helper\Logger */
    public $logger;

    /**
     * Update constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Profile $profile
     * @param \Ced\Claro\Helper\Category $category
     * @param \Ced\Claro\Helper\Logger $logger
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        PageFactory $resultPageFactory,
        Profile $profile,
        \Ced\Claro\Helper\Category $category,
        \Ced\Claro\Helper\Logger $logger
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->profile = $profile;
        $this->category = $category;
        $this->logger = $logger;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('profile_id');
        if (isset($id) && !empty($id)) {
            $this->profile->load($id);
        }

        $this->coreRegistry->register('claro_profile', $this->profile);

        $categoryId = $this->getRequest()->getParam('category_id');
        $requiredAttributes = [];
        $optionalAttributes = [];

        try {
            if (isset($categoryId) && !empty($categoryId)) {
                $params = [
                    'required' => true
                ];

                $requiredAttributes = array_merge(
                    $requiredAttributes,
                    $this->category->getAttributes($categoryId, $params)
                );

                $params = [
                    'required' => false
                ];

                $optionalAttributes = array_merge(
                    $optionalAttributes,
                    $this->category->getAttributes($categoryId, $params)
                );
            }
        } catch (\Exception $e) {
            $this->logger->addError($e->getMessage(), ['path' => __METHOD__]);
        }

        $attributes[] = [
            'label' => __('Required Attributes'),
            'value' => $requiredAttributes
        ];

        $attributes[] = [
            'label' => __('Optional Attributes'),
            'value' => $optionalAttributes
        ];

        /** @var  $result */
        $result = $this->resultPageFactory->create(true);
        /** @var \Magento\Framework\View\LayoutInterface $layout */
        $layout = $result->getLayout();
        /** @var \Magento\Framework\View\Element\BlockInterface $block */
        $block = $layout->createBlock(
            \Ced\Claro\Block\Adminhtml\Profile\Ui\Form\AttributeMapping::class,
            'claro_attributes'
        );

        $html = $block->setAttributes($attributes)->toHtml();

        return $this->getResponse()->setBody($html);
    }
}
