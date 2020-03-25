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
 * @package   Ced_WalmartMx
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CedCommerce (http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\WalmartMx\Controller\Adminhtml\Profile;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use Magento\Framework\DataObject;

/**
 * Class Save
 *
 * @package Ced\WalmartMx\Controller\Adminhtml\Profile
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    public $registory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    public $catalogCollection;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    public $categoryCollection;

    /**
     * @var \Ced\WalmartMx\Model\ProfileProductFactory
     */
    public $profileProduct;

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    public $moduleDataSetup;

    /**
     * @var \Ced\WalmartMx\Model\ProfileFactory
     */
    public $profileFactory;

    /**
     * @var \Ced\WalmartMx\Helper\Profile
     */
    public $profileHelper;

    /**
     * @var DataObject
     */
    public $data;

    public $logger;
    public $walmartmxCache;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registory,
        \Magento\Config\Model\Config\Structure $configStructure,
        \Magento\Config\Model\Config\Factory $configFactory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollection,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $catalogCollection,
        \Magento\ConfigurableProduct\Model\Product\Type\ConfigurableFactory $configurable,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\DataObject $data,
        \Psr\Log\LoggerInterface $logger,
        \Ced\WalmartMx\Model\ProfileProductFactory $profileProduct,
        \Ced\WalmartMx\Model\ProfileFactory $profileFactory,
        \Ced\WalmartMx\Helper\Cache $walmartmxCache,
        \Ced\WalmartMx\Helper\Profile $profileHelper
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->configStructure = $configStructure;
        $this->registory = $registory;
        $this->configFactory = $configFactory;
        $this->productConfigFactory = $configurable;
        $this->catalogCollection = $catalogCollection;
        $this->categoryCollection = $categoryCollection;
        $this->profileHelper = $profileHelper;
        $this->profileFactory = $profileFactory;
        $this->profileProduct = $profileProduct;
        $this->walmartmxCache = $walmartmxCache;
        $this->data = $data;
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->logger->info('Saving Started');
        $profileId = null;
        $returnToEdit = true;

        if ($this->validate()) {
            try {
                $profile = $this->profileFactory->create()->load($this->data->getProfileId());
                $profile->addData($this->data->getData());
                
                $profile->save();
               
                $profile->removeProducts($profile->getMagentoCategory());
                $profile->addProducts($profile->getMagentoCategory());
                $profileId = $profile->getId();
                if($profileId) {
                    $this->walmartmxCache->removeValue(\Ced\WalmartMx\Helper\Cache::PROFILE_CACHE_KEY . $profileId);
                }
                $this->messageManager->addSuccessMessage(__('Profile save successfully.'));
            } catch (\Magento\Framework\Exception\AlreadyExistsException $e) {
                $this->messageManager->addErrorMessage(__('Profile code already exists. '.$e->getMessage()));
            }    
            catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
            
        }


        $resultRedirect = $this->resultRedirectFactory->create();
        if ($returnToEdit) {
            if ($profileId) {
                $resultRedirect->setPath(
                    'walmartmx/profile/edit',
                    ['id' => $profileId, '_current' => true]
                );
            } else {
                $resultRedirect->setPath(
                    'walmartmx/profile/edit',
                    ['_current' => true]
                );
            }
        } else {
            $resultRedirect->setPath('walmartmx/profile/index');
        }
        $this->logger->info('Saving Ended');
        return $resultRedirect;
    }

    private function validate()
    {
  
        $generalInformation = $this->getRequest()->getParam('general_information');
        $offer_information = $this->getRequest()->getParam('offer_information');
        $walmartmx = $this->getRequest()->getParam('walmartmx');
        $store_categories = $this->getRequest()->getParam('store_categories');
        $walmartmxAttributes = $this->getRequest()->getParam('walmartmx_attributes');

        if (!empty($walmartmxAttributes)) {
            $walmartmxAttributes = $this->mergeAttributes($walmartmxAttributes, 'name');

            $requiredAttributes = $optionalAttributes = [];

            foreach ($walmartmxAttributes as $walmartmxAttribute_key => $walmartmxAttribute_value) {
                if (isset($walmartmxAttribute_value['delete']) and $walmartmxAttribute_value['delete']) {
                     continue;   
                }        
                if (isset($walmartmxAttribute_value['isMandatory']) and $walmartmxAttribute_value['isMandatory'] == 'true') {
                    $requiredAttributes[$walmartmxAttribute_key] = $walmartmxAttribute_value;
                } else {
                    $optionalAttributes[$walmartmxAttribute_key] = $walmartmxAttribute_value;
                    $optionalAttributes[$walmartmxAttribute_key]['isMandatory'] = 0;
                }
            }

            $this->data->setData('profile_required_attributes', json_encode($requiredAttributes));
            $this->data->setData('profile_optional_attributes', json_encode($optionalAttributes));
        }
        //$this->data->addData($offer_information);
        $this->data->addData($generalInformation);

        if (isset($walmartmx)) {
            $this->data->setData('profile_categories', json_encode($walmartmx));
            $this->data->setData('profile_category', end($walmartmx));
        }


        if (isset($store_categories['magento_category'])) {
            $this->data->setData('magento_category', json_encode($store_categories['magento_category']));
        }

        if (isset($generalInformation['profile_name'])) {
            $this->data->addData($generalInformation);
        }


        if (!$this->data->getProfileCode() or !$this->data->getProfileName()) {
            return false;
        }

        return true;
        
    }


    /**
     * @param $array
     * @param $key
     * @return array
     */
    private function mergeAttributes($attributes, $key)
    {

        $tempArray = [];
        $i = 0;
        $keyArray = [];

        if (!empty($attributes) and is_array($attributes)) {
            foreach ($attributes as $val) {
                if (isset($val['delete']) and $val['delete']  == 1) {
                    continue;
                }
                if (!in_array($val[$key], $keyArray)) {
                    $keyArray[$val[$key]] = $val[$key];
                    $tempArray[$val[$key]] = $val;
                }
                $i++;
            }
        }

        return $tempArray;
    }

}
