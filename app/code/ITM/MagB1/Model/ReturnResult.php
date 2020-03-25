<?php
namespace ITM\MagB1\Model;

use ITM\MagB1\Api\Data\ReturnResultDataInterface;

class ReturnResult implements ReturnResultDataInterface
{

    private $error;

    private $data;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->error = false;
        $this->data = [];
    }

    /**
     *
     * @api
     *
     * @return bool
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     *
     * @api
     *
     * @param $value bool
     * @return null
     */
    public function setError($value)
    {
        $this->error = $value;
    }

    /**
     *
     * @api
     *
     * @return string[] Array of items.
     */
    public function getData()
    {
        return $this->items;
    }

    /**
     *
     * @api
     *
     * @param
     *            $items
     * @return null
     */
    public function setData($value)
    {
        $this->items = $value;
    }
}
