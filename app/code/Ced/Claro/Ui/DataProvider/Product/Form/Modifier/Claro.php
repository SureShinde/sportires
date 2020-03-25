<?php

namespace Ced\Claro\Ui\DataProvider\Product\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class Claro implements ModifierInterface
{
    /**
     * @param array $data
     * @return array
     * @since 100.1.0
     */
    public function modifyData(array $data)
    {
        // TODO: Implement modifyData() method.
    }

    /**
     * @param array $meta
     * @return array
     * @since 100.1.0
     */
    public function modifyMeta(array $meta)
    {
        if (isset($meta['claro']['children']['container_claro_product_id']['children']['claro_product_id']['arguments']['data']['config'])) {
            $meta['claro']['children']['container_claro_product_id']['children']['claro_product_id']['arguments']['data']['config']['disabled'] = true;
        }

       /* if (isset($meta['claro']['children']['container_claro_product_status']['children']['claro_product_status']['arguments']['data']['config'])) {
            $meta['claro']['children']['container_claro_product_status']['children']['claro_product_status']['arguments']['data']['config']['disabled'] = true;
        }*/

        /*if (isset($meta['claro']['children']['container_claro_validation_errors']['children']['claro_validation_errors']['arguments']['data']['config'])) {
            $meta['claro']['children']['container_claro_validation_errors']['children']['claro_validation_errors']['arguments']['data']['config']['disabled'] = true;
        }

        if (isset($meta['claro']['children']['container_claro_feed_errors']['children']['claro_feed_errors']['arguments']['data']['config'])) {
            $meta['claro']['children']['container_claro_feed_errors']['children']['claro_feed_errors']['arguments']['data']['config']['disabled'] = true;
        }*/

        return $meta;
    }
}