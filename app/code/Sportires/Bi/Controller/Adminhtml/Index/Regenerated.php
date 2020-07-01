<?php
declare(strict_types=1);

namespace Sportires\Bi\Controller\Adminhtml\Index;

class Regenerated extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context  $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $block = $objectManager->get('Sportires\Bi\Block\Adminhtml\Index\Index');
        $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();

        try {
            $paramRex = $this->getRequest()->getParam('data');
            switch($paramRex){
                case 't10ms':
                    $response = $block->getProductsMostSales($this->getRequest()->getParam('days'));
                break;
                case 'sdp':
                    $response = $block->getDetailBySku($this->getRequest()->getParam('sku'),$this->getRequest()->getParam('days'));
                break;  
                case 'do':
                    $response = array('li' => $block->getOrdersNumber($this->getRequest()->getParam('sku'),$this->getRequest()->getParam('date'),$this->getRequest()->getParam('pay')));
                break;              
            }

            return $this->jsonResponse($response);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return $this->jsonResponse($e->getMessage());
        }
    }

    /**
     * Create json response
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }
}

