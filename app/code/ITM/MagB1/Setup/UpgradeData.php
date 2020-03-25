<?php
namespace ITM\MagB1\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{

    /**
     *
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     *
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    private $_customerAttributeSetId;

    private $_customerAttributeGroupId;

    public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig,
        CustomerSetupFactory $customerSetupFactory, AttributeSetFactory $attributeSetFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }


    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create([
            'setup' => $setup
        ]);

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $this->_customerAttributeSetId = $attributeSetId;
        $this->_customerAttributeGroupId = $attributeGroupId;


        if (version_compare($context->getVersion(), '1.0.6') < 0) {
            $this->addCustomerAddressId($customerSetup);
        }
        if (version_compare($context->getVersion(), '1.1.1') < 0) {
            $this->addCustomerCardCode($customerSetup);
        }
        if (version_compare($context->getVersion(), '1.2.7') < 0) {
            $this->addDisplayOrderAttribute($customerSetup);
        }
        if (version_compare($context->getVersion(), '1.2.8') < 0) {
            $this->updateCustomerCardCode($customerSetup);
        }
        if (version_compare($context->getVersion(), "1.3.8", "<")) {
            $setup->getConnection()->addColumn($setup->getTable("customer_group"),'itm_payment_methods',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'comment' =>'Disabled Payment Methods'
                ]);
        }
        if (version_compare($context->getVersion(), "1.3.9", "<")) {
            $this->addCustomerCreditAttributes($customerSetup);
        }
    }

    private function addCustomerCreditAttributes($customerSetup)
    {
        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'itm_credit_limit', [
            'type' => 'decimal',
            'label' => 'Credit Limit',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 300,
            'system' => false,
            /* 'user_defined' =>true,*/
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'itm_credit_limit')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
            ]]);
        $attribute->save();

        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'itm_credit_balance', [
            'type' => 'decimal',
            'label' => 'Credit Balance',
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 310,
            'system' => false,
            /*   'user_defined' =>true,*/
            'backend' => ''
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'itm_credit_balance')
            ->addData(['used_in_forms' => [
                'adminhtml_customer',
            ]]);
        $attribute->save();
    }

    private function updateCustomerCardCode($customerSetup)
    {
        $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_current_version = $_objectManager->get('\Magento\Framework\App\ProductMetadataInterface')->getVersion();

        if (!(version_compare($_current_version, '2.2.6') < 0))
        {
            $att_name= "itm_cardcode";
            $customerSetup->updateAttribute(\Magento\Customer\Model\Customer::ENTITY, $att_name, [
                'is_used_in_grid' => true,
                'is_visible_in_grid'=>true,
                'is_filterable_in_grid'=>true,
                'is_searchable_in_grid'=>true
            ]);
        }

        // update customer_eav_attribute set is_used_in_grid=1,is_visible_in_grid=1,is_filterable_in_grid=1, is_searchable_in_grid=1  where attribute_id in (select attribute_id from eav_attribute where attribute_code = 'itm_cardcode')

    }
    private function addDisplayOrderAttribute($customerSetup)
    {
        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'display_all_orders', [
            'type' => 'int',
            'label' => 'Allow contact persons to see all BP orders',
            'input' => 'select',
            'source' => 'ITM\MagB1\Model\System\Config\DisplayOrders',
            'required' => false,
            'visible' => true,
            'position' => 333,
            'system' => false,
            'backend' => ''
        ]);

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'display_all_orders')
            ->addData(['used_in_forms' => [
                'adminhtml_customer'
            ]
            ]);
        $attribute->save();
    }
    private function addCustomerCardCode($customerSetup)
    {
        $att_name= "itm_cardcode";
        $label = "Card Code";
        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, $att_name, [
            'type' => 'varchar',
            'label' => $label,
            'input' => 'text',
            'source' => '',
            'required' => false,
            'visible' => true,
            'position' => 333,
            'system' => false,
            'backend' => ''
        ]);


        $attribute = $customerSetup->getEavConfig()->getAttribute('customer', 'itm_cardcode')
            ->addData(['used_in_forms' => [
                'adminhtml_customer'
            ]]);
        $attribute->save();
    }
    private function addCustomerAddressId($customerSetup)
    {
        $att_name= "itm_address_id";
        $label = "Address ID";

        //$customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->removeAttribute('customer_address', $att_name);
        $customerSetup->addAttribute('customer_address', $att_name, [
            'label' => $label,
            'input' => 'text',
            'type' => 'varchar',
            'source' => '',
            'required' => false,
            'position' => 333,
            'visible' => true,
            'system' => false,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'backend' => ''
        ]);

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', $att_name)
            ->addData(['used_in_forms' => [
                'adminhtml_customer_address',
                //'customer_address_edit',
                //'customer_register_address'
            ]]);
        $attribute->save();

    }

}