<?php

namespace Core\Interfaces\Service;

interface CrudServiceInterface
{
    /**
     * Find a record by id
     *
     * @param $id
     * @return array
     */
    public function find($id);

    /**
     * Find all records
     * @return array
     */
    public function findAll();

    /**
     * Save a record
     * @param $data
     * @return array
     */
    public function save($data);

    /**
     * Remove a record
     * @param $entity
     * @return array
     */
    public function remove($entity);
}