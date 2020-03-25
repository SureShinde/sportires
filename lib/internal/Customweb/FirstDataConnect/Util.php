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
 * This util class some basic functions for FirstDataConnect.
 *
 * @author Nico Eigenmann
 *
 */
final class Customweb_FirstDataConnect_Util {

	private function __construct(){
		// prevent any instantiation of this class	
	}
	private static $numericCurrencyCodeMap = array(
		'AED' => '784',
		'AUD' => '036',
		'BHD' => '048',
		'CAD' => '124',
		'CHF' => '756',
		'CNY' => '156',
		'CZK' => '203',
		'DKK' => '208',
		'EUR' => '978',
		'GBP' => '826',
		'HKD' => '344',
		'HRK' => '191',
		'HUF' => '348',
		'INR' => '356',
		'ISL' => '376',
		'JPY' => '392',
		'KRW' => '410',
		'KWD' => '414',
		'LTL' => '440',
		'MXN' => '484',
		'NOK' => '578',
		'NZD' => '554',
		'PLN' => '985',
		'RON' => '946',
		'SAR' => '682',
		'SEK' => '752',
		'SGD' => '702',
		'TRY' => '949',
		'USD' => '840',
		'ZAR' => '710' 
	);
	public static $supportedLanguages = array(
		'en_US',
		'en_GB',
		'fi_FI',
		'fr_FR',
		'de_DE',
		'it_IT',
		'nl_NL',
		'zh_CN',
		'zh_TW',
		'pt_BR',
		'es_ES'
		
		
	);

	public static function calculateHash($parameters, $secret){
		if (empty($secret)) {
			throw new Exception("The shared secret is empty.");
		}
		$requiredParameters = array(
			'storename',
			'txndatetime',
			'chargetotal',
			'currency' 
		);
		$stringToHash = '';
		foreach ($requiredParameters as $key) {
			$stringToHash .= $parameters[$key];
		}
		$ascii = bin2hex($stringToHash . $secret);
		return hash('sha256', $ascii);
	}

	public static function calculateExtendedHash($parameters, $secret){
		if (empty($secret)) {
			throw new Exception("The shared secret is empty.");
		}
		
		$validKeys = array(
			'accountnumber',
			'authenticateTransaction',
			'baddr1',
			'baddr2',
			'bankcode',
			'bcity',
			'bcompany',
			'bcountry',
			'bfirstname',
			'blastname',
			'bname',
			'bstate',
			'bzip',
			'cab_billing',
			'cab_shipping',
			'cardnumber',
			'chargetotal',
			'checkoutoption',
			'comments',
			'currency',
			'customerid',
			'cvm',
			'dynamicMerchantName',
			'email',
			'expmonth',
			'expyear',
			'fax',
			'full_bypass',
			'hash_algorithm',
			'hosteddataid',
			'hosteddatastoreid',
			'ident_actiontype',
			'invoicenumber',
			'ipgTransactionId',
			'issuenumber',
			'language',
			'merchantTransactionId',
			'mobileMode',
			'mode',
			'oid',
			'paymentMethod',
			'phone',
			'recurringInstallmentCount',
			'recurringInstallmentFrequency',
			'recurringInstallmentPeriod',
			'refer',
			'responseFailURL',
			'responseSuccessURL',
			'reviewOrder',
			'reviewURL',			
			'saddr1',
			'saddr2',
			'scity',
			'scountry',
			'shipping', 
			'sname',
			'sstate',
			'storename',
			'subtotal',
			'szip',
			'tdate',
			'timezone',
			'trxOrigin',
			'transactionNotificationURL',
			'txndatetime',
			'txntype',
			'valueaddedservices',
			'vattax',
			'klarnaPersonalNumber',
			'klarnaBirthDate',
			'klarnaClientGender',
			'klarnaFirstname',
			'klarnaLastname',
			'klarnaStreetName',
			'klarnaHouseNumber',
			'klarnaHouseNumberExtension',
			'klarnaCellPhoneNumber',
			'klarnaPClassID',
			'klarnaCity',
			'klarnaCountry',
			'klarnaZip',
			'klarnaPhone',
			'klarnaEmail',
		);
		$stringToHash = '';
		$parametersToUse = array();
		foreach ($validKeys as $key) {
			if (isset($parameters[$key])) {
				$parametersToUse[] = $key;
				//$stringToHash .= $parameters[$key];
			}
		}
		for($i=1; $i<1000; $i++) {
			if(isset($parameters['item'.$i])){
				$parametersToUse[] = 'item'.$i;
			}
			else {
				break;
			}
		}
		sort($parametersToUse);
		foreach($parametersToUse as $key) {
			$stringToHash .= $parameters[$key];
		}		
		$ascii = bin2hex($stringToHash . $secret);
		return hash('sha256', $ascii);
	}

