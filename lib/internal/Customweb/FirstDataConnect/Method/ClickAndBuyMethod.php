<?php
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
 */


/**
 * 
 * @author nicoeigenmann
 * @Method(paymentMethods={'ClickAndBuyMethod'})
 */
class Customweb_FirstDataConnect_Method_ClickAndBuyMethod extends Customweb_FirstDataConnect_Method_DefaultMethod {

		
	protected function getBillingParameters(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext, array $formData){
		
		$splitted = Customweb_Util_Address::splitStreet($orderContext->getBillingStreet(), $orderContext->getBillingCountryIsoCode(), $orderContext->getBillingPostCode());
		$xml = 	'<shipping xmlns=\'http://api.clickandbuy.com/webservices/pay_1_0_0/\'><consumer>';
		$xml .= '<firstName>'.$orderContext->getBillingFirstName().'</firstName>';
		$xml .= '<lastName>'.$orderContext->getBillingLastName().'</lastName>';
		$xml .= '<address><street>'.$splitted['street'].'</street>';
		$xml .= '<houseNumber>'.$splitted['street-number'].'</houseNumber>';
		$xml .= '<zip>'.$orderContext->getBillingPostCode().'</zip>';
		$xml .= '<city>'.$orderContext->getBillingCity().'</city>';
		$xml .= '<country>'.$orderContext->getBillingCountryIsoCode().'</country>';
		$xml .= '<state>'.$orderContext->getBillingState().'</state></address></consumer></shipping>';
		
		$parameters = array('cab_billing' => $xml);
			
		return $parameters;
	}
	
	protected function getShippingParameters(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentCustomerContext, array $formData){
		
		$splitted = Customweb_Util_Address::splitStreet($orderContext->getShippingStreet(), $orderContext->getShippingCountryIsoCode(), $orderContext->getShippingPostCode());
		$xml = 	'<shipping xmlns=\'http://api.clickandbuy.com/webservices/pay_1_0_0/\'><consumer>';
		$xml .= '<firstName>'.$orderContext->getShippingFirstName().'</firstName>';
		$xml .= '<lastName>'.$orderContext->getShippingLastName().'</lastName>';
		$xml .= '<address><street>'.$splitted['street'].'</street>';
		$xml .= '<houseNumber>'.$splitted['street-number'].'</houseNumber>';
		$xml .= '<zip>'.$orderContext->getShippingPostCode().'</zip>';
		$xml .= '<city>'.$orderContext->getShippingCity().'</city>';
		$xml .= '<country>'.$orderContext->getShippingCountryIsoCode().'</country>';
		$xml .= '<state>'.$orderContext->getShippingState().'</state></address></consumer></shipping>';
		
		$parameters = array('cab_shipping' => $xml);
			
		return $parameters;
	}
	

}