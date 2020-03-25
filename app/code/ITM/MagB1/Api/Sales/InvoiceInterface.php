<?php
namespace ITM\MagB1\Api\Sales;

interface InvoiceInterface
{

    /**
     *
     * @api
     *
     * @param ITM\MagB1\Api\Data\InvoiceDataInterface $entity.
     * @param ITM\MagB1\Api\Data\ItemDetailsDataInterface[] $items.
     * @param bool $send_email.
     * @return ITM\MagB1\Api\Data\ReturnResultDataInterface
     */
    public function createInvoice($entity, $items, $send_email);
}
