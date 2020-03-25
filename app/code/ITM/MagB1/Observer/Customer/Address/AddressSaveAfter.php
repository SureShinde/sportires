<?php
namespace ITM\MagB1\Observer\Customer\Address;

use Magento\Framework\Event\ObserverInterface;

class AddressSaveAfter implements ObserverInterface
{

    protected $resource;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
            $this->_objectManager = $objectManager;
            $this->resource = $resource;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $address = $observer->getCustomerAddress();
        $customer = $address->getCustomer();
        $customer_id = $customer->getEntityId();

        $updated_at = $address->getUpdatedAt();
        $connection = $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $customer_table = $this->resource->getTableName("customer_entity");

        $connection->update(
            $customer_table,
            ['updated_at' => $updated_at],
            ['entity_id = ?' => $customer_id ]
        );
    }
}
