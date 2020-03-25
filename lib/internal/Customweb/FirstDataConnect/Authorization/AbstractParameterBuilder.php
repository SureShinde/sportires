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



abstract class Customweb_FirstDataConnect_Authorization_AbstractParameterBuilder extends Customweb_FirstDataConnect_AbstractParameterBuilder {
	
	private $formData = array();
	
	/**
	 *
	 * @var Customweb_FirstDataConnect_Authorization_Transaction
	 */
	private $transaction = null;
	
	
	public function __construct($transaction, Customweb_DependencyInjection_IContainer $container, $formData) {
		parent::__construct( $container);
		$this->transaction = $transaction;
		$this->formData = $formData;
	}
	
	/**
	 *
	 * @return Customweb_FirstDataConnect_Authorization_Transaction
	 */
	public function getTransaction(){
		return $this->transaction;
	}
	
	/**
	 *
	 * @return Customweb_Payment_Authorization_ITransactionContext
	 */
	public function getTransactionContext(){
		return $this->getTransaction()->getTransactionContext();
	}
	
	/**
	 *
	 * @return Customweb_Payment_Authorization_IOrderContext
	 */
	public function getOrderContext(){
		return $this->getTransactionContext()->getOrderContext();
	}
	
	
	protected function getPaymentParameters(){
		$parameters = array();
		$parameters['chargetotal'] = Customweb_Util_Currency::formatAmount($this->getOrderContext()->getOrderAmountInDecimals(),
				$this->getOrderContext()->getCurrencyCode());
		$parameters['currency'] = Customweb_FirstDataConnect_Util::getNumericCurrencyCode($this->getOrderContext()->getCurrencyCode());
		return $parameters;
	}
	
	protected function getOrderId(){
		return array(
			'oid' => $this->getOrderAppliedSchema()
		);
	}
	
	protected function getCustomerIdParameter(){
		$parameters = array();
		if ($this->getOrderContext()->getCustomerId() != null) {
			$parameters['customerid'] = $this->getOrderContext()->getCustomerId();
		}	
		return $parameters;
	}
	
	protected function getLanguageParameter(){
		$parameter = array();
		$language = Customweb_Core_Util_Language::getCleanLanguageCode($this->getOrderContext()->getLanguage(),
				Customweb_FirstDataConnect_Util::$supportedLanguages);
		$parameter['language'] = $language;
		return $parameter;
	}
	
	protected final function getOrderAppliedSchema(){
		$schema = $this->getConfiguration()->getOrderIdSchema();
		$tId = (string) $this->getTransaction()->getExternalTransactionId();
		$id = str_ireplace('{id}', $tId, $schema);
		$id = preg_replace('/_/', '-', $id);
		return preg_replace('/[^a-zA-Z0-9-]/', '', $id);
	}
	
	protected function getOperationModeParameter() {
		return array('txntype' => $this->getCapturingMode());
	}
	
	protected function getCapturingMode() {
		return $this->getPaymentMethod()->getCapturingMode($this->getTransaction());
	}
	
	protected function getReactionUrlParameters() {
		return array(
				'responseSuccessURL' => $this->getTransaction()->getSuccessUrl(),
				'responseFailURL' => $this->getFailedUrl(),
				'transactionNotificationURL' => $this->getProcessAuthorizationUrl(),
		);
	}
	
	
	protected function getProcessAuthorizationUrl(){
		$endpointAdapter = $this->getContainer()->getBean('Customweb_Payment_Endpoint_IAdapter');
		$urlString = $endpointAdapter->getUrl('process', 'index', array('cw_transaction_id' => $this->getTransaction()->getExternalTransactionId()));
		if($this->getConfiguration()->isForcedNonSSlNotification()) {
			$url = new Customweb_Core_Url($urlString);
			$url->setScheme('http')->setPort(80);
			$urlString = $url->getUrlAsString();
		}
		
		// FirstDataConnect is encoding the string on there side again. If we pass it in proper
		// way (encoded) they destroy it. Reference: 2017041115472000663
		$urlString = urldecode($urlString);
		
		return $urlString;
	}
	
	protected function getFailedUrl(){
		$endpointAdapter = $this->getContainer()->getBean('Customweb_Payment_Endpoint_IAdapter');;
				return $endpointAdapter->getUrl('process' , 'failed' , array('cw_transaction_id' => $this->getTransaction()->getExternalTransactionId()));
	}
	
