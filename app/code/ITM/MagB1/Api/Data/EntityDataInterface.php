<?php
namespace ITM\MagB1\Api\Data;

interface EntityDataInterface
{

    /**
     *
     * @api
     * @return string .
     */
    public function getPrimaryCode();

    /**
     *
     * @api

     * @param string $value
     *            .
     * @return null
     */
    public function setPrimaryCode($value);

    /**
     *
     * @api
     * @return string .
     */
    public function getModelName();

    /**
     *
     * @api
     * @param string $value
     *            .
     * @return null
     */
    public function setModelName($value);

    /**
     *
     * @api
     * @return \ITM\MagB1\Api\Data\EntityLineDataInterface[] Array of lines.
     */
    public function getLines();

    /**
     *
     * @api
     * @param \ITM\MagB1\Api\Data\EntityLineDataInterface[] $lines
     * @return null
     */
    public function setLines($lines);
}
