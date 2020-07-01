<?php
declare(strict_types=1);

namespace Sportires\Bi\Block\Adminhtml\Index;

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

    public function getLastOrders(){

        $sql = "SELECT 
                        CASE SUBSTR(increment_id,1,6)
                        WHEN 'MLIBRE' THEN 'MERCADO LIBRE'
                        WHEN 'WALMAR' THEN 'WALMART'
                        WHEN 'AMZN-0' THEN 'AMAZON'
                        ELSE 'SPORTIRES'
                        END AS canal_compra,
                        COUNT(*) AS totales, DATE(created_at) created_at,
                        CASE payment_method 
                        WHEN 'paybymlibre' THEN 'MLIBRE'
                        WHEN 'classyllama_llamacoin' THEN 'FIRSTDATA'
                        WHEN 'paybywalmartmx' THEN 'WALMART'
                        WHEN 'paypal_express' THEN 'PAYPAL'
                        WHEN 'stripe_payments' THEN 'STRIPE'
                        WHEN 'paybyamazon' THEN 'AMAZON'
                        ELSE payment_method 
                        END AS forma_pago
                        FROM sales_order_grid 
                        WHERE payment_method NOT IN ('cashondelivery','banktransfer')
                        #AND TIME(created_at) BETWEEN '01:00:00' AND '14:00:00'
                        AND DATE(created_at) >= DATE(ADDDATE(NOW(), INTERVAL -4 DAY))
                        GROUP BY SUBSTR(increment_id,1,6),DATE(created_at)
                        ORDER BY DATE(created_at) DESC;";
        $result = $this->getConnection()->fetchAll($sql); 
 
        return $result;

    }

    public function getProductsMostSales($days = NULL){

        if($days != NULL){
            $days = $days;
        }

        $sql = "SELECT sku,name,SUM(qty_ordered) AS qty FROM sales_order_item WHERE order_id IN (
                SELECT 
                      entity_id
                                        FROM sales_order_grid 
                                        WHERE payment_method NOT IN ('cashondelivery','banktransfer')
                                        AND TIME(created_at) BETWEEN '01:00:00' AND '14:00:00'
                                        AND DATE(created_at) >= DATE(ADDDATE(NOW(), INTERVAL -$days DAY))
                                        #GROUP BY SUBSTR(increment_id,1,6),DATE(created_at)
                                        ORDER BY DATE(created_at) DESC
                ) GROUP BY product_id ORDER BY SUM(qty_ordered) DESC limit 10;";

        $result = $this->getConnection()->fetchAll($sql); 
 
        return $result;        
    }

    public function getDetailBySku($sku,$days){

        $sql = "SELECT 
                    CASE SUBSTR(a.increment_id,1,6)
                    WHEN 'MLIBRE' THEN 'MERCADO LIBRE'
                    WHEN 'WALMAR' THEN 'WALMART'
                    WHEN 'AMZN-0' THEN 'AMAZON'
                    ELSE 'SPORTIRES'
                    END AS canal_compra,
                    COUNT(*) AS totales, DATE(a.created_at) AS created_at,
                    CASE a.payment_method 
                    WHEN 'paybymlibre' THEN 'MLIBRE'
                    WHEN 'classyllama_llamacoin' THEN 'FIRSTDATA'
                    WHEN 'paybywalmartmx' THEN 'WALMART'
                    WHEN 'paypal_express' THEN 'PAYPAL'
                    WHEN 'stripe_payments' THEN 'STRIPE'
                    WHEN 'paybyamazon' THEN 'AMAZON'
                    ELSE a.payment_method 
                    END AS forma_pago,
                    SUM(b.qty_ordered) AS productos,b.name
                    FROM sales_order_grid a 
                    INNER JOIN sales_order_item b
                    ON a.entity_id = b.order_id
                    AND b.sku = '$sku'
                    WHERE a.payment_method NOT IN ('cashondelivery','banktransfer')
                    AND DATE(a.created_at) >= DATE(ADDDATE(NOW(), INTERVAL -$days DAY))
                    GROUP BY SUBSTR(a.increment_id,1,6),DATE(a.created_at)
                    ORDER BY DATE(a.created_at) DESC;";

        $result = $this->getConnection()->fetchAll($sql); 
 
        return $result;        

    }

    public function getOrdersNumber($sku,$date,$pay){

        $sql = "SELECT a.entity_id,a.increment_id FROM sales_order_grid a
            INNER JOIN sales_order_item b
            ON a.`entity_id` = b.`order_id`
            AND b.`sku` = '$sku'
            AND DATE(a.created_at) = '$date' 
            AND a.increment_id LIKE '$pay%'";

        $result = $this->getConnection()->fetchAll($sql); 
 
        $out = '';

        foreach($result as $item){

            $out .= '<li><a href="'.$this->urlBase('sales/order/view/', array('order_id' => $item['entity_id'], 'key' => '5195f2dfbc9ea567475be250cf5b3190aa850bb19a3ee4fe426f420f326cff1')).'">'.$item['increment_id'].'</a></li>';

        }

        return $out;             
    }

  
}

