<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement(EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category  Ced
 * @package   Ced_FbNative
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\FbNative\Block\Adminhtml\Account\Edit\Tab;

/**
 * Class Info
 * @package Ced\FbNative\Block\Adminhtml\Account\Edit\Tab
 */
class Info extends \Magento\Backend\Block\Widget\Form\Generic
{
    public $_objectManager;
    /**
     * Info constructor.
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Framework\ObjectManagerInterface $objectInterface
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        $this->_objectManager = $objectInterface;
        parent::__construct($context, $registry, $formFactory);
    }

    /**
     * @return \Magento\Backend\Block\Widget\Form\Generic
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $account = $this->_objectManager->get('Ced\FbNative\Model\Account')->load($id);
        } else {
            $account = $this->_objectManager->get('Ced\FbNative\Model\Account');
        }
        $fieldset = $form->addFieldset('Account_info', ['legend' => __('Account Information')]);

        $fieldset->addField('page_name', 'text',
            [
                'name' => "page_name",
                'label' => __('Shop Page Name'),
                'note' => __('To Identify the Account'),
                'required' => true,
                'class' => 'validate-alphanum',
                'value' => $account->getData('page_name'),
            ]
        );

        $fieldset->addField('account_status', 'select',
            array(
                'name' => "account_status",
                'label' => __('Account Status'),
                'required' => true,
                'value' => $account->getData('account_status'),
                'values' => $this->_objectManager->get('Ced\FbNative\Model\Source\Account\Status')->getOptionArray(),
            )
        );

        $fieldset->addField('account_store', 'select',
            array(
                'name' => "account_store",
                'label' => __('Account Store'),
                'required' => true,
                'value' => $account->getData('account_store'),
                'values' => $this->_objectManager->get('Magento\Config\Model\Config\Source\Store')->toOptionArray(),
            )
        );

        if($account->getData('page_name')) {
            /** @var \Magento\Store\Model\StoreManagerInterface $storeManager */
            $storeManager = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface');
            $currentStore = $storeManager->getStore();
            $fieldset->addField('','label',
                array(
                    'name' => "export_csv",
                    'label' => __('Page Exported CSV Link'),
                    'value' => $account->getData('export_csv'),
                )
            );
        }

        $this->setForm($form);
        return parent::_prepareForm();
    }
}