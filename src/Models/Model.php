<?php

    namespace App\Models;

    abstract class Model
    {
        abstract public function startTransaction();
        abstract public function commit();
        abstract public function rollback();
    }