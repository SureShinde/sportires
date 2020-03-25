<?php
/**
* CedCommerce
*
* NOTICE OF LICENSE
*
* This source file is subject to the End User License Agreement (EULA)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://cedcommerce.com/license-agreement.txt
*
* @category    Ced
* @package     Ced_StorePickup
* @author      CedCommerce Core Team <connect@cedcommerce.com >
* @copyright   Copyright CEDCOMMERCE (https://cedcommerce.com/)
* @license      https://cedcommerce.com/license-agreement.txt
*/

namespace Ced\StorePickup\Ui\Component;

use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
/**
 * Class ProductActions
 */
class StorePickupName extends Column
{
    protected $escaper;
    protected $systemStore;
    protected $productloader;
    protected $_storeinfo;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Catalog\Model\ProductFactory $productloader,
        \Ced\StorePickup\Model\StoreInfo $storeinfo,
        Escaper $escaper,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $components = [],
        array $data = []
    ) {
        $this->_objectManager = $objectManager;
        $this->escaper = $escaper;
        $this->productloader = $productloader;
        $this->_storeinfo = $storeinfo;
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
                $storeName = '';
                $order = $this->_objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($item['increment_id']);
                if(count($order->getData()) && isset($order['store_pickup_id']) && $order['store_pickup_id']) {
                    $storeData = $this->_storeinfo->load($order['store_pickup_id']);

                    if (count($storeData->getData())) {
                        $storeName = $storeData->getStoreName();
                    }
                }
                $item['store_pickup_id'] = $storeName ;
            }
        }
        return $dataSource;
    }
}