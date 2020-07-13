# Mage2 Module Sportires Walmart

    ``sportires/module-walmart``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Modulo para manejo de marketplaces de Walmart

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Sportires`
 - Enable the module by running `php bin/magento module:enable Sportires_Walmart`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require sportires/module-walmart`
 - enable the module by running `php bin/magento module:enable Sportires_Walmart`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - is_active (marketplaces/walmart/is_active)

 - url_service (marketplaces/walmart/url_service)

 - user (marketplaces/walmart/user)

 - pass (marketplaces/walmart/pass)

 - token (marketplaces/walmart/token)

 - other (marketplaces/walmart/other)


## Specifications

 - Helper
	- Sportires\Walmart\Helper\Order

 - Helper
	- Sportires\Walmart\Helper\Product

 - Helper
	- Sportires\Walmart\Helper\Price

 - Helper
	- Sportires\Walmart\Helper\Stock

 - Helper
	- Sportires\Walmart\Helper\Label

 - Controller
	- adminhtml > walmart/manage/index

 - Block
	- Configuration > configuration.phtml

 - Observer
	- catalog_product_save_after > Sportires\Walmart\Observer\Backend\Catalog\ProductSaveAfter

 - Cronjob
	- sportires_walmart_sportireswalmartorder

 - Cronjob
	- sportires_walmart_sportireswalmartprice

 - Cronjob
	- sportires_walmart_sportireswalmartstock

 - Cronjob
	- sportires_walmart_sportireswalmartproducts


## Attributes



