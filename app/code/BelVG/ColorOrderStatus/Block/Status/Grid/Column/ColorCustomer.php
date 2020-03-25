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
 * Class ColorCustomer
 * @package BelVG\ColorOrderStatus\Block\Status\Grid\Column
 */
class ColorCustomer extends \Magento\Backend\Block\Widget\Grid\Column
{
    protected $rowId = 0;
    /**
     * @var \BelVG\ColorOrderStatus\Helper\Data
     */
    protected $helper;

    protected  $collectionFactory;

    /**
     * ColorCustomer constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \BelVG\ColorOrderStatus\Helper\Data $helper
     * @param array $data
     */
    public function __construct(\Magento\Backend\Block\Template\Context $context,
        \BelVG\ColorOrderStatus\Helper\Data $helper,
        \Magento\Sales\Model\ResourceModel\Order\Grid\CollectionFactory $collectionFactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->helper = $helper;
        $this->collectionFactory = $collectionFactory;
    }

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

        $item = $this->collectionFactory->create()
            ->addFieldToSelect('status')
            ->addFieldToFilter('entity_id',$row->getEntityId())
            ->getFirstItem();

        $color = $this->helper->getStatusColor($item->getStatus());

        $cell = '<span data-init-row="'.$row->getId().'"/><script>
            require(["jquery"],
                function($) {
                 $(".col-'.$column->getId().' [data-init-row='.$row->getId().']")
                 .closest("tr")
                 .find("td") 
                 .css("background","'.$color.'");
                }
            );
            </script>';

        return $cell;
    }

}
