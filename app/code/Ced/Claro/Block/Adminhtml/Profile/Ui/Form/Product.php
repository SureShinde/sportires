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

namespace Ced\Claro\Block\Adminhtml\Profile\Ui\Form;

class Product extends \Magento\Backend\Block\Template
{
    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'Ced_Claro::profile/product.phtml';

    /**
     * @var \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
     */
    protected $blockGrid;

    /**
     * @var \Magento\Framework\Registry
     */
    public $registry;

    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    public $serializer;

    /**
     * Product constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->serializer = $serializer;
    }

    /**
     * Retrieve instance of grid block
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                \Ced\Claro\Block\Adminhtml\Profile\Ui\Form\Product\Grid::class,
                'claro.admin.profile.Product.grid'
            );
        }
        return $this->blockGrid;
    }

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getBlockGrid()->toHtml();
    }

    /**
     * @return string
     */
    public function getProductsJson()
    {
        $products = $this->getProfile()->getProductsPosition();
        $products = [1];
        if (!empty($products)) {
            return $this->serializer->serialize($products);
        }
        return '{}';
    }

    /**
     * @return string
     */
    public function getFilters()
    {
        $filters = '';
        $profileProductFilter = $this->getProfile()->getProfileProductsFilters();
        if (isset($profileProductFilter) && !empty($profileProductFilter)) {
            $filters = $profileProductFilter;
        }
        return $filters;
    }

    /**
     * @return $profile
     */
    public function getProfile()
    {
        return $this->registry->registry('claro_profile');
    }
}
