<?php

namespace Core\Interface\Controller;

interface CrudControllerInterface
{
    /**
     * Index action
     * @return mixed
     */
    public function indexAction();

    /**
     * Action responsible for adding a new record
     * @return mixed
     */
    public function addAction();

    /**
     * Action responsible for editing a record
     * @return mixed
     */
    public function editAction();

    /**
     * Action responsible for deleting a record
     * @return mixed
     */
    public function deleteAction();
}