	public static function calculateResponseHash($parameters, $secret, $storename){
		$requiredParameters = array(
			'approval_code',
			'chargetotal',
			'currency',
			'txndatetime' 
		);
		$stringToHash = '';
		foreach ($requiredParameters as $key) {
			$stringToHash .= $parameters[$key];
		}
		$ascii = bin2hex($secret . $stringToHash . $storename);
		return hash('sha256', $ascii);
	}

	public static function calculateNotificationHash($parameters, $secret, $storename){
		$stringToHash = $parameters['chargetotal'];
		$stringToHash .= $secret;
		$stringToHash .= $parameters['currency'];
		$stringToHash .= $parameters['txndatetime'];
		$stringToHash .= $storename;
		$stringToHash .= $parameters['approval_code'];
		$ascii = bin2hex($stringToHash);
		return hash('sha256', $ascii);
	}

	public static function getNumericCurrencyCode($code){
		return self::$numericCurrencyCodeMap[$code];
	}

	private static function getClientCertificateSpecific($path, $apiUserId){
		if(file_exists($path.$apiUserId.'.pem')){
			return $path.$apiUserId.'.pem';
		}
		return '';
	}
	
	private static function getClientCertificateGeneral($path){
		if ($handle = opendir($path)) {
			while (false !== ($entry = readdir($handle))) {
				$extension = pathinfo($path . $entry, PATHINFO_EXTENSION);
				if (stripos($extension, 'pem') !== false) {
					if (stripos($entry, 'geotrust.pem') !== false){
						continue;
					}
					closedir($handle);
					return $path . $entry;
				}
			}
			closedir($handle);
		}
		return '';
	}

	public static function setTxTypeForPaymentMethod($paymentMethod, $txType, Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction $ipgTransaction){
		$paymentMethodName = $paymentMethod->getPaymentMethodName();
		switch (strtolower($paymentMethodName)) {
			case 'diners':
			case 'mastercard':
			case 'visa':
			case 'americanexpress':
			case 'jcb':
			case 'maestro':
			case 'maestrouk':
			case 'creditcard':
			case 'masterpass':
				$type = null;
				switch ($txType) {
					case Customweb_FirstDataConnect_IConstants::OPERATION_AUTHORISATION:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType_Type::PREAUTH();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_CAPTURE:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType_Type::POSTAUTH();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_CANCEL:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType_Type::VOID();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_REFUND:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType_Type::CONSTANT_RETURN();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_SALE:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType_Type::SALE();
						break;
					default:
						break;
				}
				$ipgTransaction->setCreditCardTxType(
						Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CreditCardTxType::_()->setType($type));
				break;
			
			case 'directdebits':
			case 'directdebitssepa':
				$type = null;
				switch ($txType) {
					case Customweb_FirstDataConnect_IConstants::OPERATION_REFUND:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType_Type::CONSTANT_RETURN();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_SALE:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType_Type::SALE();
						break;
					default:
						break;
				}
				$ipgTransaction->setDE_DirectDebitTxType(
						Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType::_()->setType($type));
				break;
			case 'clickandbuy':
				$type = null;
				switch ($txType) {
					case Customweb_FirstDataConnect_IConstants::OPERATION_CAPTURE:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyTxType_Type::POSTAUTH();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_CANCEL:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyTxType_Type::VOID();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_REFUND:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyTxType_Type::CONSTANT_RETURN();
						break;
					default:
						break;
				}
				$ipgTransaction->setClickandBuyTxType(
						Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_ClickandBuyTxType::_()->setType($type));
				break;
			case 'paypal':
				$type = null;
				switch ($txType) {
					case Customweb_FirstDataConnect_IConstants::OPERATION_CAPTURE:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PayPalTxType_Type::POSTAUTH();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_CANCEL:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PayPalTxType_Type::VOID();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_REFUND:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PayPalTxType_Type::CONSTANT_RETURN();
						break;
					default:
						break;
				}
				$ipgTransaction->setPayPalTxType(
						Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_PayPalTxType::_()->setType($type));
				break;
			case 'klarnaopeninvoice':
			case 'klarnainvoice':
			case 'klarnainstallments':
				$type = null;
				switch ($txType) {
					case Customweb_FirstDataConnect_IConstants::OPERATION_AUTHORISATION:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type::PREAUTH();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_CAPTURE:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type::POSTAUTH();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_CANCEL:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type::VOID();
						break;
					case Customweb_FirstDataConnect_IConstants::OPERATION_REFUND:
						$type = Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType_Type::CONSTANT_RETURN();
						break;
					default:
						break;
				}
				$ipgTransaction->setKlarnaTxType(Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_KlarnaTxType::_()->setType($type));
				break;
				
			default:
				throw new Exception('This payment method is not supported through the API');
		}
	}
	
