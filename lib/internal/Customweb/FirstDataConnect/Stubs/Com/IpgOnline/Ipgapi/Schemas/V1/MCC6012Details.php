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
 * @XmlType(name="MCC6012Details", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details {
	/**
	 * @XmlElement(name="BirthDate", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	private $birthDate;
	
	/**
	 * @XmlElement(name="AccountFirst6", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountFirst6", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountFirst6
	 */
	private $accountFirst6;
	
	/**
	 * @XmlElement(name="AccountLast4", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountLast4", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountLast4
	 */
	private $accountLast4;
	
	/**
	 * @XmlElement(name="AccountNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max
	 */
	private $accountNumber;
	
	/**
	 * @XmlElement(name="PostCode", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max
	 */
	private $postCode;
	
	/**
	 * @XmlElement(name="Surname", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	private $surname;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details();
		return $i;
	}
	/**
	 * Returns the value for the property birthDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate
	 */
	public function getBirthDate(){
		return $this->birthDate;
	}
	
	/**
	 * Sets the value for the property birthDate.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate $birthDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details
	 */
	public function setBirthDate($birthDate){
		if ($birthDate instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate) {
			$this->birthDate = $birthDate;
		}
		else {
			throw new BadMethodCallException("Type of argument birthDate must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_StringDate.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property accountFirst6.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountFirst6
	 */
	public function getAccountFirst6(){
		return $this->accountFirst6;
	}
	
	/**
	 * Sets the value for the property accountFirst6.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountFirst6 $accountFirst6
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details
	 */
	public function setAccountFirst6($accountFirst6){
		if ($accountFirst6 instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountFirst6) {
			$this->accountFirst6 = $accountFirst6;
		}
		else {
			throw new BadMethodCallException("Type of argument accountFirst6 must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountFirst6.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property accountLast4.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountLast4
	 */
	public function getAccountLast4(){
		return $this->accountLast4;
	}
	
	/**
	 * Sets the value for the property accountLast4.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountLast4 $accountLast4
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details
	 */
	public function setAccountLast4($accountLast4){
		if ($accountLast4 instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountLast4) {
			$this->accountLast4 = $accountLast4;
		}
		else {
			throw new BadMethodCallException("Type of argument accountLast4 must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details_AccountLast4.");
		}
		return $this;
	}
	
	
	/**
	 * Either (AccountFirst6 and AccountLast4) or AccountNumber have to be filled. If AccountFirst6 and AccountLast4 are both available, the value of AccountNumber is to be ignored.
	 * 
	 * Returns the value for the property accountNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max
	 */
	public function getAccountNumber(){
		return $this->accountNumber;
	}
	
	/**
	 * Either (AccountFirst6 and AccountLast4) or AccountNumber have to be filled. If AccountFirst6 and AccountLast4 are both available, the value of AccountNumber is to be ignored.
	 * 
	 * Sets the value for the property accountNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max $accountNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details
	 */
	public function setAccountNumber($accountNumber){
		if ($accountNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max) {
			$this->accountNumber = $accountNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument accountNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property postCode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max
	 */
	public function getPostCode(){
		return $this->postCode;
	}
	
	/**
	 * Sets the value for the property postCode.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max $postCode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details
	 */
	public function setPostCode($postCode){
		if ($postCode instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max) {
			$this->postCode = $postCode;
		}
		else {
			throw new BadMethodCallException("Type of argument postCode must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String50max.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property surname.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max
	 */
	public function getSurname(){
		return $this->surname;
	}
	
	/**
	 * Sets the value for the property surname.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max $surname
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_MCC6012Details
	 */
	public function setSurname($surname){
		if ($surname instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max) {
			$this->surname = $surname;
		}
		else {
			throw new BadMethodCallException("Type of argument surname must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_String100max.");
		}
		return $this;
	}
	
	
	
}