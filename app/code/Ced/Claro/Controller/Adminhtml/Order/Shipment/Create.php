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

namespace Ced\Claro\Controller\Adminhtml\Order\Shipment;

use Magento\Backend\App\Action;

/**
 * Class Create
 * @package Ced\Claro\Controller\Adminhtml\Order\Shipment
 */
class Create extends Action
{
    /**
     * @var \Ced\Claro\Model\ResourceModel\Order\CollectionFactory
     */
    public $mporders;

    public $orders;

    /** @var \Ced\Claro\Helper\Shipment */
    public $shipment;

    /**
     * Create constructor.
     * @param Action\Context $context
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     * @param \Ced\Claro\Model\ResourceModel\Order\CollectionFactory $mporderCollectionFactory
     * @param \Ced\Claro\Helper\Shipment $shipment
     */
    public function __construct(
        Action\Context $context,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Ced\Claro\Model\ResourceModel\Order\CollectionFactory $mporderCollectionFactory,
        \Ced\Claro\Helper\Shipment $shipment
    ) {
        parent::__construct($context);
        $this->orders = $orderCollectionFactory;
        $this->mporders = $mporderCollectionFactory;
        $this->shipment = $shipment;
    }

    public function execute()
    {
        $synced = 0;
        /** @var \Ced\Claro\Model\ResourceModel\Order\Collection $mporders */
        $mporders = $this->mporders->create()
            ->addFieldToFilter(
                \Ced\Claro\Model\Order::COLUMN_STATUS,
                ['neq' => \Ced\Claro\Model\Source\Order\Status::CONFIRMED]
            );

        $mporderIds = $mporders->getColumnValues(\Ced\Claro\Model\Order::COLUMN_MARKETPLACE_ORDER_ID);

        /** @var \Magento\Sales\Model\ResourceModel\Order\Collection $orders */
        $orders =  $this->orders->create()
            ->addFieldToFilter('entity_id', ['in' => $mporderIds]);

        if (isset($orders) && $orders->getSize() > 0) {
            /** @var \Magento\Sales\Model\Order $order */
            foreach ($orders as $order) {
                /** @var \Magento\Framework\DataObject|null $mporder */
                $mporder = $mporders->getItemByColumnValue(
                    \Ced\Claro\Model\Order::COLUMN_MARKETPLACE_ORDER_ID,
                    $order->getId()
                );

                /** @var \Magento\Sales\Model\ResourceModel\Order\Shipment\Collection|false $shipments */
                $shipments = $order->getShipmentsCollection();
                if (!empty($shipments)) {
                    /** @var \Magento\Sales\Model\Order\Shipment $shipment */
                    foreach ($shipments as $shipment) {
                        /** @var array $mpshipment */
                        $mpshipment = $this->shipment->get(
                            $mporder->getData(\Ced\Claro\Model\Order::COLUMN_ID),
                            $shipment->getId(),
                            $mporder
                        );

                        if (empty($mpshipment)) {
                            $synced++;
                            $this->shipment->create($shipment);
                        }
                    }
                }
            }
        }

        $this->messageManager->addSuccessMessage("{$synced} shipment(s) synced successfully.");

        /** @var \Magento\Framework\Controller\Result\Redirect $response */
        $response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $response->setPath('*/*/listorder');
        return $response;
    }
}
