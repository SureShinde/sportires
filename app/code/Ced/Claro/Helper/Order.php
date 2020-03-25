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
 * @category    Ced
 * @package     Ced_Claro
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright © 2018 CedCommerce. All rights reserved.
 * @license     EULA http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Claro\Helper;

/**
 * Class Order
 * @package Ced\Claro\Helper
 */
class Order extends \Magento\Framework\App\Helper\AbstractHelper
{
    const ERROR_OUT_OF_STOCK = "'%s' SKU out of stock";
    const ERROR_NOT_ENABLED = "'%s' SKU not enabled on store '%s'";
    const ERROR_DOES_NOT_EXISTS = "'%s' SKU not exists on store '%s'";
    const ERROR_ITEM_DATA_NOT_AVAILABLE = "'%s' SKU not available in order items '%s'";

    /** @var \Magento\Framework\DataObjectFactory */
    public $dataFactory;

    /** @var \Magento\Framework\Notification\NotifierInterface */
    public $notifier;

    /** @var \Magento\Framework\Serialize\SerializerInterface */
    public $serializer;

    /** @var \Magento\Framework\Registry */
    public $registry;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    public $storeManager;

    /** @var \Magento\Framework\DB\TransactionFactory  */
    public $transactionFactory;

    /** @var \Magento\Customer\Model\CustomerFactory */
    public $customerFactory;

    /** @var \Magento\Customer\Api\CustomerRepositoryInterface */
    public $customerRepository;

    /** @var \Magento\Sales\Model\Service\OrderService */
    public $orderService;

    /** @var \Magento\Sales\Model\Service\InvoiceService  */
    public $invoiceService;

    /** @var \Magento\Sales\Controller\Adminhtml\Order\CreditmemoLoaderFactory */
    public $creditmemoLoaderFactory;

    /** @var \Magento\Quote\Api\CartRepositoryInterface */
    public $cartRepositoryInterface;

    /** @var \Magento\Quote\Api\CartManagementInterface */
    public $cartManagementInterface;

    /** @var \Magento\Catalog\Model\ProductFactory */
    public $productFactory;

    /** @var \Magento\CatalogInventory\Api\StockRegistryInterface */
    public $stockRegistry;

    /** @var \Ced\Claro\Model\OrderFactory */
    public $orderFactory;

    /** @var \Ced\Integrator\Model\MailFactory */
    public $mailFactory;

    /** @var Logger */
    public $logger;

    /** @var Config */
    public $config;

    /** @var Sdk */
    public $sdk;

