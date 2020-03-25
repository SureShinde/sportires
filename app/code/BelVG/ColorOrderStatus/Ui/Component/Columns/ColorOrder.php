<?php
/**
 * BelVG LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 *
 ********************************************************************
 * @category   BelVG
 * @package    BelVG_ColorOrderStatus
 * @copyright  Copyright (c) BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */
namespace BelVG\ColorOrderStatus\Ui\Component\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponentInterface;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class ColorOrder
 * @package BelVG\ColorOrderStatus\Ui\Component\Columns
 */
class ColorOrder extends Column
{

    /**
     * @var mixed
     */
    protected $_helper;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    )
    {
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
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['status']) && !empty($item['status'])) {
                    $item['color_order'] = $this->getColor($item['status']);
                }
            }
        }
        return $dataSource;
    }

    /**
     * @param $status
     * @return string
     */
    protected function getColor($status)
    {
        if(!$this->_helper)
            $this->_helper =  \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\BelVG\ColorOrderStatus\Helper\Data::class);
        return   $this->_helper->getStatusColor($status);
    }
}