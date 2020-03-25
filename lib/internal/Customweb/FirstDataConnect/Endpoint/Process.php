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
 *
 * @author Thomas Hunziker
 * @Controller("process")
 *
 */
class Customweb_FirstDataConnect_Endpoint_Process extends Customweb_Payment_Endpoint_Controller_Abstract {

	
	/**
	 * @var Customweb_Core_ILogger
	 */
	private $logger;
	
	/**
	 * @param Customweb_DependencyInjection_IContainer $container
	 */
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		parent::__construct($container);
		$this->logger = Customweb_Core_Logger_Factory::getLogger(get_class($this));
	}
	
	/**
	 * @Action("failed")
	 */
	public function failed(Customweb_Core_Http_IRequest $request){
		$loadedId = $this->getTransactionId($request);
		$externalTransactionId = $loadedId['id'];
		$this->logger->logInfo("The failed process has been started for the transaction with external transaction id " . $externalTransactionId . ".");
		for ($i = 0; $i < 5; $i++) {
			try {
				$this->getTransactionHandler()->beginTransaction();
				$transaction = $this->getTransactionHandler()->findTransactionByTransactionExternalId($externalTransactionId, false);
				if ($transaction->isAuthorizationFailed()) {
					$this->getTransactionHandler()->commitTransaction();
					$this->logger->logInfo("The failed process has been finished for the transaction with external transaction id " . $externalTransactionId . ".");
					return Customweb_Core_Http_Response::redirect($transaction->getFailedUrl());
				}
				
				$adapter = $this->getAdapterFactory()->getAuthorizationAdapterByName($transaction->getAuthorizationMethod());
				$parameters = $request->getParameters();
				$response = $adapter->handleFailedTransaction($transaction, $parameters);
				$this->getTransactionHandler()->persistTransactionObject($transaction);
				$this->getTransactionHandler()->commitTransaction();
				$this->logger->logInfo("The failed process has been finished for the transaction with external transaction id " . $externalTransactionId . ".");
				return $response;
			}
			catch (Customweb_Payment_Exception_OptimisticLockingException $lockingException) {
				$this->getTransactionHandler()->rollbackTransaction();
				if($i == 4){
					throw $lockingException;
				}
				sleep(1);
			}
		}
		$transaction = $this->getTransactionHandler()->findTransactionByTransactionExternalId($externalTransactionId, false);
		$this->logger->logInfo("The failed process has been finished for the transaction with external transaction id " . $externalTransactionId . ".");
		return Customweb_Core_Http_Response::redirect($transaction->getFailedUrl());
	}

	/**
	 * @Action("index")
	 */
	public function process(Customweb_Core_Http_IRequest $request){
		$loadedId = $this->getTransactionId($request);
		$externalTransactionId = $loadedId['id'];
		$this->logger->logInfo("The notification process has been started for the transaction with external transaction id " . $externalTransactionId . ".");
		for ($i = 0; $i < 5; $i++) {
			try {
				$this->getTransactionHandler()->beginTransaction();
				$transaction = $this->getTransactionHandler()->findTransactionByTransactionExternalId($externalTransactionId, false);
				if ($transaction->isAuthorizationFailed() || $transaction->isAuthorized()) {
					$this->getTransactionHandler()->commitTransaction();
					$this->logger->logInfo("The notification process has been finished for the transaction with external transaction id " . $externalTransactionId . ".");
					return Customweb_Core_Http_Response::_('');
				}
				$adapter = $this->getAdapterFactory()->getAuthorizationAdapterByName($transaction->getAuthorizationMethod());
				$parameters = $request->getParameters();
				$response = $adapter->processAuthorization($transaction, $parameters);
				$this->getTransactionHandler()->persistTransactionObject($transaction);
				$this->getTransactionHandler()->commitTransaction();
				$this->logger->logInfo("The notification process has been finished for the transaction with external transaction id " . $externalTransactionId . ".");
				return $response;
			}
			catch (Customweb_Payment_Exception_OptimisticLockingException $lockingException) {
				$this->getTransactionHandler()->rollbackTransaction();
				if($i == 4){
					throw $lockingException;
				}
				sleep(1);
			}
		}
		$this->logger->logInfo("The notification process has been finished for the transaction with external transaction id " . $externalTransactionId . ".");
		return Customweb_Core_Http_Response::_('');
	}
}