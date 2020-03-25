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

namespace Mageplaza\AbandonedCart\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Stdlib\DateTime\Timezone;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\Core\Helper\AbstractData;

/**
 * Class Data
 * @package Mageplaza\AbandonedCart\Helper
 */
class Data extends AbstractData
{
    const CONFIG_MODULE_PATH = 'abandonedcart';

    /**
     * @var string Url Suffig analytics
     */
    protected $urlSuffix = [];

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var Timezone
     */
    protected $timeZone;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     * @param DateTime $date
     * @param Timezone $timeZone
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        DateTime $date,
        Timezone $timeZone
    ) {
        $this->date = $date;
        $this->timeZone = $timeZone;

        parent::__construct($context, $objectManager, $storeManager);
    }

    /**
     * @param null $storeId
     *
     * @return array|mixed
     * @throws \Zend_Serializer_Exception
     */
    public function getEmailConfig($storeId = null)
    {
        $emailConfig = $this->getConfigGeneral('email', $storeId);
        if ($emailConfig) {
            $configs = $this->unserialize($emailConfig);
            foreach ($configs as $configId => $config) {
                if (isset($config['send']) && $config['send']) {
                    $configSeconds = 0;
                    $configTimes = explode(' ', $config['send']);
                    foreach ($configTimes as $configTime) {
                        if (strpos($configTime, 'd') !== false) {
                            $configSeconds += (int)str_replace('d', '', $configTime) * 24 * 60 * 60;
                        } else if (strpos($configTime, 'h') !== false) {
                            $configSeconds += (int)str_replace('h', '', $configTime) * 60 * 60;
                        } else if (strpos($configTime, 'm') !== false) {
                            $configSeconds += (int)str_replace('m', '', $configTime) * 60;
                        }
                    }
                    $configs[$configId]['send'] = $configSeconds;
                    $send[$configId] = $configSeconds;
                }
            }
            array_multisort($send, SORT_ASC, $configs);

            return $configs;
        }

        return [];
    }

    /**
     * @param string $code
     * @param null $storeId
     *
     * @return mixed
     */
    public function getAnalyticsConfig($code = '', $storeId = null)
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->getConfigValue(self::CONFIG_MODULE_PATH . '/analytics' . $code, $storeId);
    }

    /**
     * @param Store $store
     *
     * @return mixed
     */
    public function getUrlSuffix($store)
    {
        $storeId = $store->getId();
        if (!isset($this->urlSuffix[$storeId])) {
            $suffix = ['___store' => $store->getCode()];
            if ($this->getAnalyticsConfig('enabled', $storeId)) {
                if ($source = $this->getAnalyticsConfig('source', $storeId)) {
                    $suffix['utm_source'] = $source;
                }
                if ($medium = $this->getAnalyticsConfig('medium', $storeId)) {
                    $suffix['utm_medium'] = $medium;
                }
                if ($name = $this->getAnalyticsConfig('name', $storeId)) {
                    $suffix['utm_campaign'] = $name;
                }
                if ($term = $this->getAnalyticsConfig('term', $storeId)) {
                    $suffix['utm_term'] = $term;
                }
                if ($content = $this->getAnalyticsConfig('content', $storeId)) {
                    $suffix['utm_content'] = $content;
                }
            }

            $this->urlSuffix[$storeId] = $suffix;
        }

        return $this->urlSuffix[$storeId];
    }

    /**
     * Get Coupon Config
     *
     * @param string $code
     * @param null $storeId
     *
     * @return mixed
     */
    public function getCouponConfig($code = '', $storeId = null)
    {
        $code = ($code !== '') ? '/' . $code : '';

        return $this->getConfigValue(self::CONFIG_MODULE_PATH . '/coupon' . $code, $storeId);
    }

    /**
     * @return \Magento\Store\Model\StoreManagerInterface
     */
    public function getStoreManager()
    {
        return $this->storeManager;
    }

    /**
     * @param null $storeId
     *
     * @return mixed
     */
    public function onlySendToSubscribed($storeId = null)
    {
        return $this->getConfigGeneral('send_subscribed_only', $storeId);
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @param null $dimension
     *
     * @return false|int|string
     */
    public function getRangeNumbers($fromDate, $toDate, $dimension = null)
    {
        $timeZoneFrom = $this->timeZone->date($fromDate);
        $timeZoneTo = $this->timeZone->date($toDate);
        $timeDiff = $timeZoneFrom->diff($timeZoneTo);
        if ($dimension == 'month') {
            $numbers = $timeDiff->m;
            if ($numbers == 0 && $this->date->date('m', $fromDate) != $this->date->date('m', $toDate)) {
                $numbers = 1;
            }
        } else {
            $numbers = $timeDiff->days;
        }

        return $numbers;
    }
}
