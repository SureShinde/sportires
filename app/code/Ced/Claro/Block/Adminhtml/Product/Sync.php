<?php
/**
 * Created by PhpStorm.
 * User: cedcoss
 * Date: 6/6/18
 * Time: 7:54 PM
 */
namespace Ced\Claro\Block\Adminhtml\Product;

class Sync extends \Magento\Backend\Block\Template
{
    /**
     * Object Manger
     * @var  \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public $objectManager;

    /**
     * Registry
     * @var \Magento\Framework\Registry
     */
    public $registry;

    /**
     * Product Ids
     * @var $productids
     */
    public $productids;

    /**
     * Constructor
     * @param  \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Backend\Block\Template\Context $context
     * @param string|[] $data
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        $data = []
    ) {
        $this->objectManager = $objectManager;
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->productids = $this->registry->registry('productids');
    }

    public function getActionUrl(){
        return $this->getUrl('claro/product/sync');
    }

    public function  getMassage(){
        return 'Product Ids Imported Successfully ';
    }
}