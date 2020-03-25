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




/**
 * @Controller("masterpass")
 */
class Customweb_FirstDataConnect_ExternalCheckout_MasterPass_Endpoint extends Customweb_Payment_ExternalCheckout_AbstractCheckoutEndpoint {
	
	
	/**
	 * @var Customweb_Core_ILogger
	 */
	private $logger;
	
	/**
	 *
	 * @var Customweb_FirstDataConnect_Container
	 */
	private $container;

	public function __construct(Customweb_DependencyInjection_IContainer $container){
		parent::__construct($container);
		$this->container = new Customweb_FirstDataConnect_Container($container);
		$this->logger = Customweb_Core_Logger_Factory::getLogger(get_class($this));
	}

	/**
	 * @Action("redirect")
	 */
	public function redirectAction(Customweb_Core_Http_IRequest $request){
		$context = $this->loadContextFromRequest($request);
		try{
			$this->checkContextTokenInRequest($request, $context);
		}catch(Customweb_Payment_Exception_ExternalCheckoutTokenExpiredException $e) {
			$this->getCheckoutService()->markContextAsFailed($context, $e->getMessage());
			return Customweb_Core_Http_Response::redirect($context->getCartUrl());
		}
		try {
			// We set already here the payment method to be able to access the
			// setting data in the redirection parameter builder.
			$checkoutService = $this->container->getCheckoutService();
			foreach ($checkoutService->getPossiblePaymentMethods($context) as $method) {
				if (strtolower($method->getPaymentMethodName()) == 'masterpass') {
					$checkoutService->updatePaymentMethod($context, $method);
					break;
				}
			}
			
			$templateContext = new Customweb_Mvc_Template_RenderContext();
			$templateContext->setSecurityPolicy(new Customweb_Mvc_Template_SecurityPolicy());
			$templateContext->setTemplate('checkout/masterpass/redirect');
			$templateContext->addVariable('url', 
					Customweb_Core_Url::_($this->container->getConfiguration()->getBaseUrl() . Customweb_FirstDataConnect_IConstants::URL_CONNECT)->toString());
			$token = $this->getSecurityTokenFromRequest($request);
			$templateContext->addVariable('formData', Customweb_Util_Html::buildHiddenInputFields($this->getRedirectionParameters($context, $token)));
			$templateContext->addVariable('redirectionText', Customweb_I18n_Translation::__("You will be redirected in a few seconds to MasterPass."));
			
			$content = $this->getTemplateRenderer()->render($templateContext);
			
			$layoutContext = new Customweb_Mvc_Layout_RenderContext();
			$layoutContext->setTitle('MasterPass: Redirection');
			$layoutContext->setMainContent($content);
			return $this->getLayoutRenderer()->render($layoutContext);
		}
		catch (Exception $e) {
			$this->getCheckoutService()->markContextAsFailed($context, $e->getMessage());
			return Customweb_Core_Http_Response::redirect($context->getCartUrl());
		}
	}

	/**
	 * @Action("update-context")
	 */
	public function updateContextAction(Customweb_Core_Http_IRequest $request){
		$parameters = $request->getParameters();
		$checkoutService = $this->getCheckoutService();
		$this->getTransactionHandler()->beginTransaction();
		$context = $this->loadContextFromRequest($request);
		try{
			$this->checkContextTokenInRequest($request, $context);
		}catch(Customweb_Payment_Exception_ExternalCheckoutTokenExpiredException $e) {
			$this->getCheckoutService()->markContextAsFailed($context, $e->getMessage());
			$this->getTransactionHandler()->commitTransaction();
			return Customweb_Core_Http_Response::redirect($context->getCartUrl());
		}
		try {
			
			if (!isset($parameters['ipgTransactionId']) || !isset($parameters['redirectUrl']) || !isset($parameters['txndatetime'])) {
				$checkoutService->markContextAsFailed($context, Customweb_I18n_Translation::__('Missing requried parameters'));
				$this->getTransactionHandler()->commitTransaction();
				return Customweb_Core_Http_Response::redirect($context->getCartUrl());
			}
			
			$checkoutService->updateProviderData($context, 
					array(
						'ipgTransactionId' => $parameters['ipgTransactionId'],
						'redirectUrl' => $parameters['redirectUrl'] 
					));
			
			$shippingAddress = $this->getShippingAddressFromParameters($parameters);
			$checkoutService->updateShippingAddress($context, $shippingAddress);
			
			$billingAddress = $this->getBillingAddressFromParameters($parameters);
			$checkoutService->updateBillingAddress($context, $billingAddress);
			
			$email= '';
			if(isset($parameters['email'])){
				$email =  trim($parameters['email']);
			}
			
			$this->getTransactionHandler()->commitTransaction();
			
			return $checkoutService->authenticate($context, $email, $this->getConfirmationPageUrl($context, $this->getSecurityTokenFromRequest($request)));
		}
		catch (Exception $e) {
			$this->getCheckoutService()->markContextAsFailed($context, $e->getMessage());
			$this->getTransactionHandler()->commitTransaction();
			return Customweb_Core_Http_Response::redirect($context->getCartUrl());
		}
	}

