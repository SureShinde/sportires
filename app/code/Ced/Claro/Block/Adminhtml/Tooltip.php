<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Block\Adminhtml;

class Tooltip extends \Magento\Backend\Block\Template
{
    //TODO: fix
    const DEFAULT_URL = 'https://docs.cedcommerce.com/';

    public function getTooltipUrl()
    {
        $url = self::DEFAULT_URL;
        if ($this->hasData('tooltip_url')) {
            $url = $this->getData('tooltip_url');
        }

        return $url;
    }
}
