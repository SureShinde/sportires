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
 * @category  Ced
 * @package   Ced_Claro
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Controller\Adminhtml\Order;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

/**
 *  TODO: dev
 * Class Ship
 * @package Ced\Claro\Controller\Adminhtml\Order
 */
class Ship extends \Magento\Backend\App\Action
{
    /** @var \Magento\Framework\Serialize\SerializerInterface */
    public $serializer;

    public $shipment;

    public $order;

    public $orderFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \Ced\Claro\Helper\Shipment $shipment,
        \Ced\Claro\Model\OrderFactory $model,
        \Ced\Claro\Helper\Order $order
    )
    {
        parent::__construct($context);
        $this->serializer = $serializer;
        $this->shipment = $shipment;

        $this->order = $order;
        $this->orderFactory = $model;
    }

    public function execute()
    {
        $response = [
            'message' => [],
            'success' => false
        ];

        $data = $this->getRequest()->getParams();
        $orderId = $this->getRequest()->getParam('order_id');

        // cleaning data
        if (isset($data['form_key'])) {
            unset($data['form_key']);
        }

        if (isset($data['key'])) {
            unset($data['key']);
        }

        if (isset($data['isAjax'])) {
            unset($data['isAjax']);
        }

        if (!empty($orderId)) {
            /** @var \Ced\Claro\Model\Order $order */
            $order = $this->orderFactory->create()->load($orderId);
        }

        if (isset($data['fulfillments'], $order) && is_array($data['fulfillments'])) {
            $envelope = null;
            foreach ($data['fulfillments'] as $item) {
                $fulfillment = $this->shipment->prepare($item, $envelope);
                if (!isset($fulfillment['errors'])) {
                    $envelope = $fulfillment['envelope'];
                    $feed = $this->shipment->send($fulfillment);
                    $item['shipment_id'] = 'na';
                    $item['errors'] = $fulfillment['errors'];
                    $item['Feed'] = $feed;
                    if (isset($feed['Id'])) {
                        $item['feed_id'] = $feed['Id'];
                        $item['Status'] = \Ced\Claro\Model\Source\Feed\Status::SUBMITTED;
                    } else {
                        $item['feed_id'] = '0';
                        $item['Status'] = \Ced\Claro\Model\Source\Feed\Status::FAILED;
                    }

                    $this->shipment->add('na', $item, $order);

                    $response['message'][] = 'Order shipment sent successfully.';
                    $response['success'] = true;
                } else {
                    $response['message'][] = $fulfillment['errors'];
                }
            }
        }

        if (isset($data['adjustments'], $order) && is_array($data['adjustments'])) {
            foreach ($data['adjustments'] as $item) {
                $adjustment = $this->order->adjust($item);
                if ($adjustment['success'] === true) {
                    $response['message'][] = 'Order adjustment sent successfully.';
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                    $response['message'][] = $adjustment['message'];
                }
            }
        }

        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $result->setData($response);
        return $result;
    }
}
