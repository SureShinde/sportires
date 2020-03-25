<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_AbandonedCart
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\AbandonedCart\Controller\Checkout;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Quote\Model\QuoteFactory;
use Mageplaza\AbandonedCart\Helper\Data;
use Mageplaza\AbandonedCart\Model\LogsFactory;
use Mageplaza\AbandonedCart\Model\Token;

/**
 * Class Cart
 * @package Mageplaza\AbandonedCart\Controller\Checkout
 */
class Cart extends Action
{
    /**
     * @var \Mageplaza\AbandonedCart\Model\Token
     */
    protected $tokenModel;

    /**
     * @var \Magento\Quote\Model\QuoteFactory
     */
    protected $quoteFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Mageplaza\AbandonedCart\Model\LogsFactory
     */
    protected $logsFactory;

    /**
     * @var \Mageplaza\AbandonedCart\Helper\Data
     */
    protected $helperData;

    /**
     * Cart constructor.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     * @param \Mageplaza\AbandonedCart\Model\Token $tokenModel
     * @param \Mageplaza\AbandonedCart\Model\LogsFactory $logsFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Mageplaza\AbandonedCart\Helper\Data $helperData
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        Context $context,
        QuoteFactory $quoteFactory,
        Token $tokenModel,
        LogsFactory $logsFactory,
        Session $customerSession,
        Data $helperData,
        CheckoutSession $checkoutSession
    ) {
        parent::__construct($context);

        $this->tokenModel = $tokenModel;
        $this->quoteFactory = $quoteFactory;
        $this->customerSession = $customerSession;
        $this->logsFactory = $logsFactory;
        $this->helperData = $helperData;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Recovery cart by cart link
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        $token = $this->getRequest()->getParam('token');
        if (!$this->helperData->isEnabled() && ($token != 'test_email')) {
            return $this->goBack();
        }

        $quoteId = (int)$this->getRequest()->getParam('id');
        if (!$this->tokenModel->validateCartLink($quoteId, $token) && ($token != 'test_email')) {
            $this->messageManager->addErrorMessage(__('You can\'t used this link.'));

            return $this->goBack();
        }

        $quote = $this->quoteFactory->create()->load($quoteId);
        if (!$quote->getId() || !$quote->getIsActive()) {
            $this->messageManager->addErrorMessage(__('An error occurred while recovering your cart.'));

            return $this->goBack();
        }

        $customerId = $quote->getCustomerId();
        if (!$customerId) {
            $this->checkoutSession->setQuoteId($quoteId);
            $this->logsFactory->create()->updateRecovery($quoteId);
            $this->messageManager->addSuccess(__('The recovery succeeded.'));

            return $this->goBack();
        }

        if (!$this->customerSession->isLoggedIn()) {
            if (!$this->customerSession->loginById($customerId)) {
                $this->messageManager->addErrorMessage(__('An error occurred while logging in your account. Please try to log in again.'));

                return $this->goBack();
            }

            $this->customerSession->regenerateId();
            $this->logsFactory->create()->updateRecovery($quoteId);
            $this->messageManager->addSuccess(__('The recovery succeeded.'));
        } else if ($this->customerSession->getId() != $customerId) {
            $this->messageManager->addNotice(__('Please login with %1', $quote->getCustomerEmail()));

            return $this->goBack();
        }

        $this->logsFactory->create()->updateRecovery($quoteId);
        $this->messageManager->addSuccess(__('The recovery succeeded.'));

        return $this->goBack();
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface
     */
    protected function goBack()
    {
        return $this->_redirect('checkout/cart');
    }
}
