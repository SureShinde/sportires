<?php
    
namespace ITM\MagB1\Model\Api\Data;
    
use ITM\MagB1\Api\Data\InvoicefilesDataInterface;
    
class InvoicefilesData implements InvoicefilesDataInterface
{

    private $id;
    private $increment_id;
    private $path;
    private $description;
    private $store_id;
    private $position;
    private $status;
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function setId($value)
    {
        $this->id = $value;
    }
                
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function getIncrementId()
    {
        return $this->increment_id;
    }
            
    /**
     *
     *
     * {@inheritdoc}
     *
     */
    public function setIncrementId($value)
    {
        $this->increment_id = $value;
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
