<?php

namespace Ced\WalmartMx\Ui\Component\Profile\Form\Categories;


use Magento\Framework\Data\OptionSourceInterface;

class Options implements OptionSourceInterface
{
    public $category;

    public function __construct
    (
        \Ced\WalmartMx\Helper\Category $category
    )
    {
        $this->category = $category;
    }

    public function toOptionArray()
    {
        return $this->category->getCategoriesTree();
    }
}