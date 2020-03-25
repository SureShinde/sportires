<?php
    
namespace ITM\MagB1\Api\Data;
    
interface InvoicefilesDataInterface
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
     * Get Increment ID
     * @return string|null.
     */
    public function getIncrementId();

    /**
     *
     * Set Increment ID
     * @param string $value.
     * @return null
     */
    public function setIncrementId($value);
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
     * Get Invoicefiles status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set Invoicefiles status
     *
     * @param int $status
     * @return null
     */
    public function setStatus($status);
}
