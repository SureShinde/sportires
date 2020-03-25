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
namespace Ced\FbNative\Model\ResourceModel\Feed;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function _construct()
    {
        $this->_init('Ced\FbNative\Model\Feeds', 'Ced\FbNative\Model\ResourceModel\Feed');
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }
}
