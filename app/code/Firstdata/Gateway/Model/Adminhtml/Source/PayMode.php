<?php

/**
 * Copyright � 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Firstdata\Gateway\Model\Adminhtml\Source;

use Magento\Payment\Model\Method\AbstractMethod;

/**
 * Class PaymentAction
 */
class PayMode implements \Magento\Framework\Option\ArrayInterface {

    /**
     * {@inheritdoc}
     */
    public function toOptionArray() {

        return array(
            array('value' => 'payonly', 'label' => 'PayOnly'),
            array('value' => 'payplus', 'label' => 'PayPlus'),
            array('value' => 'fullpay', 'label' => 'FullPay'),
        );
    }

}