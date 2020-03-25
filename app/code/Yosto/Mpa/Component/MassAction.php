<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Mpa\Component;


use Magento\Framework\App\ObjectManager;
use Magento\Ui\Component\AbstractComponent;

/**
 * Class MassAction
 * @package Yosto\Mpa\Component
 */
class MassAction extends AbstractComponent
{
    const NAME = 'massaction';
    /**
     * @inheritDoc
     */
    public function prepare()
    {
        $config = $this->getConfiguration();

        foreach ($this->getChildComponents() as $actionComponent) {
            $config['actions'][] = $actionComponent->getConfiguration();
        };

        $origConfig = $this->getConfiguration();
        if ($origConfig !== $config) {
            $config = array_replace_recursive($config, $origConfig);
        }

        $newConfigActions = [];
        foreach ($config['actions'] as $configItem) {
            if(in_array($configItem['type'], $this->getRemoveActionTypes())) {
                continue;
            }
            $newConfigActions[] = $configItem;
        }

        $config['actions'] = $newConfigActions;
        $this->setData('config', $config);
        $this->components = [];

        parent::prepare();
    }

    /**
     * Get allowed actions from configuration
     *
     * @return mixed
     */
    public function getAllowActions()
    {
        /** @var \Yosto\Mpa\Helper\ConfigData $dataHelper */
        $dataHelper = ObjectManager::getInstance()->create(\Yosto\Mpa\Helper\ConfigData::class);
        return $dataHelper->getAllowedActions();
    }

    /**
     * Get removed action types
     *
     * @return array
     */
    public function getRemoveActionTypes() {
        $allowActions = explode(",",$this->getAllowActions());

        /** @var \Yosto\Mpa\Model\Config\Source\Actions $actions */
        $actions = ObjectManager::getInstance()->create(\Yosto\Mpa\Model\Config\Source\Actions::class);

        $removeTypes = [];
        foreach ($actions->mapActionTypes() as $key => $value) {
            if (!in_array($key, $allowActions)) {
                $removeTypes[] = $value;
            }
        }

        return $removeTypes;

    }

    /**
     * Get component name
     *
     * @return string
     */
    public function getComponentName()
    {
        return static::NAME;
    }
}