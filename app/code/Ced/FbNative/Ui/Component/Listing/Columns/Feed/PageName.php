<?php


namespace Ced\FbNative\Ui\Component\Listing\Columns\Feed;

use Ced\FbNative\Model\Account;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class PageName extends Column
{

    const URL_PATH_EDIT = 'fbnative/account/edit';

    public $account;

    public $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Account $account,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->account = $account;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['account'])) {
                    $item[$name] = $this->account->load($item['account'])->getData('page_name');
                    $item['export_csv'] = $this->account->load($item['account'])->getData('export_csv');
                    $item['feed_store'] = $this->account->load($item['account'])->getData('account_store');
                }
            }
        }
        return $dataSource;
    }
}