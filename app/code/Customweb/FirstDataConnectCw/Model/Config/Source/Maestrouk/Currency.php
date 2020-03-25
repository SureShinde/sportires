<?php
/**
 * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2018 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
 *
 * @category	Customweb
 * @package		Customweb_FirstDataConnectCw
 * 
 */

namespace Customweb\FirstDataConnectCw\Model\Config\Source\Maestrouk;

class Currency implements \Magento\Framework\Option\ArrayInterface
{
	/**
	 * @return array
	 */
	public function toOptionArray()
	{
		return [
			['value' => 'AED', 'label' => __('United Arab Emirates dirham (AED)')],
			['value' => 'AUD', 'label' => __('Australian dollar (AUD)')],
			['value' => 'BHD', 'label' => __('Bahraini dinar (BHD)')],
			['value' => 'CAD', 'label' => __('Canadian dollar (CAD)')],
			['value' => 'CHF', 'label' => __('Swiss franc (CHF)')],
			['value' => 'CNY', 'label' => __('Chinese yuan (CNY)')],
			['value' => 'CZK', 'label' => __('Czech koruna (CZK)')],
			['value' => 'DKK', 'label' => __('Danish krone (DKK)')],
			['value' => 'EUR', 'label' => __('Euro (EUR)')],
			['value' => 'GBP', 'label' => __('Pound sterling (GBP)')],
			['value' => 'HKD', 'label' => __('Hong Kong dollar (HKD)')],
			['value' => 'HRK', 'label' => __('Croatian kuna (HRK)')],
			['value' => 'HUF', 'label' => __('Hungarian forint (HUF)')],
			['value' => 'INR', 'label' => __('Indian rupee (INR)')],
			['value' => 'ILS', 'label' => __('Israeli new shekel (ILS)')],
			['value' => 'JPY', 'label' => __('Japanese yen (JPY)')],
			['value' => 'KRW', 'label' => __('South Korean won (KRW)')],
			['value' => 'KWD', 'label' => __('Kuwaiti dinar (KWD)')],
			['value' => 'LTL', 'label' => __('Lithuanian litas (LTL)')],
			['value' => 'MXN', 'label' => __('Mexican peso (MXN)')],
			['value' => 'NOK', 'label' => __('Norwegian krone (NOK)')],
			['value' => 'NZD', 'label' => __('New Zealand dollar (NZD)')],
			['value' => 'PLN', 'label' => __('Polish złoty (PLN)')],
			['value' => 'RON', 'label' => __('Romanian new leu (RON)')],
			['value' => 'SAR', 'label' => __('Saudi riyal (SAR)')],
			['value' => 'SEK', 'label' => __('Swedish krona (SEK)')],
			['value' => 'SGD', 'label' => __('Singapore dollar (SGD)')],
			['value' => 'TRY', 'label' => __('Turkish lira (TRY)')],
			['value' => 'USD', 'label' => __('United States dollar (USD)')],
			['value' => 'ZAR', 'label' => __('South African rand (ZAR)')],
		];
	}
}
