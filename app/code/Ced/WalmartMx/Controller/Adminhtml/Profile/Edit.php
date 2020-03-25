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
 * @package   Ced_WalmartMx
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CedCommerce (http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\WalmartMx\Controller\Adminhtml\Profile;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Ced\WalmartMx\Model\Profile;
use Magento\Backend\App\Action;

/**
 * Class Edit
 *
 * @package Ced\WalmartMx\Controller\Adminhtml\Profile
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    public $resultPageFactory;
    /**
     * @var
     */
    public $_entityTypeId;
    /**
     * @var \Magento\Framework\Registry
     */
    public $_coreRegistry;

    /**
     * @var Profile
     */
    public $profile;

    public $config;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        PageFactory $resultPageFactory,
        Profile $profile,
        \Ced\WalmartMx\Helper\Config $config
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->profile = $profile;
        $this->config = $config;
    }

    /**
     * Index action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // case 1 check if api config are valid
        if (!$this->config->isValid()) {
            $this->messageManager->addErrorMessage(
                __('WalmartMx API not enabled or credentials are invalid. Please check WalmartMx Configuration.')
            );
        }

        // Case 2 api credentials are valid, for block form

        /*
        // Case 2.1: Block form
        $profileCode = $this->getRequest()->getParam('pcode');
        $id = $this->getRequest()->getParam('id');
        if (isset($profileCode) or isset($id)) {
            if (isset($profileCode) and !empty($profileCode)) {
                $profile = $this->profile->getCollection()
                    ->addFieldToFilter('profile_code', $profileCode)
                    ->getFirstItem();
            } else {
                $profile = $this->profile->getCollection()
                    ->addFieldToFilter('id', $id)
                    ->getFirstItem();
            }

            $this->getRequest()->setParam('is_profile', 1);
            $this->_coreRegistry->register('current_profile', $profile);
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()
                ->prepend($profile->getId() ? $profile->getProfileName() : __('New Profile'));
            $resultPage->getLayout()->getBlock('profile_edit_js')
                ->setIsPopup((bool)$this->getRequest()->getParam('popup'));
            return $resultPage;
        } else {
            $profile = $this->profile;
            $this->_coreRegistry->register('current_profile', $this->profile);
            $breadCrumb = __('Add New Profile');
            $breadCrumbTitle = __('Add New Profile');
            $item = __('New Profile');
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('New Profile'));
            $resultPage->getLayout()
                ->getBlock('profile_edit_js')
                ->setIsPopup((bool)$this->getRequest()->getParam('popup'));
            return $resultPage;
        }*/

        // Case 2.1 : Ui form
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ced_WalmartMx::walmartmx_profile');
        $id = $this->getRequest()->getParam('id');
        if (isset($id) and !empty($id)) {
            $this->profile->load($id);
            if($this->profile && $this->profile->getData('profile_name')){
                $this->_coreRegistry->register('walmartmx_profile', $this->profile);
                $resultPage->getConfig()->getTitle()->prepend(__('Edit Profile '.$this->profile->getData('profile_name')));
            }else {
                $resultPage->getConfig()->getTitle()->prepend(__('Add New Profile'));
            }
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('Add New Profile'));
        }
        return $resultPage;
    }
}
