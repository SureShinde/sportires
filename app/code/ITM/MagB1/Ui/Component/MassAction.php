<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ITM\MagB1\Ui\Component;


class MassAction extends \Magento\Ui\Component\MassAction
{

    /**
     * @inheritDoc
     */
    public function prepare()
    {

        parent::prepare();

        $allow_delete_order = \Magento\Framework\App\ObjectManager::getInstance()
            ->create('\ITM\MagB1\Helper\Data')->allowDeleteOrders();
        if(!$allow_delete_order) {
            $config = $this->getConfiguration();
            $allowedActions = [];
            foreach ($config['actions'] as $action) {
                if ('magb_delete' != $action['type']) {
                    $allowedActions[] = $action;
                }
            }
            $config['actions'] = $allowedActions;
            $this->setData('config', (array)$config);
        }
    }
}
