<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Mpa\Helper;


use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class ConfigData
 * @package Yosto\Mpa\Helper
 */
class ConfigData extends AbstractHelper
{
    /**
     * @param null $storeId
     * @return mixed
     */
    public function getAllowedActions($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'yosto_mpa/general/allow_actions',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}