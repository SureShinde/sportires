# Changelog

## 1.3.0 - 2019-10-03

- Added SCA MOTO Exemptions support in the Magento admin
- Guest customers are now associated with their Stripe customer ID if they register immediately after placing an order
- The Stripe.js locale is now overwritten based on the Magento store view locale configuration
- Depreciated Email Receipt configuration option, this should now be disabled from the Stripe dashboard
- Added a partner ID in the module's app info
- Fixed placing subscription orders from the admin area
- Fixed refunds through the Stripe dashboard (no credit memo was being created)
- Fixed an installation problem with the Magento area code
- Fixed a Stripe account retrieval problem with some specific web server configurations

## 1.2.1 - 2019-09-18

- Compatibility fix with older versions of Magento 2
- Fixed card country not appearing in the Magento admin
- In some cases the Configure button in the admin area could not be clicked
- Improvements with subscription order invoicing
- Fix for configurable products when added to the card through the catalog or search pages

## 1.2.0 - 2019-08-27

- Added support for Stripe Billing / Subscriptions.
- Added support for the FPX payment method (Malaysia).
- Added support for 3D Secure v2 at the Multi-Shipping checkout page (SCA compliance)
- Added support for India exports as per country regulations. Full customer details are collected for all export sales.
- Added support for creating admin MOTO orders for guest customers (with no Magento customer login).
- Performance improvements (less API calls)
- Upgraded to Stripe API version 2019-02-19.
- The creation of Payment Intents is now deferred until the very final step of the checkout. Incomplete payment intents will no longer be shown in the Stripe Dashboard.
- The "Authentication Required" message at the checkout prior to the 3D Secure modal is now hidden completely
- Fixed an issue with capturing Authorized Only payments from the Magento admin area.
- Various fixes and improvements with Apple Pay

## 1.1.2 - 2019-06-10

- Improvements with multi-shipping checkout.
- Compatibility improvements with M2EPro and some other 3rd party modules.
- New translation entries.
- Fixed the street and CVC checks not displaying correctly in the admin order page.

## 1.1.1 - 2019-05-30

- Depreciates support for saved cards created through the Sources API.
- Improves checkout performance.
- Fixed error when trying to capture an expired authorization in the admin area using a saved card.
- Fixed a checkout crash with guest customers about the Payment Intent missing a payment method.

## 1.1.0 - 2019-05-28

- `MAJOR`: Switched from automatic Payment Intents confirmation at the front-end to manual Payment Intents confirmation on the server side. Resolves reported issue with charges not being associated with a Magento order.
- `MAJOR`: Replaced the Sources API with the new Payment Methods API. Depreciated all fallback scenarios to the Charges API.
- Stripe.js v2 has been depreciated, Stripe Elements is now used everywhere.
- When Apple Pay is used on the checkout page, the order is now submitted automatically as soon as the paysheet closes.
- Fixed: In the admin configuration, when the card saving option was set to "Always save cards", it wouldn't have the correct effect.
- Fixed: In the admin configuration, when disabling Apple Pay on the product page or the cart, it wouldn't have the correct effect.
- Fixed a multishipping page validation error with older versions of Magento 2.

## 1.0.0 - 2019-05-14

Initial release.
