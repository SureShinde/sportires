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
 * @package     Claro-Sdk
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Sdk;

/**
 * Directory separator shorthand
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * @api
 */
interface ApiInterface
{
    /**
     * Default API URLs
     * @TODO: move to \Ced\Claro\Sdk\Url
     */
    const CLARO_API_URL = "https://api.mercadolibre.com/";

    const GET_TOKEN_SUB_URL = 'oauth/token';
    const GET_CURRENCIES_SUB_URL = 'currencies';
    const GET_SITES_SUB_URL = 'sites';
    const GET_LISTING_TYPES_SUB_URL = 'sites/%s/listing_types';
    const GET_ALL_CATEGORIES_SUB_URL = 'sites/%s/categories';
    const GET_CATEGORIES_SUB_URL = 'categories';
    const POST_PRODUCT_VALIDATE_URL = 'items/validate';
    const POST_PRODUCT_UPLOAD_URL = 'items';
    const GET_USER_DETAILS = 'users';

    const GET_ORDERS_SUB_URL = 'orders';
    const GET_MESSAGES_SUB_URL = 'messages';
    const POST_SHIP_SUB_URL = 'shipments';
    const SSL_VERIFY = false;

    const FEED_CODE_ITEM_UPDATE = 'item-update';

    /**
     * Get Request
     * @param $url
     * @param array $params
     * @param bool $withToken
     * @return mixed
     */
    public function get($url, $params = [], $withToken = false);

    /**
     * Put Request
     * @param $url
     * @param array $params
     * @return mixed
     */
    public function put($url, $params = []);

    /**
     * Post Request
     * @param $url
     * @param array $params
     * @return mixed
     */
    public function post($url, $params = []);
}
