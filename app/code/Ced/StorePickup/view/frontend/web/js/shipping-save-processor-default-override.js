
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

/*global define,alert*/
define(
        [
            'ko',
            'Magento_Checkout/js/model/quote',
            'Magento_Checkout/js/model/resource-url-manager',
            'mage/storage',
            'Magento_Checkout/js/model/payment-service',
            'Magento_Checkout/js/model/payment/method-converter',
            'Magento_Checkout/js/model/error-processor',
            'Magento_Checkout/js/model/full-screen-loader',
            'Magento_Checkout/js/action/select-billing-address'
        ],
        function (
                ko,
                quote,
                resourceUrlManager,
                storage,
                paymentService,
                methodConverter,
                errorProcessor,
                fullScreenLoader,
                selectBillingAddressAction
                ) {
            'use strict';

            return {
                saveShippingInformation: function () {
                    var payload;

                    var method = quote.shippingMethod().method_code;
                    if (method =='storepickupshipping') {
                            var pickupdate = jQuery('#calendar_inputField').val();
                            payload = {
                                addressInformation: {
                                    shipping_address: quote.shippingAddress(),
                                    billing_address: quote.billingAddress(),
                                    shipping_method_code: quote.shippingMethod().method_code,
                                    shipping_carrier_code: quote.shippingMethod().carrier_code,
                                    extension_attributes: {
                                        store_pickup_id: jQuery('#carrier-store-list').val(),
                                        store_pickup_date: pickupdate,
                                    }
                                }
                            };

                    }else{

                        if (!quote.billingAddress()) {
                            selectBillingAddressAction(quote.shippingAddress());
                        }
                        
                            payload = {
                            addressInformation: {
                                shipping_address: quote.shippingAddress(),
                                billing_address: quote.billingAddress(),
                                shipping_method_code: quote.shippingMethod().method_code,
                                shipping_carrier_code: quote.shippingMethod().carrier_code,
                                extension_attributes: {
                                    store_pickup_id: '',
                                    store_pickup_date: '',
                                }
                            }
                        };
                    }

                    fullScreenLoader.startLoader();

                    return storage.post(
                        resourceUrlManager.getUrlForSetShippingInformation(quote),
                        JSON.stringify(payload)
                    ).done(
                        function (response) {
                            quote.setTotals(response.totals);
                            paymentService.setPaymentMethods(methodConverter(response.payment_methods));
                            fullScreenLoader.stopLoader();
                        }
                    ).fail(
                        function (response) {
                            errorProcessor.process(response);
                            fullScreenLoader.stopLoader();
                        }
                    );
                }
            };
        }
);
