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
/**
 * Created by PhpStorm.
 * User: zyr3x
 * Date: 3.9.18
 * Time: 13.03
 */
namespace BelVG\ColorOrderStatus\Helper;

use Magento\Framework\App\Helper\Context;

/**
 * Class Data
 * @package BelVG\ColorOrderStatus\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Status\Collection
     */
    protected $collection;

    /**
     * @var mixed
     */
    protected $statusColor;

    /**
     * Data constructor.
     * @param Context $context
     * @param \Magento\Sales\Model\ResourceModel\Order\Status\Collection $collection
     */
    public function __construct(
        Context $context,
        \Magento\Sales\Model\ResourceModel\Order\Status\Collection $collection
    ) {
        parent::__construct($context);
        $this->collection = $collection;
    }

    /**
     * @param $status
     * @return string
     */
    public function getStatusColor($status)
    {
        $statues = $this->getColorStatuses();
        return (isset($statues[$status])) ? $statues[$status] : '';
    }

    /**
     * @return mixed
     */
    public function getColorStatuses()
    {
        if (!isset($this->statusColor)) {
            foreach ($this->collection->getItems() as $item) {
                $this->statusColor[$item->getStatus()] = $item->getColor();
            }
        }
        return $this->statusColor;
    }

}