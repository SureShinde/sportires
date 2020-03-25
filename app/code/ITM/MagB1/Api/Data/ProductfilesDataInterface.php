<?php
    
namespace ITM\MagB1\Api\Data;
    
interface ProductfilesDataInterface
{
    
    /**
     *
     * @api
     * @return int entity_id.
     */
    public function getEntityId();
    
    /**
     *
     * @api
     * @param $value entity_id.
     * @return null
     */
    public function setEntityId($value);
                
    /**
     *
     * Get SKU
     * @return string|null.
     */
    public function getSku();

    /**
     *
     * Set SKU
     * @param string $value.
     * @return null
     */
    public function setSku($value);
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
     * Get Store ID
     * @return int|null.
     */
    public function getStoreId();

    /**
     *
     * Set Store ID
     * @param int $value
     * @return null
     */
    public function setStoreId($value);

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
     * Get Productfiles status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set Productfiles status
     *
     * @param int $status
     * @return null
     */
    public function setStatus($status);
}
