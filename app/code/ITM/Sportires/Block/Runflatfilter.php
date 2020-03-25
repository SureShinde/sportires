<?php


namespace ITM\Sportires\Block;

class Runflatfilter extends \Magento\Framework\View\Element\Template
{

	protected $search;
    protected $request;
    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->request = $request;
        parent::__construct($context, $data);
    }
	function _prepareLayout(){
		$this->getsize();
	}

	public function setSearch($_search)
    {
        $this->search = $_search;
    }
    public function getRunFlat()
    {
        $runFlat = $this->request->getParam('run_flat');
        return $runFlat;
    }

}


