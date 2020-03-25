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

namespace Ced\StorePickup\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
class Predispatch  implements ObserverInterface
{
    protected $_feed;
    protected $_backendAuthSession;
    protected $_objectManager;
    
    public function __construct(
        \Ced\StorePickup\Model\Feed $_feed,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        \Magento\Backend\Model\Auth\Session $backendAuthSession
    ) {
        $this->_feed = $_feed;
        $this->_backendAuthSession = $backendAuthSession;
        $this->_objectManager = $objectInterface;
    }

    
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_backendAuthSession->isLoggedIn()) {
            $this->_feed->checkUpdate();
    
        }
        return $this;
    }
}
