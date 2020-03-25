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

namespace Ced\Claro\Sdk;

class Url
{
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

    public static $API_ROOT_URL = "https://api.mercadolibre.com/";
    public static $OAUTH_URL    = "oauth/token";
    public static $AUTH_URL = array(
        "MLA" => "https://auth.mercadolibre.com.ar", // Argentina
        "MLB" => "https://auth.mercadolivre.com.br", // Brasil
        "MCO" => "https://auth.mercadolibre.com.co", // Colombia
        "MCR" => "https://auth.mercadolibre.com.cr", // Costa Rica
        "MEC" => "https://auth.mercadolibre.com.ec", // Ecuador
        "MLC" => "https://auth.mercadolibre.cl",     // Chile
        "MLM" => "https://auth.mercadolibre.com.mx", // Mexico
        "MLU" => "https://auth.mercadolibre.com.uy", // Uruguay
        "MLV" => "https://auth.mercadolibre.com.ve", // Venezuela
        "MPA" => "https://auth.mercadolibre.com.pa", // Panama
        "MPE" => "https://auth.mercadolibre.com.pe", // Peru
        "MPT" => "https://auth.mercadolibre.com.pt", // Prtugal
        "MRD" => "https://auth.mercadolibre.com.do",  // Dominicana
        'MHN' => 'https://auth.mercadolibre.com.hn',  // Honduras
        'MSV' => 'https://auth.mercadolibre.com.sv', // Salvador
        'MPY' => 'https://auth.mercadolibre.com.py', // Paraguay
        'MNI' => 'https://auth.mercadolibre.com.ni', // Nicaragua
        'MGT' => 'https://auth.mercadolibre.com.gt', // Guatemala
        'MBO' => 'https://auth.mercadolibre.com.bo' // Bolivia
    );

    /**
     * Get Authorization Url
     * @param $siteId
     * @param array $params, ['response_type' => 'code', 'client_id' => '1213']
     * @return string
     */
    public static function getAuthUrl($siteId, array $params = array())
    {
        $url = '';
        if (!empty($siteId) && isset(self::$AUTH_URL[strtoupper($siteId)])) {
            $url = self::$AUTH_URL[strtoupper($siteId)]."/authorization?".http_build_query($params);
        }

        return $url;
    }
}
