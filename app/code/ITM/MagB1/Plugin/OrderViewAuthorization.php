<?php
namespace  ITM\MagB1\Plugin;


class OrderViewAuthorization
{

    protected $_helper;

    public function __construct(
        \ITM\MagB1\Helper\Data $helper
    ) {
        $this->_helper = $helper;
    }

   
    public function aroundCanView(
        \Magento\Sales\Controller\AbstractController\OrderViewAuthorization $subject,
        \Closure $proceed,
        $order
    ) {

        if($this->_helper->canViewOrder($order)) {
            return true;
        }
        return $proceed($order);
    }
}