	public static function getCertificate(Customweb_FirstDataConnect_Configuration $config, $isMoto){
		$certificatePath = '';
	
		if ($isMoto) {
			if ($config->isTestMode()) {
				$folder = dirname(__FILE__) . '/Certificates/MoTo/Test/';
				$certificatePath = self::getClientCertificateSpecific($folder, $config->getMotoAPIUserId());
				if (empty($certificatePath)) {
					$certificatePath = self::getClientCertificateGeneral($folder);
				}
			}
			if (empty($certificatePath)) {
				$folder = dirname(__FILE__) . '/Certificates/MoTo/Live/';
				$certificatePath = self::getClientCertificateSpecific($folder, $config->getMotoAPIUserId());
				if (empty($certificatePath)) {
					$certificatePath = self::getClientCertificateGeneral($folder);
				}
			}
			if (empty($certificatePath)) {
				$folder = dirname(__FILE__) . '/Certificates/MoTo/';
				$certificatePath = self::getClientCertificateSpecific($folder, $config->getMotoAPIUserId());
				if (empty($certificatePath)) {
					$certificatePath = self::getClientCertificateGeneral($folder);
				}
			}
		}
		else {
			if ($config->isTestMode()) {
				$folder = dirname(__FILE__) . '/Certificates/Default/Test/';
				$certificatePath = self::getClientCertificateSpecific($folder, $config->getAPIUserId());
				if (empty($certificatePath)) {
					$certificatePath = self::getClientCertificateGeneral($folder);
				}
			}
			if (empty($certificatePath)) {
				$folder = dirname(__FILE__) . '/Certificates/Default/Live/';
				$certificatePath = self::getClientCertificateSpecific($folder, $config->getAPIUserId());
				if (empty($certificatePath)) {
					$certificatePath = self::getClientCertificateGeneral($folder);
				}
			}
			if (empty($certificatePath)) {
				$folder = dirname(__FILE__) . '/Certificates/Default/';
				$certificatePath = self::getClientCertificateSpecific($folder, $config->getAPIUserId());
				if (empty($certificatePath)) {
					$certificatePath = self::getClientCertificateGeneral($folder);
				}
			}
		}
		if (empty($certificatePath)) {
			throw new Exception('Can not find Certificate.');
		}
		return new Customweb_Core_Stream_Input_File($certificatePath);
	}
	
	public static function getOrderAppliedSchema(Customweb_Payment_Authorization_ITransaction $transaction, Customweb_FirstDataConnect_Configuration $configuration){
		$schema = $configuration->getOrderIdSchema();
		$tId = (string) $transaction->getExternalTransactionId();
		$id = str_ireplace('{id}', $tId, $schema);
		$id = preg_replace('/_/', '-', $id);
		return preg_replace('/[^a-zA-Z0-9-]/', '', $id);
	}
}