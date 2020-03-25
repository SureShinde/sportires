<?php
    
namespace ITM\MagB1\Block\Adminhtml\Categoryfiles\Edit\Tab;
    
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
    protected $_categoryList;
    
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Status $status,
        \Magento\Store\Model\System\Store $systemStore,
        \ITM\MagB1\Model\System\Config\CategoryList $categoryList,
        array $data = []
    ) {
        $this->_status = $status;
        $this->_systemStore = $systemStore;
        $this->_categoryList = $categoryList->toOptionArray(false);
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
        $model = $this->_coreRegistry->registry('current_itm_magb1_categoryfiles');
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('item_');
        $fieldset = $form->addFieldset('base_fieldset', [
            'legend' => __('Item Information')
        ]);
        if ($model->getEntityId()) {
            $fieldset->addField('entity_id', 'hidden', [
              'name' => 'id'
             ]);
        } else {
            $model->setData("code", time());
        }

        if ($model->getEntityId()) {
            $fieldset->addField('code', 'text', [
                'name' => 'code',
                'required' => true,
                'label' => __('Code'),
                'title' => __('Code'),
                'readonly' => true,
            ]);
        } else {
            $fieldset->addField('code', 'text', [
                'name' => 'code',
                'required' => true,
                'label' => __('Code'),
                'title' => __('Code'),
            ]);
        }
        
        $fieldset->addField('category_id', 'multiselect', [
            'name' => 'category_id',
            'required' => true,
            'values' => $this->_categoryList,
            'label' => __('Category IDs'),
            'title' => __('Category IDs'),
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

        $fieldset->addField('description', 'text', [
            'name' => 'description',
            'required' => false,
            'label' => __('Description'),
            'title' => __('Description'),
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
            'required' => false,
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
