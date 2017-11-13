<?php
interface iDataBase
{
    public function execute($query,$bindings);
    public function connect($query);
    public function beginTransaction();
    public function endTransaction();
    
    
}