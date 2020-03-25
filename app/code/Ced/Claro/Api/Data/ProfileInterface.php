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
 * @package     Ced_Amazon
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Api\Data;

/**
 * Interface ProfileInterface
 * @package Ced\Claro\Api\Data
 * @api
 */
interface ProfileInterface extends \Ced\Integrator\Api\Data\ProfileInterface
{
    /**
     * Set Status
     * @param int $status
     * @return $this
     */
    public function setSatus($status);

    /**
     * Get Profile Category
     * @return string
     */
    public function getCategory();

    /**
     * Get Profile Sub Category
     * @return string
     */
    public function getCategoryNode();

    public function getLastCategoryNode();

    /**
     * Get Profile Attributes
     * @return array
     */
    public function getAttributes();

    /**
     * Get Profile Shipping Methods
     * @return array
     */
    public function getShippingMethods();

    /**
     * Get Profile Attribute
     * @param string $id
     * @return array
     */
    public function getAttribute($id);

    /**
     * Get Mapped magento attribute code
     * @param $id
     * @param null $default
     * @return null
     */
    public function getMappedAttribute($id, $default = null);

    /**
     * Get Attribute by magento code
     * @param $code
     * @return array|mixed
     */
    public function getAttributeByCode($code);
}
