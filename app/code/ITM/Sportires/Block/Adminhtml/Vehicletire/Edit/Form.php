<?php
    
namespace ITM\Sportires\Block\Adminhtml\Vehicletire\Edit;
    
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('itm_sportires_form');
        $this->setTitle(__('ITM Information'));
    }
    
    /**
     * Prepare form before rendering HTML
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
            'data' => [
                'id' => 'edit_form',
                'action' => $this->getUrl('itm_sportires/vehicletire/save'),
                'method' => 'post'
            ]
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
