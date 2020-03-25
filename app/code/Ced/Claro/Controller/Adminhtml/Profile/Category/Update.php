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

namespace Ced\Claro\Controller\Adminhtml\Profile\Category;

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
        PageFactory $resultPageFactory,
        Profile $profile,
        \Ced\Claro\Helper\Category $category,
        \Ced\Claro\Helper\Logger $logger
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->profile = $profile;
        $this->category = $category;
        $this->logger = $logger;
    }

    /**
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $categoryId = $this->getRequest()->getParam('category_id');
        $childs = [];
        $success = false;
        $leaf = false;

        try {
            if (isset($categoryId) && !empty($categoryId)) {
                $childs = $this->category->getList($categoryId);
                if (isset($childs['id'])) {
                    $success = true;
                    if (isset($childs['children_categories']) && empty($childs['children_categories'])) {
                        $leaf = true;
                        $success = false;
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->addError($e->getMessage(), ['path' => __METHOD__]);
        }

        /** @var \Magento\Framework\Controller\Result\Json $resultPage */
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $resultPage->setData(['success' => $success, 'categories' => $childs, 'leaf' => $leaf]);
        return $resultPage;
    }
}
