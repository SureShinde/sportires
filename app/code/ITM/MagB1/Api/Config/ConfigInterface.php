<?php
namespace ITM\MagB1\Api\Config;

interface ConfigInterface
{

    /**
     * Get Carrier list
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getCarrierList();

    /**
     * Get Carrier list
     *
     * @return \Magento\Framework\Api\SearchResultsInterface
     */
    public function getPaymentMethodList();

    /**
     * reIndex
     *
     * @return null
     */
    public function reIndex();

    /**
     * getVersion
     *
     * @return string
     */
    public function getVersion();
}
