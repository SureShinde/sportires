<?php
namespace ITM\MagB1\Model;

use Magento\Store\Api\StoreResolverInterface;
use Magento\Framework\App\RequestInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Magb1StoreManager extends \Magento\Store\Model\StoreManager
{

    /**
     * Request instance
     *
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     *
     * @param \Magento\Store\Api\StoreRepositoryInterface $storeRepository
     * @param \Magento\Store\Api\GroupRepositoryInterface $groupRepository
     * @param \Magento\Store\Api\WebsiteRepositoryInterface $websiteRepository
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param StoreResolverInterface $storeResolver
     * @param \Magento\Framework\Cache\FrontendInterface $cache
     * @param bool $isSingleStoreAllowed
     */
    public function __construct(
        \Magento\Store\Api\StoreRepositoryInterface $storeRepository,
        \Magento\Store\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Store\Api\WebsiteRepositoryInterface $websiteRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        StoreResolverInterface $storeResolver,
        \Magento\Framework\Cache\FrontendInterface $cache,
        RequestInterface $request,
        $isSingleStoreAllowed = true
    ) {
        $this->storeRepository = $storeRepository;
        $this->websiteRepository = $websiteRepository;
        $this->groupRepository = $groupRepository;
        $this->scopeConfig = $scopeConfig;
        $this->storeResolver = $storeResolver;
        $this->cache = $cache;
        $this->request = $request;
        $this->isSingleStoreAllowed = $isSingleStoreAllowed;
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function getStore($storeId = null)
    {
        if ($this->request->isPut() && strlen($this->request->getParam('storeId'))) {
            return parent::getStore($this->request->getParam('storeId'));
        }
        return parent::getStore($storeId);
    }
}
