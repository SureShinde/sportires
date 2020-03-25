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

class Order extends \Ced\Claro\Sdk\Api
{
    const GET_ORDERS_URL = '/pedidos';
    const GET_SHIPMENT_URL = '/embarque';
    public function getClaroShippingMethods($siteId = '')
    {
        $claroShippingMethods = [];
        try {
            if (!empty($siteId)) {
                $shippingMethodsFile = $this->baseDirectory . DS . 'claro' . DS . 'claro_shipping_methods.json';
                if (file_exists($shippingMethodsFile)) {
                    $shippingMethodsJson = file_get_contents($shippingMethodsFile);
                    $claroShippingMethods = json_decode($shippingMethodsJson, true);
                } else {
                    $shippingMethodsJson = $this->get(self::GET_SITES_SUB_URL . '/' . trim($siteId) . '/shipping_methods');
                    if ($shippingMethodsJson && json_decode($shippingMethodsJson)) {
                        $claroShippingMethods = json_decode($shippingMethodsJson, true);
                        if (isset($claroShippingMethods['error'])) {
                            $claroShippingMethods = [];
                        }
                    }
                    file_put_contents(
                        $this->getFile($this->baseDirectory . DS . 'claro', 'claro_shipping_methods.json'),
                        $shippingMethodsJson
                    );
                }
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getClaroShippingMethods Error'
                    ]
                );
            }
        }
        return $claroShippingMethods;
    }

    /**
     * Get order by id
     * @param string $orderId
     * @return array
     */
    public function getById($orderId = '')
    {
        $response = [
            'success' => false,
            'message' => 'No order found for order id: ' . $orderId
        ];

        try {
            $url = \Ced\Claro\Sdk\Url::GET_ORDERS_SUB_URL . '/' . trim($orderId);
            $response = $this->get($url, [], true);
            if (!empty($response)) {
                $result = json_decode($response, true);
                if (isset($result['id']) && !empty($result['id'])) {
                    $response = [
                        'success' => true,
                        'message' => $result
                    ];
                } elseif (isset($result['error'])) {
                    $message = $result['error'] . ' ' . $result['message'];
                    $response = [
                        'success' => false,
                        'message' => $message
                    ];
                }
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'params' => $orderId]
                );
            }
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return $response;
    }

    /**
     * @param string $orderId
     * @return array
     * @deprecated : Use getById()
     */
    public function getOrder($orderId = '')
    {
        return $this->getById($orderId);
    }

    /**
     * Get Orders List
     * @param string $status
     * @return array|string
     */
    public function getList($status)
    {
        $response = [
            'success' => false,
            'message' => 'No new Order(s) found'
        ];
        try {
            $url = self::GET_ORDERS_URL . '?action=' . $status;
            $respond = $this->get($url, $status);
            if (!empty($response)) {
                $result = json_decode($respond, true);
                if (isset($result['totalpendientes']) && !empty($result['totalpendientes']) ||
                    isset($result['totalentregados']) && !empty($result['totalentregados']) ||
                    isset($result['totalembarcados']) && !empty($result['totalembarcados'])) {
                    //totalembarcados : total Shipped orders
                    //totalentregados : total deliverd orders
                    //totalpendientes : total pending orders
                    $orderDetails = [];
                    if (isset($result['listapendientes'])) { //listapendientes : pending list
                        foreach ($result['listapendientes'] as $orderNo) {
                            $id = $orderNo['nopedido']; //nopedido : order id
                            $orderDetails = [$this->getFullOrderDetails($id)];
                        }
                        $response = [
                            'success' => true,
                            'message' => $orderDetails
                        ];
                    } elseif (isset($result['listaentregados'])) { //listaentregados : delivered list
                        foreach ($result['listapendientes'] as $orderNo) {
                            $id = $orderNo['nopedido'];
                            $orderDetails = [$this->getFullOrderDetails($id)];
                        }
                        $response = [
                            'success' => true,
                            'message' => $orderDetails
                        ];
                    } elseif (isset($result['listaguiasautomaticas']) && !isset($result['listaguiasmanuales'])) {
                        foreach ($result['listaguiasautomaticas'] as $orderNo) {
                            $id = $orderNo['nopedido'];
                            $orderDetails = [$this->getFullOrderDetails($id)];
                        }
                        $response = [
                            'success' => true,
                            'message' => $orderDetails
                        ];
                    } elseif (!isset($result['listaguiasautomaticas']) && isset($result['listaguiasmanuales'])) {
                        foreach ($result['listaguiasmanuales'] as $orderNo) {
                            $id = $orderNo['nopedido'];
                            $orderDetails = [$this->getFullOrderDetails($id)];
                        }
                        $response = [
                            'success' => true,
                            'message' => $orderDetails
                        ];
                    } elseif (isset($result['listaguiasautomaticas']) && isset($result['listaguiasmanuales'])) {
                        foreach ($result['listaguiasautomaticas'] as $orderNo) {
                            $id = $orderNo['nopedido'];
                            $orderDetails = [$this->getFullOrderDetails($id)];
                        }
                        foreach ($result['listaguiasmanuales'] as $orderNo) {
                            $id = $orderNo['nopedido'];
                            $orderDetails = [$this->getFullOrderDetails($id)];
                        }
                        $response = [
                            'success' => true,
                            'message' => $orderDetails
                        ];
                    }
                } elseif (isset($result['error'])) {
                    $message = $result['error'];
                    $response = [
                        'success' => false,
                        'message' => $message
                    ];
                } elseif (isset($result['estatus']) && isset($result['mensaje'])) {
                    $message = $result['mensaje'];
                    $response = [
                        'success' => false,
                        'message' => $message
                    ];
                }
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'params' => $status]
                );
            }
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        /*$data = array (
            0 =>
                array (
                    'nopedido' => '701581',
                    'estatuspedido' =>
                        array (
                            'estatus' => 'Por embarcar con Proveedor',
                            'fechacolocado' => '2018-04-06 18:40:36',
                        ),
                    'datosenvio' =>
                        array (
                            'entregara' => 'Kingo Goe',
                            'direccion' => 'Ejercito nacional',
                            'entrecalles' => 'Heracles-Hercules',
                            'colonia' => 'Polanco V Sección',
                            'del/municipio' => 'Miguel Hidalgo',
                            'cp' => '11560',
                            'ciudad' => 'Ciudad de México',
                            'estado' => 'Ciudad de México',
                            'observaciones' => NULL,
                        ),
                    'comentarios' =>
                        array (
                            0 =>
                                array (
                                    'fecha' => '2018-04-09 12:55:49',
                                    'usuario' => 'kingo.6630@live.com',
                                    'comentario' => 'comentario desde apicomercios',
                                ),
                        ),
                    'productos' =>
                        array (
                            0 =>
                                array (
                                    'fechaasignacion' => '2018-04-09 11:05:28',
                                    'fechaenvio' => NULL,
                                    'producto' => 'IPHONE 7 Plus',
                                    'importe' => '79',
                                    'envio' => '47',
                                    'estatus' => NULL,
                                    'asignado' => 'garumi',
                                    'guia' => NULL,
                                    'claroid' => 'Iphone7',
                                    'idpedidorelacion' => '1666610',
                                    'skuhijo' => '',
                                ),
                            1 =>
                                array (
                                    'fechaasignacion' => '2018-04-09 11:05:28',
                                    'fechaenvio' => NULL,
                                    'producto' => 'IPHONE 7 Plus',
                                    'importe' => '79',
                                    'envio' => '47',
                                    'estatus' => NULL,
                                    'asignado' => 'garumi',
                                    'guia' => NULL,
                                    'claroid' => 'Iphone7',
                                    'idpedidorelacion' => '1666610',
                                    'skuhijo' => '',
                                ),
                            2 =>
                                array (
                                    'fechaasignacion' => '2018-04-09 11:05:28',
                                    'fechaenvio' => NULL,
                                    'producto' => 'SANDiskPENDRIVE',
                                    'importe' => '79',
                                    'envio' => '47',
                                    'estatus' => NULL,
                                    'asignado' => 'garumi',
                                    'guia' => NULL,
                                    'claroid' => 'sandiskpendrive',
                                    'idpedidorelacion' => '1666610',
                                    'skuhijo' => '',
                                ),
                        ),
                ),
            1 =>
                array (
                    'nopedido' => '701582',
                    'estatuspedido' =>
                        array (
                            'estatus' => 'Por embarcar con Proveedor',
                            'fechacolocado' => '2018-04-06 18:40:36',
                        ),
                    'datosenvio' =>
                        array (
                            'entregara' => 'Julio Enrique',
                            'direccion' => 'Ejercito nacional',
                            'entrecalles' => 'Heracles-Hercules',
                            'colonia' => 'Polanco V Sección',
                            'del/municipio' => 'Miguel Hidalgo',
                            'cp' => '11560',
                            'ciudad' => 'Ciudad de México',
                            'estado' => 'Ciudad de México',
                            'observaciones' => NULL,
                        ),
                    'comentarios' =>
                        array (
                            0 =>
                                array (
                                    'fecha' => '2018-04-09 12:55:49',
                                    'usuario' => 'jekar.6630@live.com',
                                    'comentario' => 'comentario desde apicomercios',
                                ),
                        ),
                    'productos' =>
                        array (
                            0 =>
                                array (
                                    'fechaasignacion' => '2018-04-09 11:05:28',
                                    'fechaenvio' => NULL,
                                    'producto' => 'SANDiskPENDRIVE',
                                    'importe' => '79',
                                    'envio' => '47',
                                    'estatus' => NULL,
                                    'asignado' => 'garumi',
                                    'guia' => NULL,
                                    'claroid' => 'sandiskpendrive',
                                    'idpedidorelacion' => '1666610',
                                    'skuhijo' => '',
                                ),
                        ),
                ),
        );
        $response = [
            'success' => true,
            'message' => $data
        ];*/
        /*echo "<pre>";print_r($response);echo "</pre>";
                die('------');*/
        return $response;
    }

    /**
     * Get Order By Id from orderno from getList()
     * @param $id
     * @return array|string
     */
    public function getFullOrderDetails($id)
    {
        $message = "Error in Order fetching from Api";
        if (isset($id) && !empty($id)) {
            try {
                $url = self::GET_ORDERS_URL . '?action=detallepedido&nopedido=' . $id;
                $response = $this->get($url);
                if (!empty($response)) {
                    $result = json_decode($response, true);
                    if (isset($result['estatuspedido']) && !empty($result['estatuspedido'])) {
                        $result['nopedido'] = $id;
                        $message = $result;
                    } elseif (isset($result['error'])) {
                        $message = $result['error'];
                    } elseif (isset($result['estatus']) && isset($result['mensaje']) && $result['estatus'] == 'error') {
                        $message = $result['mensaje'];
                    }
                }
            } catch (\Exception $e) {
                if ($this->debugMode) {
                    $this->logger->addError(
                        $e->getMessage(),
                        ['path' => __METHOD__]
                    );
                }
                $response = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        }
        return $message;
    }

    /**
     * @param array $params
     * @return array
     * @deprecated: Use getList()
     */
    public function getOrders($params = [])
    {
        return $this->getList($params);
    }

    public function shipOrder($shipmentId, $params = [])
    {
        if (!empty($shipmentId)) {
            try {
                $url = self::GET_SHIPMENT_URL;
                $result = $this->post($url, json_encode($params));
                $response = json_decode($result, true);
//                echo "<pre>";print_r($response);echo "<pre>";die(',,,,,,,');
                $data = array (
                    'estatus' => 'success',
                    'mensaje' => 'La guía fue asignada al pedido correctamente',
                    'nopedido' => '701655',
                    'tipoguia' => 'manual',
                    'mensajeria' => 'manual',
                    'guia' => '5214859663',
                    'productosid' => '993000',
                    'idrelacionproducto' => '693777',
                );
                return [
                    'success' => true,
                    'message' => $data
                ];
                /*if (isset($response) && isset($response['estatus']) && $response['estatus'] == 'success') {
                    return [
                        'success' => true,
                        'message' => $response
                    ];
                } elseif (isset($response) && isset($response['estatus']) && $response['estatus'] == 'error') {
                    return [
                            'success' => false,
                            'message' => $response['mensaje']
                        ];
                } else {
                    return [
                        'success' => false,
                        'message' => isset($response['message']) ? $response['message'] : ''
                    ];
                }*/
            } catch (\Exception $e) {
                if ($this->debugMode) {
                    $this->logger->addError(
                        $e->getMessage(),
                        ['path' => __METHOD__, 'message' => 'Ship Order ' . $shipmentId . ' Error'
                        ]
                    );
                }
            }
        }
        return [
            'success' => false,
            'message' => ''
        ];
    }
    public function markOrder($orderId, $type = 'delivered')
    {
        if (!empty($orderId)) {
            try {
                $url = self::GET_ORDERS_SUB_URL . '/' . trim($orderId) . '/feedback';
                $params = [];
                if ($type == 'cancelled') {
                    $params['fulfilled'] = false;
                    $params['rating'] = 'neutral';
                } else {
                    $params['fulfilled'] = true;
                    $params['rating'] = 'positive';
                }
                $result = $this->post($url, json_encode($params));
                $response = json_decode($result, true);
                if (isset($response) && isset($response['id'])) {
                    return [
                        'success' => true,
                        'message' => $response
                    ];
                } elseif (isset($response) && isset($response['error'])) {
                    return [
                            'success' => false,
                            'message' => $response['message'] . ' ' . $response['error']
                        ];
                } elseif (is_array($response) && isset($response[0]) && $response[0] == 'Feedback already exists') {
                    return [
                        'success' => false,
                        'message' => 'Feedback already exists'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => isset($response['message']) ? $response['message'] : ''
                    ];
                }
            } catch (\Exception $e) {
                if ($this->debugMode) {
                    $this->logger->addError(
                        $e->getMessage(),
                        ['path' => __METHOD__, 'message' => 'MarkOrder ' . $orderId . 'as ' . $type . ' Error'
                        ]
                    );
                }
            }
        }
        return [
            'success' => false,
            'message' => ''
        ];
    }
    public function sendMessage($params)
    {
        if (!empty($params)) {
            try {
                $url = 'messages';
                $result = $this->post($url, json_encode($params));
                $response = json_decode($result, true);
                if (isset($response) && isset($response['id'])) {
                    return [
                        'success' => true,
                        'message' => $response
                    ];
                } elseif (isset($response) && isset($response['error'])) {
                    return [
                            'success' => false,
                            'message' => $response['message'] . ' ' . $response['error']
                        ];
                } elseif (is_array($response) && isset($response[0]) && $response[0] == 'Can not Sent Message') {
                    return [
                        'success' => false,
                        'message' => 'Feedback already exists'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => isset($response['message']) ? $response['message'] : ''
                    ];
                }
            } catch (\Exception $e) {
                if ($this->debugMode) {
                    $this->logger->addError(
                        $e->getMessage(),
                        ['path' => __METHOD__, 'message' => 'Send Message To Customer', 'data' => $params
                        ]
                    );
                }
            }
        }
        return [
            'success' => false,
            'message' => ''
        ];
    }

    public function getMessages($orderId = '')
    {
        $subUrl = self::GET_ORDERS_SUB_URL;
        try {
            $response = $this->get($subUrl . '/' . trim($orderId) . '/messages', [], true);
            if (!empty($response) && json_decode($response, true)) {
                $result = json_decode($response, true);
                if (isset($result['results']) && !empty($result['results'])) {
                    return [
                        'success' => true,
                        'message' => $result
                    ];
                } elseif (isset($result['error'])) {
                    $message = $result['error'] . ' ' . $result['message'];
                    return [
                        'success' => false,
                        'message' => $message
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'No new Order Data Found for Order Id ' . $orderId
                    ];
                }
            }
            return [
                'success' => false,
                'message' => 'No new Order Data Found for Order Id ' . $orderId
            ];
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getOrder ' . $orderId . ' Error'
                    ]
                );
            }
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