    public $result = 0;
    /**
     * @var \Magento\Directory\Model\RegionFactory
     */
    public $regionFactory;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\DataObjectFactory $dataFactory,
        \Magento\Framework\Notification\NotifierInterface $notifier,
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Sales\Model\Service\OrderService $orderService,
        \Magento\Sales\Model\Service\InvoiceService $invoiceService,
        \Magento\Sales\Controller\Adminhtml\Order\CreditmemoLoaderFactory $creditmemoLoaderFactory,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface,
        \Magento\Quote\Api\CartManagementInterface $cartManagementInterface,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\ProductFactory $product,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Ced\Integrator\Model\MailFactory $mailFactory,
        \Ced\Claro\Model\OrderFactory $orderFactory,
        \Ced\Claro\Helper\Config $config,
        \Ced\Claro\Helper\Logger $logger,
        \Ced\Claro\Helper\Sdk $sdk,
        \Magento\Directory\Model\RegionFactory $regionFactory
    ) {
        parent::__construct($context);
        $this->dataFactory = $dataFactory;
        $this->notifier = $notifier;
        $this->serializer = $serializer;
        $this->registry = $registry;
        $this->storeManager = $storeManager;
        $this->transactionFactory = $transactionFactory;

        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;

        $this->orderService = $orderService;
        $this->invoiceService = $invoiceService;
        $this->creditmemoLoaderFactory = $creditmemoLoaderFactory;
        $this->cartRepositoryInterface = $cartRepositoryInterface;
        $this->cartManagementInterface = $cartManagementInterface;

        $this->productRepository = $productRepository;
        $this->productFactory = $product;
        $this->stockRegistry = $stockRegistry;

        $this->orderFactory = $orderFactory;
        $this->mailFactory = $mailFactory;

        $this->logger = $logger;
        $this->config = $config;
        $this->sdk = $sdk;
        $this->regionFactory = $regionFactory;
    }

    /**
     * Import Orders
     * @param null $orderId
     * @param string $status
     * @param string $shippingStatus
     * @param null $orderDate
     * @return int
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function import(
        $orderId = null,
        $status = \Ced\Claro\Model\Source\Order\Status::PENDING
        /*$shippingStatus = \Ced\Claro\Model\Source\Order\Shipment\Status::PENDING,
        $orderDate = null*/
    ) {
        $this->result = 0;
        $storeId = $this->config->getStoreId();
        $websiteId = $this->storeManager->getStore($storeId)->getWebsiteId();
        /** @var \Magento\Store\Model\Store $store */
        $store = $this->storeManager->getStore($storeId);

        $orders = [
            'success' => false,
            'message' => []
        ];
        if (!empty($orderId)) {
            $order = $this->sdk->getOrder()->getById($orderId);
            if (isset($order["message"]['id'])) {
                $orders = [
                    "success" => $order["success"],
                    "message" => [
                        $order["message"]
                    ],
                ];
            }
        } else {
            // Add CreatedAfter date Parameter: Required
            /*if (!isset($orderDate) || empty($orderDate)) {
                $orderDate = date('Y-m-d', strtotime('-1 days'));
            }

            // Adding OrderStatus Parameter: Optional
            if ((!isset($status) && empty($status)) ||
                !in_array($status, \Ced\Claro\Model\Source\Order\Status::STATUS)) {
                $status = \Ced\Claro\Model\Source\Order\Status::PAID;
            }

            // Adding OrderStatus Parameter: Optional
            if ((!isset($shippingStatus) && empty($shippingStatus)) ||
                !in_array($shippingStatus, \Ced\Claro\Model\Source\Order\Shipment\Status::STATUS)) {
                $shippingStatus = \Ced\Claro\Model\Source\Order\Shipment\Status::PENDING;
            }

            $params = [
                "seller" => $this->config->getSellerId()
            ];

            $params['order.date_created.from'] = $orderDate . 'T00:00:00.000-00:00';
            if ($status != 'all') {
                $params['order.status'] = $status;
            }

            if ($shippingStatus != 'all') {
                $params['shipping.status'] = $shippingStatus;
            }*/
            $orders = $this->sdk->getOrder()->getList($status);
            /*echo "<pre>";print_r($orders);echo "</pre>";die();*/
        }

        /*$orders['message'] = [json_decode('{
    "id": 1860209084,
    "date_created": "2018-11-15T00:23:38.000-04:00",
    "date_closed": "2018-11-15T00:23:41.000-04:00",
    "last_updated": "2018-11-15T00:23:41.000-04:00",
    "manufacturing_ending_date": null,
    "feedback": {
        "sale": null,
        "purchase": null
    },
    "mediations": [],
    "comments": null,
    "pickup_id": null,
    "order_request": {
        "return": null,
        "change": null
    },
    "fulfilled": null,
    "total_amount": 548,
    "total_amount_with_shipping": 548,
    "paid_amount": 548,
    "taxes": {
        "amount": null,
        "currency_id": null
    },
    "coupon": {
        "id": null,
        "amount": 0
    },
    "expiration_date": "2018-12-13T00:23:41.000-04:00",
    "order_items": [
        {
            "item": {
                "id": "MLM647069245",
                "title": "Funda Zizo Bolt Iphone Xs Max Negro/negro Cristal Y Clip",
                "category_id": "MLM167442",
                "variation_id": null,
                "seller_custom_field": "02_02516",
                "variation_attributes": [],
                "warranty": null,
                "condition": "new",
                "seller_sku": null
            },
            "quantity": 1,
            "unit_price": 100.00,
            "full_unit_price": 100.00,
            "currency_id": "MXN",
            "manufacturing_days": null
        }
    ],
    "currency_id": "MXN",
    "payments": [
        {
            "id": 4292713668,
            "order_id": 1859283509,
            "payer_id": 27402748,
            "collector": {
                "id": 10169526
            },
            "card_id": 8566235291,
            "site_id": "MLM",
            "reason": "Funda Zizo Bolt Iphone Xs Max Negro/negro Cristal Y Clip",
            "payment_method_id": "visa",
            "currency_id": "MXN",
            "installments": 1,
            "issuer_id": "158",
            "atm_transfer_reference": {
                "company_id": null,
                "transaction_id": null
            },
            "coupon_id": null,
            "activation_uri": null,
            "operation_type": "regular_payment",
            "payment_type": "credit_card",
            "available_actions": [
                "refund"
            ],
            "status": "approved",
            "status_code": null,
            "status_detail": "accredited",
            "transaction_amount": 548,
            "taxes_amount": 0,
            "shipping_cost": 0,
            "coupon_amount": 0,
            "overpaid_amount": 0,
            "total_paid_amount": 548,
            "installment_amount": 548,
            "deferred_period": null,
            "date_approved": "2018-11-15T00:23:41.000-04:00",
            "authorization_code": "305525",
            "transaction_order_id": null,
            "date_created": "2018-11-15T00:23:39.000-04:00",
            "date_last_modified": "2018-11-15T00:23:41.000-04:00"
        }
    ],
    "shipping": {
    "id": 27737259548,
    "mode": "me2",
    "created_by": "receiver",
    "order_id": 1859283509,
    "order_cost": 548,
    "base_cost": 98,
    "site_id": "MLM",
    "status": "ready_to_ship",
    "substatus": "ready_to_print",
    "status_history": {
        "date_cancelled": null,
        "date_delivered": null,
        "date_first_visit": null,
        "date_handling": "2018-11-15T00:23:43.000-04:00",
        "date_not_delivered": null,
        "date_ready_to_ship": "2018-11-15T00:23:44.000-04:00",
        "date_shipped": null,
        "date_returned": null
    },
    "date_created": "2018-11-15T00:23:38.000-04:00",
    "last_updated": "2018-11-15T00:23:44.000-04:00",
    "tracking_number": "783786646395",
    "tracking_method": "FedEx Express Saver",
    "service_id": 511,
    "carrier_info": null,
    "sender_id": 10169526,
    "sender_address": {
        "id": 154392260,
        "address_line": "Calzada del Valle 605",
        "street_name": "Calzada del Valle",
        "street_number": "605",
        "comment": "Referencia Local TODOparaSMARTPHONES Entre Olmos Y Ebanos (local Todoparasmartphones)",
        "zip_code": "66268",
        "city": {
            "id": "TUxNQ1NBTjQ0Mjg",
            "name": "San Pedro Garza García"
        },
        "state": {
            "id": "MX-NLE",
            "name": "Nuevo León"
        },
        "country": {
            "id": "MX",
            "name": "Mexico"
        },
        "neighborhood": {
            "id": null,
            "name": "Valle de Santa Engracia"
        },
        "municipality": {
            "id": null,
            "name": "San Pedro Garza García"
        },
        "agency": null,
        "types": [
            "billing",
            "default_buying_address",
            "default_selling_address",
            "shipping"
        ],
        "latitude": 25.659892,
        "longitude": -100.384591,
        "geolocation_type": "RANGE_INTERPOLATED"
    },
    "receiver_id": 27402748,

    "shipping_items": [
        {
            "id": "MLM647069245",
            "description": "Funda Zizo Bolt Iphone Xs Max Negro/negro Cristal Y Clip",
            "quantity": 1,
            "dimensions": "1.0x5.0x10.0,30.0",
            "dimensions_source": {
                "id": "MLM167442",
                "origin": "categories"
            }
        }
    ],
    "shipping_option": {
        "id": 535757286,
        "shipping_method_id": 501245,
        "name": "Estándar a domicilio",
        "currency_id": "MXN",
        "cost": 0,
        "delivery_type": "estimated",
        "list_cost": 0,
        "estimated_delivery_time": {
            "type": "known_frame",
            "date": "2018-11-20T00:00:00.000-06:00",
            "unit": "hour",
            "offset": {
                "date": "2018-11-21T00:00:00.000-06:00",
                "shipping": 24
            },
            "time_frame": {
                "from": null,
                "to": null
            },
            "pay_before": null,
            "shipping": 48,
            "handling": 24,
            "schedule": null
        },
        "estimated_schedule_limit": {
            "date": null
        },
        "estimated_handling_limit": {
            "date": "2018-11-15T00:00:00.000-06:00"
        },
        "estimated_delivery_final": {
            "date": "2018-12-20T00:00:00.000-06:00",
            "offset": 480
        },
        "estimated_delivery_limit": {
            "date": "2018-12-06T00:00:00.000-06:00",
            "offset": 264
        },
        "estimated_delivery_extended": {
            "date": "2018-11-27T00:00:00.000-06:00",
            "offset": 96
        }
    },
    "comments": null,
    "date_first_printed": null,
    "market_place": "MELI",
    "return_details": null,
    "tags": [],
    "type": "forward",
    "application_id": null,
    "return_tracking_number": null,
    "cost_components": {
        "special_discount": 0,
        "loyal_discount": 1,
        "compensation": 0
    },
    "logistic_type": "drop_off",
    "substatus_history": [],
    "delay": []
}
,
    "status": "paid",
    "status_detail": null,
    "tags": [
        "not_delivered",
        "paid"
    ],
    "buyer": {
        "id": 27402748,
        "nickname": "RAUJIMENEZMOSCOSO",
        "email": "rjimene.lzdltb+2-oge4dkojshaztknbt@mail.mercadolibre.com.mx",
        "phone": {
            "area_code": "9933",
            "extension": "",
            "number": "591101",
            "verified": false
        },
        "alternative_phone": {
            "area_code": "",
            "extension": "",
            "number": ""
        },
        "first_name": "RAUL ALONSO",
        "last_name": "JIMENEZ MOSCOSO",
        "billing_info": {
            "doc_type": null,
            "doc_number": null
        }
    },
    "seller": {
        "id": 10169526,
        "nickname": "TODOPARASMARTPHONES",
        "email": "lchapa.08dgqhw+2-oge4dkojshaztkmzz@mail.mercadolibre.com.mx",
        "phone": {
            "area_code": "81",
            "extension": "",
            "number": "11581555",
            "verified": false
        },
        "alternative_phone": {
            "area_code": "81",
            "extension": "",
            "number": "1158 1666"
        },
        "first_name": "LEOBARDO",
        "last_name": "CHAPA"
    }
}', true)];*/

        //Claro Order Example
        /*{
            "totalpendientes": 8,
            "listapendientes": [   //pending order
                {
                    "nopedido": "701580",// order id----->id to get details of orders
                    "estatus": "Pendiente",// status:pending/shipped/delivered
                    "fechacolocacion": "2018-05-09", //placement date
                    "fechaautorizacion": "2018-05-09",//Authorization date
                    "sku": "74503230",
                    "idpedidorelacion": "1674552",
                    "articulo": "BURBERRY THE BEAT WOMEN EDP 75ML",
                    "sla": "En tiempo de embarque",
                    "comision": "0",
                    "totalproducto": "1690",
                    "totalpedido": "1690", //total order
                    "skuhijo": ""
                    }
            ]
        }
        // Full order Details----------
        {
            "nopedido" = "701580",
            "estatuspedido":{ //order status
                "estatus":"Por embarcar con Proveedor", //order status
                "fechacolocado":"2018-04-06 18:40:36" //date placed
            },
            "datosenvio":{ //shipping data
                "entregara":"Julio Enrique", //customer name
                "direccion":"Ejercito nacional", //address
                "entrecalles":"Heracles-Hercules",
                "colonia":"Polanco V Sección",
                "del/municipio":"Miguel Hidalgo",
                "cp":"11560",
                "ciudad":"Ciudad de México",
                "estado":"Ciudad de México",
                "observaciones":null
            },
            "comentarios":[ //comments
                {
                    "fecha":"2018-04-09 12:55:49",
                    "usuario":"jekar.6630@live.com",
                    "comentario":"comentario desde apicomercios"
                }
            ],
            "productos":[ //product details
                {
                    "fechaasignacion":"2018-04-09 11:05:28",
                    "fechaenvio":null,
                    "producto":"Fidget Hand Spinner Rosa Led Juguete Antiestres ",
                    "importe":"79",
                    "envio":"47",
                    "estatus":null,
                    "asignado":"garumi",
                    "guia":null,
                    "claroid":"728220", //product id on claroshop
                    "idpedidorelacion":"1666610",
                    "skuhijo":""
                }
            ]
        }
        */

        /*echo "<pre>";print_r($orders);echo "</pre>";
        die('======');*/
        if (isset($orders['message']) &&
            is_array($orders['message']) && isset($orders['message'][0]['nopedido'])) {
            /** @var array $apiOrder */

            /*echo "<pre>";print_r($orders);echo "</pre>";
        die('======');*/

            foreach ($orders['message'] as $apiOrder) {
                $apiOrderId = $apiOrder['nopedido']; //nopedido : order id

                /** @var \Ced\Claro\Model\Order|null $mporder */
                $mporder = $this->orderFactory->create()->getByPurchaseOrderId($apiOrderId);
                if (empty($mporder)) {
                    // Create order in our Claro : marketplace table, if not created.
                    $mporder = $this->create(null, $apiOrder);
                }
                /*print_r($mporder->getData(\Ced\Claro\Model\Order::COLUMN_MAGENTO_ORDER_ID));die('====');*/
                // Create order in magento
                if (!empty($mporder) &&
                    empty($mporder->getData(\Ced\Claro\Model\Order::COLUMN_MAGENTO_ORDER_ID))) {
                    /** @var \Magento\Customer\Api\Data\CustomerInterface $customer */
                    $customer = $this->getCustomer($apiOrder, $websiteId);
                    /*var_dump($customer->getId());die('lllllll');*/
                    /*print_r($mporder->getId());die('===');*/
                    if ($customer !== false) {
                        $this->quote($store, $customer, $apiOrder, $mporder->getId());
                    } else {
                        continue;
                    }
                }
            }
        }
        if (isset($this->result) && $this->result > 0) {
            $this->notify(
                "New Claro Orders",
                "Congratulation! You have received {$this->result} new orders form Claro"
            );
        }
        return $this->result;
    }

    /**
     * Create an order in claro table
     * @param \Magento\Sales\Model\Order|null $order
     * @param array $data
     * @throws \Exception
     * @return \Ced\Claro\Model\Order
     */
    public function create($order = null, $data = [])
    {
        try {
            // after save order
            //estatuspedido : order status
            //fechacolocado : date placed
            $orderPlace = substr($data['estatuspedido']['fechacolocado'], 0, 10);
            $status = $data['estatuspedido']['estatus'];
            $orderData = [
                \Ced\Claro\Model\Order::COLUMN_MARKETPLACE_ORDER_ID => $data['nopedido'],
                \Ced\Claro\Model\Order::COLUMN_MARKETPLACE_DATE_CREATED => $orderPlace,
                \Ced\Claro\Model\Order::COLUMN_STATUS => $status,
                \Ced\Claro\Model\Order::COLUMN_ORDER_DATA => $this->serializer->serialize($data),
            ];

            if (isset($order) && !empty($order->getId())) {
                $orderData[ \Ced\Claro\Model\Order::COLUMN_MAGENTO_ORDER_ID] = $order->getId();
                if ($orderData['status'] == \Ced\Claro\Model\Source\Order\Status::NOT_IMPORTED) {
                    $orderData['status'] = \Ced\Claro\Model\Source\Order\Status::IMPORTED;
                }
            }

            /** @var \Ced\Claro\Model\Order $mporder */
            $mporder = $this->orderFactory->create()->addData($orderData);
            return $mporder->save();
        } catch (\Exception $e) {
            $this->logger->addCritical(
                'Order create failed in marketplace table.',
                [
                    'order' => $data,
                ]
            );
            return null;
        }
    }

    /**
     * Generate Quote
     * @param \Magento\Store\Model\Store $store
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @param array|null $order
     * @param int $mporderId
     * @return int
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function quote(
        $store,
        $customer,
        $order = null,
        $mporderId = null
    ) {
        $claroOrderId = '';
        $reason = [];
        try {
            $claroOrderId = $this->getValue('nopedido', $order, '');// nopedido : order id
            $items = $this->getValue('productos', $order, []); //productos : products array
            $productItems = $this->getClaroProductQuantity($items);
            /*echo "<pre>";print_r($this->getClaroProductQuantity($items));echo "</pre>";die('-----');*/
            /** @var int $cartId */
            $cartId = $this->cartManagementInterface->createEmptyCart();
            /** @var \Magento\Quote\Model\Quote $quote */
            $quote = $this->cartRepositoryInterface->get($cartId);
            $quote->setStore($store);
            $quote->setCurrency();
            $customer = $this->customerRepository->getById($customer->getId());
            $quote->assignCustomer($customer);
            $itemAccepted = 0;
            foreach ($productItems as $index => $item) {
                if (isset($index)) { //claroid : assigned as sku of product
                    $sku = $index;
                    /*$qty = $this->getValue('quantity', $order, 0);*/
                    $qty = $item['qty'];
                    $product = $this->productFactory->create()
                        ->loadByAttribute('sku', $sku);
                    if (isset($product) && !empty($product)) {
                        /** @var \Magento\Catalog\Model\Product $product */
                        $product = $this->productFactory->create()->load($product->getEntityId());
                        if ($product->getStatus() == '1') {
                            $sku = $product->getSku();
                            /* Get stock item */
                            $stock = $this->stockRegistry
                                ->getStockItem($product->getId(), $product->getStore()->getWebsiteId());
                            $stockStatus = ($stock->getQty() > 0) ? ($stock->getIsInStock() == '1' ?
                                ($stock->getQty() >= $qty ? true : false)
                                : false) : false;
//                            var_dump($stockStatus);die('ppppp');
                            if ($stockStatus) {
                                $itemAccepted++;
                                $price = $item['price']; //importe : amount
                                $product->setPrice($price)
                                    ->setOriginalCustomPrice($price)->setSpecialPrice($price);
//                                $product->setOriginalCustomPrice($price); //todo:check
                                $quote->addProduct($product, (int)$qty);
                            } else {
                                $reason[] = sprintf(self::ERROR_OUT_OF_STOCK, $sku);
                            }
                        } else {
                            $reason[] = sprintf(self::ERROR_NOT_ENABLED, $sku, $store->getName());
                        }
                    } else {
                        $reason[] = sprintf(self::ERROR_DOES_NOT_EXISTS, $sku, $store->getName());
                    }
                } else {
                    $reason[] = self::ERROR_ITEM_DATA_NOT_AVAILABLE;
                }
            }
