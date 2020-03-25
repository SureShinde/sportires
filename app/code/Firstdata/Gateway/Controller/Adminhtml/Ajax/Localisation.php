<?php

namespace Firstdata\Gateway\Controller\Adminhtml\Ajax;

class Localisation extends \Magento\Backend\App\Action {

    protected $resultJsonFactory;
    protected $localisation;

    public function __construct(
    \Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Firstdata\Gateway\Model\Adminhtml\Source\Localisation $localisation
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->localisation = $localisation;
        parent::__construct($context);
    }

    /**
     * Hello test controller page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {
        $result_page = $this->resultJsonFactory->create();
        if ($this->getRequest()->isAjax()) {
            $country = $this->getRequest()->getParam('country');
            $resellers = $this->localisation->items($country);
            $result_array = array();

            foreach ($resellers as $reseller => $reseller_details) {
                $reseller_details['value'] = $reseller;
                $reseller_details['label'] = $reseller_details['reseller_name'];
                $result_array[] = $reseller_details;
            }
            return $result_page->setData($result_array);
        }
    }

    /**
     * Check Permission.
     *
     * @return bool
     */
    protected function _isAllowed() {
        return $this->_authorization->isAllowed('Firstdata_Gateway::fgateway');
    }

}