<?php
namespace Firstdata\Gateway\Api;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Firstdata\Gateway\Api\APIRequest;
use Firstdata\Gateway\Logger\Logger;

class APIHandler{

    /** @var string API Username */
    public $api_username;

    /** @var string API Password */
    public $api_password;

    /** @var string API URL */
    public $api_url;

    /** @var string API Key Password */
    public $certificate_key_password;

    /** @var string API Server Trust PEM */
    public $server_trust_pem;

    /** @var string API Client Certificate PEM */
    public $client_certificate_pemfile;

    /** @var string API Client Certificate Key */
    public $client_certificate_keyfile;
	
    protected $scopeConfig;
    protected $apirequest;
    protected $logger;

    public function __construct(ScopeConfigInterface $scopeConfig, APIRequest $apirequest, Logger $logger)
    {
        $this->scopeConfig = $scopeConfig;	 
        $this->apirequest = $apirequest;
        $this->logger = $logger;
    }
    
    public function Log($var) {
        $storeScope=\Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $logging = $this->scopeConfig->getValue("payment/firstdata/logging", $storeScope);
        if ($logging == 1) {
           $this->logger->info($var);
        }
    }

    public function get_refund_request($request_param) {

        $request = array(
            'URL' => $this->api_url,
            'USER' => $this->api_username,
            'PWD' => $this->api_password,
            'KEY_PWD' => $this->certificate_key_password,
            'TRUST_PEM' => $this->server_trust_pem,
            'CERT_PEM' => $this->client_certificate_pemfile,
            'CERT_KEY' => $this->client_certificate_keyfile,
            'ORDERID' => $request_param['order_hash_id'],
            'TRANSACTIONID' => $request_param['transaction_id'],
            'METHOD' => $request_param['method'],
        );
        
        //$this->Log($this->api_url);
        //$this->Log($this->client_certificate_keyfile);
        if (!is_null($request_param['amount'])) {
            $request['AMT'] = number_format($request_param['amount'], 2, '.', '');
            $request['CURRENCYCODE'] = $request_param['order_currency'];
        }
        if ($request_param['method'] == "return") {
            $request['XML'] = '<?xml version="1.0" encoding="utf-8"?>' .
                    '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://ipg-online.com/ipgapi/schemas/v1" xmlns:ipg="http://ipg-online.com/ipgapi/schemas/ipgapi">' .
                    '<soap:Body>' .
                    '<ipgapi:IPGApiOrderRequest
                    xmlns:v1="http://ipg-online.com/ipgapi/schemas/v1"
                    xmlns:ipgapi="http://ipg-online.com/ipgapi/schemas/ipgapi">
                    <v1:Transaction>
                    <v1:CreditCardTxType>
                    <v1:Type>return</v1:Type>
                    </v1:CreditCardTxType>
                    <v1:Payment>
                    <v1:ChargeTotal>' . $request['AMT'] . '</v1:ChargeTotal>
                    <v1:Currency>' . $request['CURRENCYCODE'] . '</v1:Currency>
                    </v1:Payment>
                    <v1:TransactionDetails>
                    <v1:OrderId>' . $request['ORDERID'] . '</v1:OrderId>
                    </v1:TransactionDetails>
                    </v1:Transaction>
                    </ipgapi:IPGApiOrderRequest>' .
                    '</soap:Body>' .
                    '</soap:Envelope>';
        } else if ($request_param['method'] == "void") {
            $request['XML'] = '<?xml version="1.0" encoding="utf-8"?>' .
                    '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://ipg-online.com/ipgapi/schemas/v1" xmlns:ipg="http://ipg-online.com/ipgapi/schemas/ipgapi">' .
                    '<soap:Body>' .
                    '<ipgapi:IPGApiOrderRequest
                    xmlns:v1="http://ipg-online.com/ipgapi/schemas/v1"
                    xmlns:ipgapi="http://ipg-online.com/ipgapi/schemas/ipgapi">
                    <v1:Transaction>
                    <v1:CreditCardTxType>
                    <v1:Type>void</v1:Type>
                    </v1:CreditCardTxType>
                    <v1:TransactionDetails>
                    <v1:IpgTransactionId>' . $request['TRANSACTIONID'] . '</v1:IpgTransactionId>
                    </v1:TransactionDetails>
                    </v1:Transaction>
                    </ipgapi:IPGApiOrderRequest>' .
                    '</soap:Body>' .
                    '</soap:Envelope>';
        }
        return $request;
    }

    /**
     * Refund an order via Firstdata.
     * @param  Array
     * @return object Either an object of name value pairs for a success.
     */
    public function refund_transaction($request_param) {
        $request = $this->get_refund_request($request_param);                
        //$this->Log(implode(",",$request));
        //$this->Log(implode(",",$request_param));                
        return $this->apirequest->build_request($request);
    }

}
