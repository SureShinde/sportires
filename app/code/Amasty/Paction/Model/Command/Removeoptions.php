<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_Paction
 */


namespace Amasty\Paction\Model\Command;

use Magento\Catalog\Api\ProductRepositoryInterface;

class Removeoptions extends \Amasty\Paction\Model\Command
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        parent::__construct();

        $this->_type = 'removeoptions';
        $this->_info = [
            'confirm_title'   => __('Remove Custom Options')->getText(),
            'confirm_message' => __('Are you sure you want to remove custom options?')->getText(),
            'type'            => $this->_type,
            'label'           => __('Remove Custom Options')->getText(),
            'fieldLabel'      => ''
        ];
        $this->productRepository = $productRepository;
    }

    /**
     * Executes the command
     *
     * @param array $ids product ids
     * @param int $storeId store id
     * @param string $val field value
     * @return string success message if any
     */
    public function execute($ids, $storeId, $val)
    {
        $success = '';
        $num = 0;
        foreach ($ids as $productId) {
            try {
                $product = $this->productRepository->getById($productId);
                $options = $product->getOptions();
                if (empty($options)) {
                    continue;
                }
                foreach ($options as $option) {
                    $option->delete();
                }

                ++$num;
            } catch (\Exception $e) {
                $this->_errors[] = __(
                    'Can not remove the options to the product ID=%1, the error is: %2',
                    $productId,
                    $e->getMessage()
                );
            }
        }

        if ($num) {
            return $success = __('Total of %1 products(s) have been successfully updated.', $num);
        }

        return $success;
    }
}
