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
 * @category  Ced
 * @package   Ced_Claro
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CedCommerce (http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Ui\Component\Listing\Columns\Product;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'catalog/Product/edit';
    const URL_PATH_VIEW = 'claro/Product/view';

    /**
     * @var UrlBuilder
     */
    protected $actionUrlBuilder;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param  array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    $sku = $item['sku'];
                    $item[$name]['view'] = [
                        'label' => __('View'),
                        'class' => 'cedcommerce actions view',
                        'popup' => [
                            'title' => __("Claro Product #{$sku}"),
                            'file' => $this->urlBuilder->getUrl(
                                self::URL_PATH_VIEW,
                                [
                                    'sku' => $sku,
                                    'type_id' => $item['type_id'],
                                    'id' => $item['entity_id']
                                ]
                            ),
                            'type' => 'json',
                            'render' => 'html',
                        ],
                    ];
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_EDIT, ['id' => $item['entity_id']]),
                        'label' => __('Edit'),
                        'class' => 'cedcommerce actions edit'
                    ];
                }
            }
        }
        return $dataSource;
    }
}
