<?php
/**
* CedCommerce
*
* NOTICE OF LICENSE
*
* This source file is subject to the End User License Agreement (EULA)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* https://cedcommerce.com/license-agreement.txt
*
* @category    Ced
* @package     Ced_StorePickup
* @author      CedCommerce Core Team <connect@cedcommerce.com >
* @copyright   Copyright CEDCOMMERCE (https://cedcommerce.com/)
* @license      https://cedcommerce.com/license-agreement.txt
*/
namespace Ced\StorePickup\Block;

class Listcountry extends \Magento\Directory\Block\Data
{
    /**
     * @var \Magento\Customer\Api\Data\AddressInterface|null
     */
    protected $_address = null;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Customer\Api\AddressRepositoryInterface
     */
    protected $_addressRepository;

    /**
     * @var \Magento\Customer\Api\Data\AddressInterfaceFactory
     */
    protected $addressDataFactory;

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context            $context
     * @param \Magento\Directory\Helper\Data                              $directoryHelper
     * @param \Magento\Framework\Json\EncoderInterface                    $jsonEncoder
     * @param \Magento\Framework\App\Cache\Type\Config                    $configCacheType
     * @param \Magento\Directory\Model\Resource\Region\CollectionFactory  $regionCollectionFactory
     * @param \Magento\Directory\Model\Resource\Country\CollectionFactory $countryCollectionFactory
     * @param \Magento\Customer\Model\Session                             $customerSession
     * @param \Magento\Customer\Api\AddressRepositoryInterface            $addressRepository
     * @param \Magento\Customer\Api\Data\AddressInterfaceFactory          $addressDataFactory
     * @param \Magento\Customer\Helper\Session\CurrentCustomer            $currentCustomer
     * @param \Magento\Framework\Api\DataObjectHelper                     $dataObjectHelper
     * @param array                                                       $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Directory\Helper\Data $directoryHelper,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\App\Cache\Type\Config $configCacheType,
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
        \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        array $data = []
    ) {
        
        $this->_customerSession = $customerSession;
        $this->currentCustomer = $currentCustomer;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct(
            $context,
            $directoryHelper,
            $jsonEncoder,
            $configCacheType,
            $regionCollectionFactory,
            $countryCollectionFactory,
            $data
        );
    }
}