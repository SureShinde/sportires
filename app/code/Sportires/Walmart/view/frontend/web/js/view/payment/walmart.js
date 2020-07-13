define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'walmart',
                component: 'Sportires_Walmart/js/view/payment/method-renderer/walmart-method'
            }
        );
        return Component.extend({});
    }
);