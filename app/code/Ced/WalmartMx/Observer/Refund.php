<?php

namespace Ced\WalmartMx\Observer;

class Refund implements \Magento\Framework\Event\ObserverInterface
{
	protected $objectManager;
	protected $api;
	protected $logger;

	public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Ced\WalmartMx\Helper\Logger $logger,
        \Ced\WalmartMx\Helper\Order $api,
        \Ced\WalmartMx\Model\OrdersFactory $orders,
        \Ced\WalmartMx\Helper\Config $config,
        \Magento\Framework\Json\Helper\Data $json,
        \Magento\Framework\Message\ManagerInterface $manager,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->objectManager = $objectManager;
        $this->api = $api;
        $this->logger = $logger;
        $this->orders = $orders;
        $this->config = $config;
        $this->json = $json;
        $this->messageManager = $manager;
        $this->_request = $request;
    }
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
        $this->logger->log('INFO','Refund Observer Working');
        $refundOnWalmartMx = $this->config->getRefundOnWalmartMx();
        $refundSkus = [];
        try {
            if ($refundOnWalmartMx == "1") {
                $postData = $this->_request->getParams();
                if(isset($postData['order_id'])) {
                    $reason = (isset($postData['reason']) && $postData['reason'] != NULL) ? $postData['reason'] : $this->config->getRefundReason();
                    $creditMemo = $observer->getEvent()->getCreditmemo();
                    $creditMemoId = $creditMemo->getIncrementId();
                    $order = $creditMemo->getOrder();
                    $orderIncrementId = $order->getIncrementId();
                    $walmartmxorder = $this->orders->create()->getCollection()->addFieldToFilter('increment_id', $orderIncrementId)->getFirstItem()->getData();
                    if (count($walmartmxorder) <= 0) {
                        return $observer;
                    }
                    if (!$reason) {
                        $this->messageManager->addErrorMessage('WalmartMx Refund Reason is not selected.');
                        return $observer;
                    }
                    $item = array();
                    $cancelOrder = array(
                        'refund' => array(
                            '_attribute' => array(),
                            '_value' => array()
                        )
                    );
                    $walmartmxorder_data = $this->json->jsonDecode($walmartmxorder['order_data']);
                    $walmartmxorder_data = $walmartmxorder_data['order_lines']['order_line'];
                    $order_line_ids = array_column($walmartmxorder_data, 'offer_sku');
                    foreach ($creditMemo->getAllItems() as $orderItems) {
                        $skuFound = array_search($orderItems->getSku(), $order_line_ids);
                        if ($skuFound !== FALSE) {
                            $refundSkus[] = $orderItems->getSku();
                            $item['amount'] = (string)$orderItems->getRowTotal();
                            $item['order_line_id'] = (string)$walmartmxorder_data[$skuFound]['order_line_id'];
                            $item['quantity'] = (string)$orderItems->getQty();
                            $item['reason_code'] = (string)$reason;
                            $item['shipping_amount'] = (string)((float)$walmartmxorder_data[$skuFound]['shipping_price'] / (float)$orderItems->getQty());
                        }
                        array_push($cancelOrder['refund']['_value'], $item);
                    }
                    $response = $this->api->refundOnWalmartMx($orderIncrementId, $cancelOrder, /*$creditMemoId*/
                        $order->getId());

                    $this->logger->info('Refund Observer Data', ['path' => __METHOD__, 'DataToRefund' => json_encode($cancelOrder), 'Response Data' => json_encode($response)]);

                    if (isset($response['body']['refunds'])) {
                        $refundSkus = implode(', ', $refundSkus);
                        $order->addStatusHistoryComment(__("Order Items ( $refundSkus ) Refunded with $reason reason On WalmartMx."))
                            ->setIsCustomerNotified(false)->save();
                        $this->logger->info('Refund Success', ['path' => __METHOD__, 'RefundSkus' => $refundSkus, 'Reason' => $reason, 'Increment Id' => $orderIncrementId]);
                        $this->messageManager->addSuccessMessage('Refund Successfully Generated on WalmartMx');
                    } else {
                        $this->logger->info('Refund Fail', ['path' => __METHOD__, 'DataToRefund' => json_encode($cancelOrder), 'Response Data' => json_encode($response)]);
                        $this->messageManager->addErrorMessage('Error Generating Refund on WalmartMx. Please process from merchant panel.');
                    }
                }
                return $observer;
            }
        } catch (\Exception $e) {
            $this->logger->error('Refund Observer', ['path' => __METHOD__, 'exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return $observer;
        }
        return $observer;
	}
}