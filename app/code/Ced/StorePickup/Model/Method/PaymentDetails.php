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
namespace Ced\StorePickup\Model\Method;

use Magento\Setup\Module\Dependency\Parser\Composer\Json;
/**
 * @codeCoverageIgnoreStart
 */
class PaymentDetails extends \Magento\Checkout\Model\PaymentDetails
{
    /**
     * @{inheritdoc}
     */
    
    protected $_scopeConfig;
    protected $_quote;
    
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $quote
    ) {
        $this->_quote = $quote;
        $this->_scopeConfig = $scopeConfig;
        
    }
    
    public function getPaymentMethods()
    {
        
        $ShipMethod = $this->_quote->getQuote()->getShippingAddress()->getShippingMethod();
        $ShipMethod = substr($ShipMethod, 0, 19);
        $Paymethods = $this->_scopeConfig->getValue('carriers/storepickupshipping/allowed_payment_methods', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $Paymethods= explode(',', $Paymethods);
        $json_obj = $this->getData(self::PAYMENT_METHODS);
        $unset_queue = array();
        if($ShipMethod == 'storepickupshipping') {
            foreach ( $json_obj as $i => $item )
            {
                for($j=0;$j<count($Paymethods);$j++)
                {
                    if (!in_array($item->getCode(), $Paymethods)) {
                        $unset_queue[] = $i;
                    }
                    if($j< (count($Paymethods)-1)) {
                        $j++;
                    }
                }
            }
        
            foreach ( $unset_queue as $index )
            {
                unset($json_obj[$index]);
            }
          
            $json_obj = array_values($json_obj);
            return $json_obj;
        }
        else
        {
            return $this->getData(self::PAYMENT_METHODS);
        }
    }
}