<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Controller\Order;

use Magento\Sales\Controller\OrderInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class History extends \Magento\Sales\Controller\Order\History
{
    /**
     * Customer order history
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {

       /* $om =   \Magento\Framework\App\ObjectManager::getInstance();

        $logger =     $om->create('\ITM\MagB1\Helper\Data');
        print_r ($logger->getCustomerIdsByCardCode());
        exit;
*/

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('My Company Orders'));

        $block = $resultPage->getLayout()->getBlock('customer.account.link.back');
        if ($block) {
            $block->setRefererUrl($this->_redirect->getRefererUrl());
        }
        return $resultPage;

    }
}
