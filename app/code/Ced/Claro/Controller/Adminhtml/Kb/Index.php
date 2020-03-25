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
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Controller\Adminhtml\Kb;

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
     * Product action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /*$mdskus = [
            '82236','22905','15696','80364'
            ];
        //echo count($mdskus);die();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $ids = $objectManager->create('\Magento\Catalog\Model\Product')
            ->getCollection()
            ->addFieldToFilter('sku', ['in' => $mdskus])
            ->getAllIds();
        foreach ($ids as $id) {
            $product = $objectManager->create('\Magento\Catalog\Model\Product')->load($id);
            $metaDesc = $product->getmeta_description();
            $sku = $product->getsku();
            $data = substr($sku . '-' . $metaDesc,0, 150);
            $product->setdata('meta_description', $data)->save();
        }
        //echo "<pre>";print_r($metaDesc);
        die('done');*/
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        return $resultPage;
    }
}
