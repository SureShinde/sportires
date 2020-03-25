<?php
namespace ITM\MagB1\Api\Data;

interface EntityLineColumnDataInterface
{

    /**
     *
     * @api
     *
     * @return string.
     */
    public function getColumnName();

    /**
     *
     * @api
     *
     * @param string $value
     * @return null
     */
    public function setColumnName($value);

    /**
     *
     * @api
     *
     * @return string.
     */
    public function getColumnValue();

    /**
     *
     * @api
     *
     * @param string $value
     * @return null
     */
    public function setColumnValue($value);
}
