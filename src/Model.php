<?php

namespace framework;

use linkphp\db\Connect;
use linkphp\db\Query;
use Config;
use Db;

abstract class Model
{

    // 数据库查询对象池
    protected static $links = [];
    // 数据库配置
    protected $connection = [];
    // 数据表字段信息 留空则自动获取
    protected $field = [];
    // 数据库查询对象
    protected $query;
    // 当前模型名称
    protected $name;
    // 数据表名称
    protected $table;
    // 当前类名称
    protected $class;
    // 回调事件
    private static $event = [];
    // 错误信息
    protected $error;
    // 创建时间字段
    protected $createTime = 'create_time';
    // 更新时间字段
    protected $updateTime = 'update_time';

    /**
     * 构造方法
     * @access public
     * @param array|object $data 数据
     */
    public function __construct($data = [])
    {

        if($data){
            $this->connection = $data;
        }
        // 当前类名
        $this->class = get_called_class();

        if (empty($this->name)) {
            // 当前模型名
            $name       = str_replace('\\', '/', $this->class);
            $this->name = basename($name);
        }
    }

    /**
     * 创建模型的查询对象
     * @access protected
     * @return Query
     */
    protected function buildQuery()
    {
        // 合并数据库配置
        if (!empty($this->connection)) {
            if (is_array($this->connection)) {
                $connection = array_merge(Config::get('database'), $this->connection);
            } else {
                $connection = $this->connection;
            }

        } else {
            $connection = Config::get('database');
        }

        Db::import($connection)->connect();

        /**
         * @var Connect $con
         */
        $con = Db::getQueryObject();

        $queryClass = $con->getConfig('query');

        /**
         * @var Query $query
         */
        $query = Application::get($queryClass);

        // 设置当前数据表和模型名
        if (!empty($this->table)) {
            $query->table($this->table);
        } else {
            $query->table($this->name);
        }

        return $query;
    }

    /**
     * 获取当前模型的查询对象
     * @access public
     * @param bool      $buildNewQuery  创建新的查询对象
     * @return Query
     */
    public function getQuery($buildNewQuery = false)
    {
        if ($buildNewQuery) {
            return $this->buildQuery();
        } elseif (!isset(self::$links[$this->class])) {
            // 创建模型查询对象
            self::$links[$this->class] = $this->buildQuery();
        }

        return self::$links[$this->class];
    }

    /**
     * @param array $data 插入数据
     * @return int 返回数据语句执行结果影响的表ID
     */
    //save 数据库添加操作方法 返回保存记录的ID
    public function insert(array $data)
    {
        if (false === $this->trigger('before_insert', $this)) {
            return false;
        }

        $response = $this->getQuery()->insert($data);

        if (false === $this->trigger('after_insert', $this)) {
            return false;
        }
        return $response;
    }

    public function table($table)
    {
        $this->getQuery()->table($table);
        return $this;
    }

    public function where($condition)
    {
        return $this->getQuery()->where($condition);
    }

    //delete
    public function delete($data=null)
    {
        if (false === $this->trigger('before_delete', $this)) {
            return false;
        }

        $response = $this->getQuery()->delete($data);

        if (false === $this->trigger('after_insert', $this)) {
            return false;
        }

        return $response;
    }

    public function update($data)
    {
        if (false === $this->trigger('before_update', $this)) {
            return false;
        }

        $response = $this->getQuery()->update($data);

        if (false === $this->trigger('after_update', $this)) {
            return false;
        }

        return $response;
    }

    public function select($data=null)
    {
        return $this->getQuery()->select($data);
    }

    public function count($filed='*')
    {
        return $this->getQuery()->count($filed);
    }

    public function insertAll(array $data)
    {
        if (false === $this->trigger('before_insert', $this)) {
            return false;
        }

        $response = $this->getQuery()->insertAll($data);

        if (false === $this->trigger('after_insert', $this)) {
            return false;
        }
        return $response;
    }

    public function field($field)
    {
        return $this->getQuery()->field($field);
    }

    public function query($sql)
    {
        return $this->getQuery()->query($sql);
    }

    public function getLastSql()
    {
        return $this->getQuery()->getLastSql();
    }

    public function find($data=null)
    {
        return $this->getQuery()->find($data);
    }

    /**
     * 返回模型的错误信息
     * @access public
     * @return string|array
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 注册回调方法
     * @access public
     * @param string   $event    事件名
     * @param callable $callback 回调方法
     * @param bool     $override 是否覆盖
     * @return void
     */
    public static function event($event, $callback, $override = false)
    {
        $class = get_called_class();
        if ($override) {
            self::$event[$class][$event] = [];
        }
        self::$event[$class][$event][] = $callback;
    }

    /**
     * 触发事件
     * @access protected
     * @param string $event  事件名
     * @param mixed  $params 传入参数（引用）
     * @return bool
     */
    protected function trigger($event, &$params)
    {
        if (isset(self::$event[$this->class][$event])) {
            foreach (self::$event[$this->class][$event] as $callback) {
                if (is_callable($callback)) {
                    $result = call_user_func_array($callback, [ & $params]);
                    if (false === $result) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * 模型事件快捷方法
     * @param      $callback
     * @param bool $override
     */
    protected static function beforeInsert($callback, $override = false)
    {
        self::event('before_insert', $callback, $override);
    }

    protected static function afterInsert($callback, $override = false)
    {
        self::event('after_insert', $callback, $override);
    }

    protected static function beforeUpdate($callback, $override = false)
    {
        self::event('before_update', $callback, $override);
    }

    protected static function afterUpdate($callback, $override = false)
    {
        self::event('after_update', $callback, $override);
    }

    protected static function beforeDelete($callback, $override = false)
    {
        self::event('before_delete', $callback, $override);
    }

    protected static function afterDelete($callback, $override = false)
    {
        self::event('after_delete', $callback, $override);
    }

}
