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
 * @category  Ced
 * @package   Ced_StorePickup
 * @author    CedCommerce Core Team <connect@cedcommerce.com >
 * @copyright Copyright CEDCOMMERCE (https://cedcommerce.com/)
 * @license      https://cedcommerce.com/license-agreement.txt
 */
namespace Ced\StorePickup\Model\Source;

use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Payment\Model\Config;

class Paymethods implements \Magento\Framework\Option\ArrayInterface
{
    protected $_appConfigScopeConfigInterface;

    protected $_paymentModelConfig;

    public function __construct(
        ScopeConfigInterface $appConfigScopeConfigInterface,
        Config $paymentModelConfig
    ) {
    
        $this->_appConfigScopeConfigInterface = $appConfigScopeConfigInterface;
        $this->_paymentModelConfig = $paymentModelConfig;
    }

    public function toOptionArray()
    {
        $payments = $this->_paymentModelConfig->getActiveMethods();
        $methods = array();
        foreach ($payments as $paymentCode=>$paymentModel)
        {
            $paymentTitle = $this->_appConfigScopeConfigInterface->getValue('payment/'.$paymentCode.'/title');
            if($paymentCode == 'free'){
                continue;
            }
            else{
                $methods[$paymentCode] = array(
                'label' => $paymentTitle,
                'value' => $paymentCode
                );
            }
        }
        return $methods;
    }
}
