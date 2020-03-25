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
 * Class Sync
 * @package Ced\Claro\Controller\Adminhtml\Order\Shipment
 */
class Sync extends Action
{
    /** @var \Ced\Claro\Helper\Shipment  */
    public $shipment;

    /** @var \Ced\Claro\Model\Source\Order\Shipment\Status  */
    public $options;

    public function __construct(
        Action\Context $context,
        \Ced\Claro\Model\Source\Order\Shipment\Status $options,
        \Ced\Claro\Helper\Shipment $shipment
    ) {
        parent::__construct($context);
        $this->shipment = $shipment;
        $this->options = $options;
    }

    public function execute()
    {
        $orderId = $this->getRequest()->getParam('order_id');
        $shipmentId = $this->getRequest()->getParam('shipment_id');
        $result = [
            'Status' => 'Submitted'
        ];

        if (isset($orderId, $shipmentId)) {
            $shipment = $this->shipment->sync($orderId, $shipmentId);

            if (isset($shipment['Status'])) {
                $result['Status'] = $this->options->getOptionText($shipment['Status']);
            }
        }

        /** @var \Magento\Framework\Controller\Result\Json $response */
        $response = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $response->setData($result);
        return $response;
    }
}