	/**
	 * @Action("confirmation")
	 */
	public function confirmationAction(Customweb_Core_Http_IRequest $request){
		$context = $this->loadContextFromRequest($request);
		try{
			$this->checkContextTokenInRequest($request, $context);
		}catch(Customweb_Payment_Exception_ExternalCheckoutTokenExpiredException $e) {
			$this->getCheckoutService()->markContextAsFailed($context, $e->getMessage());
			return Customweb_Core_Http_Response::redirect($context->getCartUrl());
		}
		try {
			$checkoutService = $this->getCheckoutService();
			$parameters = $request->getParameters();
			
			$templateContext = new Customweb_Mvc_Template_RenderContext();
			$confirmationErrorMessage = null;
			$shippingMethodErrorMessage = null;
			$additionalFormErrorMessage = null;
			if (isset($parameters['masterpass_update_shipping'])) {
				try {
					$checkoutService->updateShippingMethod($context, $request);
				}
				catch (Exception $e) {
					$shippingMethodErrorMessage = $e->getMessage();
				}
			}
			else if (isset($parameters['masterpass_confirmation'])) {
				try {
					$checkoutService->processAdditionalFormElements($context, $request);
				}
				catch (Exception $e) {
					$additionalFormErrorMessage = $e->getMessage();
				}
				if ($additionalFormErrorMessage === null) {
					try {
						$checkoutService->validateReviewForm($context, $request);
						
						$transaction = $checkoutService->createOrder($context);
						if (!$transaction->isAuthorized() && !$transaction->isAuthorizationFailed()) {
							
							$providerData = $context->getProviderData();
							$parameterBuilder = new Customweb_FirstDataConnect_ExternalCheckout_MasterPass_ConfirmationParameterBuilder($this->getContainer(),
									$transaction, $context->getProviderData());
							$url = $providerData['redirectUrl'];
							$finalUrl = Customweb_Core_Url::_($url)->appendQueryParameters($parameterBuilder->build());
							return Customweb_Core_Http_Response::redirect($finalUrl->toString());
						}
						if ($transaction->isAuthorizationFailed()) {
							$confirmationErrorMessage = current($transaction->getErrorMessages());
						}
						else {
							return Customweb_Core_Http_Response::redirect($transaction->getSuccessUrl());
						}
					}
					catch (Exception $e) {
						$confirmationErrorMessage = $e->getMessage();
					}
				}
			}
			
			$templateContext->setSecurityPolicy(new Customweb_Mvc_Template_SecurityPolicy());
			$templateContext->setTemplate('checkout/masterpass/confirmation');
			
			$templateContext->addVariable('additionalFormElements', 
					$checkoutService->renderAdditionalFormElements($context, $additionalFormErrorMessage));
			$templateContext->addVariable('shippingPane', $checkoutService->renderShippingMethodSelectionPane($context, $shippingMethodErrorMessage));
			$templateContext->addVariable('reviewPane', $checkoutService->renderReviewPane($context, true, $confirmationErrorMessage));
			$templateContext->addVariable('confirmationPageUrl', 
					$this->getConfirmationPageUrl($context, $this->getSecurityTokenFromRequest($request)));
			$templateContext->addVariable('javascript', 
					$this->getAjaxJavascript('.firstdataconnect-masterpass-shipping-pane', '.firstdataconnect-masterpass-confirmation-pane'));
			
			$content = $this->getTemplateRenderer()->render($templateContext);
			
			$layoutContext = new Customweb_Mvc_Layout_RenderContext();
			$layoutContext->setTitle(Customweb_I18n_Translation::__('MasterPass: Order Confirmation'));
			$layoutContext->setMainContent($content);
			return $this->getLayoutRenderer()->render($layoutContext);
		}
		catch (Exception $e) {
			$this->getCheckoutService()->markContextAsFailed($context, $e->getMessage());
			return Customweb_Core_Http_Response::redirect($context->getCartUrl());
		}
	}

