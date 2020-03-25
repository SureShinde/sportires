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
use Magento\Backend\App\Action;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Save
 * @package Ced\FbNative\Controller\Adminhtml\Account
 */
class Save extends Action
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Ced_FbNative::FbNative';

    /** @var \Ced\FbNative\Model\AccountFactory $accounts */
    protected $accounts;

    public $multiAccount;

    /**
     * Save constructor.
     * @param Context $context
     * @param \Ced\FbNative\Model\AccountFactory $accounts
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        \Ced\FbNative\Model\AccountFactory $accounts,
        StoreManagerInterface $storeManager,
        \Ced\FbNative\Helper\MultiAccount $multiAccount
    )
    {
        parent::__construct($context);
        $this->accounts = $accounts;
        $this->storeManager = $storeManager;
        $this->multiAccount = $multiAccount;
    }

    public function execute()
    {
        $accountDetails = $this->getRequest()->getParams();

        try {
            if (isset($accountDetails['page_name']) || isset($accountDetails['id'])) {
                if (isset($accountDetails['id'])) {
                    /** @var \Ced\FbNative\Model\Account $accounts */
                    $accounts = $this->accounts->create()->load($accountDetails['id']);
                } else {
                    if (isset($accountDetails['page_name'])) {
                        $accountcode = $accountDetails['page_name'];
                        $accountCollection = $this->_objectManager->get('Ced\FbNative\Model\Account')->getCollection()->
                        addFieldToFilter('page_name', $accountcode);
                        if (count($accountCollection) > 0) {
                            $this->messageManager->addErrorMessage(__('This Account ' . $accountcode . ' Already Exist Please Change Page Name'));
                            $this->_redirect('*/*/new');
                            return;
                        }
                    }
                    /** @var \Ced\FbNative\Model\Account $accounts */
                    $accounts = $this->accounts->create();
                }

                /** @var \Magento\Store\Model\StoreManagerInterface $storeManager */
                $storeManager = $this->_objectManager->create('Magento\Store\Model\StoreManagerInterface');
                $currentStore = $storeManager->getStore(/*$accountDetails['account_store']*/);
                $csvPath = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .
                    'ced_fbnative/' . strtolower($accountDetails['page_name']) . '.csv';
                $accountDetails['export_csv'] = $csvPath;
                $accounts->addData($accountDetails)->save();
                $this->multiAccount->createStoreAttribute($accounts->getId(), $accountDetails['page_name']);
                $this->messageManager->addSuccessMessage(__('Account Saved Successfully.'));
                $this->_redirect('*/*/index', ['id' => $accounts->getId()]);
            } else {
                $this->messageManager->addNoticeMessage(__('Please fill the Page Name'));
                $this->_redirect('*/*/new');
            }
        } catch (\Exception $e) {
            //$this->_objectManager->create('Ced\FbNative\Helper\Logger')->addError('In Save Account: ' . $e->getMessage(), ['path' => __METHOD__]);
            $this->messageManager->addErrorMessage(__('Unable to Save Account Details Please Try Again. ' . $e->getMessage()));
            $this->_redirect('*/*/new');
        }
        return;
    }
}