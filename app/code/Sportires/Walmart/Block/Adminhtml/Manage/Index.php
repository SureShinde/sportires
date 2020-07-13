<?php
declare(strict_types=1);

namespace Sportires\Walmart\Block\Adminhtml\Manage;

class Index extends \Magento\Backend\Block\Template
{
    private $_objectManager;
    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        $this->_objectManager = $objectmanager;
        parent::__construct($context, $data);
    }

    public function urlBase($url,$params){

        $key_form = $this->_objectManager->get('Magento\Framework\Data\Form\FormKey');
        $form_Key = $key_form->getFormKey();
        $urlBuinterf = $this->_objectManager->get('\Magento\Framework\UrlInterface');
        $urlsecret = $urlBuinterf->getUrl($url,$params);

        return $urlsecret;
    }

    public function getKeyForm(){

        $key_form = $this->_objectManager->get('Magento\Framework\Data\Form\FormKey');
        return  $key_form->getFormKey();     
    }    

    protected function getConnection(){

            $resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
            return $resource->getConnection();
            
    }    

    public function getStatusCronsWalmart(){


        $word = 'sportires_walmart';

        $sql = "SELECT * FROM cron_schedule WHERE job_code LIKE 'sportires_walmart%' AND status in ('pending','running','error')";
        $result = $this->getConnection()->fetchAll($sql); 
 

        return $result;

    }


    public function getDetailCronOrders(){

        $sql = "SELECT * FROM sportires_marketplaces WHERE marketplace = 'walmart' AND proccess = 'ordenes' order by 1 desc limit 1";
        $result = $this->getConnection()->fetchAll($sql); 
 
        return $result[0];
    }    

    public function getDetailCronProducts(){

        $sql = "SELECT * FROM sportires_marketplaces WHERE marketplace = 'walmart' AND proccess = 'productos' order by 1 desc limit 1";
        $result = $this->getConnection()->fetchAll($sql); 
 
        return $result[0];
    } 

    public function getDetailCronStock(){

        $sql = "SELECT * FROM sportires_marketplaces WHERE marketplace = 'walmart' AND proccess = 'inventario' order by 1 desc limit 1";
        $result = $this->getConnection()->fetchAll($sql); 
 
        return $result[0];
    }  

    public function getDetailCronPrice(){

        $sql = "SELECT * FROM sportires_marketplaces WHERE marketplace = 'walmart' AND proccess = 'precio' order by 1 desc limit 1";
        $result = $this->getConnection()->fetchAll($sql); 
 
        return $result[0];
    }             
}

