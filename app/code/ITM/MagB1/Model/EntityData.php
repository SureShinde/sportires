<?php

/**
 * Copyright 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Model;

use ITM\MagB1\Api\Data\EntityDataInterface;

/**
 * Defines a data structure representing a point, to demonstrating passing
 * more complex types in and out of a function call.
 */
class EntityData implements EntityDataInterface
{

    private $primary_code;

    private $model_name;

    private $lines;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->primary_code = "";
        $this->model_name = "";
        $this->lines = [];
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getPrimaryCode()
    {
        return $this->primary_code;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function setPrimaryCode($value)
    {
        $this->primary_code = $value;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getModelName()
    {
        return $this->model_name;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function setModelName($value)
    {
        $this->model_name = $value;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }
}
