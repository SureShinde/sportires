<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement(EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category  Ced
 * @package   Ced_FbNative
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\FbNative\Controller\Adminhtml\Account;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Ced\FbNative\Model\AccountFactory;

/**
 * Class Edit
 * @package Ced\FbNative\Controller\Adminhtml\Account
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    const ADMIN_RESOURCE = 'Ced_FbNative::FbNative';
    
    /**
     * @var \Ced\FbNative\Model\Account
     */
    public $accounts;

    /**
     * Edit constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param AccountFactory $accounts
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        AccountFactory $accounts
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->accounts = $accounts;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $accounts = $this->accounts->create()->load($id);
        } else {
            $accounts = $this->accounts->create();
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($accounts->getId() ? $accounts->getPageName() : __('New Account'));
        return $resultPage;
    }
}