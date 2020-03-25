<?php
    
namespace ITM\MagB1\Model\Api\Data;
    
use ITM\MagB1\Api\Data\ProductfilesDataInterface;
    
class ProductfilesData implements ProductfilesDataInterface
{

    private $sku;
    private $description;
    private $path;
    private $store_id;
    private $position;
    private $entity_id;
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }
    
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function setEntityId($value)
    {
        $this->entity_id = $value;
    }
                
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function getSku()
    {
        return $this->sku;
    }
            
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function setSku($value)
    {
        $this->sku = $value;
    }
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function getDescription()
    {
        return $this->description;
    }
            
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function setDescription($value)
    {
        $this->description = $value;
    }
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function getPath()
    {
        return $this->path;
    }
            
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function setPath($value)
    {
        $this->path = $value;
    }
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function getStoreId()
    {
        return $this->store_id;
    }
            
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function setStoreId($value)
    {
        $this->store_id = $value;
    }
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function getPosition()
    {
        return $this->position;
    }
            
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function setPosition($value)
    {
        $this->position = $value;
    }
    
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
