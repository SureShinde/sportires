<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @package     Claro-Sdk
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Sdk;

class Api implements \Ced\Claro\Sdk\ApiInterface
{
    /**
     * Api Access Token
     * @var $apiAccessToken
     */
    public $apiAccessToken;

    /**
     * Debug Logging
     * @var $debugMode
     */
    public $debugMode;

    /**
     * Logger
     * @var $logger
     */
    public $logger;

    /**
     * Base Directory
     * @var string
     */
    public $baseDirectory;

    /**
     * Timestamp for saving files
     * @var false|string
     */
    public $timeStamp;
    /**
     * @var \Ced\Claro\Helper\Sdk
     */
    public $sdk;

    /**
     * Api constructor.
     * @param string $apiAccessToken
     * @param string $baseDirectory
     * @param bool $debugMode
     * @param null $logger
     */
    public function __construct(
        \Ced\Claro\Helper\Sdk $sdk,
        $apiAccessToken = '',
        $baseDirectory = '',
        $debugMode = true,
        $logger = null
    ) {
        //paths
        $this->sdk = $sdk;
        $this->baseDirectory = $baseDirectory;
        if ($this->baseDirectory == '') {
            $this->baseDirectory = __DIR__ . DS . '../tmp';
        }
        $this->xsdPath = __DIR__ . DS . '../xsd' . DS;
        $this->xsdDir = __DIR__ . DS . '../xsd';
        $this->timeStamp = date("Y-m-d-H:i:s", time());

        $this->debugMode = $debugMode;
        $this->logger = $logger;

        $this->apiAccessToken = $apiAccessToken;
    }

