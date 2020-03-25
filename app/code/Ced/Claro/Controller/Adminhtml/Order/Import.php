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

/**
 * Class Import
 * @package Ced\Claro\Controller\Adminhtml\Order
 */
class Import extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    public $resultRedirectFactory;

    /**
     * @var \Ced\Claro\Helper\Order
     */
    public $order;

    /**
     * Fetch constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     * @param \Ced\Claro\Helper\Order $orderHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        \Ced\Claro\Helper\Order $orderHelper
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->order = $orderHelper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $orderId = trim((string)$this->getRequest()->getParam('order_id', ''));
        $status = $this->getRequest()->getParam('status', \Ced\Claro\Model\Source\Order\Status::PENDING);
        /*$shippingStatus = $this->getRequest()->getParam(
            'shipping_status',
            \Ced\Claro\Model\Source\Order\Shipment\Status::PENDING
        );*/
        /*$orderDate = trim((string)$this->getRequest()->getParam('created_after', ''));*/

        $status = $this->order->import($orderId, $status/*, $shippingStatus, $orderDate*/);
        if ($status) {
            $this->messageManager->addSuccessMessage((string)$status . ' New orders imported from Claro.');
        } else {
            $this->messageManager->addNoticeMessage('No new orders are imported.');
        }

        $result = $this->resultRedirectFactory->create();
        $result->setPath('claro/order/index');
        return $result;
    }
}
