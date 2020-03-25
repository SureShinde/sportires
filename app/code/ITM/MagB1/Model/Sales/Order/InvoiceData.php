<?php

/**
 * Copyright 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Model\Sales\Order;

use ITM\MagB1\Api\Data\InvoiceDataInterface;

/**
 * Defines a data structure representing a point, to demonstrating passing
 * more complex types in and out of a function call.
 */
class InvoiceData implements InvoiceDataInterface
{

    private $increment_id;

    private $items;

    private $comment_text;

    private $comment_customer_notify;

    private $is_visible_on_front;

    private $is_paid;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->increment_id = "";
        $this->items = [];
        $this->comment_text = "";
        $this->comment_customer_notify = 0;
        $this->is_visible_on_front = 0;
        $this->is_paid = true;
    }

    /**
     *
     * @api
     *
     * @return string
     */
    public function getIncrementId()
    {
        return $this->increment_id;
    }

    /**
     *
     * @api
     *
     * @param $value string
     * @return null
     */
    public function setIncrementId($value)
    {
        $this->increment_id = $value;
    }

    /**
     *
     * @api
     *
     * @return \Magento\Sales\Api\Data\ShipmentItemInterface[] Array of items.
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     *
     * @api
     *
     * @param \Magento\Sales\Api\Data\ShipmentItemInterface[] $items
     * @return null
     */
    public function setItems($value)
    {
        $this->items = $value;
    }

    /**
     *
     * @api
     *
     * @return string
     */
    public function getCommentText()
    {
        return $this->comment_text;
    }

    /**
     *
     * @api
     *
     * @param $value string
     * @return null
     */
    public function setCommentText($value)
    {
        $this->comment_text = $value;
    }

    /**
     *
     * @api
     *
     * @return bool
     */
    public function getCommentCustomerNotify()
    {
        return $this->comment_customer_notify;
    }

    /**
     *
     * @api
     *
     * @param $value bool
     * @return null
     */
    public function setCommentCustomerNotify($value)
    {
        $this->comment_customer_notify = $value;
    }

    /**
     *
     * @api
     *
     * @return bool
     */
    public function getIsVisibleOnFront()
    {
        return $this->is_visible_on_front;
    }

    /**
     *
     * @api
     *
     * @param $value bool
     * @return null
     */
    public function setIsVisibleOnFront($value)
    {
        $this->is_visible_on_front = $value;
    }

    /**
     *
     * @api
     *
     * @return bool
     */
    public function getIsPaid()
    {
        return $this->is_paid;
    }

    /**
     *
     * @api
     *
     * @param $value bool
     * @return null
     */
    public function setIsPaid($value)
    {
        $this->is_paid = $value;
    }
}
