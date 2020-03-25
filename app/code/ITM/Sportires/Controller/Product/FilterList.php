<?php

namespace ITM\Sportires\Controller\Product;

use Magento\Framework\App\Action\Context;

class FilterList extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Catalog\Api\CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;



    protected $_helper;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \ITM\Sportires\Helper\Data $helper
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->categoryRepository = $categoryRepository;
        $this->_storeManager = $storeManager;
        $this->resultPageFactory = $resultPageFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        $type = $this->getRequest()->getParam('type');
        $size_array = [];
        $category = 0;

        if ($type == "vehicle") {
            $make = $this->getRequest()->getParam('make');
            $year = $this->getRequest()->getParam('year');
            $model = $this->getRequest()->getParam('model');
            $trim = $this->getRequest()->getParam('trim');
            $category = $this->getRequest()->getParam('category');

            $size_array = $this->helper->getSizes($make, $year, $model, $trim);


            //tire_size=541,553

            $size_option_id_list = array_column($size_array, 'size_option_id');
            $size_option_ids = "";
            if (count($size_option_id_list) > 0) {
                $size_option_ids = implode(",", $size_option_id_list);
            }

            $url = $this->_url->getUrl("sportires/product/filterlist")."?tire_size=".$size_option_ids.'&product_list_dir=asc';//."&cat_id=".$category;
            echo "<script> document.location = '".$url."';</script>";
            return;
            //return $this->resultRedirectFactory->create()->setPath('sportires/product/filterlist/?tire_size='.$size_option_ids);

        }
        $cat_id = 3; //$store->getRootCategoryId()
        $store = $this->_storeManager->getStore();
        $category = $this->categoryRepository->get(
            $cat_id
        );

        $this->_coreRegistry->register('current_category', $category);

        $page = $this->resultPageFactory->create();
		
		/* Search Popup */
		$searched_tire ="Resultados para tu búsqueda";
		
		if($type == "size"){ 
			$searched_tire = "Resultados para tu búsqueda: ";
			
			$tire_width = $this->getRequest()->getParam('tire_width');
			if($tire_width != null){
				$tire1 = $this->getRequest()->getParam('tire1');
				$searched_tire = $searched_tire . $tire1;
			}
			$tire_ratio = $this->getRequest()->getParam('tire_ratio');
			if($tire_ratio != null){
				$tire2 = $this->getRequest()->getParam('tire2');
				$searched_tire = $searched_tire .'/'. $tire2;
			}
			$tire_diameter = $this->getRequest()->getParam('tire_diameter');
			if($tire_diameter != null){
				$tire3 = $this->getRequest()->getParam('tire3');
				$searched_tire = $searched_tire .'R'. $tire3;
			}
			
		}
		if($type == "moto"){ 
			$searched_tire = "Resultados para tu búsqueda: ";
			
			$moto_tire_width = $this->getRequest()->getParam('moto_tire_width');
			if($moto_tire_width != null){
				$tire1 = $this->getRequest()->getParam('tire1');
				$searched_tire = $searched_tire . $tire1;
			}
			$moto_tire_ratio = $this->getRequest()->getParam('moto_tire_ratio');
			if($moto_tire_ratio != null){
				$tire2 = $this->getRequest()->getParam('tire2');
				$searched_tire = $searched_tire .'/'. $tire2;
			}
			$moto_tire_diameter = $this->getRequest()->getParam('moto_tire_diameter');
			if($moto_tire_diameter != null){
				$tire3 = $this->getRequest()->getParam('tire3');
				$searched_tire = $searched_tire .'R'. $tire3;
			}
		}
		$page->getLayout()->getBlock('newsearch')->setSearch($searched_tire);
		/* Search Popup */
		
        $page->getLayout()->getBlock('page.main.title')->setPageTitle(__('Tires Search'));
        $page->getLayout()->getBlock('breadcrumbs')->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link' => $store->getBaseUrl()
            ]
        )->addCrumb(
            'product-tag',
            [
                'label' => __('Tires Search'),
                'title' => __('Tires Search')
            ]
        );
		
        $page->getConfig()->addBodyClass('page-products');
        $page->getConfig()->getTitle()->set(__('Tires Search'));
        $page->getConfig()->setDescription(__('Tires Search'));
        $page->getConfig()->setKeywords(__('Tires Search'));

        return $page;
    }


}