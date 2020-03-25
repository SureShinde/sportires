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
 * @XmlType(name="RecurringPaymentInformation", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation {
	/**
	 * @XmlElement(name="RecurringStartDate", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate
	 */
	private $recurringStartDate;
	
	/**
	 * @XmlElement(name="InstallmentCount", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentCount", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentCount
	 */
	private $installmentCount;
	
	/**
	 * @XmlElement(name="MaximumFailures", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_MaximumFailures", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_MaximumFailures
	 */
	private $maximumFailures;
	
	/**
	 * @XmlElement(name="InstallmentFrequency", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentFrequency", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentFrequency
	 */
	private $installmentFrequency;
	
	/**
	 * @XmlElement(name="InstallmentPeriod", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentPeriod", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentPeriod
	 */
	private $installmentPeriod;
	
	public function __construct() {
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation();
		return $i;
	}
	/**
	 * Returns the value for the property recurringStartDate.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate
	 */
	public function getRecurringStartDate(){
		return $this->recurringStartDate;
	}
	
	/**
	 * Sets the value for the property recurringStartDate.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate $recurringStartDate
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation
	 */
	public function setRecurringStartDate($recurringStartDate){
		if ($recurringStartDate instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate) {
			$this->recurringStartDate = $recurringStartDate;
		}
		else {
			throw new BadMethodCallException("Type of argument recurringStartDate must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_StringDate.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property installmentCount.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentCount
	 */
	public function getInstallmentCount(){
		return $this->installmentCount;
	}
	
	/**
	 * Sets the value for the property installmentCount.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentCount $installmentCount
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation
	 */
	public function setInstallmentCount($installmentCount){
		if ($installmentCount instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentCount) {
			$this->installmentCount = $installmentCount;
		}
		else {
			throw new BadMethodCallException("Type of argument installmentCount must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentCount.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property maximumFailures.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_MaximumFailures
	 */
	public function getMaximumFailures(){
		return $this->maximumFailures;
	}
	
	/**
	 * Sets the value for the property maximumFailures.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_MaximumFailures $maximumFailures
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation
	 */
	public function setMaximumFailures($maximumFailures){
		if ($maximumFailures instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_MaximumFailures) {
			$this->maximumFailures = $maximumFailures;
		}
		else {
			throw new BadMethodCallException("Type of argument maximumFailures must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_MaximumFailures.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property installmentFrequency.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentFrequency
	 */
	public function getInstallmentFrequency(){
		return $this->installmentFrequency;
	}
	
	/**
	 * Sets the value for the property installmentFrequency.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentFrequency $installmentFrequency
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation
	 */
	public function setInstallmentFrequency($installmentFrequency){
		if ($installmentFrequency instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentFrequency) {
			$this->installmentFrequency = $installmentFrequency;
		}
		else {
			throw new BadMethodCallException("Type of argument installmentFrequency must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentFrequency.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property installmentPeriod.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentPeriod
	 */
	public function getInstallmentPeriod(){
		return $this->installmentPeriod;
	}
	
	/**
	 * Sets the value for the property installmentPeriod.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentPeriod $installmentPeriod
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation
	 */
	public function setInstallmentPeriod($installmentPeriod){
		if ($installmentPeriod instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentPeriod) {
			$this->installmentPeriod = $installmentPeriod;
		}
		else {
			throw new BadMethodCallException("Type of argument installmentPeriod must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_RecurringPaymentInformation_InstallmentPeriod.");
		}
		return $this;
	}
	
	
	
}