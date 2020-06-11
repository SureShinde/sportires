<?php
declare(strict_types=1);

namespace Sportires\WalmarCatalog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class WalmarCreated extends AbstractHelper
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