	/**
	 * @Action("notification")
	 */
	public function notificationAction(Customweb_Core_Http_IRequest $request){
		$parameters = $request->getParameters();
		$this->getTransactionHandler()->beginTransaction();
		$context = $this->loadContextFromRequest($request);
		try{
			$this->checkContextTokenInRequest($request, $context);
		}catch(Customweb_Payment_Exception_ExternalCheckoutTokenExpiredException $e) {
			//Ignore expired
		}
		if ($context->getState() == Customweb_Payment_ExternalCheckout_IContext::STATE_COMPLETED) {
			$transcationId = $context->getTransactionId();
			$this->logger->logInfo("The notification process has been started for the transaction with id " . $transcationId . ".");
			for ($i = 0; $i < 5; $i++) {
				try {
					$transaction = $this->getTransactionHandler()->findTransactionByTransactionId($transcationId, false);
					if ($transaction->isAuthorizationFailed() || $transaction->isAuthorized()) {
						$this->getTransactionHandler()->commitTransaction();
						return Customweb_Core_Http_Response::_('');
					}
					$authorizationHandler = $this->container->getBean('Customweb_FirstDataConnect_Authorization_AuthorizationHandler');
					$response = $authorizationHandler->handleAuthorizationWithHashCheck($transaction, $parameters);
					$this->getTransactionHandler()->persistTransactionObject($transaction);
					$this->getTransactionHandler()->commitTransaction();
					$this->logger->logInfo("The notification process has been finished for the transaction with id " . $transcationId . ".");
					return $response;
				}
				catch (Customweb_Payment_Exception_OptimisticLockingException $lockingException) {
					$this->getTransactionHandler()->rollbackTransaction();
					if($i == 4){
						$this->logger->logInfo("The notification process has been rolledback for the transaction with id " . $transcationId . ".");
					}
					sleep(1);
				}
			}
			return Customweb_Core_Http_Response::_('')->setStatusCode(500);
		}
		else {
			return new Customweb_Core_Http_Response();
		}
	}

	/**
	 * @Action("success")
	 */
	public function successAction(Customweb_Core_Http_IRequest $request){
		$this->getTransactionHandler()->beginTransaction();
		$context = $this->loadContextFromRequest($request);
		try{
			$this->checkContextTokenInRequest($request, $context);
		}catch(Customweb_Payment_Exception_ExternalCheckoutTokenExpiredException $e) {
			//Ignore Expired
		}
		if ($context->getState() == Customweb_Payment_ExternalCheckout_IContext::STATE_COMPLETED) {
			$transcationId = $context->getTransactionId();
			$transaction = $this->getTransactionHandler()->findTransactionByTransactionId($transcationId, false);
			if ($transaction->isAuthorizationFailed()) {
				return Customweb_Core_Http_Response::redirect($transaction->getFailedUrl());
			}
			else {
				return Customweb_Core_Http_Response::redirect($transaction->getSuccessUrl());
			}
		}
		elseif ($context->getState() == Customweb_Payment_ExternalCheckout_IContext::STATE_FAILED) {
			return Customweb_Core_Http_Response::redirect($context->getCartUrl());
		}
		else {
			throw new Exception(Customweb_I18n_Translation::__('The context is in the wrong state, for this action')->toString());
		}
	}

	/**
	 * @Action("failure")
	 */
	public function failureAction(Customweb_Core_Http_IRequest $request){
		$parameters = $request->getParameters();
		$this->getTransactionHandler()->beginTransaction();
		$context = $this->loadContextFromRequest($request);
		try{
			$this->checkContextTokenInRequest($request, $context);
		}catch(Customweb_Payment_Exception_ExternalCheckoutTokenExpiredException $e) {
			//Ignore Expired
		}
		if ($context->getState() == Customweb_Payment_ExternalCheckout_IContext::STATE_COMPLETED) {
			$transcationId = $context->getTransactionId();
			$this->logger->logInfo("The failure process has been started for the transaction with id " . $transcationId . ".");
			for ($i = 0; $i < 5; $i++) {
				try {
					$transaction = $this->getTransactionHandler()->findTransactionByTransactionId($transcationId, false);
					if ($transaction->isAuthorizationFailed()) {
						$this->getTransactionHandler()->commitTransaction();
						return Customweb_Core_Http_Response::redirect($transaction->getFailedUrl());
					}
					
					$authorizationHandler = $this->container->getBean('Customweb_FirstDataConnect_Authorization_AuthorizationHandler');
					$response = $authorizationHandler->handleFailedTransaction($transaction, $parameters);
					$this->getTransactionHandler()->persistTransactionObject($transaction);
					$this->getTransactionHandler()->commitTransaction();
					$this->logger->logInfo("The failure process has been finished for the transaction with id " . $transcationId . ".");
					return $response;
				}
				catch (Customweb_Payment_Exception_OptimisticLockingException $lockingException) {
					$this->getTransactionHandler()->rollbackTransaction();
					if($i == 4){
						$this->logger->logInfo("The failure process has been rolled back for the transaction with id " . $transcationId . ".");
					}
					sleep(1);
				}
			}
			$transaction = $this->getTransactionHandler()->findTransactionByTransactionId($transcationId, false);
			return Customweb_Core_Http_Response::redirect($transaction->getFailedUrl());
		}
		elseif ($context->getState() == Customweb_Payment_ExternalCheckout_IContext::STATE_FAILED) {
			return Customweb_Core_Http_Response::redirect($context->getCartUrl());
		}
		else {
			try {
				
				$reason = Customweb_I18n_Translation::__('Checkout failed with unknown reason');
				if (isset($parameters['fail_reason'])) {
					$reason = $parameters['fail_reason'];
				}
				$this->getCheckoutService()->markContextAsFailed($context, $reason);
				$this->getTransactionHandler()->commitTransaction();
				return Customweb_Core_Http_Response::redirect($context->getCartUrl());
			}
			catch (Exception $e) {
				return Customweb_Core_Http_Response::redirect($context->getCartUrl());
			}
		}
	}

