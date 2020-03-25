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
    [
        'Ced_StorePickup/js/view/checkout/shipping/model/resource-url-manager',
        'Magento_Checkout/js/model/quote',
        'Magento_Customer/js/model/customer',
        'mage/storage',
        'Magento_Checkout/js/model/shipping-service',
        'Ced_StorePickup/js/view/checkout/shipping/model/store-registry',
        'Magento_Checkout/js/model/error-processor'
    ],
    function (resourceUrlManager, quote, customer, storage, shippingService, storeRegistry, errorProcessor) {
        'use strict';

        return {
            /**
             * Get nearest machine list for specified address
             * @param {Object} address
             */
            getStoreList: function (address, form) {
                shippingService.isLoading(true);
                var cacheKey = address.getCacheKey(),
                    cache = storeRegistry.get(cacheKey),
                    serviceUrl = resourceUrlManager.getUrlForStoreList(quote);

                if (cache) {
                    form.setStoreList(cache);
                    shippingService.isLoading(false);
                } else {
                    storage.get(
                        serviceUrl, false
                    ).done(
                        function (result) {
                            storeRegistry.set(cacheKey, result);
                            form.setStoreList(result);
                        }
                    ).fail(
                        function (response) {
                            errorProcessor.process(response);
                        }
                    ).always(
                        function () {
                            shippingService.isLoading(false);
                        }
                    );
                }
            }
        };
    }
);