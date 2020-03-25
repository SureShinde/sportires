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

use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Newsletter\Model\SubscriberFactory;
use Mageplaza\AbandonedCart\Helper\Data;

/**
 * Class Token
 * @package Mageplaza\AbandonedCart\Model
 */
class Token
{
    /**
     * Date model
     *
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var ResourceConnection
     */
    protected $resource;

    /**
     * @var SubscriberFactory
     */
    protected $subscriberFactory;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var \Magento\Customer\Api\Data\CustomerInterfaceFactory
     */
    private $customerFactory;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param ResourceConnection $resource
     * @param Data $helper
     * @param SubscriberFactory $subscriberFactory
     * @param \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerFactory
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        DateTime $date,
        ResourceConnection $resource,
        Data $helper,
        SubscriberFactory $subscriberFactory,
        CustomerInterfaceFactory $customerFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource = $resource;
        $this->date = $date;
        $this->subscriberFactory = $subscriberFactory;
        $this->helper = $helper;
        $this->customerFactory = $customerFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @param int $quoteId
     * @param string $configId
     * @param string $token
     *
     * @return void
     */
    public function saveToken($quoteId, $configId, $token)
    {
        $bind = [
            'quote_id'                  => $quoteId,
            'config_id'                 => $configId,
            'checkout_token'            => $token,
            'checkout_token_created_at' => $this->date->date()
        ];
        $this->resource->getConnection()->insert($this->resource->getTableName('mageplaza_abandonedcart_logs_token'), $bind);
    }

    /**
     * @param int|null $quoteId
     * @param string|null $token
     *
     * @return bool
     */
    public function validateCartLink($quoteId = null, $token = null)
    {
        if ($quoteId == null || $token == null) {
            return false;
        }
        $connection = $this->resource->getConnection();
        $select = $connection->select()
            ->from($this->resource->getTableName('mageplaza_abandonedcart_logs_token'))
            ->where('checkout_token = :checkout_token')
            ->where('quote_id = :quote_id');
        $bind = [
            'checkout_token' => $token,
            'quote_id'       => $quoteId
        ];
        $result = $connection->fetchOne($select, $bind);
        if (isset($result) && !empty($result)) {
            return true;
        }

        return false;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param string $configId
     *
     * @return bool
     */
    public function validateEmail($quote, $configId)
    {
        $customerEmail = $quote->getCustomerEmail();
        $quoteId = $quote->getId();
        $storeId = $quote->getStoreId();

        $connection = $this->resource->getConnection();
        $select = $connection->select()
            ->from($this->resource->getTableName('mageplaza_abandonedcart_logs_token'))
            ->where('config_id = :config_id')
            ->where('quote_id = :quote_id');
        $hasSent = $connection->fetchOne($select, ['config_id' => $configId, 'quote_id' => $quoteId]);

        $customerSubscribed = true;
        if ($this->helper->onlySendToSubscribed($storeId)) {
            $subscriber = $this->subscriberFactory->create();
            $customerData = ['store_id' => $storeId, 'email' => $customerEmail];

            /** @var \Magento\Customer\Api\Data\CustomerInterface $customer */
            $customer = $this->customerFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $customer,
                $customerData,
                \Magento\Customer\Api\Data\CustomerInterface::class
            );
            $subscriber->addData($subscriber->getResource()->loadByCustomerData($customer));
            $customerSubscribed = $subscriber->isSubscribed();
        }
        if (!empty($hasSent) || !$customerSubscribed) {
            return false;
        }

        return true;
    }
}
