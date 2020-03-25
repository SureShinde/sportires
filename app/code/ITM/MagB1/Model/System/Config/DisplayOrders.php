<?php


namespace ITM\MagB1\Model\System\Config;

class DisplayOrders extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => '0', 'label' => __('Use Configuration')],
                ['value' => '2', 'label' => __('No')],
                ['value' => '1', 'label' => __('Yes')]
            ];
        }
        return $this->_options;
    }
}
