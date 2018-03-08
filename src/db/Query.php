<?php

namespace link\db;

use PDO;
use PDOException;
use PDOStatement;

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

    /**
     * @var PDOResult
     */
    private $pdo_result;

    public function __construct(Connect $connect,PDOResult $PDOResult)
    {
        $this->_pdo = $connect
            ->setConfig($this->database)
            ->connect();
        $this->pdo_result = $PDOResult;
    }

    /**
     * @return PDO;
     */
    public function connect()
    {
        return $this->_pdo;
    }

    public function import($file)
    {
        if(is_array($file)) $this->database = $file;
        return;
    }

    public function table($name)
    {
        return $this;
    }

    public function select($sql='',$data=[])
    {
        $this->pdo_result->result = $this->_pdo->prepare($sql,$data);
    }

    public function insert($sql='',$data=[])
    {
        $this->pdo_result->result = $this->_pdo->prepare($sql,$data);
    }

    public function delete($sql='',$data=[])
    {
        $this->pdo_result->result = $this->_pdo->prepare($sql,$data);
    }

    public function update($sql='',$data=[])
    {
        $this->pdo_result->result = $this->_pdo->prepare($sql,$data);
    }

}
