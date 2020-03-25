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


class Customweb_FirstDataConnect_ExternalCheckout_MasterPass_ConfirmationParameterBuilder extends Customweb_FirstDataConnect_AbstractParameterBuilder {
	
	private $transaction;
	
	private $providerData;

	public function __construct(Customweb_DependencyInjection_IContainer $container, Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $providerData){
		parent::__construct($container);
		$this->transaction = $transaction;
		$this->providerData = $providerData;
	}

	protected function getTransaction(){
		return $this->transaction;
	}

	protected function getProviderData(){
		return $this->providerData;
	}
	
	protected function getOrderContext(){
		return $this->getTransaction()->getTransactionContext()->getOrderContext();
	}
	
	public function build(){
		$parameters = array();
		$amount = Customweb_Util_Invoice::getTotalAmountIncludingTax($this->getOrderContext()->getInvoiceItems());
		$parameters['chargetotal'] = Customweb_Util_Currency::formatAmount($amount,
				$this->getOrderContext()->getCurrencyCode());
		$parameters['currency'] = Customweb_FirstDataConnect_Util::getNumericCurrencyCode($this->getOrderContext()->getCurrencyCode());
		$providerData = $this->getProviderData();
		$parameters['merchantTransactionId'] = $providerData['ipgTransactionId'];
		$parameters['hash_algorithm'] = 'SHA256';
		$parameters['subtotal'] = $parameters['chargetotal'] ;
		$parameters['vattax'] = '0.00';
		$parameters['shipping'] = '0.00';
		$parameters['oid'] = $this->getOrderAppliedSchema();
		$parameters['hashExtended'] = Customweb_FirstDataConnect_Util::calculateExtendedHash($parameters,$this->getConfiguration()->getConnectSharedSecret());
		return $parameters;
	}
	
	protected final function getOrderAppliedSchema(){
		$schema = $this->getConfiguration()->getOrderIdSchema();
		$id = (string) $this->getTransaction()->getExternalTransactionId();
		$id = str_ireplace('{id}', $id, $schema);
		$id = preg_replace('/_/', '-', $id);
		return preg_replace('/[^a-zA-Z0-9-]/', '', $id);
	}
	
	
	protected function getPaymentParameters(){
		$parameters = array();
		$parameters['chargetotal'] = Customweb_Util_Currency::formatAmount($this->getTransaction()->getOrderAmountInDecimals(), 
				$this->getCheckoutContext()->getCurrencyCode());
		$parameters['currency'] = Customweb_FirstDataConnect_Util::getNumericCurrencyCode($this->getTransaction()->getCurrencyCode());
		return $parameters;
	}
}