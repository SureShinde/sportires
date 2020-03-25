<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_Amazon
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Amazon\Controller\Adminhtml\Kb;

use Ced\Amazon\Api\Data\Order\Import\ResultInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    public $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
//        $now = date("Y-m-d H:m:s");
//        $start = date('Y-m-d H:m:s', strtotime('-1 days', strtotime($now)));
//        /** @var \Ced\Amazon\Model\ResourceModel\Order\Collection $collection */
//        $collection = $this->_objectManager->create(\Ced\Amazon\Model\ResourceModel\Order\Collection::class);
//        $collection->addFieldToFilter(
//            \Ced\Amazon\Model\Order::COLUMN_MAGENTO_ORDER_ID,
//            [['null' => true],['eq' => ""]]
//        );
//        $collection->addFieldToFilter(
//            \Ced\Amazon\Model\Order::COLUMN_CREATED_AT,
//            ['from' => $start, 'to' => $now]
//        );
//        $collection->setPageSize(50);
//        foreach ([1] as $i) {
//            $collection->clear();
//            $collection->setCurPage($i);
//            $collection->load();
//            $amazonOrderId = $collection->getColumnValues(\Ced\Amazon\Model\Order::COLUMN_PO_ID);
//            /** @var \Ced\Amazon\Api\Data\Order\Import\ParamsInterface $params */
//            $params = $this->_objectManager->create(\Ced\Amazon\Api\Data\Order\Import\ParamsInterface::class);
//            $params->setCreate(true)
//                ->setAmazonOrderId($amazonOrderId)
//                ->setAccountIds([4]);
//
//            /** @var \Ced\Amazon\Api\Service\OrderServiceInterface $service */
//            $service = $this->_objectManager->create(\Ced\Amazon\Api\Service\OrderServiceInterface::class);
//            /** @var ResultInterface $ir */
//            $ir = $service->import($params);
//            echo "<pre>";
//            var_dump($ir->getParams()->getData());
//            var_dump($ir->getOrderTotal());
//            var_dump($ir->getOrderImportedTotal());
//            var_dump($ir->getIds());
//        }
//        die;

       //        $stock = $this->_objectManager->create(\Ced\Amazon\Service\Stock\Resolver::class)->resolve();
//        $stock->updateBySku("BTSP-850-BLK", 100);
//        die;
//        /** @var \Ced\Amazon\Api\Data\Order\Import\ParamsInterface $params */
//        $params = $this->_objectManager->create(\Ced\Amazon\Api\Data\Order\Import\ParamsInterface::class);
//        $params->setPath("/opt/lampp7.2/htdocs/magento/2.3/var/amazon/report/_get_amazon_fulfilled_shipments_data_-4-.tsv")
//            ->setMode(\Ced\Amazon\Api\Data\Order\Import\ParamsInterface::IMPORT_MODE_REPORT)
//            ->setCreate(true)
//            ->setAccountIds([4])
//            ->setCliLimit(2);
//
//        /** @var \Ced\Amazon\Api\Service\OrderServiceInterface $service */
//        $service = $this->_objectManager->create(\Ced\Amazon\Api\Service\OrderServiceInterface::class);
//        /** @var ResultInterface $ir */
//        $ir = $service->import($params);
//        echo "<pre>";
//        var_dump($ir->getParams()->getData());
//        var_dump($ir->getOrderTotal());
//        var_dump($ir->getOrderImportedTotal());
//        var_dump($ir->getIds());
//        die;

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ced_Amazon::amazon');
        $resultPage->getConfig()->getTitle()->prepend(__('Amazon Kb'));
        return $resultPage;
    }
}
