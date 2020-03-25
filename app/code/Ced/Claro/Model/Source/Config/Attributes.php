<?php

namespace Ced\Claro\Model\Source\Config;

class Attributes implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => 'alto', 'label' => __('alto/height')], //height
            ['value' => 'ancho', 'label' => __('ancho/width')], //width
            ['value' => 'profundidad', 'label' => __('profundidad/length')], //length
            ['value' => 'peso', 'label' => __('peso/weight')], //weight
            ['value' => 'preciopublicobase', 'label' => __('preciopublicobase/price')], //base price
            ['value' => 'preciopublicooferta', 'label' => __('preciopublicooferta/special price')], //special price/public price
            ['value' => 'cantidad', 'label' => __('cantidad/quantity')] //quantity
        ];
    }
}