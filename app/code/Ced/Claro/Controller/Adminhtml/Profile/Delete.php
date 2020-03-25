<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * You can check the licence at this URL: http://cedcommerce.com/license-agreement.txt
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * @category    Ced
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com >
 * @copyright   Copyright CEDCOMMERCE (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Controller\Adminhtml\Profile;

/**
 * Class Delete
 * @package Ced\Claro\Controller\Adminhtml\Profile
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    public $filter;

    /** @var \Ced\Claro\Model\ResourceModel\Profile\CollectionFactory */
    public $collection;

    /** @var \Ced\Claro\Model\Profile\Product */
    public $product;

    /** @var \Ced\Claro\Helper\Logger */
    public $logger;

    /** @var \Ced\Claro\Helper\Config */
    public $config;

    public $resource;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Ced\Claro\Model\ResourceModel\Profile\CollectionFactory $collection,
        \Ced\Claro\Model\ResourceModel\Profile $resource,
        \Ced\Claro\Model\Profile\Product $product,
        \Ced\Claro\Helper\Config $config,
        \Ced\Claro\Helper\Logger $logger
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->config = $config;
        $this->logger = $logger;
        $this->collection = $collection;
        $this->resource = $resource;
        $this->product = $product;
    }

    public function execute()
    {
        try {
            $isFilter = $this->getRequest()->getParam('filters');

            if (isset($isFilter)) {
                $collection = $this->filter->getCollection($this->collection->create());
            } else {
                $id = $this->getRequest()->getParam('id');
                if (isset($id) && !empty($id)) {
                    $collection = $this->collection->create()->addFieldToFilter('id', ['eq' => $id]);
                }
            }

            $status = false;
            if (isset($collection) and $collection->getSize() > 0) {
                $status = true;
                $storeId = $this->config->getStoreId();
                foreach ($collection->getItems() as $profile) {
                    $this->resource->delete($profile);
                    if ($profile->isDeleted()) {
                        $this->product->remove($profile->getId(), $storeId);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['path' => __METHOD__]);
        }

        if ($status) {
            $this->messageManager->addSuccessMessage('Profile(s) deleted successfully.');
        } else {
            $this->messageManager->addErrorMessage('Profile(s) delete failed or no profiles available.');
        }

        return $this->_redirect('*/profile/index');
    }
}
