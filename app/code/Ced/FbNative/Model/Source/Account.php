<?php

namespace Ced\FbNative\Model\Source;


use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;

class Account extends ArrayBackend
{
    public $objectManager;

    public $accounts;

    public function __construct()
    {
        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Ced\FbNative\Model\Account $AccountCollection */
        $AccountCollection = $this->objectManager->create(\Ced\FbNative\Model\Account::class)->getCollection();
        $this->accounts = $AccountCollection->getData();
    }

    public function getAllOptions() {
        $accountArray = array();

        $accountArray[] = array(
            'label' => '--Select Store--',
            'value' => ''
        );

        foreach ($this->accounts as $account) {
            $accountArray[] = array(
                'label' => $account['page_name'],
                'value' => $account['id']
            );
        }
        return $accountArray;
    }

    /*public function toOptionArray() {

        $accountArray = array();

        $accountArray[] = array(
            'label' => '--Select Store--',
            'value' => ''
        );

        foreach ($this->accounts as $account) {
            $accountArray[] = array(
                'label' => $account['page_name'],
                'value' => $account['id']
            );
        }
        return $accountArray;
    }*/
}