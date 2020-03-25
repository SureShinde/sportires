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
namespace Ced\StorePickup\Block\Adminhtml\Stores\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
 
    /**
     * @var \Magento\Cms\Model\Wysiwyg\Config
     */
    protected $_wysiwygConfig;
 
    protected $_status;
    protected $_collectionFactory;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param \Magento\Store\Model\System\Store       $systemStore
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Ced\StorePickup\Model\Status $status,
        array $data = []
    ) {

        $this->_systemStore = $systemStore;
        $this->_wysiwygConfig = $wysiwygConfig;
        $this->_status = $status;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $registry, $formFactory, $data);

    }
 

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('storepickup_data');
        $isElementDisabled = false;
        
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('storepickup_data', ['legend' => __('Store Pickup Information')]);

        if ($model->getId()) {
            $fieldset->addField('pickup_id', 'hidden', ['name' => 'pickup_id']);
        }
    
        $fieldset->addField(
            'store_name',
            'text',
            [
            'name' => 'store_name',
            'label' => __('Store Name'),
            'title' => __('Store Name'),
            'required' => true,
            'disabled' => $isElementDisabled,
            'class' => 'validate-text'
            ]
        );
        
         $fieldset->addField(
             'store_manager_name',
             'text',
             [
                'name' => 'store_manager_name',
                'label' => __('Store Manager Name'),
                'title' => __('Store Manager Name'),
                'required' => true,
                'disabled' => $isElementDisabled,
                'class' => 'validate-alphanum-with-spaces'
             ]
         );
        
         $fieldset->addField(
             'store_manager_email',
             'text',
             [
                'name' => 'store_manager_email',
                'label' => __('Store Manager Email'),
                'title' => __('Store Manager Email'),
                'required' => true,
                'disabled' => $isElementDisabled,
                'class' => 'validate-email'
             ]
         );
         $fieldset->addField(
             'store_country',
             'select',
             [
                'label' => __('country'),
                'title' => __('country'),
                'name' => 'store_country',
                'required' => true,
                'values' => $this->getCountryOptions(),
                'disabled' => $isElementDisabled,
                'class' => 'validate-select',
             ]
         );
         $fieldset->addField(
             'is_active',
             'select',
             [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'is_active',
                'required' => true,
                'options' => $this->_status->getOptionArray(),
                'disabled' => $isElementDisabled,
                'class' => 'validate-select'
             ]
         );

        
        
         if (!$model->getId()) {
             $model->setData('is_active', $isElementDisabled ? '0' : '1');
            }
            $fieldset->addField(
                'store_address',
                'text',
                [
                'name' => 'store_address',
                'label' => __('Store Address'),
                'title' => __('Store Address'),
                'required' => true,
                'disabled' => $isElementDisabled,
                'class' => 'validate-text'
                ]
            );

            $fieldset->addField(
                'latitude',
                'text',
                [
                'name' => 'latitude',
                'label' => __('Store Latitude'),
                'title' => __('Store Latitude'),
                'required' => true,
                'readonly' => true
                ]
            );

            $fieldset->addField(
                'longitude',
                'text',
                [
                'name' => 'longitude',
                'label' => __('Store Longitude'),
                'title' => __('Store Longitude'),
                'required' => true,
                'readonly' => true
                ]
            );
        
            $fieldset->addField(
                'store_city',
                'text',
                [
                'name' => 'store_city',
                'label' => __('Store City'),
                'title' => __('Store City'),
                'required' => true,
                'disabled' => $isElementDisabled,
                'class' => 'letters-with-basic-punc'
                ]
            );
        
            $fieldset->addField(
                'store_state',
                'text',
                [
                'name' => 'store_state',
                'label' => __('Store State'),
                'title' => __('Store State'),
                'required' => false,
                'disabled' => $isElementDisabled,
                'class' => 'validate-state'
                ]
            );
        
            $fieldset->addField(
                'store_zcode',
                'text',
                [
                'name' => 'store_zcode',
                'label' => __('Postal Code'),
                'title' => __('Postal Code'),
                'required' => true,
                'disabled' => $isElementDisabled,
                'class' => 'validate-number',
                ]
            );
        
            $fieldset->addField(
                'store_phone',
                'text',
                [
                'name' => 'store_phone',
                'label' => __('Contact Number'),
                'title' => __('Contact Number'),
                'required' => true,
                'disabled' => $isElementDisabled,
                'class' => 'validate-number'

                ]
            );       
        
            $form->setValues($model->getData());
            $this->setForm($form);
            return parent::_prepareForm();

    }

  
    public function getTabLabel()
    {
        return __('Store Pickup Information');
    }

    
    public function getTabTitle()
    {
        return __('Store Pickup Information');
    }

    
    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

   
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
    public function getCountryOptions()
    {
        $options=[];
        foreach($this->_collectionFactory->create()->loadByStore()->toOptionArray() as $option)
        {
            $options[$option['value']]=$option['label'];
        }

        return $options;
    }
}