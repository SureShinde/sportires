<?php

/**
 * CedCommerce
 *
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

namespace Ced\Claro\Controller\Adminhtml\Profile;

use Magento\Backend\App\Action;

/**
 * Class Base
 * @package Ced\Claro\Controller\Adminhtml\Profile
 */
abstract class Base extends Action
{
    const COLUMN_CATEGORY_LEVEL_ROOT = 'category_level_0';

    const COLUMN_REQUIRED = [
        self::COLUMN_CATEGORY_LEVEL_ROOT,
        \Ced\Claro\Model\Profile::COLUMN_STATUS,
        \Ced\Claro\Model\Profile::COLUMN_CATEGORY,
    ];
    const PROFILE_ATTRIBUTES = "claro_attributes";

    /** @var \Magento\Ui\Component\MassAction\Filter */
    public $filter;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    public $catalog;

    /** @var \Ced\Claro\Model\Profile\Product */
    public $product;

    /**
     * @var \Ced\Claro\Model\Profile
     */
    public $profile;

    /** @var \Ced\Claro\Repository\Profile $resource*/
    public $resource;

    /** @var \Ced\Claro\Helper\Config */
    public $config;

    /** @var \Ced\Claro\Helper\Category  */
    public $category;

    /** @var \Magento\Framework\DataObject */
    public $data;

    /** @var \Magento\Framework\DataObject */
    public $validation;

    /**
     * Base constructor.
     * @param Action\Context $context
     * @param \Magento\Framework\DataObjectFactory $data
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $catalogCollection
     * @param \Ced\Claro\Model\Profile\Product $product
     * @param \Ced\Claro\Repository\Profile $resource,
     * @param \Ced\Claro\Model\Profile $profile
     * @param \Ced\Claro\Helper\Config $config
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\DataObjectFactory $data,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $catalogCollection,
        \Ced\Claro\Model\Profile\Product $product,
        \Ced\Claro\Repository\Profile $resource,
        \Ced\Claro\Model\Profile $profile,
        \Ced\Claro\Helper\Category $category,
        \Ced\Claro\Helper\Config $config
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->catalog = $catalogCollection;
        $this->config = $config;
        $this->category = $category;

        $this->resource = $resource;
        $this->profile = $profile;

        $this->product = $product;
        $this->data = $data->create();
        $this->validation = $data->create();
    }

    /**
     * Validating post profile data.
     * @return bool
     */
    public function validate($setErrors = false)
    {
        $status = $this->getRequest()->getParam(\Ced\Claro\Model\Profile::COLUMN_STATUS, '0');
        $status = ($status === 'true' || $status == '1') ? 1 : 0;
        $this->data->setData(
            \Ced\Claro\Model\Profile::COLUMN_STATUS,
            $status
        );

        $this->data->setData(
            \Ced\Claro\Model\Profile::COLUMN_NAME,
            $this->getRequest()->getParam(\Ced\Claro\Model\Profile::COLUMN_NAME)
        );

        $id = $this->getRequest()->getParam(\Ced\Claro\Model\Profile::COLUMN_ID);
        if (!empty($id)) {
            $this->data->setData(\Ced\Claro\Model\Profile::COLUMN_ID, $id);
        }

        $methods = $this->getRequest()->getParam('claro_shipping');
        if (!empty($methods)) {
            $this->data->setData(\Ced\Claro\Model\Profile::COLUMN_SHIPPING_METHODS, $methods);
        }

        $id = $this->getRequest()->getParam(self::COLUMN_CATEGORY_LEVEL_ROOT);
        if (!empty($id)) {
            $this->data->setData(self::COLUMN_CATEGORY_LEVEL_ROOT, $id);
        }

        $this->processCategory();

        $messages = [];
        $valid = true;
        // Validating required values
        foreach (self::COLUMN_REQUIRED as $column) {
            if (empty($this->data->getData($column))) {
                $valid = false;
                $error = "Invalid data provided: {$column}.";
                if ($setErrors == false) {
                    $this->messageManager->addErrorMessage($error);
                } else {
                    $messages[] = $error;
                }
            }
        }

        $this->validation->setData('messages', $messages);

        return $valid;
    }

    public function processCategory()
    {
        $categories = [];
        $params = $this->getRequest()->getParams();
        foreach ($params as $key => $value) {
            if (strpos($key, 'category_level_') !== false && !empty($value)) {
                $categories[$key] = $value;
            }
        }

        if (!empty($categories)) {
            $this->data->setData(\Ced\Claro\Model\Profile::COLUMN_CATEGORY, json_encode($categories));
        }
    }

    /**
     * Add attribute mapping
     */
    public function addAttributes()
    {
        $attributes = $this->getRequest()->getParam(self::PROFILE_ATTRIBUTES);
        if (!empty($attributes) && is_array($attributes)) {
            $attributes = $this->merge($attributes, 'id');
            $requiredAttributes = $optionalAttributes = [];
            foreach ($attributes as $attributeId => $attribute) {
                if (isset($attribute['required']) && $attribute['required'] == 1) {
                    $requiredAttributes[$attributeId] = $attribute;
                } else {
                    $optionalAttributes[$attributeId] = $attribute;
                    $optionalAttributes[$attributeId]['required'] = 0;
                }
            }

            $this->data->setData(
                \Ced\Claro\Model\Profile::COLUMN_REQUIRED_ATTRIBUTES,
                $requiredAttributes
            );

            $this->data->setData(
                \Ced\Claro\Model\Profile::COLUMN_OPTIONAL_ATTRIBUTES,
                $optionalAttributes
            );
        }
    }

    /**
     * Merging attribute mapping.
     * @param $attributes
     * @param $key
     * @return array
     */
    private function merge($attributes, $key)
    {
        $default = $this->category->getAttributes($this->profile->getCategoryNode());
        $tempArray = [];
        $i = 0;
        $keyArray = [];

        if (!empty($attributes) && is_array($attributes)) {
            foreach ($attributes as &$attribute) {
                if (isset($val['delete']) && $attribute['delete'] == 1) {
                    continue;
                }
                if (!in_array($attribute[$key], $keyArray)) {
                    // decoding attribute options
                    if (isset($attribute['values']) &&
                        !empty($attribute['values'])) {
                        $data = htmlspecialchars_decode($attribute['values']);
                        $data = json_decode($data, true);
                        if (!empty($data) && is_array($data)) {
                            $options = $data;
                        } else {
                            $options = [];
                        }

                        $attribute['values'] = $options;
                    }

                    // Adding all attribute keys from api response
                    if (isset($default[$attribute[$key]])) {
                        $attribute = array_merge($default[$attribute[$key]], $attribute);
                    }

                    $keyArray[$attribute[$key]] = $attribute[$key];
                    $tempArray[$attribute[$key]] = $attribute;
                }
                $i++;
            }
        }

        return $tempArray;
    }
}
