<?php
namespace ITM\MagB1\Api\Data;

interface EntityLineDataInterface
{

    /**
     *
     * @api
     *
     * @return \ITM\MagB1\Api\Data\EntityLineColumnDataInterface[] Array of columns.
     */
    public function getColumns();

    /**
     *
     * @api
     *
     * @param \ITM\MagB1\Api\Data\EntityLineColumnDataInterface[] $columns
     * @return null
     */
    public function setColumns($columns);
}
