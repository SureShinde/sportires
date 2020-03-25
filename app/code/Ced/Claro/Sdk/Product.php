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

class Product extends \Ced\Claro\Sdk\Api
{
    const PRODUCT_ACTION_TYPE_UPLOAD = 'upload';
    const PRODUCT_ACTION_TYPE_UPDATE = 'update';
    const GET_CATEGORIES_URL = '/categorias';
    const POST_PRODUCT_URL = '/producto';
    const GET_BRANDS_URL = '/marcas';
    const POST_PRODUCT_COLOR_URL = '/colores';
    const POST_PRODUCT_SIZE_URL = '/tallas';

    /**
     * Upload/Update Product on claro marketplace
     * @param array $product
     * @param string $type
     * @param null $itemId
     * @return array
     */
    public function upload($product = [], $type = self::PRODUCT_ACTION_TYPE_UPLOAD, $itemId = null)
    {
        $response = [
            'success' => 0,
            'message' => 'Failed to update the Product on claro marketplace.'
        ];
        if (!empty($product) && is_array($product)) {
            $url = self::POST_PRODUCT_URL;
            try {
                if ($type == self::PRODUCT_ACTION_TYPE_UPDATE && !empty($itemId)) {
                    $url .= '/' . trim((string)$itemId);
                    $result = $this->put($url, json_encode($product, JSON_UNESCAPED_SLASHES));
                } else {
                    $result = $this->post($url, json_encode($product, JSON_UNESCAPED_SLASHES));
                }
                $result = json_decode($result, true);
                if (isset($result) && isset($result['estatus']) && isset($result['mensaje'])) {
                    $response = $this->responseParse($result, 'Product Upload/Update');
                } else {
                    $response = [
                        'success' => 0,
                        'message' => isset($result['mensaje']) ? $result['mensaje'] : 'Product upload/update failed.'
                    ];
                }
            } catch (\Exception $e) {
                $response['message'] = $e->getMessage();
                if ($this->debugMode) {
                    $this->logger->addError(
                        $e->getMessage(),
                        ['path' => __METHOD__, 'message' => $e->getMessage()]
                    );
                }
            }
        }
        return $response;
    }
    public function uploadColor($product = [], $type = self::PRODUCT_ACTION_TYPE_UPLOAD, $itemId = null)
    {
        $response = [
            'success' => 0,
            'message' => 'Failed to update the Product on claro marketplace.'
        ];
        if (!empty($product) && is_array($product)) {
            $url = self::POST_PRODUCT_COLOR_URL;
            try {
                if ($type == self::PRODUCT_ACTION_TYPE_UPDATE && !empty($itemId)) {
                    $url .= '/' . trim((string)$itemId);
                    $result = $this->put($url, json_encode($product, JSON_UNESCAPED_SLASHES));
                } else {
                    $result = $this->post($url, json_encode($product, JSON_UNESCAPED_SLASHES));
                }
                $result = json_decode($result, true);
                if (isset($result['estatus'])) {
                    if ($result['estatus'] == 'success' || $result['estatus'] == 'Success') {
                        if (isset($result['datos']['transactionid'])) {
                            $response = [
                                'success' => 1,
                                'message' => $result['mensaje'],
                                'transaction_id' => $result['datos']['transactionid']
                            ];
                        }
                    } else {
                        $response = [
                            'success' => 0,
                            'message' => isset($result['mensaje']) ?
                                $result['mensaje'] : 'Child Attribute Variation Upload/update failed.'
                        ];
                    }
                }
            } catch (\Exception $e) {
                $response['message'] = $e->getMessage();
                if ($this->debugMode) {
                    $this->logger->addError(
                        $e->getMessage(),
                        ['path' => __METHOD__, 'message' => $e->getMessage()]
                    );
                }
            }
        }
        return $response;
    }
    public function uploadSize($product = [], $type = self::PRODUCT_ACTION_TYPE_UPLOAD, $itemId = null)
    {
        $response = [
            'success' => 0,
            'message' => 'Failed to update the Product on claro marketplace.'
        ];
        if (!empty($product) && is_array($product)) {
            $url = self::POST_PRODUCT_SIZE_URL;
            try {
                if ($type == self::PRODUCT_ACTION_TYPE_UPDATE && !empty($itemId)) {
                    $url .= '/' . trim((string)$itemId);
                    $result = $this->put($url, json_encode($product, JSON_UNESCAPED_SLASHES));
                } else {
                    $result = $this->post($url, json_encode($product, JSON_UNESCAPED_SLASHES));
                }
                $result = json_decode($result, true);
                if (isset($result['estatus'])) {
                    if ($result['estatus'] == 'success' || $result['estatus'] == 'Success') {
                        $response = [
                                'success' => 1,
                                'message' => $result['mensaje']
                            ];
                    } else {
                        $response = [
                            'success' => 0,
                            'message' => isset($result['mensaje']) ?
                                $result['mensaje'] : 'Child Attribute Variation Upload/update failed.'
                        ];
                    }
                }
            } catch (\Exception $e) {
                $response['message'] = $e->getMessage();
                if ($this->debugMode) {
                    $this->logger->addError(
                        $e->getMessage(),
                        ['path' => __METHOD__, 'message' => $e->getMessage()]
                    );
                }
            }
        }
        return $response;
    }

