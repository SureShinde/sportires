<?php

/**
 * Copyright 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Model;

use ITM\MagB1\Api\Data\EntityLineColumnDataInterface;

/**
 * Defines a data structure representing a point, to demonstrating passing
 * more complex types in and out of a function call.
 */
class EntityLineColumnData implements EntityLineColumnDataInterface
{

    private $column_name;

    private $column_value;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->column_name = "";
        $this->column_value = "";
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getColumnName()
    {
        return $this->column_name;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function setColumnName($value)
    {
        $this->column_name = $value;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getColumnValue()
    {
        return $this->column_value;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function setColumnValue($value)
    {
        $this->column_value = $value;
    }
}
