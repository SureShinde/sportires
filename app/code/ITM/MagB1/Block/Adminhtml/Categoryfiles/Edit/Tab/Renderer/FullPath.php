<?php

namespace ITM\MagB1\Block\Adminhtml\Categoryfiles\Edit\Tab\Renderer;

use Magento\Framework\Exception;

use Magento\Framework\DataObject;

class FullPath extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @var \ITM\MagB1\Helper\Data
     */
    protected $_magb1Helper;
    /**
     * @param \Magento\Catalog\Model\CategoryFactory $categoryFactory
     */
    public function __construct(
        \ITM\MagB1\Helper\Data $magb1Helper
    ) {
            $this->_magb1Helper = $magb1Helper;
    }
    
    /**
     * get category file "full path" by id
     * @param  DataObject $row
     * @return string
     */
    public function render(DataObject $row)
    {
        $fileId = $row->getId();
        $files = "<a href='".$this->_magb1Helper->getCategoryFileById($fileId)."'>".__("Virtual Link")."</a> | ";
        $files .= "<a href='".$this->_magb1Helper->getCategoryFileLinkById($fileId)."'>".__("Real Link")."</a>";
        return $files;
    }
}
