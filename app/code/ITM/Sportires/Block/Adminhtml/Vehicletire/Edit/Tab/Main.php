<?php
    
namespace ITM\Sportires\Block\Adminhtml\Vehicletire\Edit\Tab;
    
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Cms\Model\Wysiwyg\Config;
use ITM\Sportires\Model\System\Config\Status;
use ITM\Sportires\Model\System\Config\Attributeoption;
    
class Main extends Generic implements TabInterface
{

    protected $_status;
    protected $_attributeoption;
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Config $wysiwygConfig,
        Status $status,
		Attributeoption $attributeoption,
        array $data = []
    ) {
        $this->_status = $status;
		$this->_attributeoption = $attributeoption;
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
        $model = $this->_coreRegistry->registry('current_itm_sportires_vehicletire');
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
        }
        
        $fieldset->addField('make', 'text', [
            'name' => 'make',
            'required' => true,
            'label' => __('Make'),
            'title' => __('Make'),
            ]);

        $fieldset->addField('year', 'text', [
            'name' => 'year',
            'required' => true,
            'label' => __('Year'),
            'title' => __('Year'),
            ]);

        $fieldset->addField('model', 'text', [
            'name' => 'model',
            'required' => true,
            'label' => __('Model'),
            'title' => __('Model'),
            ]);

        $fieldset->addField('trim', 'text', [
            'name' => 'trim',
            'required' => true,
            'label' => __('Trim'),
            'title' => __('Trim'),
            ]);

       /* $fieldset->addField('front_width', 'select', [
            'name' => 'front_width',
            'required' => true,
            'label' => __('Front Width'),
            'title' => __('Front Width'),
            'class' => 'validate-zero-or-greater',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_width")
            ]);

        $fieldset->addField('front_ratio', 'select', [
            'name' => 'front_ratio',
            'required' => true,
            'label' => __('Front Ratio'),
            'title' => __('Front Ratio'),
            'class' => 'validate-zero-or-greater',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_ratio")
            ]);

        $fieldset->addField('front_diameter', 'select', [
            'name' => 'front_diameter',
            'required' => true,
            'label' => __('Front Diameter'),
            'title' => __('Front Diameter'),
            'class' => 'validate-zero-or-greater',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_diameter")
            ]);

        $fieldset->addField('rear_width', 'select', [
            'name' => 'rear_width',
            'required' => true,
            'label' => __('Rear Width'),
            'title' => __('Rear Width'),
            'class' => 'validate-zero-or-greater',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_width")
            ]);

        $fieldset->addField('rear_ratio', 'select', [
            'name' => 'rear_ratio',
            'required' => true,
            'label' => __('Rear Ratio'),
            'title' => __('Rear Ratio'),
            'class' => 'validate-zero-or-greater',
			'options' => $this->_attributeoption->toCustomOptionArray("tire_ratio")
            ]);

        $fieldset->addField('rear_diameter', 'select', [
            'name' => 'rear_diameter',
            'required' => true,
            'label' => __('Rear Diameter'),
            'title' => __('Rear Diameter'),
            'options' => $this->_attributeoption->toCustomOptionArray("tire_diameter")
            ]);
               */
        $fieldset->addField('front_width', 'text', [
            'name' => 'front_width',
            'required' => true,
            'label' => __('Front Width'),
            'title' => __('Front Width'),
            'class' => 'validate-zero-or-greater'
        ]);

        $fieldset->addField('front_ratio', 'text', [
            'name' => 'front_ratio',
            'required' => true,
            'label' => __('Front Ratio'),
            'title' => __('Front Ratio'),
            'class' => 'validate-zero-or-greater'
        ]);

        $fieldset->addField('front_diameter', 'text', [
            'name' => 'front_diameter',
            'required' => true,
            'label' => __('Front Diameter'),
            'title' => __('Front Diameter'),
            'class' => 'validate-zero-or-greater'
        ]);

        $fieldset->addField('rear_width', 'text', [
            'name' => 'rear_width',
            'required' => true,
            'label' => __('Rear Width'),
            'title' => __('Rear Width'),
            'class' => 'validate-zero-or-greater'
        ]);

        $fieldset->addField('rear_ratio', 'text', [
            'name' => 'rear_ratio',
            'required' => true,
            'label' => __('Rear Ratio'),
            'title' => __('Rear Ratio'),
            'class' => 'validate-zero-or-greater'
        ]);

        $fieldset->addField('rear_diameter', 'text', [
            'name' => 'rear_diameter',
            'required' => true,
            'label' => __('Rear Diameter'),
            'title' => __('Rear Diameter'),
            'class' => 'validate-zero-or-greater'
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
