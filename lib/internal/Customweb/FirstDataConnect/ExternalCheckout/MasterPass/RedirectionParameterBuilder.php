<?php

/**
 *  * You are allowed to use this API in your web application.
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


class Customweb_FirstDataConnect_ExternalCheckout_MasterPass_RedirectionParameterBuilder extends Customweb_FirstDataConnect_AbstractParameterBuilder {
	
	/**
	 *
	 * @var Customweb_Payment_ExternalCheckout_IContext
	 */
	private $context;
	private $token;

	public function __construct(Customweb_Payment_ExternalCheckout_IContext $context, Customweb_DependencyInjection_IContainer $container, $token){
		parent::__construct($container);
		$this->context = $context;
		$this->token = $token;
	}

	protected function getCheckoutContext(){
		return $this->context;
	}

	protected function getToken(){
		return $this->token;
	}

	protected function getPaymentMethod(){
		$factory = $this->getContainer()->getBean('Customweb_FirstDataConnect_Method_Factory');
		return $factory->getPaymentMethod($this->getCheckoutContext()->getPaymentMethod(), 
				Customweb_Payment_ExternalCheckout_IProviderService::AUTHORIZATION_METHOD_NAME);
	}

	/**
	 *
	 * @return array
	 */
	public function build(){
		$parameters = array_merge($this->getPaymentParameters(), $this->getStoreId(), $this->getReactionUrlParameters(), 
				$this->getTimeParameters(), $this->getOperationModeParameter(), $this->getCustomerIdParameter(), $this->getLanguageParameter());
	
		if($this->getConfiguration()->isResponsivePamentPage()) {
			$parameters['mobileMode'] = 'true';
		}
		$parameters['hash_algorithm'] = 'SHA256';
		$parameters['hashExtended'] = Customweb_FirstDataConnect_Util::calculateExtendedHash($parameters,$this->getConfiguration()->getConnectSharedSecret());
		return $parameters;
	}

	protected function getPaymentParameters(){
		$parameters = array();
		$parameters['chargetotal'] = Customweb_Util_Currency::formatAmount($this->getCheckoutContext()->getOrderAmountInDecimals(), 
				$this->getCheckoutContext()->getCurrencyCode());
		$parameters['currency'] = Customweb_FirstDataConnect_Util::getNumericCurrencyCode($this->getCheckoutContext()->getCurrencyCode());
		return $parameters;
	}

	protected function getReactionUrlParameters(){
		return array(
			'transactionNotificationURL' =>$this->getContainer()->getEndpointAdapter()->getUrl("masterpass", "notification", 
					array(
						'context-id' => $this->getCheckoutContext()->getContextId(),
						'token' => $this->getToken() 
					)), 
			
			'responseSuccessURL' => $this->getContainer()->getEndpointAdapter()->getUrl("masterpass", "success", 
					array(
						'context-id' => $this->getCheckoutContext()->getContextId(),
						'token' => $this->getToken() 
					)),

			'responseFailURL' => $this->getContainer()->getEndpointAdapter()->getUrl("masterpass", "failure", 
					array(
						'context-id' => $this->getCheckoutContext()->getContextId(),
						'token' => $this->getToken() 
					)),
			
			'reviewURL' => $this->getContainer()->getEndpointAdapter()->getUrl("masterpass", "update-context", 
					array(
						'context-id' => $this->getCheckoutContext()->getContextId(),
						'token' => $this->getToken() 
					)),
		);
	}

	protected function getOperationModeParameter(){
		$paymentMethod = $this->getPaymentMethod();
		$capturingMode = $paymentMethod->getPaymentMethodConfigurationValue('capturing');
		$captureType = Customweb_FirstDataConnect_IConstants::OPERATION_SALE;
		if (strtolower($capturingMode) == 'deferred') {
			$captureType = Customweb_FirstDataConnect_IConstants::OPERATION_AUTHORISATION;
		}
		return array(
			'txntype' => $captureType,
			'mode' => Customweb_FirstDataConnect_IConstants::DATA_ALL,
			'reviewOrder' => 'true',
			'paymentMethod' => $this->getPaymentMethod()->getPaymentType(),
		);
	}

	protected function getCustomerIdParameter(){
		$parameters = array();
		if ($this->getCheckoutContext()->getCustomerId() != null) {
			$parameters['customerid'] = $this->getCheckoutContext()->getCustomerId();
		}
		return $parameters;
	}

	protected function getLanguageParameter(){
		$parameter = array();
		$language = Customweb_Core_Util_Language::getCleanLanguageCode($this->getCheckoutContext()->getLanguage(), 
				Customweb_FirstDataConnect_Util::$supportedLanguages);
		$parameter['language'] = $language;
		return $parameter;
	}


}
	