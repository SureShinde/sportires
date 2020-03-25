<?php
namespace ITM\MagB1\Api\Data;

interface ItemDetailsDataInterface
{

    /**
     *
     * @api
     *
     * @return string
     */
    public function getSku();

    /**
     *
     * @api
     *
     * @param string $value
     *            .
     * @return null
     */
    public function setSku($value);

    /**
     *
     * @api
     * @return float.
     */
    public function getQty();

    /**
     *
     * @api
     * @param float $value
     * @return null
     */
    public function setQty($value);
    
    /**
     *
     * @api
     *
     * @return string
     */
    public function getUomEntry();
    
    /**
     *
     * @api
     *
     * @param string $value
     *            .
     * @return null
     */
    public function setUomEntry($value);
}
