<?php

namespace ITM\MagB1\Api\Data;

interface CustomerfilesDataInterface
{

    /**
     *
     * @api
     * @return int id.
     */
    public function getId();

    /**
     *
     * @api
     * @param $value id.
     * @return null
     */
    public function setId($value);

    /**
     *
     * Get Customer ID
     * @return int|null.
     */
    public function getCustomerId();

    /**
     *
     * Set Customer ID
     * @param int $value
     * @return null
     */
    public function setCustomerId($value);
    /**
     *
     * Get Path
     * @return string|null.
     */
    public function getPath();

    /**
     *
     * Set Path
     * @param string $value.
     * @return null
     */
    public function setPath($value);
    /**
     *
     * Get Description
     * @return string|null.
     */
    public function getDescription();

    /**
     *
     * Set Description
     * @param string $value.
     * @return null
     */
    public function setDescription($value);

    /**
     *
     * Get Position
     * @return int|null.
     */
    public function getPosition();

    /**
     *
     * Set Position
     * @param int $value
     * @return null
     */
    public function setPosition($value);

    /**
     * Get Customerfiles status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set Customerfiles status
     *
     * @param int $status
     * @return null
     */
    public function setStatus($status);
}
