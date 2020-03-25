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
namespace BelVG\ColorOrderStatus\Block\Status\Grid\Column;

/**
 * Class Color
 * @package BelVG\ColorOrderStatus\Block\Status\Grid\Column
 */
class Color extends \Magento\Backend\Block\Widget\Grid\Column
{
    /**
     * Add decorated action to column
     *
     * @return array
     */
    public function getFrameCallback()
    {
        return [$this, 'decorateAction'];
    }

    /**
     * Decorate values to column
     *
     * @param string $value
     * @param \Magento\Sales\Model\Order\Status $row
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @param bool $isExport
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function decorateAction($value, $row, $column, $isExport)
    {
        $cell = '';
        $state = $row->getState();
        if (!empty($state)) {

            if($row->getColor()) {
                $cell = '<span style="width:40px;height:15px;margin-left:5px;display: inline-block;background: '.$row->getColor().'">&nbsp;</span>';
            }
        }

        return $cell;
    }

}
