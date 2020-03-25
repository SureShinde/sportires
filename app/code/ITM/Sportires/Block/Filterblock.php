<?php


namespace ITM\Sportires\Block;

class Filterblock extends \Magento\Framework\View\Element\Template
{
    /**
     * for reading the vehicletire table from databas
     * @var \ITM\Sportires\Model\VehicletireFactory
     */
    protected $_collectionFactory;
    protected $_resultPageFactory;
    protected $_categoryFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \ITM\Sportires\Model\ResourceModel\Vehicletire\CollectionFactory $collectionFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $data = []
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_collectionFactory = $collectionFactory;
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context, $data);

    }

    /**
     * @return string
     */
    public function getMakes()
    {
        $collection = $this->_collectionFactory->create();
        $collection->addFieldtoSelect("make");
        $collection->getSelect()->group("make");
        $makes = [];
        foreach ($collection as $item) {
            $makes[] = $item->getMake();
        }

       return $makes;
    }
    /**
     * @return string
     */
    public function getAutoCategories()
    {
        $categoryId = 3; // YOUR CATEGORY ID

        $category = $this->_categoryFactory->create()->load($categoryId);
        $childrenCategories = $category->getChildrenCategories();


        $options = [];
        foreach ($childrenCategories as $item) {
            $options[$item->getEntityId()] = $item->getName();
        }

        return $options;
    }
}