//            print_r($itemAccepted);die('------');
            if ($itemAccepted == 0) {
                $this->reject($order, $reason);
            }

            if ($itemAccepted > 0) {
                //&& count($items[0]) == $itemAccepted   condition for full order acknowledge
                if (isset($order['datosenvio'])) { //datosenvio : shipping data
                    /** @var array $address */
                    $address = $order['datosenvio'];
                    /** @var array $buyer */
                    $buyer = $this->getValue('datosenvio', $order, []);
                    $phone = /*implode(' ', array_values($this->getValue('phone', $buyer, [])));*/'9999999999';
                    $regionId = $this->region(
                        $this->getValue('estado', $buyer, ''),
                        $this->getValue('ciudad', $buyer, ''),
                        'MX'
                    );
                    $shipAddress = [
                        'firstname' => $this->getValue('entregara', $buyer, '-'), //entregara : customer name
                        'lastname' => /*$this->getValue('last_name', $buyer, '-')*/'claro',
                        'street' => $this->getValue('entrecalles', $buyer, ''), //entrecalles : street name
                        'city' => $this->getValue('ciudad', $buyer, ''), //ciudad : city
                        'country_id' => $this->getValue('country_id', $buyer, 'MX'),
                        'region' => $this->getValue('estado', $buyer, ''), //estado: state
                        'region_id' =>$regionId,
                        'postcode' => $this->getValue('cp', $buyer, '12345'), //cp : postal code
                        'telephone' => $phone,
                        'fax' => '',
                        'save_in_address_book' => 1
                    ];
                } else {
                    // Using seller address
                    $address = json_decode($this->config->getSellerAddress(), true);
                    $countryId = /*$this->config->getSellerCountryId()*/'00000';
                    $state = explode('-', $this->getValue('state', $address, ''), 2);
                    $buyer = $this->getValue('buyer', $order, []);
                    $phone = implode(' ', array_values($this->getValue('phone', $buyer, [])));
                    $shipAddress = [
                        'firstname' => $this->getValue('first_name', $buyer, '-'),
                        'lastname' => $this->getValue('last_name', $buyer, '-'),
                        'street' => $this->getValue('address', $address, ''),
                        'city' => $this->getValue('city', $address, ''),
                        'country_id' => $countryId,
                        'region' => $this->getValue(1, $state, ''),
                        'postcode' => $this->getValue('zip_code', $address, '12345'),
                        'telephone' => $phone,
                        'fax' => '',
                        'save_in_address_book' => 1
                    ];
                }
//                print_r($shipAddress);die('ppppp');
                $billAddress = $shipAddress;
                $quote->getBillingAddress()->addData($billAddress);
//                var_dump($quote);die('.......');
                $shippingAddress = $quote->getShippingAddress()->addData($shipAddress);
//                var_dump($shippingAddress);die('pppppp');
                $shippingAddress->setCollectShippingRates(true)->collectShippingRates()
                    ->setShippingMethod('shipbyclaro_shipbyclaro');
                $quote->setPaymentMethod('paybyclaro');
                $quote->setInventoryProcessed(false);
                $quote->getPayment()->importData([
                    'method' => 'paybyclaro'
                ]);

                $quote->collectTotals()->save();
//                var_dump($quote);die('ppppppppppp');
                /** @var \Magento\Sales\Model\Order $magentoOrder */
                $magentoOrder = $this->cartManagementInterface->submit($quote);
//                var_dump($magentoOrder);die('-------');
                if (isset($magentoOrder)) {
                    $magentoOrder
                        ->setIncrementId($this->config->getOrderIdPrefix() . $magentoOrder->getIncrementId())
                        ->save();
                    $this->result = isset($magentoOrder) ? $this->result + 1 : $this->result;

                    // after save order
                    //estatuspedido : order details array type
                    //fechacolocado : date placed
                    //estatus : pending
                    $orderPlace = substr($this->getValue('fechacolocado', $order['estatuspedido'], ''), 0, 10);
                    $status = $this->getValue('estatus', $order['estatuspedido'], \Ced\Claro\Model\Source\Order\Status::INVALID);
                    $orderData = [
                        \Ced\Claro\Model\Order::COLUMN_MARKETPLACE_ORDER_ID => $this->getValue('nopedido', $order, ''),
                        \Ced\Claro\Model\Order::COLUMN_MARKETPLACE_DATE_CREATED => $orderPlace,
                        \Ced\Claro\Model\Order::COLUMN_MAGENTO_ORDER_ID => $magentoOrder->getId(),
                        'status' => $status,
                        'order_data' => $this->serializer->serialize($order),
                        \Ced\Claro\Model\Order::COLUMN_FAILURE_REASON => ""
                    ];

                    $mporder = $this->orderFactory->create()->load($mporderId)
                        ->addData($orderData);
                    $mporder->save();

                    $adminEmail = $this->config->getNotificationEmail();
                    if (!empty($adminEmail)) {
                        /** @var \Magento\Framework\DataObject $data */
                        $data = $this->dataFactory->create();
                        $data->addData([
                            'to' => $adminEmail,
                            'marketplace_name' => 'Claro',
                            'po_id' => $this->getValue('nopedido', $order, ''),
                            'order_id' => $magentoOrder->getIncrementId(),
                            'order_date' => $orderPlace,
                        ]);
                        /** @var \Ced\Claro\Model\Mail $mail */
                        $mail = $this->mailFactory->create();
                        $mail->send($data);
                    }

                    $autoInvoice = $this->config->getAutoInvoice();
                    if ($autoInvoice) {
                        $this->invoice($magentoOrder);
                    }

                    $autoAcknowledge = $this->config->getAutoAcknowledgement();
                    if ($autoAcknowledge) {
                        //$this->acknowledge($magentoOrder->getId(), $order->getClaroOrderId(), $mporder);
                    }
                } else {
                    throw new \Magento\Framework\Exception\LocalizedException(__('Failed to create order in Magento.'));
                }
            }
        } catch (\Exception $exception) {
            $reason[] = $exception->getMessage();
            $this->reject($order, $reason);
//            print_r($exception->getMessage());die('0000000000');
            $this->logger->addError(
                "Order #{$claroOrderId} import failed." . $exception->getMessage(),
                ['path' => __METHOD__]
            );
            return false;
        }

        return true;
    }

    /**
     * Generate Invoice
     * @param \Magento\Sales\Model\Order $order
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function invoice($order)
    {
        try {
            if (!$order->getId()) {
                throw new \Magento\Framework\Exception\LocalizedException(__('The order no longer exists.'));
            }

            if (!$order->canInvoice()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('The order does not allow an invoice to be created.')
                );
            }

            /** @var \Magento\Sales\Model\Order\Invoice $invoice */
            $invoice = $this->invoiceService->prepareInvoice($order);

            if (!$invoice) {
                throw new \Magento\Framework\Exception\LocalizedException(__('We can\'t save the invoice right now.'));
            }

            if (!$invoice->getTotalQty()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('You can\'t create an invoice without products.')
                );
            }

            $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_OFFLINE);
            $invoice->register();
            $invoice->getOrder()->setCustomerNoteNotify(false);
            $invoice->getOrder()->setIsInProcess(true);
            $order->addStatusHistoryComment(
                __('Automatically invoiced via cedcommerce claro.'),
                false
            );
            /** @var \Magento\Framework\DB\Transaction $transaction */
            $transaction = $this->transactionFactory->create()
                ->addObject($invoice)
                ->addObject($invoice->getOrder());
            $transaction->save();
        } catch (\Exception $e) {
            $this->logger->addError($e->getMessage(), ['order_id' => $order->getId()]);
        }
    }

    /**
     * Reject Order
     * @param array $order
     * @param array $reason
     * @return bool
     * @throws \Exception
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function reject($order, $reason = [])
    {
        $response = false;
        if ($this->config->getAutoCancellation()) {
            // TODO: add cancel
        }

        $orderId = $this->getValue('id', $order);

        /** @var \Ced\Claro\Model\Order $mporder */
        $mporder = $this->orderFactory->create()
            ->load($orderId, \Ced\Claro\Model\Order::COLUMN_MARKETPLACE_ORDER_ID);
        $mporder->setData(\Ced\Claro\Model\Order::COLUMN_STATUS, \Ced\Claro\Model\Source\Order\Status::FAILED);
        $mporder->setData(
            \Ced\Claro\Model\Order::COLUMN_FAILURE_REASON,
            $this->serializer->serialize($reason)
        );

        if ($response !== false) {
            $mporder->setData(
                \Ced\Claro\Model\Order::COLUMN_STATUS,
                \Ced\Claro\Model\Source\Order\Status::CANCELLED
            );
        }

        $mporder->save();
        $this->logger->addNotice(
            'Order import failed. Order Id: #' . $orderId,
            [
                'cancelled' => $response,
                'reason' => $reason,
            ]
        );
        return true;
    }

    /**
     * Add Admin Notification
     * @param string $title
     * @param string $message
     * @param string $type
     */
    public function notify($title = "", $message = "", $type = 'notice')
    {
        if ($type == "critical") {
            $this->notifier->addCritical($title, $message);
        } else {
            $this->notifier->addNotice($title, $message);
        }
    }

    /**
     * Get Email
     * @param array $order
     * @return string
     */
    private function getEmail(array $order)
    {
        $email = $order['nopedido'] . "@claroshop.com"; // nopedido:order id
        //comentarios : comments
        //usuario : username
        if (isset($order['comentarios'][0]['usuario']) && !empty($order['comentarios'][0]['usuario'])) {
            return $order['comentarios'][0]['usuario'];
        } else {
            return /*$this->config->getSellerEmail();*/ $email;
        }
    }

    /**
     * Get Customer
     * @param array $order
     * @param $websiteId
     * @return bool|\Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCustomer($order, $websiteId)
    {
        $customerId = $this->config->getDefaultCustomer();
        if ($customerId !== false) {
            /** case 1: Use default customer.*/
            $customer = $this->customerFactory->create()
                ->setWebsiteId($websiteId)
                ->load($customerId);
            if (!isset($customer) or empty($customer)) {
                $this->logger->log(
                    'ERROR',
                    "Default Customer does not exists. Customer Id: #{$customerId}."
                );
                return false;
            }
        } else {
            /** Case 2: Use Customer from Order.*/
            $email = $this->getEmail($order);
            /** Case 2.1 Get Customer if already exists. */
            $customer = $this->customerFactory->create()
                ->setWebsiteId($websiteId)
                ->loadByEmail($email);

            if (!isset($customer) || empty($customer) || empty($customer->getData())) {
                // Case 2.1 : Create customer if does not exists.
                try {
                    /** @var \Magento\Customer\Model\Customer $customer */
                    $customer = $this->customerFactory->create();
                    $customer->setWebsiteId($websiteId);
                    $customer->setEmail($email);
                    if (isset($order['datosenvio'])) { //datosenvio : shipping data
                        $this->getValue('entregara', $order['datosenvio']);
                        //entregara : customer name
                        $customer->setFirstname($this->getValue('entregara', $order['datosenvio'], '.'));
                        $customer->setLastname(/*$this->getValue('entregara', $order['datosenvio'], '.')*/'claro');
                    } else {
                        $customer->setFirstname($this->config->getSellerName());
                        $customer->setLastname('.');
                    }
                    $customer->setPassword(uniqid());
                    $customer->save();
                } catch (\Exception $e) {
                    $this->logger->log(
                        'ERROR',
                        'Customer create failed. Order Id: #' . $order->getClaroOrderId(),
                        [
                            'message' => $e->getMessage(),
                            'order_id' => $order->getClaroOrderId()
                        ]
                    );
                    return false;
                }
            }
        }

        return $customer;
    }

    /**
     * Get value from an array
     * @param string|int $index
     * @param array $haystack
     * @param string|null $default
     * @return null|string|array
     */
    public function getValue($index, $haystack = [], $default = null)
    {
        $value = $default;
        if (isset($index, $haystack[$index]) && !empty($haystack[$index])) {
            $value = $haystack[$index];
        }
        return $value;
    }
    /**
     * Process Region Id
     * @param string $name , Region name
     * @param string $city , City name
     * @param string $countryId , Country id example: US
     * @param string $pin , PostalCode
     * @return null|int
     */
    private function region($name, $city, $countryId, $pin = '')
    {
        $create = $this->config->createRegion();
        $geocode = $this->config->useGeocode();
        $default = $this->config->useDash();

        $regionId = null;

        try {
            /** @var \Magento\Directory\Model\Region $region */
            $region = $this->regionFactory->create();
            $region->loadByName($name, $countryId);
            $regionId = $region->getRegionId();

            if (empty($regionId)) {
                // Match by the short-code
                $regionId = $region->loadByCode($name, $countryId)->getRegionId();
            }

            /** @var \Magento\Directory\Helper\Data $regionHelper */
            $regionHelper = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magento\Directory\Helper\Data::class);
            if (empty($regionId) && $regionHelper->isRegionRequired($countryId)) {
                // 1. If region is required and not present in Magento directory and $create is allowed,
                // creating a new and, setting it on order address.
                if (!empty($countryId) && !empty($name) && $create) {
                    $code = $name;
                    if ($geocode) {
                        // Get the State Name
                        /** @var \Ced\Integrator\Api\Data\Geocode\StateInterface $state */
                        $state = $this->geocodeRepository->getStateByPincodeAndCity($pin, $city);
                        if (!empty($state->getShortName())) {
                            $name = $state->getLongName();
                            $code = $state->getShortName();
                            // Match by the short-code
                            $regionId = $region->loadByCode($code, $countryId)->getRegionId();
                        }
                    }

                    if (!empty($regionId)) {
                        $regionId = $region->setData('country_id', $countryId)
                            ->setData('code', $code)
                            ->setData('default_name', $name)
                            ->setData('name', $name)
                            ->save()
                            ->getRegionId();
                    }
                } else {
                    // 2. If region is not present use city
                    $region->loadByName($city, $countryId);
                    $regionId = $region->getRegionId();

                    if ($geocode) {
                        // 3. Get the State By City and Create, if Geocode is enabled
                        /** @var \Ced\Integrator\Api\Data\Geocode\StateInterface $state */
                        $state = $this->geocodeRepository->getStateByPincodeAndCity($pin, $city);

                        if (!empty($state->getShortName())) {
                            $name = $state->getLongName();
                            $code = $state->getShortName();
                            // Match by the short-code
                            $regionId = $region->loadByCode($code, $countryId)->getRegionId();
                            if (empty($regionId)) {
                                $regionId = $region->setData('country_id', $countryId)
                                    ->setData('code', $code)
                                    ->setData('default_name', $name)
                                    ->setData('name', $name)
                                    ->save()
                                    ->getRegionId();
                            }
                        }
                    }

                    // 4. If city as region is not available and $default is allowed, use default value '-'
                    if (empty($regionId) && $default) {
                        $regionId = $region->loadByName('-', $countryId)->getRegionId();

                        // 5. If default value not present create with $countryId as country
                        if (empty($regionId)) {
                            $regionId = $region->setData('country_id', $countryId)
                                ->setData('code', '-')
                                ->setData('default_name', '-')
                                ->setData('name', '-')
                                ->save()
                                ->getRegionId();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Silence
        }

        return $regionId;
    }

    public function getClaroProductQuantity($items)
    {
        $data = [];
        $qty = 1;
        foreach ($items as $key => $value) {
            if (!isset($data[$value['claroid']])) {
                $qty = 1;
                $data[$value['claroid']] =
                    ['qty' => $qty , 'price' => $value['importe'] , 'cpId' => $value['idpedidorelacion']];
            } else {
                $qty++;
                $data[$value['claroid']]['qty'] = $qty;
            }
        }
        return $data;
    }
}
