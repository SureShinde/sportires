# Mage2 Module Sportires Instalacion

    ``sportires/module-instalacion``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Modulo de envio con instalacion

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Sportires`
 - Enable the module by running `php bin/magento module:enable Sportires_Instalacion`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require sportires/module-instalacion`
 - enable the module by running `php bin/magento module:enable Sportires_Instalacion`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - Instalacion - carriers/instalacion/*


## Specifications

 - Helper
	- Sportires\Instalacion\Helper\Instalacion

 - Block
	- Instalacion > instalacion.phtml

 - Shipping Method
	- instalacion


## Attributes



