<?php

namespace Ced\Claro\Controller\Adminhtml\Config;

/**
 * Class Save
 * @package Ced\Claro\Controller\Adminhtml\Config
 */
class Save extends \Magento\Backend\App\Action
{
    /** @var \Magento\Config\Model\ResourceModel\Config */
    public $configWriter;

    /** @var \Ced\Claro\Helper\Config */
    public $config;

    public $cacheTypeList;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Config\Model\ResourceModel\Config $configWriter,
        \Ced\Claro\Helper\Config $config
    ) {
        parent::__construct($context);
        $this->cacheTypeList = $cacheTypeList;
        $this->configWriter = $configWriter;
        $this->config = $config;
    }

    public function execute()
    {
        $response = [
            'success' => false,
            'message' => __('App credentials are invalid. App saving failed.'),
            'redirect_uri' => null
        ];

        $appId = $this->getRequest()->getParam('app_id');
        $siteId = $this->getRequest()->getParam('site_id');
        $endPointUri = $this->getRequest()->getParam('endpoint_uri');
        $publicKey = $this->getRequest()->getParam('public_key');
        $privateKey = $this->getRequest()->getParam('private_key');
//        $secretKey = $this->getRequest()->getParam('secret_key');
        if (isset($endPointUri, $publicKey, $privateKey, $appId, $siteId)
            && !empty($appId) && !empty($endPointUri) && !empty($privateKey)
            && !empty($publicKey) && !empty($siteId)) {
            $this->configWriter->saveConfig(\Ced\Claro\Helper\Config::CONFIG_PATH_SITE_ID, $siteId, 'default', 0);
            $this->configWriter->saveConfig(\Ced\Claro\Helper\Config::CONFIG_PATH_APP_ID, $appId, 'default', 0);
//            $this->configWriter->saveConfig(
//                \Ced\Claro\Helper\Config::CONFIG_PATH_SECRET_KEY,
//                $secretKey,
//                'default',
//                0
//            );
            $this->configWriter->saveConfig(
                \Ced\Claro\Helper\Config::CONFIG_PATH_PUBLIC_KEY,
                $publicKey,
                'default',
                0
            );
            $this->configWriter->saveConfig(
                \Ced\Claro\Helper\Config::CONFIG_PATH_PRIVATE_KEY,
                $privateKey,
                'default',
                0
            );
            $this->configWriter->saveConfig(
                \Ced\Claro\Helper\Config::CONFIG_PATH_ENDPOINT_URI,
                $endPointUri,
                'default',
                0
            );
            // Cleaning cache manually for quick authorization on frontend.
            $this->cacheTypeList->cleanType('config');
            $response['success'] = true;
            $response['message'] =
                __('App credentials are saved successfully. Kindly authorize in the next tab.');
            $response['redirect_uri'] =
                \Ced\Claro\Sdk\Url::getAuthUrl(
                    $siteId,
                    ['response_type' => 'code', 'client_id' => $appId]
                );
        }

        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        $result->setData($response);

        return $result;
    }
}
