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

namespace Ced\Claro\Ui\Component\Listing\Columns\Product;

class Errors extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    public $urlBuilder;

    /**
     * @var \Magento\Framework\Serialize\SerializerInterface $serializer
     */
    public $serializer;

    /**
     * ProductValidation constructor.
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\Serialize\SerializerInterface  $json
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        $components = [],
        $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->serializer = $serializer;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
//        echo "<pre>";print_r($dataSource);echo "</pre>";die('oooooooooo');
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item[$fieldName])) {
                    if ($item[$fieldName] == '["valid"]') {
                        $item[$fieldName . '_html'] =
                            "<td class='cedcommerce errors'><div class='grid-severity-notice'><span>valid</span></div>";
                        $item[$fieldName . '_title'] = __('Errors');
                        $item[$fieldName . '_productid'] = $item['entity_id'];
                    } else {
                        $item[$fieldName . '_html'] =
                            "<div class='grid-severity-critical'><span>invalid</span></div>";
                        $item[$fieldName . '_title'] = __('Errors');
                        $item[$fieldName . '_productid'] = $item['entity_id'];
                        $item[$fieldName . '_productvalidation'] = $item[$fieldName];
                    }
                } else {
                    $item[$fieldName . '_html'] =
                        "<div class='grid-severity-notice'><span>not validated</span></div>";
                    $item[$fieldName . '_title'] = __('Errors');
                    $item[$fieldName . '_productid'] = $item['entity_id'];
                }
            }
        }
        return $dataSource;
    }
}
