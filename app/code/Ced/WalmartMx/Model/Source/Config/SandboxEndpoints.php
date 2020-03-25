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
 * @package   Ced_WalmartMx
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\WalmartMx\Model\Source\Config;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class ServiceUrl
 * @package Ced\WalmartMx\Model\Source
 */
class SandboxEndpoints extends AbstractSource
{
    /**
     * @return array
     */
    public function getAllOptions()
    {
        $serviceUrls = [];

        $serviceUrls[] = [
            'value' => \WalmartMxSdk\Core\Request::WALMARTMX_SANDBOX_API_URL,
            'label' => __('Sandbox API URL'),
        ];

        return $serviceUrls;
    }
}
