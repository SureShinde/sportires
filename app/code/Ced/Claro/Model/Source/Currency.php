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

namespace Ced\Claro\Model\Source;

use Magento\Framework\Option\ArrayInterface;

class Currency implements ArrayInterface
{
    /** @var \Ced\Claro\Helper\Sdk  */
    public $sdk;

    public function __construct(
        \Ced\Claro\Helper\Sdk $sdk
    ) {
        $this->sdk = $sdk;
    }

    /*
     * Option getter
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getAllOptions();
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        $currencies = [];

        /** @var \Ced\Claro\Sdk\Product $product */
        $product = $this->sdk->getProduct();

        $response = $product->getAllClaroCurrencies();
        foreach ($response as $value) {
            $currencies[] = [
                'label' => $value['description'],
                'value' => $value['id']
            ];
        }

        return $currencies;
    }
}
