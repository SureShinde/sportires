<?php


namespace ITM\MagB1\Block;


class AllOrdersLink extends \Magento\Framework\View\Element\Html\Link\Current
{
    /*
     * var \ITM\MagB1\Helper\Data
     */

    protected $helper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\DefaultPathInterface $defaultPath
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\DefaultPathInterface $defaultPath,
        \ITM\MagB1\Helper\Data $helper,
        array $data = []

    ) {
        $this->helper = $helper;
        parent::__construct($context, $defaultPath, $data);
    }

    protected function _toHtml()
    {

        if(!$this->helper->displayAllOrders()) {
            return;
        }
        return parent::_toHtml();

        /*if ($this->getPath()== "outstanding_payments/index" ) {
            return parent::_toHtml();
        }*/

    }
}