    /**
     * Put Request
     * $params = ['file' => "", 'data' => "" ]
     * @paarray()ram string $url
     * @param $url
     * @param array $params
     * @return string
     */
    public function put($url, $params = [])
    {
        $request = null;
        $response = null;
        try {
            $headers = ["cache-control: no-cache", "content-type: application/json"];
            $apiUrl = $this->getUrl() . $url;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $servererror = curl_error($ch);
            $header_size = curl_getinfo($ch);
            if (!empty($servererror)) {
                $request = curl_getinfo($ch);
                curl_close($ch);
                throw new \Exception($servererror);
            }
            curl_close($ch);
            return $response;
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => json_encode(
                        [
                            'Request' => $apiUrl,
                            'Response' => $response
                        ]
                    )]
                );
            }
            return false;
        }
    }

    public function curlFileCreate($filename, $name, $mimetype)
    {
        if (!function_exists('curl_file_create')) {
            return "@$filename;filename={$name};type=$mimetype";
        } else {
            return curl_file_create($filename, $mimetype);
        }
    }

    /**
     * Post Request
     * $params = ['file' => "", 'data' => "" ]
     * @param string $url
     * @param array $params
     * @return string
     */
    public function post($url, $params = [])
    {
        $request = null;
        $response = null;
        try {
            $apiUrl = $this->getUrl() . $url;
            $headers = ["cache-control: no-cache", "content-type: application/json"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $servererror = curl_error($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $body = substr($response, $header_size);
            if (!empty($servererror)) {
                $request = curl_getinfo($ch);
                curl_close($ch);
                throw new \Exception($servererror);
            }
            curl_close($ch);
            return $body;
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => json_encode(
                        [
                            'Request' => $apiUrl,
                            'Response' => $response
                        ]
                    )]
                );
            }
            return false;
        }
    }

    public function deleteRequest($url)
    {
        $request = null;
        $response = null;
        try {
            $apiUrl = $this->getUrl() . $url;
            $headers = ["cache-control: no-cache", "content-type: application/json"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $servererror = curl_error($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $body = substr($response, $header_size);
            if (!empty($servererror)) {
                $request = curl_getinfo($ch);
                curl_close($ch);
                throw new \Exception($servererror);
            }
            curl_close($ch);
            return $body;
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => json_encode(
                        [
                            'Request' => $apiUrl,
                            'Response' => $response
                        ]
                    )]
                );
            }
            return false;
        }
    }
    /**
     * Get Token
     * @param $params, [
        'client_id'=> '',
        'client_secret'=> '',
        'code'=> '',
        'grant_type'=>'authorization_code',
        'redirect_uri'=> ''
        ];
     * @return array|bool
     */
    public function getToken($params)
    {
        $method = self::GET_TOKEN_SUB_URL;

        $response = [];
        if (!empty($params)) {
            try {
                $url = $this->apiUrl . $method;
                $headers = [];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $servererror = curl_error($ch);
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                //$header = substr($response, 0, $header_size);
                $body = substr($response, $header_size);
                if (!empty($servererror)) {
                    $request = curl_getinfo($ch);
                    curl_close($ch);
                    throw new \Exception($servererror);
                }
                curl_close($ch);
                $result = json_decode($body, true);
                if (isset($result['error'])) {
                    return [
                        'success' => false,
                        'message' => $result['message']
                    ];
                } else {
                    return [
                        'success' => true,
                        'message' => $result
                    ];
                }
            } catch (\Exception $e) {
                if ($this->debugMode) {
                    $this->logger->addError(
                        $e->getMessage(),
                        ['path' => __METHOD__, 'message' => json_encode(
                            [
                                'Request' => $url,
                                'Response' => $response
                            ]
                        )]
                    );
                }
                return false;
            }
        }
    }

    /**
     * Refresh Token
     * @param $params, [
    'client_id'=> '',
    'client_secret'=> '',
    'refresh_token'=> '',
    'grant_type'=>'refresh_token',
    ];
     * @return array|bool
     */
    public function refreshToken($params)
    {
        $method = self::GET_TOKEN_SUB_URL;
        $response = [];
        try {
            $url = $this->apiUrl . $method;
            $headers = [];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $servererror = curl_error($ch);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            //$header = substr($response, 0, $header_size);
            $body = substr($response, $header_size);
            if (!empty($servererror)) {
                $request = curl_getinfo($ch);
                curl_close($ch);
                throw new \Exception($servererror);
            }
            curl_close($ch);
            $result = json_decode($body, true);
            if (isset($result['error'])) {
                return [
                    'success' => false,
                    'message' => $result['message']
                ];
            } else {
                return [
                    'success' => true,
                    'message' => $result
                ];
            }
        } catch (\Exception $e) {
            $url = '';
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => json_encode(
                        [
                            'Request' => $url,
                            'Response' => $response
                        ]
                    )]
                );
            }
            return false;
        }
    }

    /**
     * Get user data
     * @return array
     */
    public function getUser($force = false)
    {
        $user = [];
        try {
            $file = $this->baseDirectory . DS . 'claro' . DS . 'user_data.json';
            if (!$force && file_exists($file)) {
                $user = file_get_contents($file);
                $user = json_decode($user, true);
            } else {
                $response = $this->get(self::GET_USER_DETAILS . '/me', [], true);
                if ($response && json_decode($response)) {
                    $user = json_decode($response, true);
                    if (isset($user, $user['id'])) {
                        file_put_contents(
                            $this->getFile($this->baseDirectory . DS . 'claro', 'user_data.json'),
                            $response
                        );
                    }
                }
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    [
                        'path' => __METHOD__,
                        'message' => [
                            'Request' => 'getUserInfo',
                            'Response' => $user
                        ]
                    ]
                );
            }
        }

        return $user;
    }

    /**
     * Get Request
     * @param string $url
     * @param array $params
     * @param bool $withToken
     * @return string
     */
    public function get($url, $params = [], $withToken = false)
    {
        $request = null;
        $response = null;
        try {
            $headers = [];
            $apiUrl = $this->getUrl() . $url;
            $request = curl_init();
            curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($request, CURLOPT_URL, $apiUrl);
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($request);
            $errors = curl_error($request);
            if (!empty($errors)) {
                curl_close($request);
                throw new \Exception($errors);
            }
            curl_close($request);
            return $response;
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    [
                        'path' => __METHOD__,
                        'message' => json_encode(
                        [
                            'Request' => $apiUrl,
                            'Response' => $response
                        ]
                    )]
                );
            }
            return false;
        }
    }

    public function getUrl()
    {
        $commonUrl = $this->sdk->config->getEndPointUri() . $this->sdk->config->getPublicKey() . '/'
            . $this->getSignature() . '/' . $this->getDate();
        return $commonUrl;
    }

    public function getSignature()
    {
        $publicKey = $this->sdk->config->getPublicKey();
        $privateKey = $this->sdk->config->getPrivateKey();
        $date = $this->getDate();
        $signature = hash('sha256', $publicKey . $date . $privateKey);
        return $signature;
    }

    public function getDate()
    {
        date_default_timezone_set('America/Mexico_City');
        $date = date("Y-m-d") . 'T' . date("H:i:s");
        return $date;
    }

    /**
     * Get a File or Create
     * @param $path
     * @param null $name
     * @return string
     */
    public function getFile($path, $name = null)
    {
        if (!file_exists($path)) {
            @mkdir($path, 0775, true);
        }

        if ($name != null) {
            $path = $path . DS . $name;

            if (!file_exists($path)) {
                @file($path);
            }
        }
        return $path;
    }

    public function responseParse($result = [], $requestFor = '')
    {
        if (isset($result['estatus']) && ($result['estatus']=='error' || $result['estatus']=='Error')) {
            if (is_array($result['mensaje'])) {
                foreach ($result['mensaje'] as $key => $value) {
                    $msg = "";
                    if (isset($value['isEmpty'])) {
                        $errMsg = $value['isEmpty'];
                        $msg .= $key . ':' . $errMsg;
                    }
                    elseif (isset($value['regexNotMatch'])) {
                        $errMsg = $value['regexNotMatch'];
                        $msg .= $key . ':' . $errMsg;
                    }
                    elseif (isset($value['stringLengthTooLong'])) {
                        $errMsg = $value['stringLengthTooLong'];
                        $msg .= $key . ':' . $errMsg;
                    }
                    return [
                        'success' => 0,
                        'message' => $msg
                    ];
                }
            } elseif ($result['mensaje']) {
                $msg = $result['mensaje'];
                return [
                    'success' => 0,
                    'message' => $msg
                ];
            } else {
                return [
                    'success' => 0,
                    'message' => 'Upload failed'
                ];
            }
        } elseif (isset($result['estatus']) &&
            ($result['estatus']=='success' || $result['estatus']=='Success') ||
            $result['estatus']=='Warning' || $result['estatus']=='warning') {
            if (isset($result['mensaje'])) {
                if (isset($result['infoproducto']) && is_array($result['infoproducto'])) {
                    $transactionId = $result['infoproducto']['transactionid'];
                    $msg = $result['mensaje'];
                    return [
                        'success' => 1,
                        'message' => $msg,
                        'transaction_id' => $transactionId
                    ];
                } elseif (!isset($result['infoproducto'])) {
                    $msg = $result['mensaje'];
                    return [
                        'success' => 1,
                        'message' => $msg
                    ];
                }
            } else {
                return [
                    'success' => 0,
                    'message' => ''
                ];
            }
        } else {
            return [
                'success' => 0,
                'message' => "$requestFor Failed at ClaroShop"
            ];
        }
    }
}
