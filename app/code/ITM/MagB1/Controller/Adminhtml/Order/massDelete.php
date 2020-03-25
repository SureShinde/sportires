<?php
/**
 * Copyright � 2015 Magento.
 * All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Controller\Adminhtml\Order;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\DeploymentConfig;

class massDelete extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
{

    protected $_helper;

    public function __construct(
        Context $context,
        ResourceConnection $resource,
        Filter $filter,
        CollectionFactory $collectionFactory,
        DeploymentConfig $deploymentConfig,
        \ITM\MagB1\Helper\Data $helper
    ) {
        $this->_resource = $resource;
        parent::__construct($context, $filter);
        $this->deploymentConfig = $deploymentConfig;
        $this->collectionFactory = $collectionFactory;
        $this->_helper = $helper;
        
    }

    /**
     * Delete selected orders
     * 
     * @param AbstractCollection $collection            
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        if($this->_helper->allowDeleteOrders()) {


            $countDeleteOrder = 0;
            foreach ($collection->getItems() as $order) {
                $order->delete();
                $countDeleteOrder++;
            }
            $countNonDeleteOrder = $collection->count() - $countDeleteOrder;

            if ($countNonDeleteOrder && $countDeleteOrder) {
                $this->messageManager->addError(__('%1 order(s) have not deleted.', $countNonDeleteOrder));
            } elseif ($countNonDeleteOrder) {
                $this->messageManager->addError(__('No order(s) have been deleted.'));
            }

            if ($countDeleteOrder) {
                $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $countDeleteOrder));
            }
        }else {
            $this->messageManager->addError(__('This action is not allowed for current user, please contact your administrator.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->getComponentRefererUrl());
        return $resultRedirect;
    }
}