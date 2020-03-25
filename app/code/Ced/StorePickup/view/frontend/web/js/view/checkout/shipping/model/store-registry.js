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
    [],
    function() {
        "use strict";
        var cache = [];
        return {
            get: function(addressKey) {
                if (cache[addressKey]) {
                    return cache[addressKey];
                }
                return false;
            },
            set: function(addressKey, data) {
                cache[addressKey] = data;
            }
        };
    }
);