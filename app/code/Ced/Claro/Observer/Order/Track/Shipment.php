<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement(EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Observer\Order\Track;

use Magento\Framework\Event\ObserverInterface;

class Shipment implements ObserverInterface
{
    /**
     * @var \Ced\Claro\Helper\Logger
     */
    protected $logger;
    /**
     * @var \Ced\Claro\Helper\Order
     */
    protected $api;
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;
    /**
     * @var \Ced\Claro\Model\OrderFactory
     */
    protected $orderFactory;
    /**
     * @var \Ced\Claro\Helper\Sdk
     */
    protected $sdk;

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Ced\Claro\Helper\Logger $logger,
        \Ced\Claro\Model\OrderFactory $orderFactory,
        \Ced\Claro\Helper\Order $api,
        \Ced\Claro\Helper\Sdk $sdk
    ) {
        $this->objectManager = $objectManager;
        $this->api = $api;
        $this->logger = $logger;
        $this->orderFactory = $orderFactory;
        $this->sdk = $sdk;
    }
    /**
     * Event name : 'sales_order_shipment_save_after'
     * Observer name : ced_claro_shipment_track_save
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->logger->info('Shipment Observer', ['path' => __METHOD__, 'ShipData' => 'Shipment Observer Working']);
        if ($observer->getEvent()->getTrack()) {
            $order_id = $observer->getEvent()->getTrack()->getOrderId();
            if ($order_id) {
                try {
                    $claroOrder = $this->orderFactory->create()->loadByMagentoOrderId($order_id);
                    $claroOrderId = $claroOrder->getData(\Ced\Claro\Model\Order::COLUMN_MARKETPLACE_ORDER_ID);
                    if ($claroOrderId) {
                        $tracking_number = $observer->getEvent()->getTrack()->getTrackNumber();
                        /*$carrier_code = $observer->getEvent()->getTrack()->getCarrierCode();*/
                        $carrier_name = $observer->getEvent()->getTrack()->getTitle();
                        $order_data = json_decode($claroOrder->getData(\Ced\Claro\Model\Order::COLUMN_ORDER_DATA), true);
                        $array = $this->api->getClaroProductQuantity($order_data['productos']);

                        $cpId = "";
                        foreach ($array as $key => $value) {
                            $cpId = $cpId . $value['cpId'] . ',';
                        }
                        $cpIds = rtrim($cpId, ',');
                        if ($carrier_name == 'manual' || $carrier_name == 'Manual' || $carrier_name == 'MANUAL') {
                            $data = [
                                'guia' => 'manual',
                                'nopedido' => $claroOrderId,
                                'mensajeria' => 'manual',
                                'idpedidorelacion' => $cpIds,
                                'rastreopedido' => $tracking_number
                            ];
                        } else {
                            $data = [
                                'guia' => 'automatica',
                                'nopedido' => $claroOrderId,
                                'mensajeria' => $carrier_name,
                                'idpedidorelacion' => $cpIds,
                                'rastreopedido' => $tracking_number
                            ];
                        }
                        $shipment = $this->sdk->getOrder()->shipOrder($claroOrderId, $data);
                        if (isset($shipment['success']) && $shipment['success']) {
                            $status = [\Ced\Claro\Model\Order::COLUMN_STATUS => 'Embarcado'];
                            $claroOrder->addData($status);
                            $claroOrder->save();
                            if ($claroOrder) {
                                $this->logger->info(
                                    'Shipment Data In Observer',
                                    ['path' => __METHOD__, 'DataToShip' => json_encode($shipment['message']),
                                        'Response Data' => json_encode($shipment['message'])]
                                );
                            } else {
                                $this->logger->info(
                                    'Shipment Data In Observer',
                                    ['path' => __METHOD__, 'DataToShip' => json_encode($shipment['message']),
                                        'Response Data' => 'Claro Staus is not Updated']
                                );
                            }
                        }
                    }
                } catch (\Exception $e) {
                    $this->logger->error(
                        'Shipment Observer',
                        ['path' => __METHOD__,
                            'exception' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()]
                    );
                }
            }
        }
    }
}
