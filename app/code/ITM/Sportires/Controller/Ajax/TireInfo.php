<?php

namespace ITM\Sportires\Controller\Ajax;

class TireInfo extends \Magento\Framework\App\Action\Action
{
    protected $_collectionFactory;
    protected $resultPageFactory;
    protected $jsonHelper;
    protected $logger;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \ITM\Sportires\Model\ResourceModel\Vehicletire\CollectionFactory $collectionFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        $this->_collectionFactory = $collectionFactory;
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
            $options = [];
            $type = $this->getRequest()->getParam('type');
            $make = $this->getRequest()->getParam('make');
            $year = $this->getRequest()->getParam('year');
            $model = $this->getRequest()->getParam('model');
            $trim = $this->getRequest()->getParam('trim');
            
            if($type== "year") {
                $options = $this->getYears($make);
            }
            if($type== "model") {
                $options = $this->getModels($make, $year);
            }
            if($type== "trim") {
                $options = $this->getTrims($make, $year,$model);
            }
            if($type== "size") {
                $options = $this->getSize($make, $year,$model, $trim);
            }

            return $this->jsonResponse($options);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return $this->jsonResponse($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getYears($make)
    {
        $collection = $this->_collectionFactory->create();
        $collection->addFieldtoSelect("year");
        $collection->addFieldtoFilter("make", $make);
        $collection->getSelect()->group("year");
        $options = [];
        foreach ($collection as $item) {
            $options[] = $item->getYear();
        }
        return $options;
    }
    /**
     * @return string
     */
    public function getModels($make, $year)
    {
        $collection = $this->_collectionFactory->create();
        $collection->addFieldtoSelect("model");
        $collection->addFieldtoFilter("make", $make);
        $collection->addFieldtoFilter("year", $year);
        $collection->getSelect()->group("model");
        $options = [];
        foreach ($collection as $item) {
            $options[] = $item->getModel();
        }
        return $options;
    }
    /**
     * @return string
     */
    public function getTrims($make, $year, $model)
    {

        $collection = $this->_collectionFactory->create();
        $collection->addFieldtoSelect("trim");
        $collection->addFieldtoFilter("make", $make);
        $collection->addFieldtoFilter("year", $year);
        $collection->addFieldtoFilter("model", $model);
        $collection->getSelect()->group("trim");
        $options = [];
        foreach ($collection as $item) {
            $options[] = $item->getTrim();
        }
        return $options;
    }

    /**
     * @return string
     */
    public function getSize($make, $year, $model, $trim)
    {

        $collection = $this->_collectionFactory->create();
        $collection->addFieldtoSelect("front_width");
        $collection->addFieldtoSelect("front_ratio");
        $collection->addFieldtoSelect("front_diameter");
        $collection->addFieldtoFilter("make", $make);
        $collection->addFieldtoFilter("year", $year);
        $collection->addFieldtoFilter("model", $model);
        $collection->addFieldtoFilter("trim", $trim);

       // $collection->getSelect()->group("front_width", "front_ratio", "front_diameter");
        $options = [];
        foreach ($collection as $item) {
            $options[] =  [
                $item->getFrontWidth(),
                $item->getFrontRatio(),
                $item->getFrontDiameter()];

        }
        return $options;
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