<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_AbandonedCart
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\AbandonedCart\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\View\Result\PageFactory;
use Mageplaza\AbandonedCart\Model\AbandonedCart as AbandonedCartModel;
use Mageplaza\AbandonedCart\Model\LogsFactory;
use Mageplaza\AbandonedCart\Model\ResourceModel\Logs;
use Psr\Log\LoggerInterface;

/**
 * Class AbandonedCart
 * @package Mageplaza\AbandonedCart\Controller\Adminhtml
 */
abstract class AbandonedCart extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Mageplaza_AbandonedCart::abandonedcart';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Mageplaza\AbandonedCart\Model\ResourceModel\Logs
     */
    protected $abandonedCartLog;

    /**
     * @var \Mageplaza\AbandonedCart\Model\LogsFactory
     */
    protected $logsFactory;

    /**
     * @var \Mageplaza\AbandonedCart\Model\AbandonedCart
     */
    protected $abandonedCartModel;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Mageplaza\AbandonedCart\Model\ResourceModel\Logs $abandonedCartLog
     * @param \Mageplaza\AbandonedCart\Model\LogsFactory $logsFactory
     * @param \Mageplaza\AbandonedCart\Model\AbandonedCart $abandonedCartModel
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Data $jsonHelper,
        LoggerInterface $logger,
        Logs $abandonedCartLog,
        LogsFactory $logsFactory,
        AbandonedCartModel $abandonedCartModel
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
        $this->abandonedCartLog = $abandonedCartLog;
        $this->logsFactory = $logsFactory;
        $this->abandonedCartModel = $abandonedCartModel;
    }

    /**
     * Initiate action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Mageplaza_AbandonedCart::abandonedcart');
        $resultPage->addBreadcrumb(__('AbandonedCart'), __('AbandonedCart'));

        return $resultPage;
    }
}
