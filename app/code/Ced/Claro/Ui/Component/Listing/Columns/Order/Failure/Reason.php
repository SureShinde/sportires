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

namespace Ced\Claro\Ui\Component\Listing\Columns\Order\Failure;

class Reason extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item[$name]) && !empty($item[$name])) {
                    $reasons = $item[$name];
                    $item[$name] = [];
                    $item[$name]['error'] = [
                        'label' => __('View Reasons'),
                        'class' => 'cedcommerce actions error',
                        'popup' => [
                            'title' => __("Claro Order #{$item['claro_order_id']}"),
                            'message' => $reasons,
                            'type' => 'json',
                            'render' => 'html',
                        ],
                    ];
                } else {
                    $item[$name] = [];
                    $item[$name]['error'] = [
                        'label' => __('View Reasons'),
                        'class' => 'cedcommerce actions error disable',
                        'disable' => true
                    ];
                }
            }
        }

        return $dataSource;
    }
}
