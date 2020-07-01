<?php
 
namespace Morwi\AddressColumn\Model\ResourceModel\Order\Grid;
 
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OriginalCollection;
use Psr\Log\LoggerInterface as Logger;
 
/**
 * Order grid extended collection
 */
class Collection extends OriginalCollection
{
    protected $helper;
 
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable = 'sales_order_grid',
        $resourceModel = \Magento\Sales\Model\ResourceModel\Order::class
    )
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel);
    }
 
    protected function _renderFiltersBefore()
    {
        $joinTable = $this->getTable('sales_order_address');
        $this->getSelect()->joinLeft($joinTable, "main_table.entity_id = sales_order_address.parent_id AND sales_order_address.address_type = 'shipping'", ["CONCAT_WS('',street,',Col.',fax,',',city,', ',region,', ',postcode,', Tel. ',telephone) AS full_address","(SELECT value FROM core_config_data WHERE path like CONCAT('payment/',main_table.payment_method,'/title') LIMIT 1) as pago"]);

        $joinTable = $this->getTable('sales_order_payment');
        $this->getSelect()->joinLeft($joinTable, "main_table.entity_id = sales_order_payment.parent_id AND sales_order_payment.additional_information LIKE '%Meses sin intereses%'", ["SUBSTR(sales_order_payment.additional_information,25,1) AS msi "]);
     
        parent::_renderFiltersBefore();
    }


    
}


