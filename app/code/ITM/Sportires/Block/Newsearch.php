<?php


namespace ITM\Sportires\Block;

class Newsearch extends \Magento\Framework\View\Element\Template
{

	protected $search;
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
	function _prepareLayout(){
		$this->getsize();
	}
    /**
     * @return string
     */
    public function getSearch()
    {	
        return $this->search;
    }
	public function setSearch($_search)
    {
        $this->search = $_search;
    }
	
	public function getController()
    {
		$objectManager =  \Magento\Framework\App\ObjectManager::getInstance();        
		$request = $objectManager->get('\Magento\Framework\App\Request\Http');
		return $request->getControllerName();
    }
	
	
	
}
