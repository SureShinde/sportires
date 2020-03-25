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

var config = {
    map: {
        '*': {
            "Magento_Checkout/js/model/shipping-save-processor/default": "Ced_StorePickup/js/shipping-save-processor-default-override"
        }
    },
    config: {
        mixins: {
            'Magento_Checkout/js/view/shipping': {
                'Ced_StorePickup/js/shipping-override': true
            }
        }
    }
};