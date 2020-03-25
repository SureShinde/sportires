<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Mpa\Model\Config\Source;


use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Actions
 * @package Yosto\Mpa\Model\Config\Source
 */
class Actions implements OptionSourceInterface
{
    const UPDATE_CATEGORY = 0;
    const CHANGE_PRICE = 1;
    const UPDATE_RELATED_PRODUCTS = 2;
    const UPDATE_UPSELL_PRODUCTS = 3;
    const UPDATE_CROSSSELL_PRODUCTS = 4;
    const COPY_CUSTOM_OPTIONS = 5;
    const MANAGE_STOCK = 6;
    const UPDATE_TEXT = 7;
    const CHANGE_ATTRIBUTE_SET = 8;
    const UPDATE_CATEGORY_TYPE = "yosto_mpa_update_category";
    const CHANGE_PRICE_TYPE = "yosto_mpa_change_price";
    const UPDATE_RELATED_PRODUCTS_TYPE = "yosto_mpa_update_related_products";
    const UPDATE_UPSELL_PRODUCTS_TYPE = "yosto_mpa_update_upsell_products";
    const UPDATE_CROSSSELL_PRODUCTS_TYPE = "yosto_mpa_update_crosssell_products";
    const COPY_CUSTOM_OPTIONS_TYPE = "yosto_mpa_copy_custom_options";
    const MANAGE_STOCK_TYPE = "yosto_mpa_manage_stock";
    const UPDATE_TEXT_TYPE = "yosto_mpa_update_text";
    const CHANGE_ATTRIBUTE_SET_TYPE = "yosto_mpa_change_attribute_set";
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('Update Category'), 'value' => self::UPDATE_CATEGORY],
            ['label' => __('Change Price'), 'value' => self::CHANGE_PRICE],
            ['label' => __('Update Related Products'), 'value' => self::UPDATE_RELATED_PRODUCTS],
            ['label' => __('Update Upsell Products'), 'value' => self::UPDATE_UPSELL_PRODUCTS],
            ['label' => __('Update Crosssell Products'), 'value' => self::UPDATE_CROSSSELL_PRODUCTS],
            ['label' => __('Copy Custom Options'), 'value' => self::COPY_CUSTOM_OPTIONS],
            ['label' => __('Manage Stock'), 'value' => self::MANAGE_STOCK],
            ['label' => __('Update Text'), 'value' => self::UPDATE_TEXT],
            ['label' => __('Change Attribute Set'), 'value' => self::CHANGE_ATTRIBUTE_SET]
        ];
    }

    /**
     * @return array
     */
    public function mapActionTypes()
    {
        return [
            self::UPDATE_CATEGORY => self::UPDATE_CATEGORY_TYPE,
            self::CHANGE_PRICE => self::CHANGE_PRICE_TYPE,
            self::UPDATE_RELATED_PRODUCTS => self::UPDATE_RELATED_PRODUCTS_TYPE,
            self::UPDATE_UPSELL_PRODUCTS => self::UPDATE_UPSELL_PRODUCTS_TYPE,
            self::UPDATE_CROSSSELL_PRODUCTS => self::UPDATE_CROSSSELL_PRODUCTS_TYPE,
            self::COPY_CUSTOM_OPTIONS => self::COPY_CUSTOM_OPTIONS_TYPE,
            self::MANAGE_STOCK => self::MANAGE_STOCK_TYPE,
            self::UPDATE_TEXT => self::UPDATE_TEXT_TYPE,
            self::CHANGE_ATTRIBUTE_SET => self::CHANGE_ATTRIBUTE_SET_TYPE
        ];
    }

}