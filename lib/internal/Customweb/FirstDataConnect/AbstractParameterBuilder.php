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


abstract class Customweb_FirstDataConnect_AbstractParameterBuilder {
	/**
	 *
	 * @var Customweb_DependencyInjection_IContainer
	 */
	private $container = null;
	
	/**
	 *
	 * @var Customweb_FirstDataConnect_Authorization_Transaction
	 */
	private $transaction = null;

	public function __construct(Customweb_DependencyInjection_IContainer $container){
		$this->container = $container;

	}

	/**
	 *
	 * @return Customweb_FirstDataConnect_Configuration
	 */
	public function getConfiguration(){
		return $this->getContainer()->getBean('Customweb_FirstDataConnect_Configuration');
	}

	protected function getContainer() {
		return $this->container;
	}
	
	
	protected function getStoreId(){
		$storeId = $this->getConfiguration()->getStoreId();
		if (empty($storeId)) {
			throw new Exception(Customweb_I18n_Translation::__('No Store ID was provided.'));
		}
		
		return array(
			'storename' => $storeId 
		);
	}

	

	protected function getTimeParameters(){
		$parameters = array(
			'timezone' => 'GMT' 
		);
		$date = new DateTime(null, new DateTimeZone($parameters['timezone']));
		$parameters['txndatetime'] = $date->format('Y:m:d-H:i:s');
		return $parameters;
	}


}