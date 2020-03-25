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
 * @category  Ced
 * @package   Ced_Claro
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CedCommerce (http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Controller\Install;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * ResultPageFactory
     *
     * @var \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public $resultPageFactory;

    /**
     * @var \Ced\Claro\Helper\Sdk $sdk
     */
    public $sdk;

    /**
     * Product constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Ced\Claro\Helper\Sdk $sdk
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Ced\Claro\Helper\Sdk $sdk
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->sdk = $sdk;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $code = $this->getRequest()->getParam('code');
        if (!empty($code)) {
            $status = $this->sdk->install($code);
            if ($status == true) {
                $this->messageManager->addSuccessMessage('Claro application successfully installed.');
            }
        }
        return $resultPage;
    }
}
