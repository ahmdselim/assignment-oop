<?php

namespace App;

interface DB_RUlES
{
    public function table($table);
    public function select($rows);
    public function insert($rows = [], $values = []);
    public function update(array $data = []);
    public function delete();
    public function where($rows = [], $condition, $val);
    public function like($like);
    public function limit($limit);
    public function execute();
}
