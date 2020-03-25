<?php

namespace Firstdata\Gateway\Block;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Checkout\Model\Session;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Firstdata\Gateway\Logger\Logger;
use Magento\Framework\App\Response\Http;
use Magento\Sales\Model\Order\Payment\Transaction\Builder as TransactionBuilder;

class Main extends \Magento\Framework\View\Element\Template {

    protected $_objectmanager;
    protected $checkoutSession;
    protected $orderFactory;
    protected $urlBuilder;
    private $logger;
    protected $response;
    protected $config;
    protected $messageManager;
    protected $transactionBuilder;
    protected $inbox;
    protected $_template = 'Firstdata_Gateway::contents.phtml';

    public function __construct(Context $context, Session $checkoutSession, OrderFactory $orderFactory, Logger $logger, Http $response, TransactionBuilder $tb, \Magento\AdminNotification\Model\Inbox $inbox) {


        $this->checkoutSession = $checkoutSession;
        $this->orderFactory = $orderFactory;
        $this->response = $response;
        $this->config = $context->getScopeConfig();
        $this->transactionBuilder = $tb;
        $this->logger = $logger;
        $this->inbox = $inbox;
        $this->urlBuilder = \Magento\Framework\App\ObjectManager::getInstance()
                ->get('Magento\Framework\UrlInterface');
        parent::__construct($context);
    }
}
