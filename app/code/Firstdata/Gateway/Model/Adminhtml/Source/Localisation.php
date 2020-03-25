<?php

namespace Firstdata\Gateway\Model\Adminhtml\Source;

use Magento\Framework\View\Asset\Source;

/**
 * Class PaymentAction
 */
class Localisation {

    protected $assetRepo;
    protected $storeManager;
    protected $urlBuilder;

    public function __construct(
    \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\View\Asset\Repository $assetRepo, \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
        $this->assetRepo = $assetRepo;
    }

    public function items($country) {
        $localsation = array(
            "ind" => array(
                "icici" => array(
                    "plugin_name" => "First Data Gateway - ICICI Merchant Services",
                    "reseller_name" => "ICICI Merchant Services",
                    "logo" => $this->getLogoUrl() . "/icici.jpg",
                    "description" => "Pay securely with ICICI Merchant Services",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Contact ICICI Merchant Services Support:",
                    "contact_support" => "Telephone number: 1800 102 1673<br/>Email: ipghelpdesk@icicims.com<br/>Opening Hours: 24/7",
                    "produrl" => "https://www4.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www4.ipg-online.com/ipgapi/services",
                    "local_payment" => array('RU', 'netbanking', 'masterpass', 'indiawallet'),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'yes',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'yes',
                    "refunds" => 'yes',
                    "card_type" => 'no',
                ),
                "idfc" => array(
                    "plugin_name" => "IDFC Bank",
                    "reseller_name" => "IDFC",
                    "logo" => $this->getLogoUrl() . "/idfc.png",
                    "description" => "Pay securely with IDFC",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Contact IDFC Bank Services Support:",
                    "contact_support" => "Telephone number: 1800 102 1673<br/>Email: idfcbankpghelpdesk@firstdata.com<br/>Opening Hours: 24/7",
                    "produrl" => "https://www4.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www4.ipg-online.com/ipgapi/services",
                    "local_payment" => array('RU', 'netbanking', 'masterpass', 'indiawallet'),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'yes',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'yes',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
            "arg" => array(
                "posnet" => array(
                    "plugin_name" => "ePosnet",
                    "reseller_name" => "ePosnet",
                    "logo" => $this->getLogoUrl() . "/e-posnet.png",
                    "description" => "Pay securely with ePosnet",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Para dudas, consultas o revisión de estados de trámites, puede contactarse con nosotros de las siguientes formas:",
                    "contact_support" => "Teléfono desde Capital Federal y GBA:<br/>(011) 4126-3000 – de Lunes a Viernes de 9 a 21hs Teléfono desde el Interior del país:<br/>0810-999-7676 – de Lunes a Viernes de 9 a 21hs Completando el formulario online: <a href='http://www.posnet.com.ar/atencion'>http://www.posnet.com.ar/atencion</a>",
                    "produrl" => "https://www5.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www5.ipg-online.com/ipgapi/services",
                    "local_payment" => array(),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'yes',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'no',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
            "col" => array(
                "pagogo" => array(
                    "plugin_name" => "Plataforma Pago Go",
                    "reseller_name" => "Pago Go",
                    "logo" => $this->getLogoUrl() . "/pagogo.png",
                    "description" => "Pay securely with Pago Go",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => " ",
                    "contact_support" => " ",
                    "produrl" => "https://www2.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www2.ipg-online.com/ipgapi/services",
                    "local_payment" => array(),
                    "dynamic_merchant_name" => 'no',
                    "instalments" => 'yes',
                    "secure_pay" => 'no',
                    "dcc_skip_offer" => 'no',
                    "refunds" => 'no',
                    "card_type" => 'no'
                )
            ),
            "bra" => array(
                "bin" => array(
                    "plugin_name" => "Plugin FD",
                    "reseller_name" => "Bin",
                    "logo" => $this->getLogoUrl() . "/bin.png",
                    "description" => "Pay securely with Bin",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => " ",
                    "contact_support" => "3004-2017  para capitais ou <br/>0800 757 1017 para as demais regiões  - Horário de atendimento: <br/>de segunda às sextas-feiras das 09h às 20h ou pelo <br/>e-mail: solicitacaoespecial@firstdatacorp.com.br",
                    "produrl" => "https://www2.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www2.ipg-online.com/ipgapi/services",
                    "local_payment" => array('M', 'V', 'MA', 'CA', 'SO', 'hipercard', 'EL'),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'yes',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'no',
                    "refunds" => 'yes',
                    "card_type" => 'yes'
                ),
                "sipag" => array(
                    "plugin_name" => "Plugin FD",
                    "reseller_name" => "SiPag",
                    "logo" => $this->getLogoUrl() . "/sipag.png",
                    "description" => "Pay securely with SiPag",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => " ",
                    "contact_support" => "3004-2013  para capitais ou <br/>0800 757 1013 para as demais regiões  - Horário de atendimento: <br/>de segunda às sextas-feiras das 09h às 20h ou pelo <br/>e-mail: solicitacaoespecial@firstdatacorp.com.br",
                    "produrl" => "https://www2.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www2.ipg-online.com/ipgapi/services",
                    "local_payment" => array('M', 'V', 'MA', 'CA', 'SO', 'hipercard', 'EL'),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'yes',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'no',
                    "refunds" => 'yes',
                    "card_type" => 'yes'
                ),
                "sicredi" => array(
                    "plugin_name" => "Plugin FD",
                    "reseller_name" => "Sicredi",
                    "logo" => $this->getLogoUrl() . "/sicredi.png",
                    "description" => "Pay securely with Sicredi",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => " ",
                    "contact_support" => "3003-7828  para capitais ou <br/>0800 7287828 para as demais regiões  - Horário de atendimento: <br/>de segunda às sextas-feiras das 09h às 20h ou pelo <br/>e-mail: solicitacaoespecial@firstdatacorp.com.br",
                    "produrl" => "https://www2.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www2.ipg-online.com/ipgapi/services",
                    "local_payment" => array('M', 'V', 'MA', 'CA', 'SO', 'hipercard', 'EL'),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'yes',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'no',
                    "refunds" => 'yes',
                    "card_type" => 'yes'
                )
            ),
            "mex" => array(
                "firstdatamexico" => array(
                    "plugin_name" => "First Data Gateway",
                    "reseller_name" => "First Data Mexico",
                    "logo" => $this->getLogoUrl() . "/fda.png",
                    "description" => "Pay securely with First Data Mexico",
                    "customer_detail_title" => "Números de contacto 24hrs:",
                    "customer_detail" => "Interior de la republica: 01 800 215 5733<br/>Ciudad de Mexico: 55 11020660<br/>helpdeskmx@firstdata.com",
                    "contact_support_title" => " ",
                    "contact_support" => " ",
                    "produrl" => "https://www2.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www2.ipg-online.com/ipgapi/services",
                    "local_payment" => array('M', 'V', 'MA', 'A', 'mexicoLocal', 'masterpass'),
                    "dynamic_merchant_name" => 'no',
                    "instalments" => 'yes',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'no',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                ),
                "scotiapos" => array(
                    "plugin_name" => "ScotiaPOS",
                    "reseller_name" => "ScotiaPOS",
                    "logo" => $this->getLogoUrl() . "/scotiapos.jpg",
                    "description" => "Pay securely with ScotiaPOS",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Números de contacto 24hrs:",
                    "contact_support" => "Interior de la republica: 01 800 215 5733<br/>Ciudad de Mexico: 55 11020660<br/>helpdeskmx@firstdata.com",
                    "produrl" => "https://www2.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www2.ipg-online.com/ipgapi/services",
                    "local_payment" => array('M', 'V', 'MA', 'A', 'mexicoLocal', 'masterpass'),
                    "dynamic_merchant_name" => 'no',
                    "instalments" => 'yes',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'no',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
            "gbr" => array(
                "first_data_uk" => array(
                    "plugin_name" => "First Data Gateway - UK",
                    "reseller_name" => "First Data UK",
                    "logo" => $this->getLogoUrl() . "/fdtm.jpg",
                    "description" => "Pay securely with First Data UK",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Contact First Data U.K. Support:",
                    "contact_support" => "Telephone number: +44 (0) 345 606 5055, Option 2<br/>Email: FDHelpdesk@firstdata.com<br/>Opening Hours: 8am - 9pm, Monday to Saturday (excluding UK Public Holidays)",
                    "produrl" => "https://www.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www.ipg-online.com/ipgapi/services",
                    "local_payment" => array('paypal', 'masterpass'),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'no',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'yes',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                ),
                "lloyds_cardnet" => array(
                    "plugin_name" => "Lloyds Bank Online Payments",
                    "reseller_name" => "Lloyds Cardnet",
                    "logo" => $this->getLogoUrl() . "/lloyds.jpg",
                    "description" => "Pay securely with Lloyds Cardnet",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Contact Lloyds Cardnet Support:",
                    "contact_support" => "Telephone number: +44 (0) 1268 567 100<br/>Opening Hours: 8am - 9pm, Monday to Saturday",
                    "produrl" => "https://www.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www.ipg-online.com/ipgapi/services",
                    "local_payment" => array('paypal'),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'no',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'no',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
            "irl" => array(
                "aib_merchant_services" => array(
                    "plugin_name" => "AIB Merchant Services - Authipay",
                    "reseller_name" => "AIB Merchant Services",
                    "logo" => $this->getLogoUrl() . "/aib.png",
                    "description" => "Pay securely with AIB Merchant Services",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Contact AIB Merchant Services Support:",
                    "contact_support" => "Telephone number (IRL): 1850 200 417 or +44 1268 567121 (from outside Ireland)<br/>Telephone number (GB): 0371 200 1436 or +44 1268 567123 (from outside Ireland)<br/>Email: authipay@aibms.com",
                    "produrl" => "https://www.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www.ipg-online.com/ipgapi/services",
                    "local_payment" => array('paypal', 'masterpass', 'ideal'),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'no',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'yes',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
            "nld" => array(
                "european_merchant_services" => array(
                    "plugin_name" => "EMS eCommerce Gateway",
                    "reseller_name" => "European Merchant Services",
                    "logo" => $this->getLogoUrl() . "/ems.png",
                    "description" => "Pay securely with European Merchant Services",
                    "customer_detail_title" => "Are you already a customer",
                    "customer_detail" => "If you are already registered as an EMS merchant then please enter the credentials and settings below. <br/>For new customers please follow the link below to acquire an EMS merchant account.<br/><br/><b>Becoming an EMS customer</b><br/>Get a merchant account via this link: <a href='https://www.emspay.eu/en/request-an-offer'>https://www.emspay.eu/en/request-an-offer</a>",
                    "contact_support_title" => "Contact EMS Support",
                    "contact_support" => "Visit the FAQ: <br/><a href='http://www.emspay.eu/en/customer-service/faq'>http://www.emspay.eu/en/customer-service/faq</a><br/><br/>Contact information:<br/>Telephone number: 0800 711 88<br/>Mon-Wed: 08.30-18.00 hrs<br/>Thu & Fri: 08.30-19.00 hrs<br/>Email: contact@be.emspay.eu",
                    "produrl" => "https://www.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www.ipg-online.com/ipgapi/services",
                    "local_payment" => array('ideal', 'klarna', 'paypal', 'masterpass'),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'no',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'no',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
            "deu" => array(
                "first_data_telecash" => array(
                    "plugin_name" => "First Data Gateway - TeleCash",
                    "reseller_name" => "First Data Telecash",
                    "logo" => $this->getLogoUrl() . "/fd-telecash.png",
                    "description" => "Pay securely with First Data Telecash",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Contact First Data TeleCash Support:",
                    "contact_support" => "Telephone number: +49 (0) 180 6 2255 8844<br/>Email: internet.support@telecash.de",
                    "produrl" => "https://www.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www.ipg-online.com/ipgapi/services",
                    "local_payment" => array('paypal', 'sofort', 'giropay'),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'no',
                    "secure_pay" => 'no',
                    "dcc_skip_offer" => 'no',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
            "sgp" => array(
                "first_data_singapore" => array(
                    "plugin_name" => "First Data Gateway - Singapore",
                    "reseller_name" => "First Data Singapore",
                    "logo" => $this->getLogoUrl() . "/fda.png",
                    "description" => "Pay securely with First Data Singapore",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Contact First Data Singapore Support:",
                    "contact_support" => "Telephone number: +65 6622 1888<br/>Email: FDgateway.techsupport@Firstdata.com<br/>Opening Hours: 24/7",
                    "produrl" => "https://www.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www4.ipg-online.com/ipgapi/services",
                    "local_payment" => array(),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'no',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'yes',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
            "hkg" => array(
                "first_data_hong_kong" => array(
                    "plugin_name" => "First Data Gateway - Hong Kong",
                    "reseller_name" => "First Data Hong Kong",
                    "logo" => $this->getLogoUrl() . "/fda.png",
                    "description" => "Pay securely with First Data Hong Kong",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Contact First Data Hong Kong Support:",
                    "contact_support" => "Telephone number: +852 3071 5008<br/>Email: FDgateway.techsupport@Firstdata.com<br/>Opening Hours: 24/7",
                    "produrl" => "https://www.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www4.ipg-online.com/ipgapi/services",
                    "local_payment" => array(),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'no',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'yes',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
            "mys" => array(
                "first_data_malaysia" => array(
                    "plugin_name" => "First Data Gateway - Malaysia",
                    "reseller_name" => "First Data Malaysia",
                    "logo" => $this->getLogoUrl() . "/fda.png",
                    "description" => "Pay securely with First Data Malaysia",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Contact First Data Malaysia Support:",
                    "contact_support" => "Telephone number: +60 3 6207 4888<br/>Email: FDgateway.techsupport@Firstdata.com<br/>Opening Hours: 24/7",
                    "produrl" => "https://www.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www4.ipg-online.com/ipgapi/services",
                    "local_payment" => array(),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'no',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'yes',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
            "aus" => array(
                "first_data_australia" => array(
                    "plugin_name" => "First Data Gateway - Australia",
                    "reseller_name" => "First Data Australia",
                    "logo" => $this->getLogoUrl() . "/fda.png",
                    "description" => "Pay securely with First Data Australia",
                    "customer_detail_title" => " ",
                    "customer_detail" => " ",
                    "contact_support_title" => "Contact First Data Austalia Support: ",
                    "contact_support" => "Telephone number: 1800 243 444<br/>Email: ipgsupport@firstdata.com.au<br/>Opening Hours: 24/7",
                    "produrl" => "https://www.ipg-online.com/connect/gateway/processing",
                    "testurl" => "https://test.ipg-online.com/connect/gateway/processing",
                    "apiurl" => "https://test.ipg-online.com/ipgapi/services",
                    "prodapiurl" => "https://www.ipg-online.com/ipgapi/services",
                    "local_payment" => array(),
                    "dynamic_merchant_name" => 'yes',
                    "instalments" => 'yes',
                    "secure_pay" => 'yes',
                    "dcc_skip_offer" => 'yes',
                    "refunds" => 'yes',
                    "card_type" => 'no'
                )
            ),
        );

        return isset($localsation[$country]) ? $localsation[$country] : array();
    }

    public function getLogoUrl() {
        return $this->getViewFileUrl('Firstdata_Gateway::images/ipg', array(
            'area' => 'frontend'
        ));
    }


    public function getViewFileUrl($fileId, array $params = []) {
        try {
            return $this->assetRepo->getUrlWithParams($fileId, $params);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->logger->critical($e);
            return $this->urlBuilder->getUrl('', [
                '_direct' => 'core/index/notFound'
            ]);
        }
    }

    public function getCountryConfig($country, $reseller) {
        $return = array();
        $lconfig = $this->items($country);
        if (isset($lconfig[$reseller])) {
            $return = $lconfig[$reseller];
        }

        return $return;
    }

    public function getAlternatePayments($country, $reseller) {
        $alternatepayments = $this->getCountryConfig($country, $reseller);

        return isset($alternatepayments['local_payment']) ? $alternatepayments['local_payment'] : array();
    }

    public function getPaymentMethodValue($payment_method) {
        $alternatepayments = array(
            'M' => 'MasterCard',
            'V' => 'Visa (Credit/Debit/Electron/Delta)',
            'A' => 'American Express',
            'C' => 'Diners',
            'J' => 'JCB',
            'debitDE' => 'SEPA Direct Debit',
            'CA' => 'Cabal',
            'giropay' => 'Giropay',
            'ideal' => 'iDEAL',
            'klarna' => 'Klarna',
            'indiawallet' => 'Local Wallets India',
            'emi' => 'Equated Monthly Installments (EMI)',
            'MA' => 'Maestro',
            'maestroUK' => 'Maestro UK',
            'masterpass' => 'MasterPass',
            'netbanking' => 'Netbanking (India)',
            'paypal' => 'PayPal',
            'RU' => 'RuPay',
            'sofort' => 'SOFORT Banking (Ãœberweisung) ',
            'SO' => 'Sorocred',
            'BCMC' => 'Bancontact',
            'EL' => 'Elo',
            'hipercard' => 'Hiper/Hipercard',
            "mexicoLocal" => "MexicoLocal"
        );

        return isset($alternatepayments[$payment_method]) ? $alternatepayments[$payment_method] : $payment_method;
    }

    public function getcartsupportdetail() {

        return array(
            'M' => array('name' => 'MasterCard', 'card_support' => true, 'shipping_support' => true),
            'V' => array('name' => 'Visa (Credit/Debit/Electron/Delta)', 'card_support' => true, 'shipping_support' => true),
            'A' => array('name' => 'American Express', 'card_support' => true, 'shipping_support' => true),
            'C' => array('name' => 'Diners', 'card_support' => true, 'shipping_support' => true),
            'J' => array('name' => 'JCB', 'card_support' => true, 'shipping_support' => true),
            'debitDE' => array('name' => 'SEPA Direct Debit', 'card_support' => false, 'shipping_support' => true),
            'CA' => array('name' => 'Cabal', 'card_support' => true, 'shipping_support' => true),
            'giropay' => array('name' => 'Giropay', 'card_support' => false, 'shipping_support' => true),
            'ideal' => array('name' => 'iDEAL', 'card_support' => false, 'shipping_support' => true),
            'klarna' => array('name' => 'Klarna', 'card_support' => false, 'shipping_support' => true),
            'indiawallet' => array('name' => 'Local Wallets India', 'card_support' => false, 'shipping_support' => false),
            'emi' => array('name' => 'Equated Monthly Instalments (EMI)', 'card_support' => true, 'shipping_support' => true),
            'MA' => array('name' => 'Maestro', 'card_support' => true, 'shipping_support' => true),
            'maestroUK' => array('name' => 'Maestro UK', 'card_support' => true, 'shipping_support' => true),
            'masterpass' => array('name' => 'MasterPass', 'card_support' => false, 'shipping_support' => true),
            'netbanking' => array('name' => 'Netbanking (India)', 'card_support' => false, 'shipping_support' => false),
            'paypal' => array('name' => 'PayPal', 'card_support' => false, 'shipping_support' => true),
            'RU' => array('name' => 'RuPay', 'card_support' => true, 'shipping_support' => true),
            'sofort' => array('name' => 'SOFORT Banking (Überweisung)', 'card_support' => false, 'shipping_support' => true),
            'SO' => array('name' => 'Sorocred', 'card_support' => true, 'shipping_support' => true),
            'BCMC' => array('name' => 'Bancontact', 'card_support' => true, 'shipping_support' => true),
            'EL' => array('name' => 'Elo', 'card_support' => true, 'shipping_support' => true),
            'hipercard' => array('name' => 'Hiper/Hipercard', 'card_support' => true, 'shipping_support' => true),
            'mexicoLocal' => array('name' => 'MexicoLocal', 'card_support' => true, 'shipping_support' => true)
        );
    }

    public function getvalidationerror() {
        return array(
            'invalid_payment_mode' => __('Invalid Payment mode.'),
            'invalid_payment_option' => __('Invalid Payment option.'),
            'invalid_installment_detail' => __('Invalid installment detail.'),
            'invalid_card_detail' => __('Invalid card detail.'),
            'invalid_expiry' => __('Invalid expiry month & year detail.'),
            'invalid_local_payment_option' => __('Invalid local payment option.'),
        );
    }

    public function getCardTypeSupport($country, $reseller) {
        $crconfig = $this->getCountryConfig($country, $reseller);
        return (isset($crconfig['card_type']) && $crconfig['card_type'] == 'yes') ? true : false;
    }

}
