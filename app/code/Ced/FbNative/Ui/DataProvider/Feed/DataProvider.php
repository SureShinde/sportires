<?php

namespace Ced\FbNative\Ui\DataProvider\Feed;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Ced\FbNative\Model\Feeds $collectionFactory,
        $addFieldStrategies = [],
        $addFilterStrategies = [],
        $meta = [],
        $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection= $collectionFactory->getCollection();
        $this->size = sizeof($this->collection->getData());
    }

    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }

        $items = $this->getCollection()->getData();
        return [
            'totalRecords' => $this->collection->getSize(),
            'items' => array_values($items),

        ];
    }
}