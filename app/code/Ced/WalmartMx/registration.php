<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement(EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category  Ced
 * @package   Ced_WalmartMx
 * @author    CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright Copyright CEDCOMMERCE(http://cedcommerce.com/)
 * @license   http://cedcommerce.com/license-agreement.txt
 */
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Ced_WalmartMx',
    __DIR__
);
$vendorDir = require BP . '/app/etc/vendor_path.php';
$vendorAutoload = BP . "/{$vendorDir}/autoload.php";
/** @var \Composer\Autoload\ClassLoader $composerAutoloader */
$composerAutoloader = include $vendorAutoload;
$composerAutoloader->addPsr4('WalmartMxSdk\\', array(__DIR__ . '/walmartmx-sdk/src'));
