<?php
declare(strict_types=1);

namespace Sportires\Instalacion\Helper;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\AbstractHelper;

class Instalacion extends AbstractHelper
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
    	ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Helper\Context $context
    ) {
    	$this->objectManager        = $objectManager;
        parent::__construct($context);
    }


    public function validateIfIsShowByZip($zip){

    $resource = $this->objectManager->get('Magento\Framework\App\ResourceConnection');
    $connection = $resource->getConnection();


		$cart = $this->objectManager->get('\Magento\Checkout\Model\Cart'); 

		// retrieve quote items collection
		$itemsCollection = $cart->getQuote()->getItemsCollection();

		// get array of all items what can be display directly
		$itemsVisible = $cart->getQuote()->getAllVisibleItems();

		// retrieve quote items array
		$items = $cart->getQuote()->getAllItems();

		$productosIguales = 0;
		foreach($items as $item) {
		    if($item->getQty() >= 2){
		    	$productosIguales = 1;
		    }
		}

		if($productosIguales == 1){

        	$sql = "SELECT instalacion FROM sepomex WHERE d_codigo = $zip LIMIT 1;";
        	$result = $connection->fetchAll($sql);

        	return $result[0]['instalacion'];
		}else{
			return 0;
		}


    }

    public function getNewFactorCostInstallation(){
        $scopeConfig = $this->objectManager->create('Magento\Framework\App\Config\ScopeConfigInterface');
        $factor = $scopeConfig->getValue('carriers/instalacion/price_by_tire',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $price = $scopeConfig->getValue('carriers/instalacion/price',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $resource = $this->objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();


        $cart = $this->objectManager->get('\Magento\Checkout\Model\Cart'); 

        // retrieve quote items collection
        $itemsCollection = $cart->getQuote()->getItemsCollection();

        // get array of all items what can be display directly
        $itemsVisible = $cart->getQuote()->getAllVisibleItems();

        // retrieve quote items array
        $items = $cart->getQuote()->getAllItems();

        
        foreach($items as $item) {
            if($item->getQty() >= 2){
                $price = $price+($factor*$item->getQty());
            }
        }

        return $price;
    }

    public function getDataByZip($zip){
    	$resource = $this->objectManager->get('Magento\Framework\App\ResourceConnection');
    	$connection = $resource->getConnection();

        $sql = "SELECT d_mnpio as municipio,d_ciudad as estado,d_asenta as colonia FROM sepomex WHERE d_codigo = $zip LIMIT 1;";
        $result = $connection->fetchAll($sql);    	

        return $result;
    }

}

