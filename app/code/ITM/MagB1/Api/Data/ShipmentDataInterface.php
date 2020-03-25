<?php
namespace ITM\MagB1\Api\Data;

interface ShipmentDataInterface
{

    /**
     *
     * @api
     *
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
     * @return \Magento\Sales\Api\Data\ShipmentItemInterface[] Array of items.
     */
    public function getItems();

    /**
     *
     * @api
     *
     * @param \Magento\Sales\Api\Data\ShipmentItemInterface[] $items
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
     * @return \Magento\Sales\Api\Data\ShipmentTrackInterface[] Array of tracks.
     */
    public function getTracks();

    /**
     *
     * @api
     *
     * @param \Magento\Sales\Api\Data\ShipmentTrackInterface[] $tracks
     * @return null
     */
    public function setTracks($value);

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
