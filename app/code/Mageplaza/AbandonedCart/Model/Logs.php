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

namespace Mageplaza\AbandonedCart\Model;

use Magento\Email\Model\TemplateFactory;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;

/**
 * Class Logs
 * @package Mageplaza\AbandonedCart\Model
 */
class Logs extends AbstractModel
{
    /**
     * @var \Magento\Email\Model\TemplateFactory
     */
    protected $templateFactory;

    /**
     * Logs constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Email\Model\TemplateFactory $templateFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        TemplateFactory $templateFactory
    ) {
        $this->templateFactory = $templateFactory;

        parent::__construct($context, $registry);
    }

    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();

        $this->_init('Mageplaza\AbandonedCart\Model\ResourceModel\Logs');
    }

    /**
     * @param $quote
     * @param $customerEmail
     * @param $customerName
     * @param $sender
     * @param $subject
     * @param $body
     * @param bool $status
     * @param null $couponCode
     */
    public function saveLogs($quote, $customerEmail, $customerName, $sender, $subject, $body, $status = false, $couponCode = null)
    {
        $this->setSubject($subject)
            ->setCustomerEmail($customerEmail)
            ->setCouponCode($couponCode)
            ->setQuoteId($quote->getId())
            ->setSender($sender)
            ->setCustomerName($customerName)
            ->setSequentNumber(1)
            ->setEmailContent(htmlspecialchars($body))
            ->setStatus($status)
            ->save();
    }

    /**
     * @param $quoteId
     *
     * @return $this
     */
    public function updateRecovery($quoteId)
    {
        try {
            $this->_getResource()->updateRecovery($quoteId);
        } catch (\Exception $e) {
            $this->_logger->critical($e->getMessage());
        }

        return $this;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function clear()
    {
        return $this->_getResource()->clear();
    }
}
