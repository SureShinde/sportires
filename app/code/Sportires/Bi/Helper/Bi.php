<?php
declare(strict_types=1);

namespace Sportires\Bi\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Bi extends AbstractHelper
{

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }
}

