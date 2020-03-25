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
 *
 * @category	Customweb
 * @package		Customweb_FirstDataConnectCw
 * 
 */

namespace Customweb\FirstDataConnectCw\Model\Service;

class TransactionManagement implements \Customweb\FirstDataConnectCw\Api\TransactionManagementInterface
{
	/**
	 * @var \Customweb\FirstDataConnectCw\Api\TransactionRepositoryInterface
	 */
	protected $_transactionRepository;

	/**
	 * @var \Customweb\FirstDataConnectCw\Model\Authorization\TransactionRegistry
	 */
	protected $_transactionRegistry;

	/**
	 * @var \Customweb\FirstDataConnectCw\Model\Alias\Handler
	 */
	protected $_aliasHandler;

	/**
	 * @param \Customweb\FirstDataConnectCw\Api\TransactionRepositoryInterface $transactionRepository
	 * @param \Customweb\FirstDataConnectCw\Model\Authorization\TransactionRegistry $transactionRegistry
	 * @param \Customweb\FirstDataConnectCw\Model\Alias\Handler $aliasHandler
	 */
	public function __construct(
			\Customweb\FirstDataConnectCw\Api\TransactionRepositoryInterface $transactionRepository,
			\Customweb\FirstDataConnectCw\Model\Authorization\TransactionRegistry $transactionRegistry,
			\Customweb\FirstDataConnectCw\Model\Alias\Handler $aliasHandler
	) {
		$this->_transactionRepository = $transactionRepository;
		$this->_transactionRegistry = $transactionRegistry;
		$this->_aliasHandler = $aliasHandler;
	}

	public function update($id)
	{
		$transaction = $this->_transactionRegistry->retrieve($id);
		if ($transaction->getTransactionObject()->getUpdateExecutionDate() != null) {
			$transaction->update();
		}
		return true;
	}

	public function getStatus($id)
	{
		return $this->_transactionRepository->get($id)->getAuthorizationStatus();
	}

	public function deleteAlias($id)
	{
		$transaction = $this->_transactionRegistry->retrieve($id);
		$this->_aliasHandler->removeAlias($transaction);
		return true;
	}
}