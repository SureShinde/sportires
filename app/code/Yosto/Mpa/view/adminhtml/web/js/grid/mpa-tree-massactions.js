/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */
define([
        'jquery',
        'mageUtils',
        'underscore',
        'mage/translate',
        'jquery/ui',
        'Magento_Ui/js/modal/modal'
    ],
    function (
        $,
        utils,
        _,
        $t
    ) {
    'use strict';

    var mixin = {
        submitData: function (action, data) {
            var itemsType = data.excludeMode ? 'excluded' : 'selected',
                selections = {};

            selections[itemsType] = data[itemsType];

            if (!selections[itemsType].length) {
                selections[itemsType] = false;
            }

            _.extend(selections, data.params || {});

            utils.submit({
                url: action.url,
                data: selections
            });
        },
        assignCategory: function (action, data) {
            this.showAssignCategoryModal(action, data);
        },
        showAssignCategoryModal: function (action,data) {
            var self = this;
            $('#yosto-mpa-handle-category').modal({
                wrapperClass: 'yosto-mpa-modal',
                responsive: true,
                innerScroll: true,
                title: $t('Update Category'),
                buttons: [],
                opened: function() {
                    $('#assign-categories-list-chooser').on('click', function () {
                       self.selectCategories('#assign-categories-list')
                    });
                    $('#remove-categories-list-chooser').on('click', function () {
                        self.selectCategories('#remove-categories-list')
                    });
                    $('#new-category-chooser').on('click', function () {
                        self.selectCategory('#new-category')
                    });

                    $('#current-category-chooser').on('click', function () {
                        self.selectCategory('#current-category')
                    });

                    $('#massaction-category-btn').on('click', function () {
                        if (!self.validateCategoryForm()) {
                            return false;
                        }
                        action.url = $('#massaction-category-submit-url').val();
                        data.params.assign_categories = $('#assign-categories-list').val();
                        data.params.remove_categories = $('#remove-categories-list').val();
                        data.params.current_category = $('#current-category').val();
                        data.params.new_category = $('#new-category').val();
                        self.submitData(action, data);
                    })
                },
                closed: function () {

                }
            }).trigger('openModal');
        },
        selectCategories: function (inputElement) {
            $('#multiselect-category-popup').modal({
                wrapperClass: 'yosto-mpa-modal-slide',
                responsive: true,
                innerScroll: true,
                type: 'slide',
                title: $t('Select Categories'),
                buttons: [{
                    text: 'Save',
                    class: '',
                    click: function() {
                        this.closeModal();
                    }
                }],
                opened: function () {
                    var existingValues = $(inputElement).val();
                    $("#select-categories option:selected").removeAttr('selected');
                    if (existingValues) {
                        $.each(existingValues.split(","), function(i,e){
                            $("#select-categories option[value='" + e + "']").prop("selected", true);
                        });
                    }
                },
                closed: function () {
                    var categories = [];
                    $.each($("#select-categories option:selected"), function(){
                        categories.push($(this).val());
                    });
                    if (categories.length > 0) {
                        $(inputElement).val(categories.join(","));
                    }
                }
            }).trigger('openModal');
        },
        selectCategory: function (inputElement) {
            $('#select-category-popup').modal({
                wrapperClass: 'yosto-mpa-modal-slide',
                responsive: true,
                innerScroll: true,
                type: 'slide',
                title: $t('Select Category'),
                buttons: [{
                    text: 'Save',
                    class: '',
                    click: function() {
                        this.closeModal();
                    }
                }],
                opened: function () {
                    var existingValue = $(inputElement).val();
                    if (existingValue) {
                        $("#select-category").val(existingValue);
                    } else {
                        $("#select-category").val(null);
                    }
                },
                closed: function () {

                    $(inputElement).val($("#select-category").val());

                }
            }).trigger('openModal');
        },
        changePrice: function (action, data) {
            this.showPriceModal(action, data);
        },
        showPriceModal: function (action, data) {
            var self = this;
            $('#yosto-mpa-handle-price').modal({
                wrapperClass: 'yosto-mpa-modal',
                responsive: true,
                innerScroll: true,
                title: $t('Change Price'),
                buttons: [],
                opened: function() {
                    $('#massaction-price-btn').on('click', function () {
                        if (!self.validatePriceForm()) {
                            return false;
                        }
                        action.url = $('#massaction-price-submit-url').val();
                        data.params.modify_price = $('#modify-price').val();
                        data.params.modify_special_price = $('#modify-special-price').val();
                        data.params.modify_cost = $('#modify-cost').val();

                        self.submitData(action, data);
                    })
                },
                closed: function () {

                }
            }).trigger('openModal');
        },
        updateRelatedProducts: function (action, data) {
            this.showRelatedProductsModal(action, data);
        },
        showRelatedProductsModal: function (action, data) {
            var self = this;
            $('#yosto-mpa-handle-related-products').modal({
                wrapperClass: 'yosto-mpa-modal',
                responsive: true,
                innerScroll: true,
                title: $t('Update Related Products'),
                buttons: [],
                opened: function() {
                    $('#massaction-related-products-btn').on('click', function () {
                        if (!self.validateLinkedProductsForm(
                                "#add-related-products",
                                "#add-related-products-error",
                                "#remove-related-products",
                                "#remove-related-products-error"
                            )) {
                            return false;
                        }
                        action.url = $('#massaction-related-products-submit-url').val();
                        data.params.add_related_products = $('#add-related-products').val();
                        data.params.remove_related_products = $('#remove-related-products').val();

                        self.submitData(action, data);
                    })
                },
                closed: function () {

                }
            }).trigger('openModal');
        },
        updateUpsellProducts: function (action, data) {
            this.showUpsellProductsModal(action, data);
        },
        showUpsellProductsModal: function (action, data) {
            var self = this;
            $('#yosto-mpa-handle-upsell-products').modal({
                wrapperClass: 'yosto-mpa-modal',
                responsive: true,
                innerScroll: true,
                title: $t('Update Upsell Products'),
                buttons: [],
                opened: function() {
                    $('#massaction-upsell-products-btn').on('click', function () {
                        if (!self.validateLinkedProductsForm(
                                "#add-upsell-products",
                                "#add-upsell-products-error",
                                "#remove-upsell-products",
                                "#remove-upsell-products-error"
                            )) {
                            return false;
                        }
                        action.url = $('#massaction-upsell-products-submit-url').val();
                        data.params.add_upsell_products = $('#add-upsell-products').val();
                        data.params.remove_upsell_products = $('#remove-upsell-products').val();
                        self.submitData(action, data);
                    })
                },
                closed: function () {

                }
            }).trigger('openModal');
        },
        updateCrosssellProducts: function (action, data) {
            this.showCrosssellProductModal(action, data);
        },
        showCrosssellProductModal: function (action, data) {
            var self = this;
            $('#yosto-mpa-handle-crosssell-products').modal({
                wrapperClass: 'yosto-mpa-modal',
                responsive: true,
                innerScroll: true,
                title: $t('Update Crosssell Products'),
                buttons: [],
                opened: function() {
                    $('#massaction-crosssell-products-btn').on('click', function () {
                        if (!self.validateLinkedProductsForm(
                                "#add-crosssell-products",
                                "#add-crosssell-products-error",
                                "#remove-crosssell-products",
                                "#remove-crosssell-products-error"
                            )) {
                            return false;
                        }
                        action.url = $('#massaction-crosssell-products-submit-url').val();
                        data.params.add_crosssell_products = $('#add-crosssell-products').val();
                        data.params.remove_crosssell_products = $('#remove-crosssell-products').val();

                        self.submitData(action, data);
                    })
                },
                closed: function () {

                }
            }).trigger('openModal');
        },
        copyCustomOptions: function (action, data) {
            this.showCopyOptionsModal(action, data);
        },
        showCopyOptionsModal: function (action, data) {
            var self = this;
            $('#yosto-mpa-handle-copy-custom-options').modal({
                wrapperClass: 'yosto-mpa-modal',
                responsive: true,
                innerScroll: true,
                title: $t('Copy Custom Options'),
                buttons: [],
                opened: function() {
                    $('#massaction-copy-custom-options-btn').on('click', function () {
                        if (!self.validateCustomOptionsForm()) {
                            return false;
                        }
                        action.url = $('#massaction-copy-custom-options-submit-url').val();
                        data.params.copy_custom_options = $('#copy-custom-options').val();
                        self.submitData(action, data);
                    })
                },
                closed: function () {

                }
            }).trigger('openModal');
        },
        manageStock: function (action, data) {
            this.showManageStockModal(action, data);
        },
        showManageStockModal: function (action, data) {
            var self = this;
            $('#yosto-mpa-handle-stock').modal({
                wrapperClass: 'yosto-mpa-modal',
                responsive: true,
                innerScroll: true,
                title: $t('Manage Stock'),
                buttons: [],
                opened: function() {
                    $('#massaction-stock-btn').on('click', function () {
                        if (!self.validateManageStockForm()) {
                            return false;
                        }
                        action.url = $('#massaction-stock-submit-url').val();
                        data.params.quantity = $('#quantity').val();
                        data.params.stock_status = $('#stock-status').val();
                        data.params.manage_stock = $('#manage-stock').val();
                        data.params.stock_threshold = $('#stock-threshold').val();
                        data.params.use_config_settings_for_threshold = $("#use-config-settings-for-threshold").val();
                        self.submitData(action, data);
                    })
                },
                closed: function () {

                }
            }).trigger('openModal');
        },
        updateText: function (action, data) {
            this.showUpdateTextModal(action, data);
        },
        showUpdateTextModal: function (action, data) {
            var self = this;
            $('#yosto-mpa-handle-text').modal({
                wrapperClass: 'yosto-mpa-modal',
                responsive: true,
                innerScroll: true,
                title: $t('Update Text'),
                buttons: [],
                opened: function() {
                    $("#text-action").on('change', function () {
                       var textAction = $(this).val();
                       if (textAction == 1) {
                           $(".is-show-if-replace").fadeIn();
                           $(".is-show-if-append").hide();
                       } else {
                           $(".is-show-if-replace").hide();
                           $(".is-show-if-append").fadeIn();
                       }
                    });

                    $('#massaction-text-btn').on('click', function () {
                        // if (!self.validateUpdateTextForm()) {
                        //     return false;
                        // }
                        action.url = $('#massaction-text-submit-url').val();
                        data.params.attribute_code = $('#attribute-code').val();
                        data.params.text_action = $('#text-action').val();
                        data.params.old_text = $('#old-text').val();
                        data.params.new_text = $('#new-text').val();
                        data.params.append_text = $("#append-text").val();
                        data.params.append_position = $("#append-position").val();
                        data.params.store = $('#text-store').val();
                        self.submitData(action, data);
                    })
                },
                closed: function () {

                }
            }).trigger('openModal');
        },
        changeAttributeSet: function (action, data) {
            this.showChangeAttributeSetModal(action, data);
        },
        showChangeAttributeSetModal: function (action, data) {
            var self = this;
            $('#yosto-mpa-handle-attribute-set').modal({
                wrapperClass: 'yosto-mpa-modal',
                responsive: true,
                innerScroll: true,
                title: $t('Change Attribute Set'),
                buttons: [],
                opened: function() {

                    $('#massaction-attribute-set-btn').on('click', function () {
                        if (!self.validateChangeAttributeSetForm()) {
                            return false;
                        }
                        action.url = $('#massaction-attribute-set-submit-url').val();
                        data.params.attribute_set = $('#attribute-set').val();
                        self.submitData(action, data);
                    })
                },
                closed: function () {

                }
            }).trigger('openModal');
        },
        /** Validate **/
        validateCategoryForm: function () {
            var assignCategoryValues = $('#assign-categories-list').val();
            var removeCategoryValues = $('#remove-categories-list').val();
            var currentCategoryValue = $('#current-category').val();
            var newCategoryValue = $('#new-category').val();
            if (assignCategoryValues == "" && removeCategoryValues == "" && currentCategoryValue == "" && newCategoryValue == "") {
                $('#assign-categories-list-error').fadeOut();
                $('#remove-categories-list-error').fadeOut();
                $('#current-category-error').fadeOut();
                $('#new-category-error').fadeOut();
                return false;
            }
            var pat = /^(\d+,)*\d+$/;
            if (assignCategoryValues != "") {
                if (!pat.test(assignCategoryValues)) {
                    $('#assign-categories-list-error').html($t("Invalid data, e.g. 10,20,30 or 10")).fadeIn();
                    return false;
                } else {
                    $('#assign-categories-list-error').fadeOut();
                }
            } else {
                $('#assign-categories-list-error').fadeOut();
            }
            if (removeCategoryValues != "") {
                if (!pat.test(removeCategoryValues)) {
                    $('#remove-categories-list-error').html($t("Invalid data, e.g. 10,20,30 or 10")).fadeIn();
                    return false;
                } else {
                    $('#remove-categories-list-error').fadeOut();
                }
            } else {
                $('#remove-categories-list-error').fadeOut();
            }

            if (currentCategoryValue != "") {
                if (newCategoryValue == "") {
                    $('#current-category-error').html($t("Please enter new category")).fadeIn();
                    return false;
                }
                if (!/^\d+$/.test(currentCategoryValue)) {
                    $('#current-category-error').html($t("Invalid data, e.g. 10")).fadeIn();
                    return false;
                } else {
                    $('#current-category-error').fadeOut();
                }
            } else {
                $('#current-category-error').fadeOut();
            }
            if (newCategoryValue != "") {
                if (currentCategoryValue == "") {
                    $('#new-category-error').html($t("Please enter old category")).fadeIn();
                    return false;
                }
                if (!/^\d+$/.test(newCategoryValue)) {
                    $('#new-category-error').html($t("Invalid data, e.g. 20")).fadeIn();
                    return false;
                } else {
                    $('#new-category-error').fadeOut();
                }
            } else {
                $('#new-category-error').fadeOut();
            }
            return true;
        },
        validatePriceForm: function () {
            var modifyPrice = $('#modify-price').val();
            var modifySpecialPrice = $('#modify-special-price').val();
            var modifyCost = $('#modify-cost').val();
            if (modifyPrice == "" && modifySpecialPrice == "" && modifyCost == "") {
                $('#modify-price-error').fadeOut();
                $('#modify-special-price-error').fadeOut();
                $('#modify-cost-error').fadeOut();
                return false;
            }

            var pat = /^[\+\-]?[1-9]\d*(\.\d+)?%?$/;
            var patspecialprice = /^[\+\-]?[1-9]\d*(\.\d+)?%?(pp)?$/
            if (modifyPrice != "") {
                if (!pat.test(modifyPrice)) {
                    $('#modify-price-error').html($t("Invalid data, e.g. +10,-10,+10%,-10% or 10")).fadeIn();
                    return false;
                } else {
                    $('#modify-price-error').fadeOut();
                }
            } else {
                $('#modify-price-error').fadeOut();
            }

            if (modifySpecialPrice != "") {
                if (!patspecialprice.test(modifySpecialPrice)) {
                    $('#modify-special-price-error').html($t("Invalid data, e.g. +10,-10,+10%,-10%, 10 or -10%pp, -10pp")).fadeIn();
                    return false;
                } else {
                    $('#modify-special-price-error').fadeOut();
                }
            } else {
                $('#modify-special-price-error').fadeOut();
            }
            if (modifyCost != "") {
                if (!pat.test(modifyCost)) {
                    $('#modify-cost-error').html($t("Invalid data, e.g. +10,-10,+10%,-10% or 10")).fadeIn();
                    return false;
                } else {
                    $('#modify-cost-error').fadeOut();
                }
            } else {
                $('#modify-cost-error').fadeOut();
            }
            return true;
        },
        validateLinkedProductsForm: function (addElement, addElementError, removeElement, removeElementError) {
            var addLikedProducts = $(addElement).val();
            var removeLinkedProducts = $(removeElement).val();
            if (addLikedProducts == "" && removeLinkedProducts == "") {
                $(addElementError).fadeOut();
                $(removeElementError).fadeOut();
                return false;
            }
            var pat = /^(\d+,)*\d+$/;
            if (addLikedProducts != "") {

                if (!pat.test(addLikedProducts)) {
                    $(addElementError).html($t("Invalid data, e.g. 10,20,30 or 10")).fadeIn();
                    return false;
                } else {
                    $(addElementError).fadeOut();
                }
            } else {
                $(addElementError).fadeOut();
            }

            if (removeLinkedProducts != "") {

                if (!pat.test(removeLinkedProducts)) {
                    $(removeElementError).html($t("Invalid data, e.g. 10,20,30 or 10")).fadeIn();
                    return false;
                } else {
                    $(removeElementError).fadeOut();
                }
            } else {
                $(removeElementError).fadeOut();
            }

            return true;    
        },
        validateCustomOptionsForm: function () {
            var copyFromProducts = $('#copy-custom-options').val();
            if (copyFromProducts == "") {
                $('#copy-custom-options-error').fadeOut();
                return false;
            }
            var pat = /^(\d+,)*\d+$/;
            if (!pat.test(copyFromProducts)) {
                $('#copy-custom-options-error').html($t("Invalid data, e.g. 10,20,30 or 10")).fadeIn();
                return false;
            } else {
                $('#copy-custom-options-error').fadeOut();
            }
            return true;
        },
        validateManageStockForm: function () {
            var quantity = $("#quantity").val();
            var stockStatus = $("#stock-status").val();
            var manageStock = $("#manage-stock").val();
            var stockThreshold = $("#stock-threshold").val();
            var useSystemConfigForThreshold = $("#use-config-settings-for-threshold").val();

            if (quantity == "" && stockStatus == "" && manageStock == "" && stockThreshold == "" && useSystemConfigForThreshold == "") {
                $('#quantity-error').fadeOut();
                $('#stock-threshold-error').fadeOut();
                return false;
            }
            var pat = /^\d+$/;
            if (quantity != "") {
                if (!pat.test(quantity)) {
                    $('#quantity-error').html($t("Invalid data,input must be a number")).fadeIn();
                    return false;
                } else {
                    $('#quantity-error').fadeOut();
                }
            } else {
                $('#quantity-error').fadeOut();
            }
            if (stockThreshold != "") {
                if (!pat.test(stockThreshold)) {
                    $('#stock-threshold-error').html($t("Invalid data,input must be a number")).fadeIn();
                    return false;
                } else {
                    $('#stock-threshold-error').fadeOut();
                }
            } else {
                $('#stock-threshold-error').fadeOut();
            }
            return true;
        },
        validateUpdateTextForm: function () {
            var textAction = $("#text-action").val();
            var oldText = $('#old-text').val();
            var newText = $('#new-text').val();
            var appendText = $('#append-text').val();
            var pat = /^(\w+\_*\-*\s*)+$/;
            if (textAction == 1) {
                if (oldText == "" && newText == "") {
                    $("#old-text-error").fadeOut();
                    $("#new-text-error").fadeOut();
                    return false;
                }
                if (newText != "" && oldText == "") {

                    $("#old-text-error").html($t("Old text is required")).fadeIn();
                    return false;
                }
                if (oldText != "") {
                    if (!pat.test(oldText)) {
                        $("#old-text-error").html($t('Invalid data, input contains word, digit, -, _ only')).fadeIn();
                        return false;
                    } else {
                        $("#old-text-error").fadeOut();
                    }
                } else {
                    $("#old-text-error").fadeOut();
                }
                if (newText != "") {
                    if (!pat.test(newText)) {
                        $("#new-text-error").html($t('Invalid data, input contains word, digit, -, _ only')).fadeIn();
                        return false;
                    } else {
                        $("#new-text-error").fadeOut();
                    }
                } else {
                    $("#new-text-error").fadeOut();
                }

            } else {
                if (appendText == "") {
                    return false;
                } else {

                    if (!pat.test(appendText)) {
                        $("#append-text-error").html($t('Invalid data, input contains word, digit, -, _ only')).fadeIn();
                        return false;
                    } else {
                        $("#append-text-error").fadeOut();
                    }

                }
            }
            return true;
        },
        validateChangeAttributeSetForm: function () {
            var attributeSet = $("#attribute-set").val();
            if (attributeSet == "") {
                return false;
            }
            return true;
        }
    };

    return function (target) {
        return target.extend(mixin);
    };
});