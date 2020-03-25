<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_AbandonedCart
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\AbandonedCart\Plugin\Data\Form\FormKey;

/**
 * Class ValidatorPlugin
 * @package Mageplaza\AbandonedCart\Data\Form\FormKey
 */
class ValidatorPlugin
{
    /**
     * @param \Magento\Framework\Data\Form\FormKey\Validator $subject
     * @param callable $proceed
     * @param \Magento\Framework\App\RequestInterface $request
     *
     * @return boolean
     */
    public function aroundValidate(\Magento\Framework\Data\Form\FormKey\Validator $subject, callable $proceed, $request)
    {
        $params = $request->getParams();
        if (isset($params['token']) && isset($params['id'])) {
            return true;
        }

        return $proceed($request);
    }
}
