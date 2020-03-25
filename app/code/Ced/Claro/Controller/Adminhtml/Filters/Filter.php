<?php

namespace Ced\Claro\Controller\Adminhtml\Filters;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;

class Filter extends Action
{
    /**
     * @var \Ced\Claro\Helper\Category
     */
    public $category;
    /**
     * @var JsonFactory
     */
    public $jsonFactory;

    public function __construct(
        Action\Context $context,
        JsonFactory $jsonFactory,
        \Ced\Claro\Helper\Category $category
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->category = $category;
    }
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $categoryId = $this->getRequest()->getParam('selectedId');
        $categories = $this->category->getList()['categorias'];
        $result = [];
        foreach ($categories as $category) {
            foreach ($category['subcategorias'] as $values) {
                foreach ($values['subcategorias'] as $value) {
                    if ($value['idcategoria'] == $categoryId && isset($value['filtros'])) {
                        foreach ($value['filtros'] as $v) {
                            $result[] = $v;
                        }
                    }
                }
            }
        }
        return $this->jsonFactory->create()->setData($result);
    }
}
