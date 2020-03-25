<?php

namespace ITM\MagB1\Plugin\Group;

use Magento\Customer\Controller\RegistryConstants;

class Form
{
    /**
     * @var \Magento\Tax\Helper\Data
     */
    protected $_taxHelper;
    /**
     * @var \Magento\Customer\Api\Data\GroupInterfaceFactory
     */
    protected $groupDataFactory;

    /**
     * @var   \Magento\Framework\Registry $coreRegistry
     */
    protected $_coreRegistry;

    /**
     * @var   \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroupCollection
     */
    protected $_customerGroupCollection;

    protected $_filterBuilder;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var \Magento\Customer\Model\GroupFactory
     */
    protected $_groupFactory;

    /**
     *
     * @var \ITM\MagB1\Helper\Data
     */
    private $helper;

    /**
     * @param \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
     * @param \Magento\Customer\Api\Data\GroupInterfaceFactory $groupDataFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Tax\Helper\Data $taxHelper,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Customer\Api\Data\GroupInterfaceFactory $groupDataFactory,
        \Magento\Customer\Model\ResourceModel\Group\Collection $customerGroupCollection,
        \Magento\Customer\Model\GroupFactory $groupFactory,
        \ITM\MagB1\Helper\Data $helper
    )
    {
        $this->_filterBuilder = $filterBuilder;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_coreRegistry = $coreRegistry;
        $this->_taxHelper = $taxHelper;
        $this->_groupRepository = $groupRepository;
        $this->groupDataFactory = $groupDataFactory;
        $this->_customerGroupCollection = $customerGroupCollection;
        $this->_groupFactory = $groupFactory;
        $this->helper = $helper;
    }

    public function afterSetForm(
        \Magento\Customer\Block\Adminhtml\Group\Edit\Form $forma)
    {
        $groupId = $this->_coreRegistry->registry(RegistryConstants::CURRENT_GROUP_ID);

        $value = "";
        if ($groupId === null) {
        } else {
            //$customerGroup = $this->_customerGroupCollection->addFieldtoFilter("customer_group_id", $groupId)->getFirstItem();
            $customerGroup = $this->_groupFactory->create();
            $customerGroup->load($groupId);
            $value = $customerGroup->getData("itm_payment_methods");
        }
        $methods = $this->helper->getPaymentMethodList();
        $options = [];
        $options[] = ["value" => "", "label" => "-- None --"];
        foreach ($methods as $method) {
            $options[] = ["value" => $method["code"], "label" => $method["model"]["title"]];
        }
        $form = $forma->getForm();
        $fieldset = $form->getElement('base_fieldset');
        $payments = $fieldset->addField('itm_payment_methods',
            'multiselect',
            [
                'name' => 'itm_payment_methods',
                'label' => __('Disabled Payment Methods'),
                'title' => __('Disabled Payment Methods'),
                'values' => $options,
            ]);
        $form->addValues(
            [
                'itm_payment_methods' => $value,
            ]
        );
        return $forma->getForm();
    }

    public function afterExecute(\Magento\Customer\Controller\Adminhtml\Group\Save $save, $result)
    {

        $itm_payment_methods = $save->getRequest()->getParam('itm_payment_methods');
        $code = $save->getRequest()->getParam('code');

        if (empty($code)) {
            $code = 'NOT LOGGED IN';
        }
        \Magento\Framework\App\ObjectManager::getInstance()->create('\ITM\MagB1\Helper\Data')->_log($code);

        $_filter = [$this->_filterBuilder->setField('customer_group_code')->setConditionType('eq')->setValue($code)->create()];
        $customerGroups = $this->_groupRepository->getList($this->_searchCriteriaBuilder->addFilters($_filter)->create())->getItems();
        $customerGroup = array_shift($customerGroups);
        if ($customerGroup) {
            $group = $this->_groupFactory->create();
            $group->load($customerGroup->getId());
            $group->setCode($customerGroup->getCode());
            $group->setData('itm_payment_methods', implode(",", $itm_payment_methods));
            $group->save();
        }
        return $result;

    }
}