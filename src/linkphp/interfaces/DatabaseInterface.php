<?php

namespace linkphp\interfaces;

interface DatabaseInterface
{

    public function select($data);

    public function find($data);

    public function insert(array $data);

    public function insertAll(array $data);

    public function delete($data);

    public function update($data);

    public function execute();

    public function table($table);

    public function field($field);

    public function value($value);

    public function where($where);

    public function join($join);

    public function limit($limit);

    public function order($order);

    public function group($group);

    public function lock($lock);

    public function having($having);

    public function union($union);

    public function count($filed);

    public function sum($filed);

    public function getLastSql();

    public function transaction();

    public function beginTransaction();

    public function commit();

    public function rollback();

    public function insertGetId(array $data);

    public function query($sql);

    public function exec($sql);

}
