
define([
    'jquery',
    'Magestat_FacebookPixel/js/pixel-code'
], function ($) {
    'use strict';

    /**
     * Dispatch checkout success event to Facebook Pixel
     *
     * @param {Object} data - product data
     *
     * @private
     */
    return function (data) {
        // Avoid errors if "fbq" don't exist.
        if (typeof fbq !== 'function') {
            return;
        }

        fbq('track', 'Purchase', {
            value: data.total,
            content_type: 'product',
            content_ids: data.contentIds,
            currency: 'MXN',
            num_items: data.qty
        });
    };
});
