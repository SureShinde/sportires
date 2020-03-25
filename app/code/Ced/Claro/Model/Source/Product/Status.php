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
 * @package   Ced_Claro
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Model\Source\Product;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * Class Status
 *
 * @package Ced\Claro\Model\Source
 */
class Status extends AbstractSource
{
    const INVALID = 'invalid'; // custom
    const NOT_UPLOADED = 'not_uploaded'; // custom
    const UPLOADED = 'uploaded';  // custom
    const UNDER_REVIEW = 'under_review';
    const ACTIVE = 'active';
    const PAUSED = 'paused';
    const CLOSED = 'closed';

    /**
     * @return array
     */
    public function getAllOptions()
    {
        return [
            [
                'value' => self::NOT_UPLOADED,
                'label' => __('Not Uploaded')
            ],
            [
                'value' => self::INVALID,
                'label' => __('Invalid')
            ],
            [
                'value' => self::UPLOADED,
                'label' => __('Uploaded')
            ],
            [
                'value' => self::UNDER_REVIEW,
                'label' => __('Under Review')
            ],
            [
                'value' => self::ACTIVE,
                'label' => __('Active')
            ],
            [
                'value' => self::PAUSED,
                'label' => __('Paused')
            ],
            [
                'value' => self::CLOSED,
                'label' => __('Deleted')
            ]
        ];
    }
}
