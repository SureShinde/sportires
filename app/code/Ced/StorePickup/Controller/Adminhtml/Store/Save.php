<?php
/**
* CedCommerce
*
* NOTICE OF LICENSE
*
* This source file is subject to the End User License Agreement (EULA)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://cedcommerce.com/license-agreement.txt
*
* @category    Ced
* @package     Ced_StorePickup
* @author      CedCommerce Core Team <connect@cedcommerce.com >
* @copyright   Copyright CEDCOMMERCE (https://cedcommerce.com/)
* @license      https://cedcommerce.com/license-agreement.txt
*/
namespace Ced\StorePickup\Controller\Adminhtml\Store;

use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{

    public function __construct(Action\Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        //print_r($data);die;
        $store_name = $data['store_name'];
        $store_manager_name = $data['store_manager_name'];
        $store_manager_email = $data['store_manager_email'];
        $store_address = $data['store_address'];
        $store_city = $data['store_city'];
        $store_country = $data['store_country'];
        $store_state = $data['store_state'];
        $store_zcode = $data['store_zcode'];
        $store_phone = $data['store_phone'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        //$shipping_price = $data['shipping_price'];
        $is_active = $data['is_active'];
        //print_r($data); die("lkhik");
        /*$storeHourInfo = array('Monday' => array('status' => $data['days_status']['mon'], 'start' => $data['start']['mon'], 'end' =>$data['end']['mon'], 'interval' => $data['interval']['mon']),
                               'Tuesday'=> array('status' => $data['days_status']['tue'], 'start' => $data['start']['tue'], 'end' =>$data['end']['tue'], 'interval' => $data['interval']['tue']),
                               'Wednesday'=> array('status' => $data['days_status']['wed'], 'start' => $data['start']['wed'], 'end' =>$data['end']['wed'], 'interval' => $data['interval']['wed']),
                               'Thursday'=> array('status' => $data['days_status']['thu'], 'start' => $data['start']['thu'], 'end' =>$data['end']['thu'], 'interval' => $data['interval']['thu']),
                               'Friday'=> array('status' => $data['days_status']['fri'], 'start' => $data['start']['fri'], 'end' =>$data['end']['fri'], 'interval' => $data['interval']['fri']),
                               'Saturday'=> array('status' => $data['days_status']['sat'], 'start' => $data['start']['sat'], 'end' =>$data['end']['sat'], 'interval' => $data['interval']['sat']),
                               'Sunday'=> array('status' => $data['days_status']['sun'], 'start' => $data['start']['sun'], 'end' =>$data['end']['sun'], 'interval' => $data['interval']['sun'])
                               ); */
        
        $resultRedirect = $this->resultRedirectFactory->create();
        //	print_r($data);die("ljl");
        if ($data) {
            $model = $this->_objectManager->create('Ced\StorePickup\Model\StoreInfo');
            $id = $this->getRequest()->getParam('pickup_id');
           
            try {
                if ($id) {
                    $model->load($id);
                    $model->setData('store_name', $store_name);
                    $model->setData('store_manager_name', $store_manager_name);
                    $model->setData('store_manager_email', $store_manager_email);
                    $model->setData('store_address', $store_address);
                    $model->setData('store_city', $store_city);
                    $model->setData('store_country', $store_country);
                    $model->setData('store_state', $store_state);
                    $model->setData('store_zcode', $store_zcode);
                    if($latitude){
                        $model->setData('latitude', $latitude);
                    }
                    if($longitude){
                        $model->setData('longitude', $longitude);
                    }
                    $model->setData('store_phone', $data['store_phone']);
                    $model->setData('is_active', $is_active);
                    //$model->setData('shipping_price', $shipping_price);
                    $model->save();
                    
                    $coll = $this->_objectManager->create('Ced\StorePickup\Model\StoreHour');
                    $coll = $coll->getCollection()
                        ->addFieldToFilter('pickup_id', $id)
                        ->getData();
                
                    foreach($coll as $val){
                        $deleteObject = $this->_objectManager->create('Ced\StorePickup\Model\StoreHour');
                        $deleteObject->load($val['id']);
                        $deleteObject->delete();
                    }
                    
                    if(isset($storeHourInfo)) {
                        foreach ($storeHourInfo as $key => $val)
                        {
                            $storeObject = $this->_objectManager->create('Ced\StorePickup\Model\StoreHour');
                            $storeObject->setData('pickup_id', $id);
                            $storeObject->setData('days', $key);
                            $storeObject->setData('start', $val['start']);
                            $storeObject->setData('end', $val['end']);
                            $storeObject->setData('interval', $val['interval']);
                            $storeObject->setData('status', $val['status']);
                            $storeObject->save();
                        }
                    }
                } else {
                
                    $model->setData('store_name', $store_name);
                    $model->setData('store_manager_name', $store_manager_name);
                    $model->setData('store_manager_email', $store_manager_email);
                    $model->setData('store_address', $store_address);
                    $model->setData('store_city', $store_city);
                    $model->setData('store_country', $store_country);
                    $model->setData('store_state', $store_state);
                    $model->setData('store_zcode', $store_zcode);
                    if(isset($latitude)){
                        $model->setData('latitude', $latitude);
                    }
                    if(isset($longitude)){
                        $model->setData('longitude', $longitude);
                    }
                    $model->setData('store_phone', $data['store_phone']);
                    $model->setData('is_active', $is_active);
                    //$model->setData('shipping_price', $shipping_price);
                    $model->save();
                    $lastID = $model->getPickupId();
                    //echo $lastID;die("khkvb");
                
                    //print_r($storeHourInfo->getData()); die("hkk");
                    if(isset($storeHourInfo)) {
                        foreach ($storeHourInfo as $key => $val){
                            $storeObject = $this->_objectManager->create('Ced\StorePickup\Model\StoreHour');
                            $storeObject->setData('pickup_id', $lastID);
                            $storeObject->setData('days', $key);
                            $storeObject->setData('start', $val['start']);
                            $storeObject->setData('end', $val['end']);
                            $storeObject->setData('interval', $val['interval']);
                            $storeObject->setData('status', $val['status']);
                            $storeObject->save();
                        }
                    }
                }
                $this->messageManager->addSuccess(__('The store pickup information has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['pickup_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __($e->getMessage()));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['pickup_id' => $this->getRequest()->getParam('pickup_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
