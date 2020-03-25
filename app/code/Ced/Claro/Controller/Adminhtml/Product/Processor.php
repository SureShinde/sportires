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

namespace Ced\Claro\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;

class Processor extends Action
{
    const ACTIONS = [
        \Ced\Claro\Helper\Config::ACTION_PRODUCT_UPLOAD => 'upload',
        \Ced\Claro\Helper\Config::ACTION_PRODUCT_UPDATE => 'update',
        \Ced\Claro\Helper\Config::ACTION_PRODUCT_UPDATE_DESCRIPTION => 'updateDescription',
        \Ced\Claro\Helper\Config::ACTION_PRODUCT_DELETE => 'delete',
        \Ced\Claro\Helper\Config::ACTION_PRODUCT_PAUSE => 'pause',
        \Ced\Claro\Helper\Config::ACTION_PRODUCT_REACTIVATE => 'reactivate',
    ];

    /** @var \Ced\Claro\Helper\Product  */
    public $product;

    /** @var \Magento\Backend\Model\Session  */
    public $session;

    /**
     * @param \Magento\Backend\App\Action\Context        $context
     */
    public function __construct(
        Action\Context $context,
        \Ced\Claro\Helper\Product $product
    ) {
        parent::__construct($context);
        $this->product = $product;
        $this->session =  $context->getSession();
    }

    public function execute()
    {
        $response = [
            'success' => false,
            'message' => 'Unable to process the invalid request.'
        ];

        $action = $this->getRequest()->getParam('action');
        $key = $this->getRequest()->getParam('unique_key');
        $id = $this->getRequest()->getParam('id');
        $last = $this->getRequest()->getParam('last', false);
        if (isset($action, $key, $id, self::ACTIONS[$action]) && !empty($action)) {
            $name = 'get'.$key;
            $queue = $this->session->$name();

            if (isset($queue[$id]) && is_array($queue[$id])) {
                $name = self::ACTIONS[$action];
                $report = $this->product->$name($queue[$id]);
                $response['success'] = true;
                $response['report'] = $report;
                $response['message'] =
                    "Product {$name} request submitted successfully. Kindly check the Product errors.";
            }

            if ($last === 'true') {
                $name = 'uns'.$key;
                $this->session->$name();
            }
        }

        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $result->setData($response);
        return $result;
    }
}