	private function getConfirmationPageUrl(Customweb_Payment_ExternalCheckout_IContext $context, $token){
		return $this->getUrl('masterpass', 'confirmation', array(
			'context-id' => $context->getContextId(),
			'token' => $token 
		));
	}

	private function getRedirectionParameters(Customweb_Payment_ExternalCheckout_IContext $context, $token){
		$builder = new Customweb_FirstDataConnect_ExternalCheckout_MasterPass_RedirectionParameterBuilder($context, $this->container, $token);
		return $builder->build();
	}

	private function getShippingAddressFromParameters(array $parameters){
		$requiredParamters = array(
			'saddr1',
			'sname',
			'scity',
			'szip',
			'scountry' 
		);
		foreach ($requiredParamters as $parameterName) {
			if (!isset($parameters[$parameterName])) {
				throw new Exception("Parameter $parameterName is missing.");
			}
		}
		
		$names = explode(' ', $parameters['sname'], 2);
		$firstName = $names[0];
		$lastName = $names[0];
		if (isset($names[1])) {
			$lastName = $names[1];
		}
		$shippingAddress = new Customweb_Payment_Authorization_OrderContext_Address_Default();
		// @formatter:off
		$shippingAddress
			->setFirstName($firstName)
			->setLastName($lastName)
			->setStreet($parameters['saddr1'])
			->setCity($parameters['scity'])
			->setCountryIsoCode($parameters['scountry'])
			->setPostCode($parameters['szip']);
		// @formatter:on
		

		if (isset($parameters['sstate'])) {
			$shippingAddress->setState($parameters['sstate']);
		}
		return $shippingAddress;
	}

	private function getBillingAddressFromParameters(array $parameters){
		$requiredParamters = array(
			'baddr1',
			'bname',
			'bcity',
			'bzip',
			'bcountry' 
		);
		foreach ($requiredParamters as $parameterName) {
			if (!isset($parameters[$parameterName])) {
				throw new Exception("Parameter $parameterName is missing.");
			}
		}
		$names = explode(' ', $parameters['bname'], 2);
		$firstName = $names[0];
		$lastName = $names[0];
		if (isset($names[1])) {
			$lastName = $names[1];
		}
		
		$billingAddress = new Customweb_Payment_Authorization_OrderContext_Address_Default();
		// @formatter:off
		$billingAddress
			->setFirstName($firstName)
			->setLastName($lastName)
			->setStreet($parameters['baddr1'])
			->setCity($parameters['bcity'])
			->setCountryIsoCode($parameters['bcountry'])
			->setPostCode($parameters['bzip']);
		// @formatter:on
		if (isset($parameters['bstate'])) {
			$billingAddress->setState($parameters['bstate']);
		}
		return $billingAddress;
	}

	/**
	 *
	 * @return Customweb_FirstDataConnect_Method_Factory
	 */
	protected function getMethodFactory(){
		return $this->getContainer()->getBean('Customweb_FirstDataConnect_Method_Factory');
	}

	protected function getPaymentMethodByTransaction(Customweb_FirstDataConnect_Authorization_Transaction $transaction){
		return $this->getMethodFactory()->getPaymentMethod($transaction->getTransactionContext()->getOrderContext()->getPaymentMethod(), 
				$transaction->getAuthorizationMethod());
	}
}