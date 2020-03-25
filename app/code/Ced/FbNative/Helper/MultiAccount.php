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

namespace Ced\FbNative\Helper;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class MultiAccount extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Ced\FbNative\Model\Account
     */
    protected $accountModel;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Eav\Attribute
     */
    public $eavAttribute;

    /** @var EavSetup $eavSetup */
    public $eavSetup;

    /** @var \Ced\FbNative\Model\ResourceModel\Account\CollectionFactory $accountsCollectionFactory */
    protected $accountsCollectionFactory;


    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Ced\FbNative\Model\AccountFactory $accounts,
        \Ced\FbNative\Model\ResourceModel\Account\CollectionFactory $accountsCollectionFactory,
        \Magento\Framework\Setup\ModuleDataSetupInterface $setup,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $eavAttribute
    )
    {
        parent::__construct($context);
        $this->accountModel = $accounts;
        $this->accountsCollectionFactory = $accountsCollectionFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->eavAttribute = $eavAttribute;
        $this->eavSetup = $eavSetupFactory->create(['setup' => $setup]);
    }

    public function createStoreAttribute($accId = null, $accName = null) {
        $attributeCode = 'fbnative_store_'.$accId;
        $attributeLabel = 'FbNative ' . $accName .' store';
        if (!$this->eavAttribute->getIdByCode('catalog_product', $attributeCode)) {
            $this->eavSetup->addAttribute(
                'catalog_product',
                $attributeCode,
                [
                    'group' => 'isFacebook',
                    'type' => 'text',
                    'frontend' => '',
                    'label' => $attributeLabel,
                    'input' => 'boolean',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Table::class,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => true,
                    'default' => false,
                    'searchable' => true,
                    'filterable' => true,
                    'comparable' => true,
                    'visible_on_front' => true,
                    'used_in_product_listing' => true,
                    'unique' => false,
                    'wysiwyg_enabled' => true,
                    'is_html_allowed_on_front' => true
                ]
            );
        }
    }

    public function getAccountRegistry($accId = null) {
        /** @var \Ced\FbNative\Model\Account $account */
        $account = $this->accountModel->create();

        if (isset($accId) and $accId > 0) {
            $account = $account->load($accId);
        }


        if(!$this->_coreRegistry->registry('fbnative_account'))
            $this->_coreRegistry->register('fbnative_account', $account);

        return $this->_coreRegistry->registry('fbnative_account');
    }

    public function getStoreAttrForAcc($accId = null) {
        $attributeCode = '';
        if($accId > 0) {
            $attributeCode = 'fbnative_store_' . $accId;
        } else {
            $attributeCode = '';
        }
        return $attributeCode;
    }

    public function getAllAccounts($onlyActive = false) {
        if($onlyActive)
            $accountCollection = $this->accountsCollectionFactory->create()->addFieldToFilter('account_status', 1);
        else
            $accountCollection = $this->accountsCollectionFactory->create();
        return $accountCollection;
    }

    public function getAllAttr() {
        $attributeCodes = array();
        $accounts = $this->accountsCollectionFactory->create();
        foreach ($accounts as $account) {
            $accId = $account->getId();
            if($accId > 0) {
                $attributeCodes[] = 'fbnative_store_' . $accId;
            }
        }
        return $attributeCodes;
    }
}