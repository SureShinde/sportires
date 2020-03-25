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
 * @author        CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license      http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Controller\Adminhtml\Profile;

/**
 * Class Save
 * @package Ced\Claro\Controller\Adminhtml\Profile
 */
class Save extends \Ced\Claro\Controller\Adminhtml\Profile\Base
{
    public function execute()
    {
        $id = $this->getRequest()->getParam(\Ced\Claro\Model\Profile::COLUMN_ID, null);
        $back = $this->getRequest()->getParam('back', false);

        if ($this->validate()) {
            $this->resource->load($this->profile, $this->data->getData(\Ced\Claro\Model\Profile::COLUMN_ID));
            $this->profile->setData(
                \Ced\Claro\Model\Profile::COLUMN_STATUS,
                $this->data->getData(\Ced\Claro\Model\Profile::COLUMN_STATUS)
            );
            $this->profile->setData(
                \Ced\Claro\Model\Profile::COLUMN_NAME,
                $this->data->getData(\Ced\Claro\Model\Profile::COLUMN_NAME)
            );
            $this->profile->setData(
                \Ced\Claro\Model\Profile::COLUMN_CATEGORY,
                $this->data->getData(\Ced\Claro\Model\Profile::COLUMN_CATEGORY)
            );

            // Processing attribute mapping
            $this->addAttributes();
            $this->profile->setData(
                \Ced\Claro\Model\Profile::COLUMN_REQUIRED_ATTRIBUTES,
                json_encode($this->data->getData(\Ced\Claro\Model\Profile::COLUMN_REQUIRED_ATTRIBUTES))
            );
            $this->profile->setData(
                \Ced\Claro\Model\Profile::COLUMN_OPTIONAL_ATTRIBUTES,
                json_encode($this->data->getData(\Ced\Claro\Model\Profile::COLUMN_OPTIONAL_ATTRIBUTES))
            );
            // Processing shipping methods
            $this->profile->setData(
                \Ced\Claro\Model\Profile::COLUMN_SHIPPING_METHODS,
                json_encode($this->data->getData(\Ced\Claro\Model\Profile::COLUMN_SHIPPING_METHODS))
            );

            $this->resource->save($this->profile);
            $id = $this->profile->getId();

            $inProfileProducts = $this->getRequest()->getParam('in_profile_products');
            if (!empty($inProfileProducts)) {
                try {
                    // Updating products
                    $storeId = $this->config->getStoreId();
                    // TODO: optimize: use difference to add or remove products
                    $ids = $this->product->getIds($id);
                    $this->product->remove(
                        $id,
                        $storeId,
                        $ids
                    );

                    $updateIds = explode(',', $inProfileProducts);
                    if (!empty($updateIds) && is_array($updateIds)) {
                        $this->product->add(
                            $id,
                            $storeId,
                            $updateIds
                        );
                    }
                } catch (\Exception $e) {
                    //TODO: log
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            }

            $this->messageManager->addSuccessMessage('Profile saved successfully.');
            $this->getRequest()->setParams([]);
        } else {
            $this->messageManager->addErrorMessage('Profile saving failed. Kindly try again.');
        }

        /** @var \Magento\Framework\Controller\Result\Redirect $redirect */
        $redirect = $this->resultRedirectFactory->create();
        if (isset($back) && $back == 'edit') {
            if ($id) {
                $redirect->setPath(
                    '*/profile/edit',
                    ['id' => $id]
                );
            } else {
                $redirect->setPath(
                    '*/profile/edit'
                //, ['_current' => true] // current adds the params in url.
                );
            }
        } else {
            $redirect->setPath('*/profile/index');
        }

        return $redirect;
    }
}
