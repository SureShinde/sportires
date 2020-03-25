<?php


namespace ITM\Sportires\Rewrite\Magento\InventoryReservations\Model\ResourceModel;

class GetReservationsQuantity extends \Magento\InventoryReservations\Model\ResourceModel\GetReservationsQuantity
{


	 /**
     * @inheritdoc
     */
    public function execute(string $sku, int $stockId): float
    {
		return 0;   
	}
}
