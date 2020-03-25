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
 * MasterPass checkout object.
 *
 * @author Thomas Hunziker
 *
 */
abstract class Customweb_FirstDataConnect_ExternalCheckout_AbstractCheckout extends Customweb_Payment_ExternalCheckout_AbstractCheckout{

	private $container;
	
	public function __construct(Customweb_DependencyInjection_IContainer $container) {
		parent::__construct(new Customweb_FirstDataConnect_Container($container));
	}
	
	/**
	 * Returns the widget for this checkout.
	 * 
	 * @param Customweb_Payment_ExternalCheckout_IContext $context
	 */
	abstract public function getWidget(Customweb_Payment_ExternalCheckout_IContext $context);
	
	/**
	 * @return Customweb_FirstDataConnect_Container
	 */
	protected function getContainer() {
		return parent::getContainer();
	}
	
	/**
	 * @return Customweb_FirstDataConnect_Configuration
	 */
	protected function getConfiguration(){
		return $this->getContainer()->getConfiguration();
	}
	
	
}