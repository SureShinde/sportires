<?php

/**
 * Copyright � 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Firstdata\Gateway\Model\Adminhtml\Source;

/**
 * Class PaymentAction
 */
class AuthorisationUX implements \Magento\Framework\Option\ArrayInterface {

    /**
     * {@inheritdoc}
     */
    public function toOptionArray() {

        return array(
            array('value' => 'hosted', 'label' => 'Hosted Payment'),
            array('value' => 'hidden', 'label' => 'Hidden Authorisation')
        );
    }

}