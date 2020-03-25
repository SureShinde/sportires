<?php

namespace Ced\WalmartMx\Observer;

class Shipment implements \Magento\Framework\Event\ObserverInterface
{
	protected $objectManager;
	protected $api;
	protected $logger;

	public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Ced\WalmartMx\Helper\Logger $logger,
        \Ced\WalmartMx\Helper\Order $api
    ) {
        $this->objectManager = $objectManager;
        $this->api = $api;
        $this->logger = $logger;
    }
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
        $this->logger->info('Shipment Observer', ['path' => __METHOD__, 'ShipData' => 'Shipment Observer Working']);
		if($observer->getEvent()->getTrack()) {
			$order_id = $observer->getEvent()->getTrack()->getOrderId();
			if($order_id) {
				try{
					$bo_order = $this->objectManager->get('Ced\WalmartMx\Model\Orders')->load($order_id,'magento_order_id');
					if($bo_order && $bo_order->getWalmartmxOrderId()) {
						$tracking_number = $observer->getEvent()->getTrack()->getTrackNumber();
                        $shippingProvider = $this->api->getShipmentProviders();
                        $providerCode = array_column($shippingProvider, 'code');
						$carrier_code = $observer->getEvent()->getTrack()->getCarrierCode();
                        $carrier_name = $observer->getEvent()->getTrack()->getTitle();
                        $carrier_code = (in_array(strtoupper($carrier_code), $providerCode)) ? strtoupper($carrier_code) : '';
						$args = ['TrackingNumber' => $tracking_number,'ShippingProvider' => strtoupper($carrier_code),'order_id' => $order_id, 'WalmartMxOrderID' => $bo_order->getWalmartmxOrderId(), 'ShippingProviderName' => strtolower($carrier_name) ];
						$response = $this->api->shipOrder($args);
                        $this->logger->info('Shipment Data In Observer', ['path' => __METHOD__, 'DataToShip' => json_encode($args), 'Response Data' => json_encode($response)]);
					}
				} catch (\Exception $e){
                    $this->logger->error('Shipment Observer', ['path' => __METHOD__, 'exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
				}
			}
		}
		return $this;
	}
}