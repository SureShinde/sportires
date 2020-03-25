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

namespace Ced\WalmartMx\Block\Adminhtml\Profile\Edit\Tab\Attribute;

use Magento\Backend\Block\Widget;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;

/**
 * Rolesedit Tab Display Block.
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class CategoryJs extends Widget implements RendererInterface
{
    public $_template = 'profile/category.phtml';

    public $_profile;

    public $_coreRegistry;

    public $walmartmx;

    /**
     * CategoryJs constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \WalmartMxSdk\Product                     $walmartmx
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Ced\WalmartMx\Helper\Config $config,
        \WalmartMxSdk\ProductFactory $walmartmx,
        $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_profile = $this->_coreRegistry->registry('current_profile');
        $this->walmartmx = $walmartmx->create(['config' => $config->getApiConfig()]);
        parent::__construct($context, $data);
    }

    /**
     * Get current level of WalmartMx category
     *
     * @param  integer $level
     * @return string
     */
    public function getLevel($level)
    {
        $option = [];
        /*$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $location = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')
            ->getValue('walmartmx_config/walmartmx_setting/location');
        $locationList = $objectManager->get('Ced\WalmartMx\Model\Config\Location')->toOptionArray();
        foreach ($locationList as $value) {
            if ($value['value'] == $location) {
                $locationName = $value['label'];
            }
        }
        $mediaDirectory = $objectManager->get('\Magento\Framework\Filesystem')
            ->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::APP);
        $folderPath = $mediaDirectory->getAbsolutePath('code/Ced/WalmartMx/Setup/json/');
        $path = $folderPath . $locationName . '/categoryLevel-' . $level . '.json';
        $rootlevel = $objectManager->get('Ced\WalmartMx\Helper\Data')->loadFile($path);
        $options = isset($rootlevel['CategoryArray']['Category']) ? $rootlevel['CategoryArray']['Category'] : [];
        foreach ($options as $value) {
            if ($value['CategoryLevel'] == $level) {
                $option[] = $value;
            }
        }*/
        return $option;
    }

    /**
     * Render form element as HTML
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }
}
