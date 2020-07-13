<?php

namespace Sportires\Walmart\Observer;

class SubmitObserver
{
    public function beforeExecute($subject, $observer)
    {
        $order = $observer->getEvent()->getOrder();

        if ($order->getShippingDescription() == 'WalmartMx Shipping Method - WalmartMx Shipping Method(Default)') {
            $order->setCanSendNewEmailFlag(false);
        }

        return [$observer];
    }
}