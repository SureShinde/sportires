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

namespace Ced\Claro\Controller\Adminhtml\Profile;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Ced\Claro\Model\Profile;

/**
 * TODO: dev
 * Class Edit
 *
 * @package Ced\Claro\Controller\Adminhtml\Profile
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    public $resultPageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    public $coreRegistry;

    /**
     * @var Profile
     */
    public $profile;

    public $config;

    /**
     * Edit constructor.
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     * @param Profile $profile
     * @param \Ced\Claro\Helper\Config $config
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        PageFactory $resultPageFactory,
        Profile $profile,
        \Ced\Claro\Helper\Config $config
    ) {
        parent::__construct($context);
        $this->messageManager = $messageManager;
        $this->resultFactory = $context->getResultFactory();
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        $this->profile = $profile;
        $this->config = $config;
    }

    /**
     * Product action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $check = $this->config->isValid();
        if (!empty($check)) {
            $id = $this->getRequest()->getParam('id');
            if (isset($id) && !empty($id)) {
                $this->profile->load($id);
            }

            $this->coreRegistry->register('claro_profile', $this->profile);

            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            $resultPage->setActiveMenu('Ced_Claro::claro_profile');
            $resultPage->getConfig()->getTitle()->prepend(__('Edit Profile'));
            return $resultPage;
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            $url = $this->_redirect->getRefererUrl('claro/profile/index');
            $resultRedirect->setUrl($url);
            $this->messageManager->
            addErrorMessage('Profile Open Failed Claro API not enabled or Invalid. Please check Claro Configuration.');
            return $resultRedirect;
        }

    }
}
