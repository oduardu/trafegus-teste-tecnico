<?php

namespace Application\Model;

interface ModelInterface
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
     * @param $entity
     * @return array
     */
    public function save($entity);

    /**
     * Remove a record
     * @param $entity
     * @return array
     */
    public function remove($entity);

    /**
     * Convert entity to array
     * @param $entity
     * @return array
     */
    public function toArray($entity);
}