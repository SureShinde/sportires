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
 * @copyright   Copyright CEDCOMMERCE (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Ui\Component\Listing\Columns\Profile;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
{
    const URL_PATH_EDIT = 'claro/profile/edit';
    const URL_PATH_PRODUCT_UPLOAD = 'claro/Product/index';
    const URL_PATH_DELETE = 'claro/profile/delete';
    const URL_PATH_SYNC = 'claro/profile/sync';

    /**
     * URL builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    public $urlBuilder;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
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
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_EDIT, ['id' => $item['id']]),
                        'label' => __('Edit'),
                        'class' => 'cedcommerce actions edit'
                    ];

                    $item[$name]['upload'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::URL_PATH_PRODUCT_UPLOAD,
                            [
                                'profile_id' => $item['id'],
                            ]
                        ),
                        'label' => __('Upload Products'),
                        'class' => 'cedcommerce actions upload'
                    ];

                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['id' => $item['id']]),
                        'label' => __('Delete'),
                        'title' => __('Profile') . ' #' . $item['id'],
                        'confirm' => [
                            'title' => __('Delete feed') . ' #' . $item['id'],
                            'message' => __('Are you sure you want to delete the profile?')
                        ],
                        'class' => 'cedcommerce actions delete'
                    ];
                }
            }
        }
        return $dataSource;
    }
}
