## Firstdata Payment Gateway for Magento 2

This extension allows you to use Firstdata as payment gateway in your Magento 2 store.

## Installing via [Composer](https://getcomposer.org/)

```bash
composer require firstdata/firstdata-magento-2
php bin/magento module:enable Firstdata_Gateway --clear-static-content
php bin/magento setup:upgrade
```

Enable and configure Firstdata in Magento Admin under `Stores -> Configuration -> Payment Methods -> Firstdata Payment Gateway`.

For any issue send us an email to support@firstdata.com and share the `gateway.log` file. The location of `gateway.log` file is `var/log/gateway.log`.