<?php

/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Firstdata\Gateway\Model\Adminhtml\Source;

use Magento\Payment\Model\Method\AbstractMethod;

/**
 * Class PaymentAction
 */
class Country implements \Magento\Framework\Option\ArrayInterface {

    /**
     * {@inheritdoc}
     */
    public function toOptionArray() {

        return array(
            array('value' => '', 'label' => 'Please select'),
            array('value' => 'ind', 'label' => 'India'),
            array('value' => 'bra', 'label' => 'Brazil'),
            array('value' => 'arg', 'label' => 'Argentina'),
            array('value' => 'col', 'label' => 'Colombia'),
            array('value' => 'hkg', 'label' => 'Hong Kong'),
            array('value' => 'mex', 'label' => 'Mexico'),
            array('value' => 'gbr', 'label' => 'United Kingdom'),
            array('value' => 'irl', 'label' => 'Ireland'),
            array('value' => 'nld', 'label' => 'Netherlands'),
            array('value' => 'deu', 'label' => 'Germany'),
            array('value' => 'mys', 'label' => 'Malaysia'),
            array('value' => 'sgp', 'label' => 'Singapore'),
            array('value' => 'aus', 'label' => 'Australia'),
        );
    }

}
