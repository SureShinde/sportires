<?php
namespace ITM\MagB1\Api\Entity;

interface EntityInterface
{

    /**
     *
     * @api
     *
     * @param ITM\MagB1\Api\Data\EntityDataInterface $entity.
     * @return int[]
     */
    public function saveEntity($entity);

    /**
     *
     * @api
     *
     * @param ITM\MagB1\Api\Data\EntityDataInterface $entity.
     * @return int[]
     */
    public function deleteEntityByKey($entity);


    /**
     *
     * @api
     *
     * @param int $cur_page.
     * @param int $page_size.
     * @param string $model_name.
     * @return ITM\MagB1\Api\Data\EntityLineDataInterface[]
     */
    public function getList($cur_page, $page_size, $model_name);

    /**
     *
     * @api
     *
     * @param string $model_name.
     * @return int
     */
    public function getCollectionCount($model_name);

    /**
     *
     * @api
     *
     * @param string $model_name.
     * @param int[] $ids.
     * @return null
     */
    public function deleteEntity($model_name, $ids);
}