    /**
     * Get Product Data
     * @param string $itemId
     * @return array
     */
    public function getData($itemId = null)
    {
        $response = [
            'success' => false,
            'message' => []
        ];

        if (!empty($itemId)) {
            $url = \Ced\Claro\Sdk\Url::POST_PRODUCT_UPLOAD_URL . '/' . trim($itemId);
            $result = $this->get($url, [], true);
            if (isset($result) && !empty($result)) {
                $result = json_decode($result, true);
                if (isset($result['id'])) {
                    $response = [
                        'success' => true,
                        'message' => $result
                    ];
                } elseif (isset($result, $result['error'])) {
                    $response = $this->responseParse($result, 'Get Product By Item Id ' . $itemId);
                }
            }
        }

        return $response;
    }

    /**
     * Delete Product on claro, set as closed
     * @param null $itemId
     * @return array
     */
    public function delete($itemId = null)
    {
        $response = [
            'success' => false,
            'message' => ''
        ];
        try {
            if (!empty($itemId)) {
                $url = self::POST_PRODUCT_URL . '/' . trim($itemId);
                $result = $this->deleteRequest($url);
                if (isset($result) && !empty($result)) {
                    $result = json_decode($result, true);
                    if (isset($result['id']) && $result['status'] == 'closed') {
                        $response = [
                            'success' => true,
                            'message' => $result
                        ];
                    } elseif (isset($result) && isset($result['estatus']) && isset($result['mensaje'])) {
                        $response = $this->responseParse($result, 'Delete Product By Item Id');
                    } else {
                        if (isset($result, $result['error'])) {
                            $response = $this->responseParse($result, 'Delete Product By Item Id ' . $itemId);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $response['message'] = $e->getMessage();
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => $e->getMessage()]
                );
            }
        }
        return $response;
    }

    public function getAllClaroSites($forceFetch = false)
    {
        $claroSites = [];
        try {
            $sitesFile = $this->baseDirectory . DS . 'claro' . DS . 'claro_sites.json';
            if (file_exists($sitesFile) && !$forceFetch) {
                $sites = file_get_contents($sitesFile);
                $claroSites = json_decode($sites, true);
            } else {
                $sites = $this->get(self::GET_SITES_SUB_URL);
                if ($sites && json_decode($sites)) {
                    $claroSites = json_decode($sites, true);
                    if (isset($claroSites['error'])) {
                        $claroSites = [];
                    }
                }
                file_put_contents(
                    $this->getFile($this->baseDirectory . DS . 'claro', 'claro_sites.json'),
                    $sites
                );
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getAllClaroSites Error'
                    ]
                );
            }
        }
        return $claroSites;
    }

    public function getAllClaroCurrencies($forceFetch = false)
    {
        $claroSites = [];
        try {
            $sitesFile = $this->baseDirectory . DS . 'claro' . DS . 'claro_currencies.json';
            if (file_exists($sitesFile) && !$forceFetch) {
                $sites = file_get_contents($sitesFile);
                $claroSites = json_decode($sites, true);
            } else {
                $sites = $this->get(self::GET_CURRENCIES_SUB_URL);
                if ($sites && json_decode($sites)) {
                    $claroSites = json_decode($sites, true);
                    if (isset($claroSites['error'])) {
                        $claroSites = [];
                    }
                }
                file_put_contents(
                    $this->getFile($this->baseDirectory . DS . 'claro', 'claro_currencies.json'),
                    $sites
                );
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getAllClaroCurrencies Error'
                    ]
                );
            }
        }
        return $claroSites;
    }

    public function getClaroListingTypes($siteId = '')
    {
        $claroListingTypes = [];
        try {
            if (!empty($siteId)) {
                $listingTypesFile = $this->baseDirectory . DS . 'claro' . DS . 'claro_listing_types.json';
                if (file_exists($listingTypesFile)) {
                    $listingTypesJson = file_get_contents($listingTypesFile);
                    $claroListingTypes = json_decode($listingTypesJson, true);
                } else {
                    $listingTypesJson = $this->get(self::GET_SITES_SUB_URL . '/' . trim($siteId) . '/listing_types');
                    if ($listingTypesJson && json_decode($listingTypesJson)) {
                        $claroListingTypes = json_decode($listingTypesJson, true);
                        if (isset($claroSites['error'])) {
                            $claroListingTypes = [];
                        }
                    }
                    file_put_contents(
                        $this->getFile($this->baseDirectory . DS . 'claro', 'claro_listing_types.json'),
                        $listingTypesJson
                    );
                }
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getClaroListingTypes Error'
                    ]
                );
            }
        }
        return $claroListingTypes;
    }
    public function getSiteCategories($forceFetch = false)
    {
        $allCategories = [];
        try {
            if (empty($siteId)) {
                $allCategoriesFile = $this->baseDirectory . DS .
                    'claro' . DS . 'claro_site_' . '_categories.json';

                if (file_exists($allCategoriesFile) && !$forceFetch) {
                    $allCategoriesJson = file_get_contents($allCategoriesFile);
                    $allCategories = json_decode($allCategoriesJson, true);
                } else {
                    $allCategoriesJson = $this->get(self::GET_CATEGORIES_URL);
                    if ($allCategoriesJson && json_decode($allCategoriesJson)) {
                        $allCategories = json_decode($allCategoriesJson, true);
                        if (isset($allCategories['categorias'])) {
                            file_put_contents(
                                $this->getFile($this->baseDirectory . DS . 'claro', 'claro_site_' . '_categories.json'),
                                $allCategoriesJson
                            );
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getSiteCategories Error']
                );
            }
        }
        return $allCategories;
    }

    public function getSiteBrands($forceFetch = false)
    {
        $allBrands = [];
        try {
            if (empty($siteId)) {
                $allBrandsFile = $this->baseDirectory . DS .
                    'claro' . DS . 'claro_site_' . '_brand.json';

                if (file_exists($allBrandsFile) && !$forceFetch) {
                    $allBrandsJson = file_get_contents($allBrandsFile);
                    $allBrands = json_decode($allBrandsJson, true);
                } else {
                    $allBrandsJson = $this->get(self::GET_BRANDS_URL);
                    if ($allBrandsJson && json_decode($allBrandsJson)) {
                        $allBrands = json_decode($allBrandsJson, true);
                        if (isset($allBrands['marcas'])) {
                            file_put_contents(
                                $this->getFile($this->baseDirectory . DS . 'claro', 'claro_site_' . '_brand.json'),
                                $allBrandsJson
                            );
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getSiteBrands Error']
                );
            }
        }
        return $allBrands;
    }

    public function getChildCategories($cat_id = '')
    {
        $claroCategories = [];
        try {
            if (!empty($cat_id)) {
                $categoriesFile = $this->baseDirectory . DS . 'categories' . DS . 'claro_categories' . trim($cat_id) . '.json';
                if (file_exists($categoriesFile)) {
                    $categoriesJson = file_get_contents($categoriesFile);
                    $claroCategories = json_decode($categoriesJson, true);
                } else {
                    $categoriesJson = $this->get(self::GET_CATEGORIES_SUB_URL . '/' . trim($cat_id));
                    if ($categoriesJson && json_decode($categoriesJson)) {
                        $claroCategories = json_decode($categoriesJson, true);
                        if (isset($claroSites['error'])) {
                            $claroCategories = [];
                        }
                    }
                    file_put_contents(
                        $this->getFile($this->baseDirectory . DS . 'categories', 'claro_categories' . trim($cat_id) . '.json'),
                        $categoriesJson
                    );
                }
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getChildCategories Error'
                    ]
                );
            }
        }
        return $claroCategories;
    }

    public function getAttributes($categoryId = '')
    {
        $claroAttributes = [];
        try {
            if (!empty($categoryId)) {
                $attributesFile = $this->baseDirectory . DS . 'attributes' . DS . 'claro_attributes' . trim($categoryId) . '.json';
                if (file_exists($attributesFile)) {
                    $attributesJson = file_get_contents($attributesFile);
                    $claroAttributes = json_decode($attributesJson, true);
                } else {
                    $attributesJson = $this->get(self::GET_CATEGORIES_SUB_URL . '/' . trim($categoryId) . '/attributes');
                    if ($attributesJson && json_decode($attributesJson)) {
                        $claroAttributes = json_decode($attributesJson, true);
                        if (isset($claroSites['error'])) {
                            $claroAttributes = [];
                        }
                    }
                    file_put_contents(
                        $this->getFile($this->baseDirectory . DS . 'attributes', 'claro_attributes' . trim($categoryId) . '.json'),
                        $attributesJson
                    );
                }
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getAttributes Error'
                    ]
                );
            }
        }
        return $claroAttributes;
    }

    public function validateProductOnClaro($productArray = [], $requestFor = "")
    {
        $response = [];
        if (!empty($productArray)) {
            $url = self::POST_PRODUCT_VALIDATE_URL;
            try {
                $result = $this->post($url, json_encode($productArray));
                if (isset($result) && !empty($result)) {
                    $res = json_decode($result, true);
                    if (isset($res) && isset($res['error'])) {
                        $response = $this->responseParse($res, 'Product Validation');
                        return $response;
                    } else {
                        return [
                            'success' => true,
                            'message' => ''
                        ];
                    }
                } else {
                    return [
                        'success' => true,
                        'message' => ''
                    ];
                }
            } catch (\Exception $e) {
                if ($this->debugMode) {
                    $this->logger->addError(
                        $e->getMessage(),
                        ['path' => __METHOD__, 'message' => 'validateProductOnClaro Error'
                        ]
                    );
                }
            }
        }
        return $response;
    }

    /**
     * @param array $productArray
     * @param string $type
     * @param null $itemId
     * @return array
     * @deprecated Use upload() method instead
     */
    public function uploadProductOnClaro($productArray = [], $type = 'upload', $itemId = null)
    {
        return $this->upload($productArray, $type, $itemId);
    }

    public function uploadVariationOnClaro($productArray = [], $itemId = null)
    {
        if (!empty($productArray)) {
            $url = self::POST_PRODUCT_UPLOAD_URL;
            try {
                $url = self::POST_PRODUCT_UPLOAD_URL . '/' . trim($itemId) . '/variations';
                $result = $this->post($url, json_encode($productArray));
                $response = json_decode($result, true);
                if (isset($response[0]) && isset($response[0]['id'])) {
                    return [
                        'success' => true,
                        'message' => $response
                    ];
                } elseif (isset($response) && isset($response['error'])) {
                    $res = $this->responseParse($response, 'Variation Upload');
                    return $res;
                } else {
                    return [
                        'success' => false,
                        'message' => isset($response['message']) ? $response['message'] : 'Variation upload failed'
                    ];
                }
            } catch (\Exception $e) {
                if ($this->debugMode) {
                    $this->logger->addError(
                        $e->getMessage(),
                        ['path' => __METHOD__, 'message' => 'uploadVariationOnClaro Error'
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

    /**
     * Get Product
     * @param string $itemId
     * @return array
     * @deprecated: Use getData()
     */
    public function getProductData($itemId = '')
    {
        return $this->getData($itemId);
    }

    /**
     * Delete Product on claro, set as closed
     * @param string $itemId
     * @return array
     */
    public function deleteProduct($itemId = '')
    {
        return $this->delete($itemId);
    }

    public function changeProductStatus($itemId = '', $status = '')
    {
        try {
            if (!empty($itemId)) {
                $url = self::POST_PRODUCT_UPLOAD_URL . '/' . trim($itemId);
                $param = [
                    'status' => $status
                ];
                $result = $this->put($url, json_encode($param));
                if (isset($result) && !empty($result)) {
                    $res = json_decode($result, true);
                    if (isset($res['id']) && $res['status'] == $status) {
                        return [
                            'success' => true,
                            'message' => $res
                        ];
                    } else {
                        if (isset($res) && isset($res['error'])) {
                            $response = $this->responseParse($res, "$status Product By Item Id $itemId");
                            return $response;
                        }
                    }
                }
                return [
                    'success' => false,
                    'message' => ''
                ];
            } else {
                return [
                    'success' => false,
                    'message' => ''
                ];
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'changeProductStatus Error'
                    ]
                );
            }
        }
        return [
            'success' => false,
            'message' => ''
        ];
    }

    public function updateDescription($itemId = '', $data = [])
    {
        try {
            if (!empty($itemId)) {
                $url = self::POST_PRODUCT_UPLOAD_URL . '/' . trim($itemId) . '/description';
                $result = $this->put($url, json_encode($data));
                if (isset($result) && !empty($result)) {
                    $res = json_decode($result, true);
                    if (isset($res) && !empty($result)) {
                        return [
                            'success' => true,
                            'message' => $res
                        ];
                    } else {
                        if (isset($res) && isset($res['error'])) {
                            $response = $this->responseParse($res, "Update Product Description By Item Id $itemId");
                            return $response;
                        }
                    }
                }
                return [
                    'success' => false,
                    'message' => ''
                ];
            } else {
                return [
                    'success' => false,
                    'message' => ''
                ];
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'updateDescription Error'
                    ]
                );
            }
        }
        return [
            'success' => false,
            'message' => ''
        ];
    }
    public function getTotalActiveProducts($sellerId = '')
    {
        try {
            $params = [
                'status' => 'active'
            ];
            if (!empty($sellerId)) {
                $url = self::GET_USER_DETAILS . '/' . trim($sellerId) . '/items/search';
                $result = $this->get($url, $params, true);
                if (isset($result) && !empty($result)) {
                    $res = json_decode($result, true);
                    if (isset($res['paging']['total']) && !empty($res['paging']['total'])) {
                        return [
                            'success' => true,
                            'message' => (int)$res['paging']['total']
                        ];
                    } else {
                        if (isset($res) && isset($res['error'])) {
                            $response = $this->responseParse($res, "Get Total Active Products For Seller $sellerId");
                            return $response;
                        }
                    }
                }
                return [
                    'success' => false,
                    'message' => ''
                ];
            } else {
                return [
                    'success' => false,
                    'message' => ''
                ];
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getTotalActiveProducts Error'
                    ]
                );
            }
        }
        return [
            'success' => false,
            'message' => ''
        ];
    }
    public function getMLProductIds($sellerId, $offset, $limit)
    {
        try {
            $params = [
                'status' => 'active',
                'offset' => $offset,
                'limit' => $limit,
            ];
            if (!empty($sellerId)) {
                $url = self::GET_USER_DETAILS . '/' . trim($sellerId) . '/items/search';
                $result = $this->get($url, $params, true);
                if (isset($result) && !empty($result)) {
                    $res = json_decode($result, true);
                    if (isset($res['results']) && !empty($res['results'])) {
                        return [
                            'success' => true,
                            'message' => $res['results']
                        ];
                    } else {
                        if (isset($res) && isset($res['error'])) {
                            $response = $this->responseParse($res, "Get Active Product IDs For Seller $sellerId");
                            return $response;
                        }
                    }
                }
                return [
                    'success' => false,
                    'message' => ''
                ];
            } else {
                return [
                    'success' => false,
                    'message' => ''
                ];
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getMLProductIds Error'
                    ]
                );
            }
        }
        return [
            'success' => false,
            'message' => ''
        ];
    }
    public function getMLProductsByIds(array $ids = [])
    {
        try {
            $params =[
                'ids' => implode(',', $ids)
            ];
            if (!empty($ids)) {
                $url = 'items';
                $result = $this->get($url, $params, true);
                if (isset($result) && !empty($result)) {
                    $res = json_decode($result, true);
                    if (isset($res['0']) && !empty($res['0'])) {
                        return [
                            'success' => true,
                            'message' => $res
                        ];
                    } else {
                        if (isset($res) && isset($res['error'])) {
                            $response = $this->responseParse($res, "Get Active Product For IDs " . implode(',', $ids));
                            return $response;
                        }
                    }
                }
                return [
                    'success' => false,
                    'message' => ''
                ];
            } else {
                return [
                    'success' => false,
                    'message' => ''
                ];
            }
        } catch (\Exception $e) {
            if ($this->debugMode) {
                $this->logger->addError(
                    $e->getMessage(),
                    ['path' => __METHOD__, 'message' => 'getMLProductsByIds Error'
                    ]
                );
            }
        }
        return [
            'success' => false,
            'message' => ''
        ];
    }
}
