<?php

namespace ITM\MagB1\Observer\Payment;

class MethodIsActive implements \Magento\Framework\Event\ObserverInterface
{
    /**
     *
     * @var \ITM\MagB1\Helper\Data
     */
    private $helper;

    public function __construct( \ITM\MagB1\Helper\Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {

        if(!$this->helper->checkDisabledPaymentMethods()) {
            return;
        }
        $event = $observer->getEvent();
        $method = $event->getMethodInstance();
        $result = $event->getResult();
        
         //if( $method->getCode() == "checkmo") {
        if(in_array($method->getCode(),$this->helper->getDisabledPaymentMethods())) {
             $result["is_available"] = 0;
        }
    }
}

