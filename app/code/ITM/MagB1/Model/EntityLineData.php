<?php

/**
 * Copyright 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Model;

use ITM\MagB1\Api\Data\EntityLineDataInterface;

/**
 * Defines a data structure representing a point, to demonstrating passing
 * more complex types in and out of a function call.
 */
class EntityLineData implements EntityLineDataInterface
{

    private $columns;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->columns = [];
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }
}
