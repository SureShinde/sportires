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
 * @package   Ced_FbNative
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\FbNative\Block\Adminhtml\Config\Field;

use Magento\Config\Block\System\Config\Form\Field;


class FbNativeUrl extends Field
{

    public function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return '<strong id = "fbnativeconfiguration_fbnativesetting_fbnative_exportcsv">'.$this->getBaseUrl()."pub/media/ced_fbnative/export.csv".'</strong>';
    }
}