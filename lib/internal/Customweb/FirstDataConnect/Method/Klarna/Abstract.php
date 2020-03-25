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
 * @author Nico Eigenmann
 */
abstract class Customweb_FirstDataConnect_Method_Klarna_Abstract extends Customweb_FirstDataConnect_Method_DefaultMethod {

	/**
	 * Should fee be treated as special item
	 */
	abstract protected function isFeeExtraItem();
	
	/**
	 * Must fee be included during authorization
	 */
	abstract protected function forceFeeExtra();

	public function getAuthorizationParameters(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $formData, $authorizationMethod){
		$this->validate($transaction->getTransactionContext()->getOrderContext(), $transaction->getTransactionContext()->getPaymentCustomerContext(),
				$formData);
		$parameters = parent::getAuthorizationParameters($transaction, $formData, $authorizationMethod);
		
		return $parameters;
	}

	private function validateItems(Customweb_Payment_Authorization_IOrderContext $orderContext){
		foreach ($orderContext->getInvoiceItems() as $item) {
			if ($item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_SHIPPING ||
					$item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_FEE) {
				continue;
			}
			if ($item->getQuantity() != round($item->getQuantity())) {
				$errorMessage = Customweb_I18n_Translation::__("The item with name !name has non integer quantity.", array(
					"!name" => $item->getName() 
				));
				throw new Customweb_I18n_LocalizableException($errorMessage);
			}
			$quantity = $item->getQuantity();
			if ($quantity == 0) {
				$quantity = 1;
			}
			
			$price = Customweb_Util_Currency::formatAmount($item->getAmountIncludingTax(), $orderContext->getCurrencyCode());
			$itemPrice = $price / $quantity;
			
			if (Customweb_Util_Currency::formatAmount($itemPrice, $orderContext->getCurrencyCode()) != $itemPrice) {
				$errorMessage = Customweb_I18n_Translation::__("The item with name !name will lead to rounding issues.", array(
					"!name" => $item->getName() 
				));
				throw new Customweb_I18n_LocalizableException($errorMessage);
			}
		}
	}

