<?php
namespace ITM\MagB1\Api\Sales;

interface ShipmentInterface
{

    /**
     *
     * @api
     *
     * @param ITM\MagB1\Api\Data\ShipmentDataInterface $entity.
     * @param ITM\MagB1\Api\Data\ItemDetailsDataInterface[] $items.
     * @param bool $send_email.
     * @return ITM\MagB1\Api\Data\ReturnResultDataInterface
     */
    public function createShipment($entity, $items, $send_email);

    /**
     * @param string $increment_id
     * @return bool Will returned true if email sent
     */
    public function sendShipmentEmail($increment_id);
}
