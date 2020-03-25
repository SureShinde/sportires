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
 * @XmlType(name="UK_DebitCardData", namespace="http://ipg-online.com/ipgapi/schemas/v1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData {
	/**
	 * @XmlElement(name="CardNumber", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_CardNumber", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_CardNumber
	 */
	private $cardNumber;
	
	/**
	 * @XmlElement(name="ExpMonth", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpMonth", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpMonth
	 */
	private $expMonth;
	
	/**
	 * @XmlElement(name="ExpYear", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpYear", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpYear
	 */
	private $expYear;
	
	/**
	 * @XmlElement(name="CardCodeValue", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue
	 */
	private $cardCodeValue;
	
	/**
	 * @XmlElement(name="IssueNo", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_IssueNo", namespace="http://ipg-online.com/ipgapi/schemas/v1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_IssueNo
	 */
	private $issueNo;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData();
		return $i;
	}
	/**
	 * Returns the value for the property cardNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_CardNumber
	 */
	public function getCardNumber(){
		return $this->cardNumber;
	}
	
	/**
	 * Sets the value for the property cardNumber.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_CardNumber $cardNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData
	 */
	public function setCardNumber($cardNumber){
		if ($cardNumber instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_CardNumber) {
			$this->cardNumber = $cardNumber;
		}
		else {
			throw new BadMethodCallException("Type of argument cardNumber must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_CardNumber.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property expMonth.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpMonth
	 */
	public function getExpMonth(){
		return $this->expMonth;
	}
	
	/**
	 * Sets the value for the property expMonth.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpMonth $expMonth
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData
	 */
	public function setExpMonth($expMonth){
		if ($expMonth instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpMonth) {
			$this->expMonth = $expMonth;
		}
		else {
			throw new BadMethodCallException("Type of argument expMonth must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpMonth.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property expYear.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpYear
	 */
	public function getExpYear(){
		return $this->expYear;
	}
	
	/**
	 * Sets the value for the property expYear.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpYear $expYear
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData
	 */
	public function setExpYear($expYear){
		if ($expYear instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpYear) {
			$this->expYear = $expYear;
		}
		else {
			throw new BadMethodCallException("Type of argument expYear must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_ExpYear.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property cardCodeValue.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue
	 */
	public function getCardCodeValue(){
		return $this->cardCodeValue;
	}
	
	/**
	 * Sets the value for the property cardCodeValue.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue $cardCodeValue
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData
	 */
	public function setCardCodeValue($cardCodeValue){
		if ($cardCodeValue instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue) {
			$this->cardCodeValue = $cardCodeValue;
		}
		else {
			throw new BadMethodCallException("Type of argument cardCodeValue must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_CardCodeValue.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property issueNo.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_IssueNo
	 */
	public function getIssueNo(){
		return $this->issueNo;
	}
	
	/**
	 * Sets the value for the property issueNo.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_IssueNo $issueNo
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData
	 */
	public function setIssueNo($issueNo){
		if ($issueNo instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_IssueNo) {
			$this->issueNo = $issueNo;
		}
		else {
			throw new BadMethodCallException("Type of argument issueNo must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_UK_DebitCardData_IssueNo.");
		}
		return $this;
	}
	
	
	
}