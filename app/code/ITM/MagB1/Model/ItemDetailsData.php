<?php
namespace ITM\MagB1\Model;

use ITM\MagB1\Api\Data\ItemDetailsDataInterface;

class ItemDetailsData implements ItemDetailsDataInterface
{

    private $sku;

    private $qty;
    
    private $uom_entry;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->sku ;
        $this->qty ;
        $this->uom_entry ;
    }

    /**
     *
     * @api
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     *
     * @api
     *
     * @param string $value
     * @return null
     */
    public function setSku($value)
    {
        $this->sku = $value;
    }

    /**
     *
     * @api
     *
     * @return float
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     *
     * @api
     *
     * @param float $value
     * @return null
     */
    public function setQty($value)
    {
        $this->qty = $value;
    }
    
    /**
     *
     * @api
     *
     * @return string
     */
    public function getUomEntry()
    {
        return $this->uom_entry;
    }
    
    /**
     *
     * @api
     *
     * @param string $value
     * @return null
     */
    public function setUomEntry($value)
    {
        $this->uom_entry = $value;
    }
}
