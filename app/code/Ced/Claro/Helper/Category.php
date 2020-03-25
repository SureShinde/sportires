<?php

/**
 * CedCommerce
 *package
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

namespace Ced\Claro\Helper;

class Category extends \Magento\Framework\App\Helper\AbstractHelper
{
    const DEFAULT_ATTRIBUTES = [
        'seller_custom_field' => [
            'id' => 'seller_custom_field',
            'name' => 'Seller Custom Field',
            "value_type" => "string",
            'magento_attribute_code' => 'sku',
            'required' => true,
            'tags' => [
                'variation_attribute' => true
            ]
        ],
        'title' => [
            'id' => 'title',
            'name' => 'Title',
            "value_type" => "string",
            'magento_attribute_code' => 'name',
            'required' => true
        ],
        'price' => [
            'id' => 'price',
            'name' => 'Price',
            "value_type" => "number",
            'magento_attribute_code' => 'price',
            'required' => true
        ],
        'description' => [
            'id' => 'description',
            'name' => 'Description',
            "value_type" => "string",
            'magento_attribute_code' => 'description',
            'required' => true
        ],
        // TODO: get from api
        'listing_type_id' => [
            'id' => 'listing_type_id',
            'name' => 'Product Listing Type',
            "value_type" => "list",
            'magento_attribute_code' => 'default_value',
            'default_value' => 'free',
            "values" => [
                [
                   "id" => "free",
                   "name" => "Gratuita"
                ],
                [
                   "id" => "bronze",
                   "name" => "Bronce"
                ],
                [
                   "id" => "silver",
                   "name" => "Plata"
                ],
                [
                   "id" => "gold",
                   "name" => "Oro"
                ],
                [
                   "id" => "gold_special",
                   "name" => "Clásica"
                ],
                [
                   "id" => "gold_premium",
                   "name" => "Oro Premium"
                ],
                [
                   "id" => "gold_pro",
                   "name" => "Premium"
                ],
            ],
            'required' => true
        ],
        'condition' => [
            'id' => 'condition',
            'name' => 'Product Condition',
            "value_type" => "list",
            'magento_attribute_code' => 'default_value',
            'default_value' => 'new',
            "values" => [
                [
                   "id" => "new",
                   "name" => "New"
                ],
                [
                   "id" => "used",
                   "name" => "Used"
                ],
                [
                   "id" => "not_specified",
                   "name" => "Not Specified"
                ],
                [
                   "id" => "refurbished",
                   "name" => "Refurbished"
                ],
            ],
            'required' => true
        ],
        'local_pick_up' => [
            'id' => 'local_pick_up',
            'name' => 'Local Pickup Allowed',
            "value_type" => "boolean",
            'magento_attribute_code' => 'default_value',
            'default_value' => 'true',
            "values" => [
                [
                    "id" => "true",
                    "name" => "Yes"
                ],
                [
                    "id" => "false",
                    "name" => "No"
                ],
            ],
            'required' => true
        ],
        'free_shipping' => [
            'id' => 'free_shipping',
            'name' => 'Free Shipping',
            "value_type" => "boolean",
            'magento_attribute_code' => 'default_value',
            'default_value' => 'false',
            "values" => [
                [
                    "id" => "true",
                    "name" => "Yes"
                ],
                [
                    "id" => "false",
                    "name" => "No"
                ],
            ],
            'required' => true
        ],
        'mode' => [
            'id' => 'mode',
            'name' => 'Shipping Mode',
            "value_type" => "string",
            'magento_attribute_code' => 'default_value',
            'default_value' => 'false',
            "values" => [
                [
                    "id" => "not_specified",
                    "name" => "not_specified"
                ],
                [
                    "id" => "custom",
                    "name" => "custom"
                ],
            ],
            'required' => true
        ],
    ];

    /** @var Sdk  */
    public $sdk;

    /** @var Logger */
    public $logger;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Ced\Claro\Helper\Logger $logger,
        \Ced\Claro\Helper\Sdk $sdk
    ) {
        parent::__construct($context);
        $this->logger = $logger;
        $this->sdk = $sdk;
    }

    public function getChildren($parentId = null)
    {
        $children = [];
        $categories = $this->getList($parentId);
        if (isset($categories['children_categories'])) {
            $children = $categories['children_categories'];
        }
        return $children;
    }

    public static function isDefaultAttribute($id)
    {
        $status = false;
        if (isset(self::DEFAULT_ATTRIBUTES[$id])) {
            $status = true;
        }

        return $status;
    }

    public function getList()
    {
        /** @var \Ced\Claro\Sdk\Product $product */
        $product = $this->sdk->getProduct();
        $categories = [];
        if (!isset($categoryId)) {
            $categories = $product->getSiteCategories();
        }
        return $categories;
    }
    /**
     * Get category-wise attributes
     * @param $categoryName
     * @param $subCategoryName
     * @param array $params
     * @return array
     */
    public function getAttributes($categoryId, $params = [])
    {
        $attributes = [];
        try {
            /** @var \Ced\Claro\Sdk\Product $product */
            $product = $this->sdk->getProduct();
            $response = $product->getAttributes($categoryId);
            if (!empty($response) && is_array($response)) {
                if (isset($params['required'])) {
                    if ($params['required'] == true) {
                        foreach (self::DEFAULT_ATTRIBUTES as $id => &$value) {
                            $value['required'] = true;
                            $attributes[$id] = $value;
                        }

                        foreach ($response as &$value) {
                            if (isset($value['tags']['required']) || isset($value['tags']['catalog_required'])) {
                                $value['required'] = true;
                                $attributes[$value['id']] = $value;
                            }
                        }
                    } else {
                        foreach ($response as $value) {
                            if (!isset($value['tags']['required']) && !isset($value['tags']['catalog_required'])) {
                                $value['required'] = false;
                                $attributes[$value['id']] = $value;
                            }
                        }
                    }
                } else {
                    foreach (self::DEFAULT_ATTRIBUTES as $id => &$value) {
                        $value['required'] = true;
                        $attributes[$id] = $value;
                    }

                    foreach ($response as $value) {
                        if (isset($value['id'])) {
                            $attributes[$value['id']] = $value;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->error(
                $e->getMessage(),
                ['path' => __METHOD__, 'message' => $e->getMessage()]
            );
        }

        return $attributes;
    }
}
