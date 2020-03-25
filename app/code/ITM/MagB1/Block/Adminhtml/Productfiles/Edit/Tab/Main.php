<?php
    
namespace ITM\MagB1\Block\Adminhtml\Productfiles\Edit\Tab;
    
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use ITM\MagB1\Model\System\Config\Status;
    
class Main extends Generic implements TabInterface
{

    protected $_status;
    protected $_systemStore;
    
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Status $status,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }
    
   /**
    *
    * {@inheritdoc}
    */
    public function getTabLabel()
    {
        return __('Item Information');
    }
                
   /**
    *
    * {@inheritdoc}
    */
    public function getTabTitle()
    {
        return __('Item Information');
    }
                
   /**
    *
    * {@inheritdoc}
    */
    public function canShowTab()
    {
        return true;
    }
                
   /**
    *
    * {@inheritdoc}
    */
    public function isHidden()
    {
        return false;
    }
                
    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('current_itm_magb1_productfiles');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
       
        /** @var \Magento\Framework\Data\Form $form */
            
        $form->setHtmlIdPrefix('item_');
        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('Item Information')
        ]);
        if ($model->getEntityId()) {
            $fieldset->addField('entity_id', 'hidden', [
              'name' => 'id'
             ]);
        }
        
        if ($model->getData("sku")!="") {
            $fieldset->addField('sku', 'text', [
            'name' => 'sku',
            'required' => true,
            'label' => __('SKU'),
            'title' => __('SKU'),
            'readonly' => true,
            ]);
        } else {
            $fieldset->addField('sku', 'text', [
                'name' => 'sku',
                'required' => true,
                'label' => __('SKU'),
                'title' => __('SKU'),
            ]);
        }
        $fieldset->addField('description', 'text', [
            'name' => 'description',
            'required' => true,
            'label' => __('Description'),
            'title' => __('Description'),
            ]);

        $file_name = "";
        $after_element = "";
        if ($model->getData("path")!="") {
            $file_name = $model->getData("path");
            $after_element = "<p><input type=\"checkbox\" name=\"delete_file_path\">Delete ($file_name)</p>";
        }
        
        $fieldset->addField('path', 'file', [
            'name' => 'path',
            'required' => false,
            'label' => __('Select file to upload'),
            'title' => __('Select file to upload'),
            'after_element_html' => $after_element,
            //'before_element_html' => '',
            ]);

        $fieldset->addField('store_id', 'select', [
            'name' => 'store_id',
            'required' => true,
            'label' => __('Store View'),
            'title' => __('Store View'),
            'values' => $this->_systemStore->getStoreValuesForForm(false, true)
            ]);

        $fieldset->addField('position', 'text', [
            'name' => 'position',
            'required' => true,
            'label' => __('Position'),
            'title' => __('Position'),
            ]);
                
        $fieldset->addField('status', 'select', [
            'name' => 'status',
            'label' => __('Status'),
            'options' => $this->_status->toOptionArray()
        ]);

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
