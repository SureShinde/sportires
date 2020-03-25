<?php
namespace Ced\Claro\Ui\Component\Listing\Columns\Product;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;

class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $this->_options = [
            ['label'=>'Select','value' => '0'],
            ['label'=>'Default Magento Price', 'value'=>'1'],
            ['label'=>'Price increase by fixed Price', 'value'=>'2'],
            ['label'=>'Price decrease by fixed Price', 'value'=>'3'],
            ['label'=>'Price increase by fixed Percentage', 'value'=>'4'],
            ['label'=>'Price decrease by fixed Percentage', 'value'=>'5'],
        ];
        return $this->_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
}