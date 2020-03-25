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
 * This interface provides some constants for the FirstDataConnect service.
 */
interface Customweb_FirstDataConnect_IConstants
{
	
	const OPERATION_AUTHORISATION 	= 'preauth';
	const OPERATION_SALE 			= 'sale';
	
	const OPERATION_CAPTURE 		= 'postAuth';
	const OPERATION_CANCEL 			= 'void';
	const OPERATION_REFUND			= 'return';
	
	
	const URL_API 			= 'ipgapi/services';
	const URL_CONNECT 		= 'connect/gateway/processing';
	const URL_HASH			= 'connect/hashServlet';
	
	const DATA_PAYONLY 			= 'payonly';
	const DATA_BILLING			= 'payplus';
	const DATA_ALL				= 'fullpay';
	
	const THREE_D_SUCCESS 				= 'success';
	const THREE_D_FAILED				= 'failed';
	const THREE_D_NOT_ENROLLED 			= 'notenrolled';
	const THREE_D_AUTH_SERVER			= 'authserver';
	const THREE_D_AUTH_ATTEMPTED		= 'attempted';
	
	const THREE_D_DIR_SERVER			= 'dirserver';
	const THREE_D_NOT_AVAILABLE			= 'notavailable';

	const DU_VERIFICATION_NONE				= 'none';
	const DU_VERIFICATION_AGE				= 'age';
	const DU_VERIFICATION_IDENTIFICATION 	= 'identification';
	const DU_VERIFICATION_AUTHENTICATION	= 'authentication';
	const DU_VERIFICATION_BANKACCOUNT		= 'bankaccount';
	
	
}