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

namespace Ced\Claro\Block\Adminhtml\Profile\Ui\Form\Product\Widget\Massaction;

class Extended extends \Magento\Backend\Block\Widget\Grid\Massaction\Extended
{
    protected $_objectManager;
    
    protected $_template = 'Ced_Claro::profile/widget/grid/massaction.phtml';

    public function getSelectedJson()
    {
        return join(",", $this->_getProducts());
    }

    public function _getProducts($isJson = false)
    {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        if ($this->getRequest()->getPost('in_profile_products') != "") {
            return explode(",", $this->getRequest()->getParam('in_profile_products'));
        }
        
        $profileId = $this->getRequest()->getParam('id');
        $productIds = $this->_objectManager->create(\Magento\Catalog\Model\ResourceModel\Product\Collection::class)
            ->addAttributeToFilter(\Ced\Claro\Helper\Product::ATTRIBUTE_CODE_PROFILE_ID, $profileId)
            ->getAllIds();
        if (!empty($productIds)) {
            $products = $this->_objectManager->create(\Magento\Catalog\Model\Product::class)
                ->getCollection()
                ->addAttributeToFilter('visibility', ['neq' => 1])
                ->addAttributeToFilter('type_id', ['simple', 'configurable'])
                ->addFieldToFilter('entity_id', $productIds);
            if ($isJson) {
                $jsonProducts = [];
                foreach ($products as $product) {
                    $jsonProducts[$product->getEntityId()] = 0;
                }
                return $this->_jsonEncoder->encode((object)$jsonProducts);
            } else {
                $jsonProducts = [];
                foreach ($products as $product) {
                    $jsonProducts[$product->getEntityId()] = $product->getEntityId();
                }
                return $jsonProducts;
            }
        } else {
            if ($isJson) {
                return '{}';
            } else {
                return [];
            }
        }
    }

    public function getGridIdsJson()
    {
        if (!$this->getUseSelectAll()) {
            return '';
        }
        /** @var \Magento\Framework\Data\Collection $allIdsCollection */
        $allIdsCollection = clone $this->getParentBlock()->getCollection();
        $gridIds = $allIdsCollection->clear()->setPageSize(0)->getAllIds();
        if (!empty($gridIds)) {
            return join(",", $gridIds);
        }
        return '';
    }
}
