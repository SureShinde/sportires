<?php
namespace Ced\StorePickup\Block\Adminhtml;
/**
* CedCommerce
*
* NOTICE OF LICENSE
*
* This source file is subject to the End User License Agreement (EULA)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://cedcommerce.com/license-agreement.txt
*
* @category    Ced
* @package     Ced_StorePickup
* @author      CedCommerce Core Team <connect@cedcommerce.com >
* @copyright   Copyright CEDCOMMERCE (https://cedcommerce.com/)
* @license      https://cedcommerce.com/license-agreement.txt
*/
class Stores extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected $_template = 'ced/blog.phtml';

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        $this->setChild(
            'grid',
            $this->getLayout()->createBlock('Ced\StorePickup\Block\Adminhtml\Stores\Stores', 'store.grid')
        );
        return parent::_prepareLayout();
    }


    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }
}