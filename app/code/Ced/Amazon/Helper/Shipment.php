<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_Amazon
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Amazon\Helper;

/**
 * Directory separator shorthand
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * Class Shipment
 * @package Ced\Amazon\Helper
 */
class Shipment extends \Magento\Framework\App\Helper\AbstractHelper
{
    /** @var \Ced\Amazon\Api\AccountRepositoryInterface */
    public $account;

    /** @var \Ced\Amazon\Api\FeedRepositoryInterface */
    public $feed;

    /** @var \Ced\Amazon\Model\OrderFactory */
    public $order;

    /** @var \Ced\Amazon\Helper\Config */
    public $config;

    /** @var Logger */
    public $logger;

    /** @var \Amazon\Sdk\Envelope */
    public $envelope;

    /** @var \Amazon\Sdk\Validator */
    public $validator;

    /** @var \Amazon\Sdk\Order */
    public $api;

    /** @var \Amazon\Sdk\Order\FulfillmentFactory */
    public $fulfillment;

    /**
     * @var \Ced\Amazon\Api\QueueRepositoryInterface
     */
    public $queue;

    /** @var \Ced\Amazon\Api\Data\Queue\DataInterfaceFactory */
    public $queueDataFactory;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Ced\Amazon\Api\AccountRepositoryInterface $account,
        \Ced\Amazon\Api\FeedRepositoryInterface $feed,
        \Ced\Amazon\Api\QueueRepositoryInterface $queue,
        \Ced\Amazon\Model\OrderFactory $orderFactory,
        \Ced\Amazon\Api\Data\Queue\DataInterfaceFactory $queueDataFactory,
        \Ced\Amazon\Helper\Config $config,
        \Ced\Amazon\Helper\Logger $logger,
        \Amazon\Sdk\Order\FulfillmentFactory $fulfillment,
        \Amazon\Sdk\EnvelopeFactory $envelope,
        \Amazon\Sdk\ValidatorFactory $validator,
        \Amazon\Sdk\Api\OrderFactory $api
    ) {
        parent::__construct($context);
        $this->account = $account;
        $this->feed = $feed;
        $this->order = $orderFactory;
        $this->config = $config;
        $this->logger = $logger;
        $this->queue = $queue;
        $this->queueDataFactory = $queueDataFactory;

        $this->api = $api;
        $this->fulfillment = $fulfillment;
        $this->envelope = $envelope;
        $this->validator = $validator;
    }

    public function sync($orderId, $shipmentId)
    {
        $shipment = $this->get($orderId, $shipmentId);
        if (isset($shipment['feed_id'])) {
            $status = $this->feed->sync($shipment['feed_id']);

            if ($status == false) {
                /** @var \Ced\Amazon\Model\Order $order */
                $order = $this->order->create()->load($orderId);
                $response = $this->feed->getResultByFeedId(
                    $shipment['feed_id'],
                    $order->getData(\Ced\Amazon\Model\Order::COLUMN_ACCOUNT_ID)
                );
                if (!empty($response) && strpos($response, '<StatusCode>Complete</StatusCode>') !== false) {
                    $status = \Ced\Amazon\Model\Source\Feed\Status::DONE;
                }
            }

            $this->update($orderId, $shipmentId, ['Status' => $status]);
        }

        return $shipment;
    }

    /**
     * Get all shipments
     * @param $orderId
     * @param null $shipmentId
     * @param \Ced\Amazon\Model\Order|null $order
     * @return array|mixed
     */
    public function get($orderId, $shipmentId = null, $order = null)
    {
        $shipments = [];
        if (!isset($order)) {
            /** @var \Ced\Amazon\Model\Order $order */
            $order = $this->order->create()->load($orderId);
        }

        if (!empty($order) && $order->getId() > 0) {
            $shipments = $order->getData(\Ced\Amazon\Model\Order::COLUMN_SHIPMENT_DATA);
            $shipments = !empty($shipments) ? json_decode($shipments, true) : [];
            if (isset($shipmentId)) {
                if (isset($shipments[$shipmentId])) {
                    $shipments = $shipments[$shipmentId];
                } else {
                    $shipments = [];
                }
            }
        }

        return $shipments;
    }

    /**
     * Update shipment status
     * @param int $orderId, Amazon Order Row Id
     * @param int $shipmentId, Magento Shipment Id
     * @param array $data
     * @throws \Exception
     */
    public function update($orderId, $shipmentId, array $data = [])
    {
        /** @var \Ced\Amazon\Model\Order $order */
        $order = $this->order->create()->load($orderId);
        if (!empty($order) && $order->getId() > 0) {
            $shipments = $order->getData(\Ced\Amazon\Model\Order::COLUMN_SHIPMENT_DATA);
            $shipments = !empty($shipments) ? json_decode($shipments, true) : [];
            if (isset($shipmentId, $shipments[$shipmentId])) {
                $shipments[$shipmentId] = array_merge($shipments[$shipmentId], $data);
                $order->setData(\Ced\Amazon\Model\Order::COLUMN_SHIPMENT_DATA, json_encode($shipments));
                $order->save();
            }
        }
    }

    /**
     * Delete shipment form mp shipments
     * @param $orderId
     * @param null $shipmentId
     * @param \Ced\Amazon\Model\Order null $order
     * @return bool
     * @throws \Exception
     */
    public function delete($orderId, $shipmentId = null, $order = null)
    {
        $status = false;
        if (!isset($order)) {
            /** @var \Ced\Amazon\Model\Order $order */
            $order = $this->order->create()->load($orderId);
        }

        if (!empty($order) && $order->getId() > 0) {
            $shipments = $order->getData(\Ced\Amazon\Model\Order::COLUMN_SHIPMENT_DATA);
            $shipments = !empty($shipments) ? json_decode($shipments, true) : [];
            if (isset($shipmentId, $shipments[$shipmentId])) {
                unset($shipments[$shipmentId]);
                $order->setData(\Ced\Amazon\Model\Order::COLUMN_SHIPMENT_DATA, json_encode($shipments));
                $order->save();
                $status = true;
            }
        }

        return $status;
    }

    /**
     * @param \Magento\Sales\Model\Order\Shipment $shipment
     */
    public function create($shipment)
    {
        $orderData = [];
        $orderItems = [];
        $incrementId = '';
        $poId = '';
        try {
            /** @var \Magento\Sales\Model\Order\Shipment $shipment */
            if (!empty($shipment)) {
                /** @var \Magento\Sales\Model\Order $order */
                $order = $shipment->getOrder();
                $incrementId = $order->getIncrementId();
                $orderId = $order->getId();
                /** @var \Ced\Amazon\Model\Order $mporder */
                $mporder = $this->order->create()
                    ->load($orderId, \Ced\Amazon\Model\Order::COLUMN_MAGENTO_ORDER_ID);
                if (isset($mporder) && !empty($mporder->getData(\Ced\Amazon\Model\Order::COLUMN_PO_ID))) {
                    $poId = $mporder->getData(\Ced\Amazon\Model\Order::COLUMN_PO_ID);
                    $orderData = $mporder->getData(\Ced\Amazon\Model\Order::COLUMN_ORDER_DATA);
                    $orderData = !empty($orderData) ? json_decode($orderData, true) : [];
                    $orderItems = $mporder->getData(\Ced\Amazon\Model\Order::COLUMN_ORDER_ITEMS);
                    $orderItems = !empty($orderItems) ? json_decode($orderItems, true) : [];

                    $fulfillments = $mporder->getData(\Ced\Amazon\Model\Order::COLUMN_SHIPMENT_DATA);
                    $fulfillments = !empty($fulfillments) ? json_decode($fulfillments, true) : [];
                    $this->logger->info(
                        'Shipment creation started via shipment helper.',
                        [
                            'po_id' => $poId,
                            'increment_id' => $incrementId,
                            'shipment_data' => $shipment->getData(),
                            'mp_order_data' => $orderData,
                            'mp_order_items' => $orderItems,
                            'mp_shipment_data' => $fulfillments,
                            'path' => __METHOD__
                        ]
                    );

                    /** @var \Magento\Sales\Api\Data\ShipmentItemInterface[] $items */
                    $items = $shipment->getAllItems();
                    $tracks = $shipment->getAllTracks();
                    $trackingRequired = $this->config->isTrackingNumberRequired();

                    /** @var \Magento\Sales\Model\Order\Shipment\Track $track */
                    foreach ($tracks as $track) {
                        if (empty($track->getData('track_number')) && $trackingRequired) {
                            continue;
                        }

                        $this->logger->info(
                            'Track processing started via shipment helper.',
                            [
                                'po_id' => $poId,
                                'increment_id' => $incrementId,
                                'track_data' => $track->getData(),
                                'path' => __METHOD__
                            ]
                        );

                        $title = $track->getData('title');
                        $code = $track->getData('carrier_code');
                        $allowedCode = $this->getCarrierCode($code, $title);
                        if (empty($allowedCode)) {
                            $carrierName = $code;
                            $carrierCode = "";
                        } else {
                            $carrierCode = $allowedCode;
                            $carrierName = "";
                        }

                        $data = [
                            'OrderId' => $orderId,
                            'TrackId' => $track->getId(),
                            'IncrementId' => $incrementId,

                            'AmazonOrderID' => $poId,
                            'FulfillmentDate' => (string)$this->getDate($shipment->getData('created_at')),
                            'FulfillmentData' => [
                                'CarrierCode' => $carrierCode,
                                'CarrierName' => $carrierName,
                                'ShippingMethod' => $track->getData('title'),
                                'ShipperTrackingNumber' => $track->getData('track_number'),
                            ],
                            'Items' => [

                            ]
                        ];

                        foreach ($items as $item) {
                            $data['Items'][] = [
                                'SKU' => (string)$item->getSku(),
                                'AmazonOrderItemCode' => (string)$this->getOrderItemCode(
                                    $item->getSku(),
                                    $orderItems,
                                    $orderData
                                ),
                                'Quantity' => (string)(int)$item->getQty(),
                            ];
                        }

                        $specifics = [
                            'ids' => [$shipment->getId()],
                            'data' => $data,
                            'account_id' => $mporder->getData(\Ced\Amazon\Model\Order::COLUMN_ACCOUNT_ID),
                            'marketplace' => $mporder->getData(\Ced\Amazon\Model\Order::COLUMN_MARKETPLACE_ID),
                            'profile_id' => null,
                            'store_id' => $shipment->getStoreId(),
                            'type' => \Amazon\Sdk\Api\Feed::ORDER_FULFILLMENT,
                        ];
                        $async = $this->config->getShipmentMode();
                        if ($async) {
                            $status = $this->queue($specifics);
                            $specifics['data']['shipment_id'] = $shipment->getId();
                            $specifics['data']['errors'] = !$status;
                            $specifics['data']['Feed'] = [];
                            $specifics['data']['Status'] = \Ced\Amazon\Model\Source\Feed\Status::NOT_SUBMITTED;
                            $this->add($shipment->getId(), $specifics['data'], $mporder);
                        } else {
                            $envelope = $this->prepare($specifics);
                            $feed = $this->feed->send($envelope, $specifics);

                            $error = '';
                            if (empty($envelope)) {
                                $error = 'Shipment prepare failed.';
                            }

                            $specifics['data']['shipment_id'] = $shipment->getId();
                            //TODO: find a way to set errors in shipment
                            $specifics['data']['errors'] = $error;
                            $specifics['data']['Feed'] = $feed;
                            if (isset($feed['Id'])) {
                                $specifics['data']['feed_id'] = $feed['Id'];
                                $specifics['data']['Status'] = \Ced\Amazon\Model\Source\Feed\Status::SUBMITTED;
                            } else {
                                $specifics['data']['feed_id'] = '0';
                                $specifics['data']['Status'] = \Ced\Amazon\Model\Source\Feed\Status::FAILED;
                            }

                            $this->add($shipment->getId(), $specifics['data'], $mporder);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical(
                'Shipment create observer failed.',
                [
                    'exception' => $e->getMessage(),
                    'po_id' => $poId,
                    'increment_id' => $incrementId,
                    'order_data' => $orderData,
                    'order_items' => $orderItems,
                    'path' => __METHOD__
                ]
            );
        }
    }

    /**
     * Get Carrier Code for Amazon
     * @param string $code
     * @param string $title
     * @return mixed|string
     */
    private function getCarrierCode($code = "", $title = "")
    {
        $value = "";
        $mappings = [
            'usps' => "USPS",
            'fedex' => "FedEx",
            'dhl' => "DHL",
        ];

        if ($code == "custom") {
            $code = $title;
        }

        if (!empty($code)) {
            $result = \Amazon\Sdk\Order\Fulfillment\CarrierCode::search($code);
            if (isset($result)) {
                $value = $result;
            }
        } elseif (isset($mappings[$code]) && !empty($mappings[$code])) {
            $value = $mappings[$code];
        } else {
            $value = "";
        }

        return $value;
    }

    private function getDate($date)
    {
        $result = date('Y-m-d H:i:s P', strtotime($date));
        return $result;
    }

    /**
     * Get Order Item Code
     * @param $sku
     * @param array $orderItems
     * @param array $orderData
     * @return string
     */
    private function getOrderItemCode($sku, array $orderItems = [], array $orderData = [])
    {
        $orderItemCode = '0';
        if (!empty($sku) && !empty($orderItems) && !empty($orderData)) {
            foreach ($orderItems as $item) {
                if (isset($item['OrderItemId'], $item['SellerSKU'])
                    && $sku == $item['SellerSKU']) {
                    $orderItemCode = $item['OrderItemId'];
                    break;
                }
            }
        }
        return $orderItemCode;
    }

    /**
     * Prepare shipment array
     * @param array $data
     * @param \Amazon\Sdk\Envelope $envelope
     * @return array
     * @deprecated
     */
    public function prepareOld(array $data = [], $envelope = null)
    {
        $result = [
            'account_id' => null,
            'marketplace' => null,
            'type' => \Amazon\Sdk\Api\Feed::ORDER_FULFILLMENT,
            'envelope' => null,
            'errors' => null
        ];

        try {
            /** @var \Amazon\Sdk\Order\Fulfillment $fulfillment */
            $fulfillment = $this->fulfillment->create();

            if (isset($data['OrderId']) and !empty($data['OrderId'])) {
                $fulfillment->setId($data['OrderId']);
                // Saving fulfillment data.
                /** @var \Ced\Amazon\Model\Order $mporder */
                $mporder = $this->order->create()->load($data['OrderId'], 'magento_order_id');
                $result['marketplace'] = $mporder->getData(\Ced\Amazon\Model\Order::COLUMN_MARKETPLACE_ID);
                $account = $this->account->getById($mporder->getData(\Ced\Amazon\Model\Order::COLUMN_ACCOUNT_ID));
            /** @var \Ced\Amazon\Model\Account $account */
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(__('Order Id is invalid.'));
            }

            if (isset($data['AmazonOrderID']) && !empty($data['AmazonOrderID'])) {
                $fulfillment->setData($data['AmazonOrderID'], $data);
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(__('AmazonOrderID is invalid.'));
            }

            if (isset($data['Items']) && !empty($data['Items'])) {
                $fulfillment->setItems($data['Items']);
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(__('Items are missing.'));
            }

            /** @var \Amazon\Sdk\Validator $validator */
            $validator = $this->validator->create(
                ['object' => $fulfillment]
            );

            // $validator->validate(), TODO: fix validator
            if (true) {
                if (!isset($envelope)) {
                    $envelope = $this->envelope->create(
                        [
                            'merchantIdentifier' => $account->getConfig()->getSellerId(),
                            'messageType' => \Amazon\Sdk\Base::MESSAGE_TYPE_ORDER_FULFILLMENT
                        ]
                    );
                }

                $envelope->addFulfillment($fulfillment);
                $result['account_id'] = $account->getId();
                $result['envelope'] = $envelope;
            } else {
                $this->logger->critical(
                    'Envelope Data Validation Failed.',
                    [
                        'order_data' => $data,
                        'errors' => $validator->getErrors(),
                        'path' => __METHOD__
                    ]
                );

                $result['errors'] = $validator->getErrors();
            }
        } catch (\Exception $exception) {
            $this->logger->critical(
                'Prepare Order Envelope Failed.',
                [
                    'exception' => $exception->getMessage(),
                    'order_data' => $data,
                    'path' => __METHOD__
                ]
            );
            $result['errors'] = $exception->getMessage();
        }

        return $result;
    }

    /**
     * Prepare shipment array
     * @param array $specifics
     * @param \Amazon\Sdk\Envelope $envelope
     * @return \Amazon\Sdk\Envelope|null $envelope
     */
    public function prepare(array $specifics = [], $envelope = null)
    {
        if (isset($specifics) && !empty($specifics)) {
            try {
                /** @var \Amazon\Sdk\Order\Fulfillment $fulfillment */
                $fulfillment = $this->fulfillment->create();

                if (isset($specifics['data']['OrderId']) && !empty($specifics['data']['OrderId'])) {
                    /** @var int $orderId, Magento Order Entity Id */
                    $orderId = $specifics['data']['OrderId'];

                    // Adding unique message id
                    $messageId = (string)$specifics['data']['OrderId'];
                    if (isset($specifics['data']['TrackId'])) {
                        $messageId .= (string)$specifics['data']['TrackId'];
                    }
                    $fulfillment->setId($messageId);

                    // Saving fulfillment data.
                    /** @var \Ced\Amazon\Model\Order $mporder */
                    $mporder = $this->order->create()->load($orderId, 'magento_order_id');
                    /** @var \Ced\Amazon\Model\Account $account */
                    $account = $this->account->getById($mporder->getData(\Ced\Amazon\Model\Order::COLUMN_ACCOUNT_ID));
                } else {
                    throw new \Magento\Framework\Exception\LocalizedException(__('Order Id is invalid.'));
                }

                if (isset($specifics['data']['AmazonOrderID']) && !empty($specifics['data']['AmazonOrderID'])) {
                    $fulfillment->setData($specifics['data']['AmazonOrderID'], $specifics['data']);
                } else {
                    throw new \Magento\Framework\Exception\LocalizedException(__('AmazonOrderID is invalid.'));
                }

                if (isset($specifics['data']['Items']) && !empty($specifics['data']['Items'])) {
                    $fulfillment->setItems($specifics['data']['Items']);
                } else {
                    throw new \Magento\Framework\Exception\LocalizedException(__('Items are missing.'));
                }

                /** @var \Amazon\Sdk\Validator $validator */
                $validator = $this->validator->create(
                    ['object' => $fulfillment]
                );

                // $validator->validate(), TODO: fix validator
                if (true) {
                    if (!isset($envelope)) {
                        $envelope = $this->envelope->create(
                            [
                                'merchantIdentifier' => $account->getConfig()->getSellerId(),
                                'messageType' => \Amazon\Sdk\Base::MESSAGE_TYPE_ORDER_FULFILLMENT
                            ]
                        );
                    }

                    $envelope->addFulfillment($fulfillment);
                } else {
                    $this->logger->critical(
                        'Prepare shipment failed due to invalid data.',
                        [
                            'specifics' => $specifics,
                            'errors' => $validator->getErrors(),
                            'path' => __METHOD__
                        ]
                    );
                }
            } catch (\Exception $exception) {
                $this->logger->critical(
                    'Prepare shipment failed.' . $exception->getMessage(),
                    [
                        'exception' => $exception->getMessage(),
                        'specifics' => $specifics,
                        'path' => __METHOD__
                    ]
                );
            }
        }

        return $envelope;
    }

    /**
     * Add a shipment
     * @param string $id, TODO: Use track id, instead of shipment id.
     * @param array $shipment
     * @param \Ced\Amazon\Model\Order|null $order
     * @throws \Exception
     */
    public function add($id = null, $shipment = [], \Ced\Amazon\Model\Order $order = null)
    {
        // Sync order while adding shipment from Amazon: 1 call per min allowed, hence disabled.
        $sync = false;

        if (isset($order, $id) && !empty($shipment)) {
            $shipments = $order->getData(\Ced\Amazon\Model\Order::COLUMN_SHIPMENT_DATA);
            $shipments = !empty($shipments) ? json_decode($shipments, true) : [];
            if ($id == 'na') {
                $shipments[] = $shipment;
            } else {
                $shipments[$id] = $shipment;
            }

            /** @var \Ced\Amazon\Api\Data\AccountInterface $account */
            $account = $this->account->getById($order->getData(\Ced\Amazon\Model\Order::COLUMN_ACCOUNT_ID));
            $config = $account->getConfig();
            $poId = $order->getData(\Ced\Amazon\Model\Order::COLUMN_PO_ID);
            try {
                // Updating order_data after shipment
                // Adding OrderId Parameter: Optional, Should be applied in the last.
                if (isset($poId) && !empty($poId) && $sync) {
                    /** @var \Amazon\Sdk\Api\Order $api */
                    $api = $this->api->create([
                        'config' => $config,
                        'logger' => $this->logger,
                        'mockMode' => $account->getMockMode(),
                    ]);

                    $api->setOrderId($poId);
                    $api->fetchOrder();
                    $data = $api->getData();
                }

                if (!empty($data)) {
                    $order->setData(
                        \Ced\Amazon\Model\Order::COLUMN_ORDER_DATA,
                        json_encode($data)
                    );
                }
            } catch (\Exception $e) {
                $this->logger->addCritical(
                    'Order update failed after shipment.',
                    [
                        'exception' => $e->getMessage(),
                        'po_id' => $poId,
                        'shipment_id' => $id,
                        'path' => __METHOD__
                    ]
                );
            }

            $order->setData(\Ced\Amazon\Model\Order::COLUMN_SHIPMENT_DATA, json_encode($shipments));
            $order->save();
        }
    }

    public function queue(array $specifics = [])
    {
        /** @var \Ced\Amazon\Api\Data\Queue\DataInterface $queueData */
        $queueData = $this->queueDataFactory->create();
        $queueData->setAccountId($specifics['account_id']);
        $queueData->setMarketplace($specifics['marketplace']);
        $queueData->setSpecifics($specifics);
        $queueData->setOperationType(\Amazon\Sdk\Base::OPERATION_TYPE_UPDATE);
        $queueData->setType($specifics['type']);
        $status = $this->queue->push($queueData);

        return $status;
    }
}
