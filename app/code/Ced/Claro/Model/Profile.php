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

namespace Ced\Claro\Model;

use Ced\Integrator\Api\Data\ProfileInterface;

class Profile extends \Magento\Framework\Model\AbstractModel implements \Ced\Claro\Api\Data\ProfileInterface
{
    const NAME = "ced_claro_profile";

    const COLUMN_ID = 'id';
    const COLUMN_NAME = 'name';
    const COLUMN_STATUS = 'status';

    const COLUMN_CATEGORY = 'category';
    const COLUMN_ATTRIBUTES = 'attributes'; // merged values, not saved.
    const COLUMN_REQUIRED_ATTRIBUTES = 'required_attributes';
    const COLUMN_OPTIONAL_ATTRIBUTES = 'optional_attributes';
    const COLUMN_SHIPPING_METHODS = 'shipping_methods';

    public $processed = false;

    public function _construct()
    {
        $this->_init(\Ced\Claro\Model\ResourceModel\Profile::class);
    }

    public function afterLoad()
    {
        $this->processAttributes();
        $this->processShippingMethods();

        parent::afterLoad();
    }

    /**
     * Get Category Node
     * @return bool|mixed|string
     */
    public function getCategoryNode()
    {
        $node = true;
        $categories = $this->getData(\Ced\Claro\Model\Profile::COLUMN_CATEGORY);
        $categories = !empty($categories) ? json_decode($categories, true) : [];
        if (!empty($categories) && is_array($categories)) {
            ksort($categories);
//            $node = end($categories);
            $node = current($categories);
        }
        return $node;
    }

    public function getLastCategoryNode()
    {
        $node = true;
        $categories = $this->getData(\Ced\Claro\Model\Profile::COLUMN_CATEGORY);
        $categories = !empty($categories) ? json_decode($categories, true) : [];
        if (!empty($categories) && is_array($categories)) {
            ksort($categories);
            if (isset($categories['category_level_1'])) {
                $node = end($categories);
            } else {
                $array = array_merge($categories, ["category_level_1" => "0"]);
                $node = end($array);
            }

        }
        return $node;
    }

    public function beforeSave()
    {
        $required = $this->getData(\Ced\Claro\Model\Profile::COLUMN_REQUIRED_ATTRIBUTES);
        $optional = $this->getData(\Ced\Claro\Model\Profile::COLUMN_OPTIONAL_ATTRIBUTES);
        $methods = $this->getData(\Ced\Claro\Model\Profile::COLUMN_SHIPPING_METHODS);

        if (is_array($required)) {
            $this->setData(\Ced\Claro\Model\Profile::COLUMN_REQUIRED_ATTRIBUTES, json_encode($required));
        }

        if (is_array($optional)) {
            $this->setData(\Ced\Claro\Model\Profile::COLUMN_OPTIONAL_ATTRIBUTES, json_encode($optional));
        }

        if (is_array($methods)) {
            $this->setData(\Ced\Claro\Model\Profile::COLUMN_OPTIONAL_ATTRIBUTES, json_encode($methods));
        }

        parent::beforeSave();
    }

    private function processShippingMethods()
    {
        $methods = $this->getData(self::COLUMN_SHIPPING_METHODS);
        $methods = !empty($methods) ? json_decode($methods, true) : [];
        if (is_array($methods)) {
            $this->setData(\Ced\Claro\Model\Profile::COLUMN_SHIPPING_METHODS, $methods);
        }
    }

    private function processAttributes()
    {
        $attributes = [];
        $required = $this->getData(\Ced\Claro\Model\Profile::COLUMN_REQUIRED_ATTRIBUTES);
        $required = !empty($required) ? json_decode($required, true) : [];

        $optional = $this->getData(\Ced\Claro\Model\Profile::COLUMN_OPTIONAL_ATTRIBUTES);
        $optional = !empty($optional) ? json_decode($optional, true) : [];

        if (is_array($required)) {
            $attributes = array_merge($attributes, $required);
            $this->setData(\Ced\Claro\Model\Profile::COLUMN_REQUIRED_ATTRIBUTES, $required);
        }

        if (is_array($optional)) {
            $attributes = array_merge($attributes, $optional);
            $this->setData(\Ced\Claro\Model\Profile::COLUMN_OPTIONAL_ATTRIBUTES, $optional);
        }

        if (is_array($attributes)) {
            $this->setData(\Ced\Claro\Model\Profile::COLUMN_ATTRIBUTES, $attributes);
        }

        $this->processed = true;
    }

    /**
     * Set Status
     * @param int $status
     * @return $this
     */
    public function setSatus($status)
    {
        return $this->setData(self::COLUMN_STATUS, $status);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::COLUMN_NAME, $name);
    }

    /**
     * Get Profile Attributes
     * @return array
     */
    public function getAttributes()
    {
        $attributes = $this->getData(self::COLUMN_ATTRIBUTES);
        if (!is_array($attributes)) {
            $attributes = [];
        }

        return $attributes;
    }

    /**
     * Get Profile Shipping Methods
     * @return array
     */
    public function getShippingMethods()
    {
        $methods = $this->getData(self::COLUMN_SHIPPING_METHODS);
        if (!is_array($methods)) {
            $methods = [];
        }

        return $methods;
    }

    /**
     * Get Profile Attribute
     * @param string $id
     * @return array
     */
    public function getAttribute($id)
    {
        $attribute = [];
        $attributes = $this->getAttributes();
        if (isset($attributes[$id])) {
            $attribute = $attributes[$id];
        }

        return $attribute;
    }

    /**
     * Get Mapped magento attribute code
     * @param $id
     * @param null $default
     * @return null
     */
    public function getMappedAttribute($id, $default = null)
    {
        $mapped = $default;
        $attributes = $this->getAttributes();
        if (isset($attributes[$id]['magento_attribute_code']) &&
            !empty($attributes[$id]['magento_attribute_code'])) {
            $mapped = $attributes[$id]['magento_attribute_code'];
        }
        return $mapped;
    }

    /**
     * Get Attribute by magento code
     * @param $code
     * @return array|mixed
     */
    public function getAttributeByCode($code)
    {
        $attribute = [];
        $attributes = $this->getAttributes();
        foreach ($attributes as $id => $value) {
            if (isset($value['magento_attribute_code']) && $value['magento_attribute_code'] == $code) {
                $attribute = $value;
            }
        }

        return $attribute;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::COLUMN_NAME);
    }

    /**
     * Get Profile Category
     * @return string
     */
    public function getCategory()
    {
        return $this->getData(self::COLUMN_CATEGORY);
    }
}