	public function validate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext, array $formData){
		try {
			$this->validateItems($orderContext, true);
		}
		catch (Exception $e) {
			throw new Customweb_I18n_LocalizableException(
					Customweb_I18n_Translation::__("This payment method is currently not available, please choose another one."));
		}
		$this->checkAddress($orderContext);
		
		$phone = "";
		$mobile = "";
		
		$update = $paymentContext->getMap();
		
		if (isset($formData['phone_number']) && isset($formData['phone_type']) && $formData['phone_type'] == 'home') {
			$phone = $formData['phone_number'];
			$phone = preg_replace('/[^0-9. ()-]/', '', $phone);
			$update['phone_number'] = $phone;
			$update['phone_type'] = $formData['phone_type'];
		}
		
		if (isset($formData['phone_number']) && isset($formData['phone_type']) && $formData['phone_type'] == 'mobile') {
			$mobile = $formData['phone_number'];
			$mobile = preg_replace('/[^0-9. ()-]/', '', $mobile);
			$update['phone_number'] = $mobile;
			$update['phone_type'] = $formData['phone_type'];
		}
		
		if (empty($phone) && empty($mobile)) {
			throw new Exception(Customweb_I18n_Translation::__("Please enter a phone number."));
		}
		
		$billingAddress = $orderContext->getBillingAddress();
		if (in_array(strtoupper($billingAddress->getCountryIsoCode()), array(
			'DE',
			'AT',
			'NL' 
		))) {
			
			if (!isset($formData['date_of_birth_year'])) {
				throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__("Please enter a valid day of birth."));
			}
			if (!isset($formData['date_of_birth_month'])) {
				throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__("Please enter a valid day of birth."));
			}
			if (!isset($formData['date_of_birth_day'])) {
				throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__("Please enter a valid day of birth."));
			}
			
			$year = $formData['date_of_birth_year'];
			$month = $formData['date_of_birth_month'];
			$day = $formData['date_of_birth_day'];
			$dateOfBirth = new Customweb_Core_DateTime();
			$dateOfBirth->setDate(intval($year), intval($month), intval($day));
			$update['date_of_birth_year'] = $year;
			$update['date_of_birth_month'] = $month;
			$update['date_of_birth_day'] = $day;
			
			if (!($dateOfBirth instanceof DateTime)) {
				throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__("Please enter a valid day of birth."));
			}
			
			$gender = "";
			if (isset($formData['customer_gender'])) {
				$gender = $formData['customer_gender'];
				$update['customer_gender'] = $gender;
			}
			if ($gender != 'female' && $gender != 'male') {
				throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__("Please selecet your gender."));
			}
		}
		else if (in_array(strtoupper($billingAddress->getCountryIsoCode()), array(
			'SE',
			'DK',
			'NO',
			'FI' 
		))) {
			$socialNumber = $billingAddress->getSocialSecurityNumber();
			if (empty($socialNumber) && isset($formData['socialSecurity'])) {
				
				$socialNumber = $formData['socialSecurity'];
				$update['socialSecurity'] = $socialNumber;
			}
			if (empty($socialNumber)) {
				throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__("Social security number required"));
			}
		}
		
		$paymentContext->updateMap($update);
	}

	protected function getAdditionalInputFields(Customweb_Payment_Authorization_IOrderContext $orderContext, $aliasTransaction, $failedTransaction, $paymentCustomerContext, $authorizationMethod, $isMoto){
		$fields = array();
		$billingAddress = $orderContext->getBillingAddress();
		
		$phone = $billingAddress->getPhoneNumber();
		$mobile = $billingAddress->getMobilePhoneNumber();
		
		$contextMap = $paymentCustomerContext->getMap();
		
		$defaultPhone = $phone;
		if (empty($defaultPhone)) {
			$defaultPhone = $mobile;
		}
		if (isset($contextMap['phone_number'])) {
			$defaultPhone = $contextMap['phone_number'];
		}
		$controlNumber = new Customweb_Form_Control_TextInput('phone_number', $defaultPhone);
		$controlNumber->addValidator(
				new Customweb_Form_Validator_NotEmpty($controlNumber, Customweb_I18n_Translation::__("Please enter your phone number.")));
		
		$options = array(
			'home' => Customweb_I18n_Translation::__('Home'),
			'mobile' => Customweb_I18n_Translation::__("Mobile") 
		);
		$defaultType = '';
		if (isset($contextMap['phone_type'])) {
			$defaultType = $contextMap['phone_type'];
		}
		$controlType = new Customweb_Form_Control_Select('phone_type', $options, $defaultType);
		$controlMulti = new Customweb_Form_Control_MultiControl('phone_multi', array(
			$controlType,
			$controlNumber 
		));
		
		$element = new Customweb_Form_Element(Customweb_I18n_Translation::__('Phone Number'), $controlMulti,
				Customweb_I18n_Translation::__('Please enter here your phone number.'));
		$fields[] = $element;
		
		if (in_array(strtoupper($billingAddress->getCountryIsoCode()), array(
			'DE',
			'AT',
			'NL' 
		))) {
			$dateOfBirth = $billingAddress->getDateOfBirth();
			$defaultYear = '';
			$defaultMonth = '';
			$defaultDay = '';
			if ($dateOfBirth instanceof DateTime) {
				$defaultDay = $dateOfBirth->format('d');
				$defaultMonth = $dateOfBirth->format('m');
				$defaultYear = $dateOfBirth->format('Y');
			}
			else {
				if (isset($contextMap['date_of_birth_year'])) {
					$defaultYear = $contextMap['date_of_birth_year'];
				}
				if (isset($contextMap['date_of_birth_month'])) {
					$defaultMonth = $contextMap['date_of_birth_month'];
				}
				if (isset($contextMap['date_of_birth_day'])) {
					$defaultDay = $contextMap['date_of_birth_day'];
				}
			}
			$fields[] = Customweb_Form_ElementFactory::getDateOfBirthElement('date_of_birth_year', 'date_of_birth_month', 'date_of_birth_day',
					$defaultYear, $defaultMonth, $defaultDay);
			
			$defaultGender = '';
			$gender = $billingAddress->getGender();
			if ($gender == 'male' || $gender == 'female') {
				$defaultGender = $gender;
			}
			if (isset($contextMap['customer_gender'])) {
				$defaultGender = $contextMap['customer_gender'];
			}
			$genders = array(
				'none' => Customweb_I18n_Translation::__('Select your gender'),
				'female' => Customweb_I18n_Translation::__('Female'),
				'male' => Customweb_I18n_Translation::__('Male') 
			);
			$genderControl = new Customweb_Form_Control_Select('customer_gender', $genders, $defaultGender);
			$genderControl->addValidator(
					new Customweb_Form_Validator_NotEmpty($genderControl, Customweb_I18n_Translation::__("Please select your gender.")));
			
			$element = new Customweb_Form_Element(Customweb_I18n_Translation::__('Gender'), $genderControl,
					Customweb_I18n_Translation::__('Please select your gender.'));
			
			$fields[] = $element;
		}
		else if (in_array(strtoupper($billingAddress->getCountryIsoCode()), array(
			'SE',
			'DK',
			'NO',
			'FI' 
		))) {
			
			$defaultSocial = $billingAddress->getSocialSecurityNumber();
			if (isset($contextMap['socialSecurity'])) {
				$defaultSocial = $contextMap['socialSecurity'];
			}
			$fields[] = Customweb_Form_ElementFactory::getSocialSecurityNumberElement('socialSecurity', $defaultSocial);
		}
		
		return $fields;
	}

	public function getCapturingMode($transaction){
		return Customweb_FirstDataConnect_IConstants::OPERATION_AUTHORISATION;
	}

	public function isDeferredCapturingSupported(){
		return true;
	}

	public function getBasketForBackend($items, Customweb_FirstDataConnect_Authorization_Transaction $transaction){
		$authItems = $transaction->getTransactionContext()->getOrderContext()->getInvoiceItems();
		
		$containsDiscount = false;
		foreach ($authItems as $item) {
			if ($item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
				$containsDiscount = true;
				break;
			}
		}
		if (Customweb_Util_Currency::compareAmount(Customweb_Util_Invoice::getTotalAmountIncludingTax($items), $transaction->getAuthorizationAmount(),
				$transaction->getCurrencyCode()) < 0 && $containsDiscount) {
			throw new Customweb_I18n_LocalizableException(
					Customweb_I18n_Translation::__(
							'Partial captures/refunds of Klarna payments containing discount/coupons items cannot be created in the shop. This can only be done in the PSP backend.'));
		}
		if ($containsDiscount) {
			foreach ($items as $item) {
				$this->checkCompleteItemAmount($item, $authItems, $transaction->getCurrencyCode());
			}
		}
		
		return $this->getIPGBasketObject($items, $transaction, $this->isFeeExtraItem(), false);
	}

	/**
	 * 
	 * @param Customweb_Payment_Authorization_IInvoiceItem[] $items
	 * @param Customweb_FirstDataConnect_Authorization_Transaction $transaction
	 * @param string $extraFeeItem
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket
	 */
	protected function getIPGBasketObject($items, Customweb_FirstDataConnect_Authorization_Transaction $transaction, $feeExtra, $forceFee){
		$basket = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket::_();
		$currencyCode = $transaction->getCurrencyCode();
		$shippingTotal = 0;
		$shippingSub = 0;
		$shippingTax = 0;
		$shippingName = Customweb_I18n_Translation::__('Shipping');
		
		$feeTotal = 0;
		$feeSub = 0;
		$feeTax = 0;
		$feeName = Customweb_I18n_Translation::__('Invoice Fee');
		
		foreach ($items as $item) {
			
			$totalAll = Customweb_Util_Currency::formatAmount($item->getAmountIncludingTax(), $currencyCode);
			$subAll = Customweb_Util_Currency::formatAmount($item->getAmountExcludingTax(), $currencyCode);
			$taxAll = $totalAll - $subAll;
					
			if ($item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_SHIPPING) {
				$shippingTotal += $totalAll;
				$shippingSub += $subAll;
				$shippingTax += $taxAll;
				$shippingName = $item->getName();
				continue;
			}
			
			if ($feeExtra && $item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_FEE) {
				$feeTotal += $totalAll;
				$feeSub += $subAll;
				$feeTax += $taxAll;
				$feeName = $item->getName();
				continue;
			}
			
			$quantity = $item->getQuantity();
			if ($quantity == 0) {
				$quantity = 1;
			}
			
			$total = Customweb_Util_Currency::formatAmount($totalAll / $quantity, $currencyCode);
			$sub = Customweb_Util_Currency::formatAmount($subAll / $quantity, $currencyCode);
			$tax = $total - $sub;
			
			
			if ($item->getType() == Customweb_Payment_Authorization_IInvoiceItem::TYPE_DISCOUNT) {
				$total *= -1;
				$sub *= -1;
				$tax *= -1;
			}
			
			$basketItem = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item::_();
			// @formatter:off
			$basketItem->setID(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max::_()->set(Customweb_Util_String::substrUtf8($item->getSku(), 0, 128)))
			->setDescription(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max::_()->set(Customweb_Util_String::substrUtf8($item->getName(), 0, 128)))
			->setQuantity($quantity)
			->setChargeTotal(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()
				->set(Customweb_Util_Currency::formatAmount($total, $currencyCode)))
			->setSubTotal(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()
					->set(Customweb_Util_Currency::formatAmount($sub, $currencyCode)))
			->setValueAddedTax(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()
					->set(Customweb_Util_Currency::formatAmount($tax, $currencyCode)))
			->setCurrency(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType::_()->set($currencyCode))
			->setDeliveryAmount(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()->set(0));
			// @formatter:on
			$basket->addItem($basketItem);
		}
		
		if (Customweb_Util_Currency::compareAmount($shippingTotal, 0, $transaction->getCurrencyCode()) > 0) {
			
			$shippingItem = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item::_();
			// @formatter:off
			$shippingItem->setID(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max::_()->set('IPG_SHIPPING'))
				->setDescription(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max::_()->set(Customweb_Util_String::substrUtf8($shippingName, 0, 128)))
				->setQuantity(1)
				->setChargeTotal(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()
					->set(Customweb_Util_Currency::formatAmount($shippingTotal, $currencyCode)))
				->setSubTotal(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()
						->set(Customweb_Util_Currency::formatAmount($shippingSub, $currencyCode)))
				->setValueAddedTax(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()
						->set(Customweb_Util_Currency::formatAmount($shippingTax, $currencyCode)))
				->setCurrency(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType::_()->set($currencyCode))
				->setDeliveryAmount(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()->set(0));
				// @formatter:on
			$basket->addItem($shippingItem);
		}
		
		if ($feeExtra && ($forceFee || Customweb_Util_Currency::compareAmount($feeTotal, 0, $currencyCode) > 0)) {
			$feeItem = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Basket_Item::_();
			// @formatter:off
			$feeItem->setID(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max::_()->set('IPG_HANDLING'))
				->setDescription(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String128max::_()->set(Customweb_Util_String::substrUtf8($feeName, 0, 128)))
				->setQuantity(1)
				->setChargeTotal(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()
				->set(Customweb_Util_Currency::formatAmount($feeTotal, $currencyCode)))
				->setSubTotal(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()
				->set(Customweb_Util_Currency::formatAmount($feeSub, $currencyCode)))
				->setValueAddedTax(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()
				->set(Customweb_Util_Currency::formatAmount($feeTax, $currencyCode)))
				->setCurrency(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType::_()->set($currencyCode))
				->setDeliveryAmount(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ItemAmountValueType::_()->set(0));
			// @formatter:on
			$basket->addItem($feeItem);
		}
		
		return $basket;
	}

	protected function getLanguageCode(Customweb_Payment_Authorization_IOrderContext $orderContext){
		$countryCode = strtolower($orderContext->getBillingAddress()->getCountryIsoCode());
		$map = array(
			'de' => 'de_de',
			'at' => 'de_at',
			'nl' => 'nl_nl',
			'se' => 'sv_se',
			'no' => 'nb_no',
			'fi' => 'fi_fi',
			'dk' => 'da_dk' 
		);
		if (isset($map[$countryCode])) {
			return $map[$countryCode];
		}
		else {
			return 'de_de';
		}
	}

	private function checkCompleteItemAmount($item, $originalItems, $currency){
		$sku = $item->getSku();
		foreach ($originalItems as $original) {
			if ($original->getSku() == $sku) {
				if (Customweb_Util_Currency::compareAmount($original->getAmountIncludingTax(), $item->getAmountIncludingTax(), $currency) != 0) {
					throw new Customweb_I18n_LocalizableException(
							Customweb_I18n_Translation::__(
									'You can only capture/refund a complete line item. (Item: !name - Expected Amount: !expected - Given Amount: !given)',
									array(
										'!name' => $item->getName(),
										'!expected' => Customweb_Util_Currency::formatAmount($original->getAmountIncludingTax(), $currency),
										'!given' => Customweb_Util_Currency::formatAmount($item->getAmountIncludingTax(), $currency) 
									)));
				}
				return;
			}
		}
		throw Exception('Modifing non existing LineItem');
	}

	public function preValidate(Customweb_Payment_Authorization_IOrderContext $orderContext, Customweb_Payment_Authorization_IPaymentCustomerContext $paymentContext){
		parent::preValidate($orderContext, $paymentContext);
		$this->checkAddress($orderContext);
		$this->validateItems($orderContext);
	}

	private function checkAddress($orderContext){
		$billing = $orderContext->getBillingAddress();
		$shipping = $orderContext->getShippingAddress();
		if (!Customweb_Util_Address::compareAddresses($billing, $shipping)) {
			throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__('The shipping and billing addresses must be equal'));
		}
		$company = $billing->getCompanyName();
		if (!empty($company)) {
			throw new Customweb_I18n_LocalizableException(Customweb_I18n_Translation::__('This method is not available for companies'));
		}
	}

	/**
	 * Creates the billing address object
	 *
	 * @param Customweb_FirstDataConnect_Authorization_Transaction $transaction
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing
	 */
	protected function getBillingAddressObject(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $formData){
		$update = $transaction->getPaymentCustomerContext()->getMap();
		
		$billingAddress = $transaction->getTransactionContext()->getOrderContext()->getBillingAddress();
		$billingObject = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Billing::_();
		
		$splitted = Customweb_Util_Address::splitStreet($billingAddress->getStreet(), $billingAddress->getCountryIsoCode(),
				$billingAddress->getPostCode());
		
		$billingObject->setFirstname(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max::_()->set($billingAddress->getFirstName()));
		$billingObject->setSurname(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String48max::_()->set($billingAddress->getLastName()));
		
		$billingObject->setCity(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max::_()->set($billingAddress->getCity()));
		$billingObject->setZip(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String24max::_()->set($billingAddress->getPostCode()));
		$billingObject->setCountry(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max::_()->set(
						Customweb_Util_Country::getCountry3LetterCode($billingAddress->getCountryIsoCode())));
		$email = $billingAddress->getEMailAddress();
		if (empty($email)) {
			$email = $transaction->getTransactionContext()->getOrderContext()->getCustomerEMailAddress();
		}
		$billingObject->setEmail(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String64max::_()->set($email));
		
		$state = trim($billingAddress->getState());
		if (!empty($state)) {
			$billingObject->setState(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max::_()->set($state));
		}
		
		if (strtoupper($billingAddress->getCountryIsoCode()) != 'AT') {
			$billingObject->setStreetName(
					Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String84max::_()->set($splitted['street']));
			$billingObject->setHouseNumber(
					Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max::_()->set($splitted['street-number']));
		}
		else {
			$billingObject->setStreetName(
					Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String84max::_()->set($billingAddress->getStreet()));
		}
		
		$phone = "";
		$mobile = "";
		
		if (isset($formData['phone_number']) && isset($formData['phone_type']) && $formData['phone_type'] == 'home') {
			$phone = $formData['phone_number'];
			$phone = preg_replace('/[^0-9. ()-]/', '', $phone);
			$update['phone_number'] = $phone;
			$update['phone_type'] = $formData['phone_type'];
		}
		
		if (isset($formData['phone_number']) && isset($formData['phone_type']) && $formData['phone_type'] == 'mobile') {
			$mobile = $formData['phone_number'];
			$mobile = preg_replace('/[^0-9. ()-]/', '', $mobile);
			$update['phone_number'] = $mobile;
			$update['phone_type'] = $formData['phone_type'];
		}
		
		if (empty($phone) && empty($mobile)) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("Please enter a phone number."),
							Customweb_I18n_Translation::__("Customer did not enter a phone number.")));
		}
		if (!empty($phone)) {
			$billingObject->setPhone(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max::_()->set($phone));
		}
		
		if (!empty($mobile)) {
			$billingObject->setMobilePhone(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max::_()->set($mobile));
		}
		
		if (in_array(strtoupper($billingAddress->getCountryIsoCode()), array(
			'DE',
			'AT',
			'NL' 
		))) {
			
			if (!isset($formData['date_of_birth_year'])) {
				throw new Customweb_Payment_Exception_PaymentErrorException(
						new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("Please enter a valid day of birth."),
								Customweb_I18n_Translation::__("Customer did not enter a date of birth.")));
			}
			if (!isset($formData['date_of_birth_month'])) {
				throw new Customweb_Payment_Exception_PaymentErrorException(
						new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("Please enter a valid day of birth."),
								Customweb_I18n_Translation::__("Customer did not enter a date of birth.")));
			}
			if (!isset($formData['date_of_birth_day'])) {
				throw new Customweb_Payment_Exception_PaymentErrorException(
						new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("Please enter a valid day of birth."),
								Customweb_I18n_Translation::__("Customer did not enter a date of birth.")));
			}
			
			$year = $formData['date_of_birth_year'];
			$month = $formData['date_of_birth_month'];
			$day = $formData['date_of_birth_day'];
			$dateOfBirth = new Customweb_Core_DateTime();
			$dateOfBirth->setDate(intval($year), intval($month), intval($day));
			$update['date_of_birth_year'] = $year;
			$update['date_of_birth_month'] = $month;
			$update['date_of_birth_day'] = $day;
			
			if ($dateOfBirth instanceof DateTime) {
				$billingObject->setBirthDate(Customweb_FirstDataConnect_BirthDateFormat::_($dateOfBirth));
			}
			else {
				throw new Customweb_Payment_Exception_PaymentErrorException(
						new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("Please enter a valid day of birth."),
								Customweb_I18n_Translation::__("Customer did not enter a date of birth.")));
			}
			
			$gender = '';
			if (isset($formData['customer_gender'])) {
				$gender = $formData['customer_gender'];
				$update['customer_gender'] = $gender;
			}
			if ($gender == 'female') {
				$billingObject->setGender(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_GenderType::FEMALE());
			}
			elseif ($gender == 'male') {
				$billingObject->setGender(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_GenderType::MALE());
			}
			else {
				throw new Customweb_Payment_Exception_PaymentErrorException(
						new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("Please select your gender."),
								Customweb_I18n_Translation::__("Customer did not select his gender.")));
			}
		}
		if (strtoupper($billingAddress->getCountryIsoCode()) == 'NL') {
			$streetAddition = $splitted['street-addition-2'];
			if (!empty($streetAddition)) {
				$billingObject->setHouseExtension(
						Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String6max::_()->set(
								Customweb_Core_String::_($streetAddition)->substring(0, 6)));
			}
		}
		
		if (in_array(strtoupper($billingAddress->getCountryIsoCode()), array(
			'SE',
			'DK',
			'NO',
			'FI' 
		))) {
			$socialNumber = "";
			if (isset($formData['socialSecurity'])) {
				$socialNumber = $formData['socialSecurity'];
				$update['socialSecurity'] = $socialNumber;
			}
			if (!empty($socialNumber)) {
				$billingObject->setPersonalNumber(
						Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String20max::_()->set($socialNumber));
			}
			else {
				throw new Customweb_Payment_Exception_PaymentErrorException(
						new Customweb_Payment_Authorization_ErrorMessage(Customweb_I18n_Translation::__("Please enter your social security number."),
								Customweb_I18n_Translation::__("Customer did not enter a social securiy number.")));
			}
		}
		$transaction->getPaymentCustomerContext()->updateMap($update);
		
		return $billingObject;
	}

	/**
	 * Creates the shipping address object
	 *
	 * @param Customweb_FirstDataConnect_Authorization_Transaction $transaction
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping
	 */
	protected function getShippingAddressObject(Customweb_FirstDataConnect_Authorization_Transaction $transaction){
		$shippingAddress = $transaction->getTransactionContext()->getOrderContext()->getShippingAddress();
		$shippingObject = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Shipping::_();
		
		$shippingObject->setName(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max::_()->set(
						$shippingAddress->getFirstName() . ' ' . $shippingAddress->getLastName()));
		$shippingObject->setAddress1(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max::_()->set($shippingAddress->getStreet()));
		$shippingObject->setCity(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String96max::_()->set($shippingAddress->getCity()));
		$shippingObject->setZip(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String24max::_()->set($shippingAddress->getPostCode()));
		$shippingObject->setCountry(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String32max::_()->set(
						Customweb_Util_Country::getCountry3LetterCode($shippingAddress->getCountryIsoCode())));
		
		return $shippingObject;
	}

	public function formatFailureReasonCustomerErrorMessage($failureReason, $failureReasonDetails){
		$reason = preg_replace("/((\S*:? )?Error code: \d* : )/", "", $failureReason);
		if (empty($reason)) {
			return Customweb_I18n_Translation::__("The transaction was declined by Klana.");
		}
		return $reason;
	}

	/**
	 * Creates the IPGOrderRequest for klarna payments.
	 * 
	 * @param Customweb_FirstDataConnect_Authorization_Transaction $transaction
	 * @param array $formData 
	 * @param int $pClass the pClass to use for this payment
	 * @throws Customweb_Payment_Exception_PaymentErrorException
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderRequest
	 */
	protected function createServerRequest(Customweb_FirstDataConnect_Authorization_Transaction $transaction, array $formData, $pClass){
		$orderContext = $transaction->getTransactionContext()->getOrderContext();
		$billingAddress = $orderContext->getBillingAddress();
		
		try {
			$this->validateItems($orderContext);
		}
		catch (Exception $e) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage(
							Customweb_I18n_Translation::__("This payment method is currently not available, please choose another one."),
							$e->getMessage()));
		}
		if (strtoupper($billingAddress->getCountryIsoCode()) != 'NL' &&
				 (!isset($formData['klarna_conditions_checkbox']) || $formData['klarna_conditions_checkbox'] != 'accepted')) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage(
							Customweb_I18n_Translation::__("Please read and accept the terms and conditions."),
							Customweb_I18n_Translation::__("The customer did not the terms and conditions of Klarna.")));
		}
		
		$formattedAmount = Customweb_Util_Currency::formatAmount($transaction->getTransactionContext()->getOrderContext()->getOrderAmountInDecimals(),
				$transaction->getTransactionContext()->getOrderContext()->getCurrencyCode());
		$currency = Customweb_FirstDataConnect_Util::getNumericCurrencyCode(
				$transaction->getTransactionContext()->getOrderContext()->getCurrencyCode());
		$orderId = Customweb_FirstDataConnect_Util::getOrderAppliedSchema($transaction, $this->getGlobalConfiguration());
		
		$ipgTransaction = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionElement::_();
		$ipgTransaction->setKlarnaPClassID($pClass);
		$ipgTransaction->setKlarnaTxType(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType::_()->setType(
						Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type::PREAUTH()));
		$basket = $this->getIPGBasketObject($orderContext->getInvoiceItems(), $transaction, $this->isFeeExtraItem(), $this->forceFeeExtra());
		$ipgTransaction->setBasket($basket);
		
		$ipgTransaction->setBilling($this->getBillingAddressObject($transaction, $formData));
		$ipgTransaction->setShipping($this->getShippingAddressObject($transaction, $formData));
		
		$ipgPayment = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Payment();
		$ipgPayment->setCurrency(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CurrencyType::_()->set($currency))->setChargeTotal(
				Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_AmountValueType::_()->set($formattedAmount));
		
		$ipgTransaction->setPayment($ipgPayment);
		
		$ipgTransactionDetails = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionDetails::_();
		$ipgTransactionDetails->setOrderId(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max::_()->set($orderId));
		$ipgTransactionDetails->setTransactionOrigin(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TransactionOrigin::ECI());
		
		try {
			$ip = $this->getContainer()->getBean('Customweb_Core_Http_IRequest')->getRemoteAddress();
			$ipgTransactionDetails->setIp(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Ip::_()->set($ip));
		}
		catch (Exception $e) {
			throw new Customweb_Payment_Exception_PaymentErrorException(
					new Customweb_Payment_Authorization_ErrorMessage(
							Customweb_I18n_Translation::__("There is a technical issue, please contact the merchant."),
							Customweb_I18n_Translation::__("Could not resolve IP address of the customer.")));
		}
		
		$ipgTransaction->setTransactionDetails($ipgTransactionDetails);
		
		$ipgOrderRequest = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderRequest::_();
		$ipgOrderRequest->setTransaction($ipgTransaction);
		
		return $ipgOrderRequest;
	}
}

