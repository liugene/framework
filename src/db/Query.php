<?php

namespace link\db;

use PDO;
use PDOException;
use PDOStatement;
use Closure;

class Query
{

    /**
     * 数据库配置文件
     * @array $database
     */
    private $database = [];

    /**
     * @var PDO
     */
    private $_pdo;

    private $build;

    private $table;

    private $field;

    private $where;

    /**
     * @var PDOResult
     */
    private $pdo_result;

    public function __construct(Connect $connect,PDOResult $PDOResult)
    {
        $this->_pdo = $connect;
        $this->pdo_result = $PDOResult;
    }

    /**
     * @return PDO;
     */
    public function connect()
    {
        return $this->_pdo
            ->setConfig($this->database)
            ->connect();
    }

    public function import($file)
    {
        if(is_array($file)) $this->database = $file;
        return;
    }

    public function select($sql='')
    {
        $this->pdo_result->exec = $this->connect()->prepare($sql[0]);
        return $this->pdoResult();
    }

    public function insert($sql='')
    {
        $this->pdo_result->exec = $this->connect()->prepare($sql);
    }

    public function delete($sql='')
    {
        $this->pdo_result->exec = $this->connect()->prepare($sql);
    }

    public function update($sql='')
    {
        $this->pdo_result->exec = $this->connect()->prepare($sql);
    }

    public function execute()
    {
        return $this->pdo_result->exec->execute();
    }

    public function pdoResult()
    {
        $this->execute();
        $this->pdo_result->result = $this->pdo_result->exec->fetchAll();
        return $this->pdo_result;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function field($field)
    {
        $this->field = $field;
        return $this;
    }

    public function where($condition)
    {
        $this->where = $condition;
        return $this;
    }

    public function join(){}

    public function limit(){}

    public function order(){}

    public function group(){}

    public function lock(){}

    public function having(){}

    public function count(){}

    public function sum(){}

    public function getLastSql(){}

    public function transaction(){}

    public function beginTransaction()
    {
        $this->connect()->beginTransaction();
    }

    public function commit()
    {
        $this->connect()->commit();
    }

    public function rollback()
    {
        $this->connect()->rollBack();
    }

    public function insertGetId(){}

    public function query($sql)
    {
        $this->pdo_result->result = $this->connect()->query($sql);
        return $this->pdo_result;
    }

    public function exec($sql)
    {
        return $this->connect()->exec($sql);
    }

    public function build(){}

    /**
     * 数据库查询语句解析方法
     * 返回对应一条相关数组
     */
    public function find()
    {
        $sql = 'SELECT ' . $this->field . ' FROM ' . $this->table . ' ' . $this->where;
        $result = static::$_dao->find($sql);
        $this->freeFunc();
        return $result;
    }


    /**
     * 数据库查询语句解析方法
     * 返回对应所有相关数组
     */
    public function selectbak()
    {
        $sql = 'select ' . static::$_function['field'] . ' from ' . static::$_function['table'] . ' ' . static::$_function['where'];
        $result = static::$_dao->select($sql);
        $this->freeFunc();
        return $result;
    }


    public function insertbak($data)
    {
        if(is_array($data)){
            //是数组将键名以及值用','拼接成字符串形式
            $value = implode('\',\'', array_values($data));
            $fileds = implode(',', array_keys($data));
            //拼接数据库插入语句
            $sql = "INSERT INTO " . static::$_function['table'] . " ( $fileds ) VALUES ( '$value' )";
        } else {
            //字段为字符串是直接拼接数据库插入语句
            $sql = "INSERT INTO " . static::$_function['table'] . " ( array_keys($data) ) VALUES ( '".array_values($data)."')";
        }
        $result = static::$_dao->insert($sql);
        return $result;
    }

    public function add($value)
    {
        $sql = 'INSERT INTO ' . static::$_function['table'] . '(' . static::$_function['field']  . ') ' . 'VALUES(' . $value . ') ' . static::$_function['where'];
        $result = static::$_dao->query($sql);
        $this->freeFunc();
        return $result;
    }

}