	protected function getBasicParameters() {
		
		$parameters = array_merge(
			$this->getPaymentParameters(),
			$this->getStoreId(),
			$this->getReactionUrlParameters(),
			$this->getOrderId(),
			$this->getTimeParameters(),
			$this->getOperationModeParameter(),
			$this->getCustomerIdParameter(),
			$this->getLanguageParameter(),
			$this->getAddressParameters(),
			$this->getAliasParameter(),
			$this->getRecurringParameter(),
			$this->getPaymentMethod()->getLineItemParameters($this->getOrderContext()->getInvoiceItems(), $this->getOrderContext()->getCurrencyCode())
		);
		return $parameters;
	}
	
	protected function getRecurringParameter() {
		$params = array();
		if ($this->getTransactionContext()->createRecurringAlias()) {
			// Those parameter seems not required.
// 			$params['recurringInstallmentCount'] = '1';
// 			$params['recurringInstallmentPeriod'] = 'day';
// 			$params['recurringInstallmentFrequency'] = '1';
		}	
		return $params;
	}
	

	protected function getAliasParameter() {
	    if ($this->getPaymentMethod()->isAliasManagerSupported() && $this->getPaymentMethod()->isAliasManagerActive() ) { 
			if ($this->getTransaction()->getAlias() == null || $this->getTransaction()->getAlias() == 'new') {
				return array('hosteddataid' => $this->getUniqueDataVaultId());
			}
			else {
				$params = $this->getTransaction()->getAlias()->getAuthorizationParameters();
				return array('hosteddataid' => $params['hosteddataid']);
			}
		}
		elseif ($this->getTransactionContext()->createRecurringAlias()) {
			return array('hosteddataid' => $this->getUniqueDataVaultId());
		}
		return array();
	}
	
	protected function getAddressParameters(){
		return $this->getPaymentMethod()->getAddressParameters($this->getOrderContext(), $this->getTransaction()->getPaymentCustomerContext(), $this->getFormData());
	}
	
	protected function getSolvencyVerficiationParameters() {
		$paymentMethod = $this->getPaymentMethod();
		$parameters = array();
		if($paymentMethod->isSolvencyCheckActive()) {
			$billing = $this->getOrderContext()->getBillingAddress();
			
			$company = trim($billing->getCompanyName());
			if(!empty($company)) {
				$parameters['bcompany'] = $company;
			}
			
			$name = trim($billing->getFirstName() . ' ' . $billing->getLastName());
			$parameters['bname'] = Customweb_Core_String::_($name)->substring(0, 96)->toString();
			
			$street = trim($billing->getStreet());
			$parameters['baddr1'] = Customweb_Core_String::_($street)->substring(0, 96)->toString();
			
			$city = trim($billing->getCity());
			$parameters['bcity'] = Customweb_Core_String::_($city)->substring(0, 96)->toString();

			$state = trim($billing->getState());
			$parameters['bstate'] = Customweb_Core_String::_($state)->substring(0, 96)->toString();

			$country = trim($billing->getCountryIsoCode());
			$parameters['bcountry'] = $country;

			$zip = trim($billing->getPostCode());
			$parameters['bzip'] = Customweb_Core_String::_($zip)->substring(0, 24)->toString();
			
			$phone = trim($billing->getPhoneNumber());
			$parameters['phone'] = Customweb_Core_String::_($phone)->substring(0, 32)->toString();
			
			$email = trim($billing->getEMailAddress());
			$parameters['email'] = Customweb_Core_String::_($email)->substring(0, 254)->toString();
			
			$parameters['valueaddedservices'] = 'buergel';
		}
		return $parameters;
	}
	
		
	/**
	 *
	 * @return int
	 */
	protected function getUniqueDataVaultId()
	{
		$transactionString = $this->getTransaction()->getExternalTransactionId();
		$dateTime = date('Y-m-d_H:i:s');
		$uniqueRefId = $transactionString . '_' . $dateTime;
		return $uniqueRefId;
	}
	
	protected function getPaymentMethod() {
		$factory = $this->getContainer()->getBean('Customweb_FirstDataConnect_Method_Factory');
		return $factory->getPaymentMethod($this->getTransaction()->getPaymentMethod(), $this->getTransaction()->getAuthorizationMethod());
		
	}
	
	protected function getFormData() {
		return $this->formData;
	}
}