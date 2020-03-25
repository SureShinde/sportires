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
 * @XmlType(name="DE_DirectDebitData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData {
	/**
	 * @XmlElement(name="BIC", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BIC", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BIC
	 */
	private $bIC;
	
	/**
	 * @XmlElement(name="IBAN", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_IBAN", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_IBAN
	 */
	private $iBAN;
	
	/**
	 * @XmlElement(name="TrackData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData
	 */
	private $trackData;
	
	/**
	 * @XmlElement(name="BankCode", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BankCode", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BankCode
	 */
	private $bankCode;
	
	/**
	 * @XmlElement(name="AccountNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_AccountNumber", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_AccountNumber
	 */
	private $accountNumber;
	
	/**
	 * @XmlElement(name="MandateReference", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference
	 */
	private $mandateReference;
	
	/**
	 * @XmlElement(name="MandateType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateType", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateType
	 */
	private $mandateType = 'SINGLE';
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData();
		return $i;
	}
	/**
	 * Returns the value for the property bIC.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BIC
	 */
	public function getBIC(){
		return $this->bIC;
	}
	
	/**
	 * Sets the value for the property bIC.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BIC $bIC
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	public function setBIC($bIC){
		if ($bIC instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BIC) {
			$this->bIC = $bIC;
		}
		else {
			throw new BadMethodCallException("Type of argument bIC must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BIC.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property iBAN.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_IBAN
	 */
	public function getIBAN(){
		return $this->iBAN;
	}
	
	/**
	 * Sets the value for the property iBAN.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_IBAN $iBAN
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	public function setIBAN($iBAN){
		if ($iBAN instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_IBAN) {
			$this->iBAN = $iBAN;
		}
		else {
			throw new BadMethodCallException("Type of argument iBAN must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_IBAN.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property trackData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData
	 */
	public function getTrackData(){
		return $this->trackData;
	}
	
	/**
	 * Sets the value for the property trackData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData $trackData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	public function setTrackData($trackData){
		if ($trackData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData) {
			$this->trackData = $trackData;
		}
		else {
			throw new BadMethodCallException("Type of argument trackData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_TrackData.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property bankCode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BankCode
	 */
	public function getBankCode(){
		return $this->bankCode;
	}
	
	/**
	 * Sets the value for the property bankCode.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BankCode $bankCode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	public function setBankCode($bankCode){
		if ($bankCode instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BankCode) {
			$this->bankCode = $bankCode;
		}
		else {
			throw new BadMethodCallException("Type of argument bankCode must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_BankCode.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property accountNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_AccountNumber
	 */
	public function getAccountNumber(){
		return $this->accountNumber;
	}
	
	/**
	 * Sets the value for the property accountNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_AccountNumber $accountNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	public function setAccountNumber($accountNumber){
		if ($accountNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_AccountNumber) {
			$this->accountNumber = $accountNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument accountNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData_AccountNumber.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property mandateReference.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference
	 */
	public function getMandateReference(){
		return $this->mandateReference;
	}
	
	/**
	 * Sets the value for the property mandateReference.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference $mandateReference
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	public function setMandateReference($mandateReference){
		if ($mandateReference instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference) {
			$this->mandateReference = $mandateReference;
		}
		else {
			throw new BadMethodCallException("Type of argument mandateReference must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateReference.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property mandateType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateType
	 */
	public function getMandateType(){
		return $this->mandateType;
	}
	
	/**
	 * Sets the value for the property mandateType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateType $mandateType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	public function setMandateType($mandateType){
		if ($mandateType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateType) {
			$this->mandateType = $mandateType;
		}
		else {
			throw new BadMethodCallException("Type of argument mandateType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MandateType.");
		}
		return $this;
	}
	
	
	
}