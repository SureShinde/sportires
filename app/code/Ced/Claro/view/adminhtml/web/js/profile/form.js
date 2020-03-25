define([
    'uiRegistry',
    'Magento_Ui/js/form/form'
], function (uiRegistry, Form) {
    'use strict';
    return Form.extend({
        save: function (redirect, data) {
            this.validate();
            this.collectProducts();

            if (!this.additionalInvalid && !this.source.get('params.invalid')) {
                this.setAdditionalData(data)
                    .submit(redirect);
            } else {
                this.focusInvalid();
            }
        },

        collectProducts: function () {
            window.claro_profile_product_massaction =
                document.getElementById('claro_profile_product_massaction-form');
            if (window.claro_profile_product_massaction) {
                window.claro_profile_product_massaction.parentElement.removeChild(window.claro_profile_product_massaction);
            }

            if (window.claro_profile_product_massactionJsObject) {
                var selectedProducts = uiRegistry.get('index = in_profile_products');
                selectedProducts.value(window.claro_profile_product_massactionJsObject.checkedString);
            }
        },

        collectCategories: function ()
        {
            //TODO: dev
        },

        empty: function (e) {
            switch (e) {
                case "":
                case 0:
                case "0":
                case null:
                case false:
                    return true;
                default:
                    if (typeof e === "undefined") {
                        return true;
                    } else if (typeof e === "object" && Object.keys(e).length === 0) {
                        return true;
                    } else {
                        return false;
                    }
            }
        }
    });
});