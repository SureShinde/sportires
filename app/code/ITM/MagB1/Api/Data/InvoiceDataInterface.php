<?php
namespace ITM\MagB1\Api\Data;

interface InvoiceDataInterface
{

    /**
     *
     * @api
     * @return string increment_id.
     */
    public function getIncrementId();

    /**
     *
     * @api
     *
     * @param $value increment_id.
     * @return null
     */
    public function setIncrementId($value);

    /**
     *
     * @api
     *
     * @return \Magento\Sales\Api\Data\InvoiceItemInterface[] Array of items.
     */
    public function getItems();

    /**
     *
     * @api
     *
     * @param \Magento\Sales\Api\Data\InvoiceItemInterface[] $items
     * @return null
     */
    public function setItems($value);

    /**
     *
     * @api
     *
     * @return string
     */
    public function getCommentText();

    /**
     *
     * @api
     *
     * @param $value string
     * @return null
     */
    public function setCommentText($value);

    /**
     *
     * @api
     *
     * @return bool
     */
    public function getCommentCustomerNotify();

    /**
     *
     * @api
     *
     * @param $value bool
     * @return null
     */
    public function setCommentCustomerNotify($value);

    /**
     *
     * @api
     *
     * @return bool
     */
    public function getIsVisibleOnFront();

    /**
     *
     * @api
     *
     * @param $value bool
     * @return null
     */
    public function setIsVisibleOnFront($value);

    /**
     *
     * @api
     *
     * @return bool
     */
    public function getIsPaid();

    /**
     *
     * @api
     *
     * @param $value bool
     * @return null
     */
    public function setIsPaid($value);
}
