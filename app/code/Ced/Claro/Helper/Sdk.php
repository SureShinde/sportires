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
 * @category    Ced
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Helper;

/**
 * Directory separator shorthand
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

use Magento\Framework\App\Helper\Context;

class Sdk extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    public $dl;

    /**
     * @var string
     */
    public $accessToken;

    /**
     * @var $selectedStore
     */
    public $selectedStore = 0;

    /**
     * Debug Log Mode
     * @var boolean
     */
    public $debugMode = true;

    /**
     * @var \Ced\Claro\Sdk\ProductFactory
     */
    public $product;

    /**
     * @var \Ced\Claro\Sdk\OrderFactory
     */
    public $order;

    /** @var Config  */
    public $config;

    /** @var \Ced\Claro\Helper\Logger */
    public $logger;

    /** @var \Ced\Claro\Sdk\ApiFactory  */
    public $api;

    public $baseDirectory = null;

    /**
     * Sdk constructor.
     * @param Context $context
     * @param \Magento\Framework\Filesystem\DirectoryList $directoryList
     * @param \Ced\Claro\Helper\Logger $logger
     * @param Config $config
     * @param \Ced\Claro\Sdk\ProductFactory $product
     * @param \Ced\Claro\Sdk\OrderFactory $order
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Ced\Claro\Helper\Logger $logger,
        \Ced\Claro\Helper\Config $config,
        \Ced\Claro\Sdk\ProductFactory $product,
        \Ced\Claro\Sdk\OrderFactory $order,
        \Ced\Claro\Sdk\ApiFactory $api
    ) {
        parent::__construct($context);
        $this->dl = $directoryList;

        $this->logger = $logger;
        $this->config = $config;

        $this->api = $api;
        $this->product = $product;
        $this->order = $order;
    }

    /**
     * Get Base directory for storing api response files
     * @return null|string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getBaseDirectory()
    {
        if (!isset($this->baseDirectory)) {
            $this->baseDirectory = $this->dl->getPath('var') . DS . 'claro';
        }
        
        return $this->baseDirectory;
    }

    /**
     * Generate access token and save after authorization
     * @param $code
     * @return bool
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function install($code)
    {
        $status = false;
        /** @var \Ced\Claro\Sdk\Api $api */
        $api = $this->api->create(
            [
                'apiAccessToken' => '',
                'apiUrl' => \Ced\Claro\Sdk\Api::CLARO_API_URL,
                'baseDirectory' => $this->getBaseDirectory(),
                'debugMode' => $this->config->getDebug(),
                'logger' => $this->logger
            ]
        );
        $params = [
            'client_id'=> $this->config->getAppId(),
            'client_secret'=> $this->config->getSecretKey(),
            'code'=> trim((string)$code),
            'grant_type'=>'authorization_code',
            'redirect_uri'=> $this->config->getRedirectUri()
        ];
        $response = $api->getToken($params);
        if (isset($response['success'], $response['message']) && $response['success'] == true) {
            $status = true;
            $token = $response['message'];
            $currentDateTime = date("Y-m-d H:i:s", strtotime("+6 hours"));
            $tokenCreatedAt = strtotime($currentDateTime);
            $this->config->setAccessToken($token['access_token']);
            $this->config->setRefreshToken($token['refresh_token']);
            $this->config->setTokenExpiry($tokenCreatedAt);
            $this->config->setValid(true);

            $api->apiAccessToken = $token['access_token'];
            $user = $api->getUser(true);
            if (isset($user['id'])) {
                $this->config->setSellerId($user['id']);

                $name = isset($user['first_name']) ? $user['first_name'] : '';
                $name .= isset($user['last_name']) ? $user['last_name'] : '';
                $this->config->setSellerName($name);

                $address = isset($user['address']) ? $user['address'] : [];
                $this->config->setSellerAddress(json_encode($address));

                $phone = isset($user['phone']) ? implode(' ', array_values($user['phone'])) : '';
                $this->config->setSellerPhone($phone);

                $countryId = isset($user['country_id']) ? $user['country_id'] : 'MX';
                $this->config->setSellerCountryId($countryId);

                $email = isset($user['email']) ? $user['email'] : 'MX';
                $this->config->setSellerEmail($email);
            }
        } else {
            $this->logger->error(
                'App installation failed. Unable to get the token.',
                ['path' => __METHOD__, 'response' => $response]
            );
            //$this->config->setValid(false);
        }

        return $status;
    }

    /**
     * Get valid access token, refresh if expired.
     * @return mixed|null
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getAccessToken()
    {
        $token = null;
        $expiry = $this->config->getTokenExpiry();
        $now = strtotime('now');
        if (!empty($expiry) && $expiry > $now) {
            $token = $this->config->getAccessToken();
        } else {
            /** @var \Ced\Claro\Sdk\Api $api */
            $api = $this->api->create(
                [
                    'apiAccessToken' => '',
                    'apiUrl' => \Ced\Claro\Sdk\Api::CLARO_API_URL,
                    'baseDirectory' => $this->getBaseDirectory(),
                    'debugMode' => $this->config->getDebug(),
                    'logger' => $this->logger
                ]
            );
            $params = [
                'client_id'=> $this->config->getAppId(),
                'client_secret'=> $this->config->getSecretKey(),
                'refresh_token' => $this->config->getRefreshToken(),
                'grant_type'=>'refresh_token',
            ];
            $response = $api->refreshToken($params);
            if (isset($response['success'], $response['message']['access_token']) &&
                $response['success'] == true) {
                $data = $response['message'];
                $currentDateTime = date("Y-m-d H:i:s", strtotime("+6 hours"));
                $tokenCreatedAt = strtotime($currentDateTime);
                $token = $data['access_token'];
                $this->config->setAccessToken($data['access_token']);
                $this->config->setRefreshToken($data['refresh_token']);
                $this->config->setTokenExpiry($tokenCreatedAt);
            } else {
                $this->logger->error(
                    'Unable to get the refresh token.',
                    ['path' => __METHOD__, 'response' => $response]
                );
            }
        }

        return $token;
    }

    /**
     * Get Order Api
     * @return \Ced\Claro\Sdk\Order
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getOrder()
    {
        return $this->order->create(
            [
                'apiAccessToken' => $this->getAccessToken(),
                'apiUrl' => \Ced\Claro\Sdk\Api::CLARO_API_URL,
                'baseDirectory' => $this->getBaseDirectory(),
                'debugMode' => $this->config->getDebug(),
                'logger' => $this->logger
            ]
        );
    }

    /**
     * Get Product Api
     * @return \Ced\Claro\Sdk\Product
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function getProduct()
    {
        return $this->product->create(
            [
                'apiAccessToken' => $this->getAccessToken(),
                'apiUrl' => \Ced\Claro\Sdk\Api::CLARO_API_URL,
                'baseDirectory' => $this->getBaseDirectory(),
                'debugMode' => $this->config->getDebug(),
                'logger' => $this->logger
            ]
        );
    }
}
