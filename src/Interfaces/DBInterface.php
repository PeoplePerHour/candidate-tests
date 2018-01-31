<?php

    namespace App\Interfaces;


    interface DBInterface
    {
		public function connect();
		public function select(bool $isList, array $columns, string $table, array $joins, array $conditions, string $orderBy, string $limitStart, string $limitEnd);
		public function insert(string $table, array $columns);
        public function update(string $table, array $values, array $conditions);
        public function delete(string $table, array $conditions);
    }