/**
 * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 *
 * @category	Customweb
 * @package		Customweb_FirstDataConnectCw
 * 
 */

define([
	'uiComponent',
	'Magento_Checkout/js/model/payment/renderer-list'
], function(
	Component,
	rendererList
) {
	'use strict';
	
	rendererList.push(
			{
			    type: 'firstdataconnectcw_generic',
			    component: 'Customweb_FirstDataConnectCw/js/view/payment/method-renderer/firstdataconnectcw_generic-method'
			},
			{
			    type: 'firstdataconnectcw_creditcard',
			    component: 'Customweb_FirstDataConnectCw/js/view/payment/method-renderer/firstdataconnectcw_creditcard-method'
			},
			{
			    type: 'firstdataconnectcw_mastercard',
			    component: 'Customweb_FirstDataConnectCw/js/view/payment/method-renderer/firstdataconnectcw_mastercard-method'
			},
			{
			    type: 'firstdataconnectcw_visa',
			    component: 'Customweb_FirstDataConnectCw/js/view/payment/method-renderer/firstdataconnectcw_visa-method'
			},
			{
			    type: 'firstdataconnectcw_americanexpress',
			    component: 'Customweb_FirstDataConnectCw/js/view/payment/method-renderer/firstdataconnectcw_americanexpress-method'
			},
			{
			    type: 'firstdataconnectcw_maestro',
			    component: 'Customweb_FirstDataConnectCw/js/view/payment/method-renderer/firstdataconnectcw_maestro-method'
			},
			{
			    type: 'firstdataconnectcw_maestrouk',
			    component: 'Customweb_FirstDataConnectCw/js/view/payment/method-renderer/firstdataconnectcw_maestrouk-method'
			},
			{
			    type: 'firstdataconnectcw_masterpass',
			    component: 'Customweb_FirstDataConnectCw/js/view/payment/method-renderer/firstdataconnectcw_masterpass-method'
			},
			{
			    type: 'firstdataconnectcw_bcmc',
			    component: 'Customweb_FirstDataConnectCw/js/view/payment/method-renderer/firstdataconnectcw_bcmc-method'
			});
	return Component.extend({});
});