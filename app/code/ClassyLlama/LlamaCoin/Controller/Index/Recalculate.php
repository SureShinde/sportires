<?php
declare(strict_types=1);

namespace ClassyLlama\LlamaCoin\Controller\Index;

class Recalculate extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $jsonHelper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
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
        try {

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
            $cartObject = $objectManager->get('\Magento\Checkout\Model\Cart');
            $checkoutSession = $objectManager->get('\Magento\Checkout\Model\Session');
            $cartRepository = $objectManager->get('\Magento\Quote\Api\CartRepositoryInterface');

            $newPrice = $objectManager->get('ClassyLlama\LlamaCoin\Block\Index\Index');
            $productsObject = $cartObject->getQuote()->getAllVisibleItems();
            $quoteId = $cartObject->getQuote()->getId();

            $meses = $this->getRequest()->getParam('meses');

            $cartItems = array();
            foreach ($productsObject as $item) {
                $cartItems[] = $item->getItemId();
                $customPriceValue = $newPrice->recalculateCostInQuote($item->getProductId(),$meses);
                $customprice = $checkoutSession->getQuote()->getItemById($item->getItemId());
                $customprice->setCustomPrice($customPriceValue);
                $customprice->setOriginalCustomPrice($customPriceValue);
                $customprice->save();

            }
        
                   
                $quote = $cartRepository->get($quoteId);
                $cartRepository->save($quote->collectTotals());


            return $this->jsonResponse(json_encode($cartItems));
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

