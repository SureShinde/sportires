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

use Ced\FbNative\Helper\MultiAccount;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Ui\Component\MassAction\Filter;
use Ced\FbNative\Model\ResourceModel\Account\CollectionFactory;
use Magento\Eav\Setup\EavSetupFactory;
/**
 * Class Massdelete
 * @package Ced\FbNative\Controller\Adminhtml\Account
 */
class Massdelete extends Action
{
    /**
     * @var CollectionFactory
     */
    public $accounts;
    /**
     * @var Filter
     */
    public $filter;

    const ADMIN_RESOURCE = 'Ced_FbNative::FbNative';

    public $multiAccount;

    public $eavSetupFactory;

    public $setup;

    /**
     * Massdelete constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        CollectionFactory $accounts,
        Filter $filter,
        MultiAccount $multiAccount,
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $setup
    ) {
        parent::__construct($context);
        $this->accounts = $accounts;
        $this->filter = $filter;
        $this->multiAccount = $multiAccount;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->setup = $setup;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $ids = $this->filter->getCollection($this->accounts->create())->getAllIds();
        if (!empty($ids)) {
            $collection = $this->accounts->create()->addFieldToFilter('id', ['in' => $ids]);
            if (isset($collection) and $collection->getSize() > 0) {
                $collection->walk('delete');
                foreach ($ids as $id) {
                    $accountAttr = $this->multiAccount->getStoreAttrForAcc($id);
                    $eavSetup = $this->eavSetupFactory->create(['setup' => $this->setup]);
                    $eavSetup->removeAttribute(
                        \Magento\Catalog\Model\Product::ENTITY,
                        $accountAttr);
                }
                $this->messageManager->addSuccessMessage(__($collection->getSize(). ' Account(s) Deleted Successfully'));
            } else {
                $this->messageManager->addErrorMessage(__('No product available for Delete.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('No product available for Delete.'));
            
        }
        return $this->_redirect('fbnative/account/index');
    }
}
