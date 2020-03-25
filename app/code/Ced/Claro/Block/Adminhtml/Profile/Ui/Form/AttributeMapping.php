<?php

namespace Ced\Claro\Block\Adminhtml\Profile\Ui\Form;

class AttributeMapping extends \Magento\Backend\Block\Template
{
    /**
     * @var string
     */
    public $_template = 'Ced_Claro::profile/mappings/attributes.phtml';

    /** @var \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory */
    public $attributeFactory;

    /** @var \Magento\Framework\Registry */
    public $registry;

    /** @var \Ced\Claro\Model\Profile */
    public $profile;

    /** @var \Ced\Claro\Helper\Category */
    public $category;

    /** @var array */
    public $claroAttribute;

    /** @var \Magento\Framework\App\Request\Http */
    public $request;

    /** @var \Ced\Claro\Helper\Config */
    public $config;

    /** @var \Ced\Claro\Helper\Logger  */
    public $logger;
    /**
     * @var \Ced\Claro\Helper\Sdk
     */
    public $sdk;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $attributeFactory,
        \Magento\Framework\Registry $registry,
        \Ced\Claro\Helper\Logger $logger,
        \Ced\Claro\Helper\Config $config,
        \Ced\Claro\Helper\Category $category,
        \Ced\Claro\Helper\Sdk $sdk,
        array $data = []
    ) {
        $this->request = $context->getRequest();
        $this->attributeFactory = $attributeFactory;
        $this->registry = $registry;
        $this->logger = $logger;
        $this->config = $config;
        $this->category = $category;
        $this->sdk = $sdk;
        parent::__construct($context, $data);
    }

    public function getShippingMethods()
    {
        $methods = $this->getProfile()->getShippingMethods();
        return $methods;
    }
    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAddButtonHtml()
    {
        $button = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Button::class
        )->setData(
            [
                'label' => __('Add Attribute'),
                'onclick' => 'return claroAttributeControl.addItem()',
                'class' => 'add'
            ]
        );

        $button->setName('claro_add_attribute_mapping_button');
        return $button->toHtml();
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAddShippingButtonHtml()
    {
        $button = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Button::class
        )->setData(
            [
                'label' => __('Add Method'),
                'onclick' => 'return shippingMethodControl.addItem()',
                'class' => 'add'
            ]
        );

        $button->setName('claro_add_shipping_button');
        return $button->toHtml();
    }

    public function getClaroAttributes()
    {
        $this->claroAttribute = [
            [
                "label" => [
                    "text:Magento\Framework\Phrase:private" => "Required Attributes",
                    "arguments:Magento\Framework\Phrase:private " => []
                ],
                "value" => [
                    "nombre" => [
                        "id" => "nombre",
                        "name" => "nombre",
                        "value_type" => "String",
                        "length" => "120",
                        "magento_attribute_code" => "name",
                        "required" => 1
                    ],
                    "descripcion" => [
                        "id" => "descripcion",
                        "name" => "descripcion",
                        "value_type" => "String",
                        "length" => "250",
                        "magento_attribute_code" => "description",
                        "required" => 1
                    ],
                    "especificacionestecnicas" => [
                        "id" => "especificacionestecnicas",
                        "name" => "especificacionestecnicas",
                        "value_type" => "String",
                        "length" => "4000",
                        "magento_attribute_code" => "short_description",
                        "required" => 1
                    ],
                    "alto" => [
                        "id" => "alto",
                        "name" => "alto",
                        "value_type" => "Integer",
                        "length" => "10",
                        "magento_attribute_code" => "ts_dimensions_length",
                        "required" => 1
                    ],
                    "ancho" => [
                        "id" => "ancho",
                        "name" => "ancho",
                        "value_type" => "Integer",
                        "length" => "10",
                        "magento_attribute_code" => "ts_dimensions_width",
                        "required" => 1
                    ],
                    "profundidad" => [
                        "id" => "profundidad",
                        "name" => "profundidad",
                        "value_type" => "Integer",
                        "length" => "10",
                        "magento_attribute_code" => "ts_dimensions_height",
                        "required" => 1
                    ],
                    "peso" => [
                        "id" => "peso",
                        "name" => "peso",
                        "value_type" => "Decimal",
                        "length" => "10:2",
                        "magento_attribute_code" => "weight",
                        "required" => 1
                    ],
                    "preciopublicobase" => [
                        "id" => "preciopublicobase",
                        "name" => "preciopublicobase",
                        "value_type" => "Decimal",
                        "length" => "10:2",
                        "magento_attribute_code" => "price",
                        "required" => 1
                    ],
                    "preciopublicooferta" => [
                        "id" => "preciopublicooferta",
                        "name" => "preciopublicooferta",
                        "value_type" => "Decimal",
                        "length" => "10:2",
                        "magento_attribute_code" => "special_price",
                        "required" => 1
                    ],
                    "cantidad" => [
                        "id" => "cantidad",
                        "name" => "cantidad",
                        "value_type" => "Integer",
                        "length" => "10",
                        "magento_attribute_code" => "quantity_and_stock_status",
                        "required" => 1
                    ],
                    "skupadre" => [
                        "id" => "skupadre",
                        "name" => "skupadre",
                        "value_type" => "String",
                        "length" => "18",
                        "magento_attribute_code" => "sku",
                        "required" => 1
                    ],
                    "ean" => [
                        "id" => "ean",
                        "name" => "ean",
                        "value_type" => "String",
                        "length" => "60",
                        "magento_attribute_code" => "sku",
                        "required" => 1
                    ],
                    "estatus" => [
                        "id" => "estatus",
                        "name" => "estatus",
                        "value_type" => "String",
                        "length" => "10",
                        "magento_attribute_code" => "default_value",
                        "default_value" => "activo",
                        "values" => [
                            "0" =>["id" => "activo", "name" => "Activo"],
                            "1" =>["id" => "inactivo", "name" => "Inactivo"]
                        ],
                        "required" => 1
                    ],
                    "embarque" => [
                        "id" => "embarque",
                        "name" => "embarque",
                        "value_type" => "Integer",
                        "length" => "100",
                        "magento_attribute_code" => "default_value",
                        "default_value" => "2",
                        "required" => 1
                    ],
                    "marca" => [
                        "id" => "marca",
                        "name" => "marca",
                        "value_type" => "String",
                        "length" => "60",
                        "magento_attribute_code" => "default_value",
                        "default_value" => "APPLE",
                        "values" => $this->getBrands(),
                        "required" => 1,
                    ]
                ]
            ],
            [
                "label" => [
                    "text:Magento\Framework\Phrase:private" => "Optional Attributes",
                    "arguments:Magento\Framework\Phrase:private " => []
                ],
                "value" => [
                    "tag" => [
                        "id" => "tag",
                        "name" => "tag",
                        "value_type" => "String",
                        "length" => "200",
                        "magento_attribute_code" => "default_value",
                        "default_value" => "tag",
                        "required" => 0
                    ],
                    "agregarmarca" => [
                        "id" => "agregarmarca",
                        "name" => "agregarmarca",
                        "value_type" => "String",
                        "length" => "45",
                        "magento_attribute_code" => "default_value",
                        "default_value" => "agregarmarca",
                        "required" => 0
                    ]/*,
                    "colores" => [
                        "id" => "colores",
                        "name" => "colores",
                        "value_type" => "String",
                        "length" => "200",
                        "magento_attribute_code" => "color",
                        "default_value" => "colores",
                        "required" => 0
                    ],
                    "talla" => [
                        "id" => "talla",
                        "name" => "talla",
                        "value_type" => "String",
                        "length" => "45",
                        "magento_attribute_code" => "size",
                        "default_value" => "talla",
                        "required" => 0
                    ]*/
                ]
            ]
        ];
        return $this->claroAttribute;
    }
    public function getBrandList()
    {
        /** @var \Ced\Claro\Sdk\Product $product */
        $product = $this->sdk->getProduct();
        $brands = $product->getSiteBrands();
        return $brands;
    }

    public function getBrands()
    {
        $preparedBrandList = [];
        $brands = $this->getBrandList();
        if (isset($brands['marcas'])) {
            foreach ($brands['marcas'] as $key => $values) {
                $preparedBrandList[$key-1] = ["id" => $values, "name" => $values];
            }
        }
        return $preparedBrandList;
    }

    /**
     * Get Profile
     * @return \Ced\Claro\Model\Profile|mixed
     */
    public function getProfile()
    {
        if (!isset($this->profile)) {
            /** @var \Ced\Claro\Model\Profile profile */
            $this->profile = $this->registry->registry('claro_profile');
        }

        return $this->profile;
    }

    /**
     * Retrieve magento attributes
     *
     * @param int|null $groupId return name by customer group id
     * @return array|string
     */
    public function getMagentoAttributes()
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection $attributes */
        $attributes = $this->attributeFactory->create();

        $preparedAttributes[''] = '--please select--';
        $preparedAttributes['default_value'] = 'Default Value';
        foreach ($attributes->getItems() as $attribute) {
            $preparedAttributes[$attribute->getData('attribute_code')] = $attribute->getData('frontend_label');
        }

        return $preparedAttributes;
    }

    public function getMappedAttribute()
    {
        $data = $this->claroAttribute[0]['value'];
        if ($this->request->isAjax() && !empty($this->getProfile()) &&
            ((string)$this->getProfile()->getCategoryNode() === (string)$this->request->getParam('category_id'))) {
            $data = $this->getProfile()->getData(\Ced\Claro\Model\Profile::COLUMN_ATTRIBUTES);
        } elseif (!$this->request->isAjax() &&
            $this->getProfile() && ($this->getProfile()->getId() > 0)) {
            $data = $this->getProfile()->getData(\Ced\Claro\Model\Profile::COLUMN_ATTRIBUTES);
        }
        return $data;
    }

    /**
     * Render form element as HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }

    /**
     * TODO: handle all types: int,text. check length.
     * Get attribute type text or select
     * @param array $attribute
     * @return string
     */
    public function getAttributeType($attribute = [])
    {
        $type = !empty($this->getAttributeOptions($attribute)) ? "select" : "text";
        return $type;
    }

    /**
     * Get options list of an claro attribute
     * @param array $attribute
     * @return array
     */
    public function getAttributeOptions($attribute = [])
    {
        $options = isset($attribute['values']) &&
        !empty($attribute['values']) ? $attribute['values'] : [];
        return $options;
    }

    /**
     * Get attribute name
     * @param array $attribute
     * @return mixed|string
     */
    public function getAttributeName($attribute = [])
    {
        $name = isset($attribute['name']) ? $attribute['name'] : "";
        return $name;
    }

    /**
     * Get attribute required
     * @param array $attribute
     * @return mixed|string
     */
    public function getAttributeRequired($attribute = [])
    {
        $required = isset($attribute['required']) && !empty($attribute['required']) ? $attribute['required'] : "";
        return $required;
    }
}
