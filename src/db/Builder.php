<?php

// +----------------------------------------------------------------------
// | LinkPHP [ Link All Thing ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 http://linkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liugene <liujun2199@vip.qq.com>
// +----------------------------------------------------------------------
// |               配置类
// +----------------------------------------------------------------------
namespace link\db;

class Builder
{

    // SQL表达式
    protected $select_sql    = 'SELECT %DISTINCT% %FIELD% FROM %TABLE%%FORCE%%JOIN%%WHERE%%GROUP%%HAVING%%ORDER%%LIMIT%%UNION%%LOCK%%COMMENT%';
    protected $insert_sql    = 'INSERT INTO %TABLE% (%FIELD%) VALUES (%DATA%) %COMMENT%';
    protected $insert_all_sql = 'INSERT INTO %TABLE% (%FIELD%) %DATA% %COMMENT%';
    protected $update_sql    = 'UPDATE %TABLE% SET %SET% %JOIN% %WHERE% %ORDER%%LIMIT% %LOCK%%COMMENT%';
    protected $delete_sql    = 'DELETE FROM %TABLE% %USING% %JOIN% %WHERE% %ORDER%%LIMIT% %LOCK%%COMMENT%';

    public function select(Query $query)
    {
        $sql = str_replace(
            ['%TABLE%', '%DISTINCT%', '%FIELD%', '%JOIN%', '%WHERE%', '%GROUP%', '%HAVING%', '%ORDER%', '%LIMIT%', '%UNION%', '%LOCK%', '%COMMENT%', '%FORCE%'],
            [
                $query->getTable(),
                $query->getField(),
                $query->getJoin(),
                $query->getWhere(),
                $query->getGroup(),
                $query->getHaving(),
                $query->getOrder(),
                $query->getLimit(),
                $query->getUnion(),
                $query->getLocks()
            ], $this->select_sql);
        return $sql;
    }

    public function insert(Query $query)
    {
        $sql = str_replace(
            ['%TABLE%','%FIELD%','%DATA%','%COMMENT%'],
            [
                $query->getTable(),
                $query->getField(),
                $query->getValue(),
            ],$this->insert_sql);
        return $sql;
    }

    public function insertAll(Query $query)
    {
        $sql = str_replace(
            ['%TABLE%','%FIELD%','%DATA%','%COMMENT%'],
            [
                $query->getTable(),
                $query->getField(),
                $query->getValue(),
            ],$this->insert_all_sql);
        return $sql;
    }

    public function delete(Query $query)
    {
        $sql = str_replace(
            ['%TABLE%','%USING%','%JOIN%','%WHERE%','%ORDER%','%LIMIT%','%LOCK%','%COMMENT%'],
            [
                $query->getTable(),
                $query->getField(),
                $query->getJoin(),
                $query->getWhere(),
                $query->getOrder(),
                $query->getLimit(),
                $query->getLocks(),
            ],$this->delete_sql);
        dump($sql);die;
        return $sql;
    }

    public function update(Query $query)
    {
        $sql = str_replace(
            ['%TABLE%','%USING%','%JOIN%','%WHERE%','%ORDER%','%LIMIT%','%LOCK%','%COMMENT%'],
            [
                $query->getTable(),
                $query->getField(),
                $query->getJoin(),
                $query->getWhere(),
                $query->getOrder(),
                $query->getLimit(),
                $query->getLocks(),
            ],$this->update_sql);
        dump($sql);die;
        return $sql;
    }

}