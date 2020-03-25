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
 * @XmlType(name="TransactionValues", namespace="http://ipg-online.com/ipgapi/schemas/a1")
 */ 
class Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues extends Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_Transaction {
	/**
	 * @XmlElement(name="IPGApiOrderResponse", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse", namespace="http://ipg-online.com/ipgapi/schemas/ipgapi")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	private $iPGApiOrderResponse;
	
	/**
	 * @XmlValue(name="ReceiptNumber", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var string
	 */
	private $receiptNumber;
	
	/**
	 * @XmlValue(name="ResponseCode", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var string
	 */
	private $responseCode;
	
	/**
	 * @XmlValue(name="TraceNumber", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var string
	 */
	private $traceNumber;
	
	/**
	 * @XmlValue(name="TransactionState", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var string
	 */
	private $transactionState;
	
	/**
	 * @XmlValue(name="UserID", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var string
	 */
	private $userID;
	
	/**
	 * @XmlElement(name="GiroPayTxType", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType
	 */
	private $giroPayTxType;
	
	/**
	 * @XmlElement(name="GiroPayData", type="Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData", namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	private $giroPayData;
	
	/**
	 * @XmlValue(name="SubmissionComponent", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String'), namespace="http://ipg-online.com/ipgapi/schemas/a1")
	 * @var string
	 */
	private $submissionComponent;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public static function _() {
		$i = new Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues();
		return $i;
	}
	/**
	 * Returns the value for the property iPGApiOrderResponse.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse
	 */
	public function getIPGApiOrderResponse(){
		return $this->iPGApiOrderResponse;
	}
	
	/**
	 * Sets the value for the property iPGApiOrderResponse.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse $iPGApiOrderResponse
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public function setIPGApiOrderResponse($iPGApiOrderResponse){
		if ($iPGApiOrderResponse instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse) {
			$this->iPGApiOrderResponse = $iPGApiOrderResponse;
		}
		else {
			throw new BadMethodCallException("Type of argument iPGApiOrderResponse must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_Ipgapi_IPGApiOrderResponse.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property receiptNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getReceiptNumber(){
		return $this->receiptNumber;
	}
	
	/**
	 * Sets the value for the property receiptNumber.
	 * 
	 * @param string $receiptNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public function setReceiptNumber($receiptNumber){
		if ($receiptNumber instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->receiptNumber = $receiptNumber;
		}
		else {
			$this->receiptNumber = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($receiptNumber);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property responseCode.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getResponseCode(){
		return $this->responseCode;
	}
	
	/**
	 * Sets the value for the property responseCode.
	 * 
	 * @param string $responseCode
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public function setResponseCode($responseCode){
		if ($responseCode instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->responseCode = $responseCode;
		}
		else {
			$this->responseCode = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($responseCode);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property traceNumber.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTraceNumber(){
		return $this->traceNumber;
	}
	
	/**
	 * Sets the value for the property traceNumber.
	 * 
	 * @param string $traceNumber
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public function setTraceNumber($traceNumber){
		if ($traceNumber instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->traceNumber = $traceNumber;
		}
		else {
			$this->traceNumber = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($traceNumber);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property transactionState.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getTransactionState(){
		return $this->transactionState;
	}
	
	/**
	 * Sets the value for the property transactionState.
	 * 
	 * @param string $transactionState
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public function setTransactionState($transactionState){
		if ($transactionState instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->transactionState = $transactionState;
		}
		else {
			$this->transactionState = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($transactionState);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property userID.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getUserID(){
		return $this->userID;
	}
	
	/**
	 * Sets the value for the property userID.
	 * 
	 * @param string $userID
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public function setUserID($userID){
		if ($userID instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->userID = $userID;
		}
		else {
			$this->userID = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($userID);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property giroPayTxType.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType
	 */
	public function getGiroPayTxType(){
		return $this->giroPayTxType;
	}
	
	/**
	 * Sets the value for the property giroPayTxType.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType $giroPayTxType
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public function setGiroPayTxType($giroPayTxType){
		if ($giroPayTxType instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType) {
			$this->giroPayTxType = $giroPayTxType;
		}
		else {
			throw new BadMethodCallException("Type of argument giroPayTxType must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitTxType.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property giroPayData.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData
	 */
	public function getGiroPayData(){
		return $this->giroPayData;
	}
	
	/**
	 * Sets the value for the property giroPayData.
	 * 
	 * @param Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData $giroPayData
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public function setGiroPayData($giroPayData){
		if ($giroPayData instanceof Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData) {
			$this->giroPayData = $giroPayData;
		}
		else {
			throw new BadMethodCallException("Type of argument giroPayData must be Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_V1_DE_DirectDebitData.");
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property submissionComponent.
	 * 
	 * @return Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String
	 */
	public function getSubmissionComponent(){
		return $this->submissionComponent;
	}
	
	/**
	 * Sets the value for the property submissionComponent.
	 * 
	 * @param string $submissionComponent
	 * @return Customweb_FirstDataConnect_Stubs_Com_IpgOnline_Ipgapi_Schemas_A1_TransactionValues
	 */
	public function setSubmissionComponent($submissionComponent){
		if ($submissionComponent instanceof Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String) {
			$this->submissionComponent = $submissionComponent;
		}
		else {
			$this->submissionComponent = Customweb_FirstDataConnect_Stubs_Org_W3_XMLSchema_String::_()->set($submissionComponent);
		}
		return $this;
	}
	
	
	
}