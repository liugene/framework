<?php

namespace framework;
use Db;
class Model
{

    protected $table;

    /**
     * @param array $data 插入数据
     * @return int 返回数据语句执行结果影响的表ID
     */
    //save 数据库添加操作方法 返回保存记录的ID
    public function insert(array $data)
    {
        return Db::table($this->table)->insert($data);
    }

    public function table($table)
    {
        Db::table($table);
        return $this;
    }

    public function where(){}

    //delete
    public function delete()
    {
        Db::table($this->table)->delete();
    }

    public function select(){}

    public function insertAll(){}

    public function field(){}

    public function query(){}

    public function getLastSql(){}

    public function find(){}

    //将查询的所有结二维数组结果转换为一维数组，键名为字段ID 键值为字段值
    public function getNewArr($array)
    {
        foreach($array as $value){
            $key = array_keys($value);
            foreach($key as $kv){
                $arr[$kv][] = $value[$kv];
            }
        }
        return $arr;
    }



}
