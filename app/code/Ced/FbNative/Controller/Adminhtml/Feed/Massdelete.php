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

namespace Ced\FbNative\Controller\Adminhtml\Feed;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Ui\Component\MassAction\Filter;
use Ced\FbNative\Model\ResourceModel\Feed\CollectionFactory;
use Magento\Eav\Setup\EavSetupFactory;
/**
 * Class Massdelete
 * @package Ced\FbNative\Controller\Adminhtml\Feed
 */
class Massdelete extends Action
{
    /**
     * @var CollectionFactory
     */
    public $feeds;
    /**
     * @var Filter
     */
    public $filter;

    const ADMIN_RESOURCE = 'Ced_FbNative::FbNative';

    /**
     * Massdelete constructor.
     * @param Context $context
     * @param CollectionFactory $feeds
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        CollectionFactory $feeds,
        Filter $filter
    ) {
        parent::__construct($context);
        $this->feeds = $feeds;
        $this->filter = $filter;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $ids = $this->filter->getCollection($this->feeds->create())->getAllIds();
        if (!empty($ids)) {
            $collection = $this->feeds->create()->addFieldToFilter('id', ['in' => $ids]);
            if (isset($collection) and $collection->getSize() > 0) {
                $collection->walk('delete');
                $this->messageManager->addSuccessMessage(__($collection->getSize(). ' Feed(s) Deleted Successfully'));
            } else {
                $this->messageManager->addErrorMessage(__('No Feed available for Delete.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('No Feed available for Delete.'));
            
        }
        return $this->_redirect('fbnative/feed/index');
    }
}
