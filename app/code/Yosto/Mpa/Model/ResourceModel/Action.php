<?php
/**
 * Copyright © 2017 x-mage2(Yosto). All rights reserved.
 * See README.md for details.
 */

namespace Yosto\Mpa\Model\ResourceModel;

/**
 * Class Action
 * @package Yosto\Mpa\Model\ResourceModel
 */
class Action extends \Magento\Catalog\Model\ResourceModel\Product\Action
{

    /**
     * @param $entityIds
     * @param $attrCode
     * @param $storeId
     * @param $priceArray
     * @return $this|void
     * @throws \Exception
     */
    public function updateAttributesPrice($entityIds, $attrCode, $storeId, $priceArray)
    {
        $object = new \Magento\Framework\DataObject();
        $object->setStoreId($storeId);

        $this->getConnection()->beginTransaction();
        try {

                $attribute = $this->getAttribute($attrCode);
                if (!$attribute->getAttributeId()) {
                    return;
                }

                $i = 0;
                foreach ($entityIds as $entityId) {
                    $i++;
                    $object->setId($entityId);
                    $object->setEntityId($entityId);
                    // collect data for save
                    $this->_saveAttributeValue($object, $attribute, $priceArray[$entityId]);
                    // save collected data every 1000 rows
                    if ($i % 1000 == 0) {
                        $this->_processAttributeValues();
                    }
                }
                $this->_processAttributeValues();

            $this->getConnection()->commit();
        } catch (\Exception $e) {
            $this->getConnection()->rollBack();
            throw $e;
        }

        return $this;
    }

    /**
     * @param $entityIds
     * @param $attrCode
     * @param $storeId
     * @param $textArray
     * @return $this|void
     * @throws \Exception
     */
    public function updateAttributesText($entityIds, $attrCode, $storeId, $textArray)
    {
        $object = new \Magento\Framework\DataObject();
        $object->setStoreId($storeId);

        $this->getConnection()->beginTransaction();
        try {

            $attribute = $this->getAttribute($attrCode);
            if (!$attribute->getAttributeId()) {
                return;
            }

            $i = 0;
            foreach ($entityIds as $entityId) {
                $i++;
                $object->setId($entityId);
                $object->setEntityId($entityId);
                // collect data for save
                $this->_saveAttributeValue($object, $attribute, $textArray[$entityId]);
                // save collected data every 1000 rows
                if ($i % 1000 == 0) {
                    $this->_processAttributeValues();
                }
            }
            $this->_processAttributeValues();

            $this->getConnection()->commit();
        } catch (\Exception $e) {
            $this->getConnection()->rollBack();
            throw $e;
        }

        return $this;
    }
}