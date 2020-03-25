<?php
namespace ITM\MagB1\Api\Sales;

interface OrderInterface
{

    /**
     * Return Order Info.
     *
     * @api
     *
     * @param string $increment_id
     *            Left hand operand.
     *            \Magento\Sales\Api\Data\OrderInterface result.
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getOrderInfo($increment_id);
    
    /**
     * Performs persist operations for a specified order.
     *
     * @param \Magento\Sales\Api\Data\OrderInterface $entity The order ID.
     * @return \Magento\Sales\Api\Data\OrderInterface Order interface.
     */
    public function updateOrder(\Magento\Sales\Api\Data\OrderInterface $entity);
    /**
     * Performs persist operations for a specified order.
     *
     * @param \Magento\Sales\Api\Data\OrderInterface $entity The order ID.
     * @return \Magento\Sales\Api\Data\OrderInterface Order interface.
     */
    public function saveOrder(\Magento\Sales\Api\Data\OrderInterface $entity);
    
    /**
     * Lists orders that match specified search criteria.
     *
     * This call returns an array of objects, but detailed information about each object’s attributes might not be
     * included. See http://devdocs.magento.com/codelinks/attributes.html#OrderRepositoryInterface to
     * determine which call to use to get detailed information about all attributes for an object.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria The search criteria.
     * @return \Magento\Sales\Api\Data\OrderSearchResultInterface Order search result interface.
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria The search criteria.
     * @return int  Order count.
     */
    public function getOrderCount(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
