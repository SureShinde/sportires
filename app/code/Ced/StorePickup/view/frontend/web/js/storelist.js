/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://cedcommerce.com/license-agreement.txt
 *
 * @category  Ced
 * @package   Ced_StorePickup
 * @author    CedCommerce Core Team <connect@cedcommerce.com >
 * @copyright Copyright CEDCOMMERCE (https://cedcommerce.com/)
 * @license      https://cedcommerce.com/license-agreement.txt
 */
define(
    'js/theme', [
    'jquery',
    'domReady!'
    ], function ($) {
        'use strict';
        console.log('js is working');
    }
);

function showSeachForm()
{
    jQuery('.search_form').show();
    jQuery('.search_form_overlay').show();
}

function closeSearch()
{
    jQuery('.search_form').hide();
    jQuery('.search_form_overlay').hide();
}
