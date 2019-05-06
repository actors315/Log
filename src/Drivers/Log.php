<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2019/1/12
 * Time: 16:19
 */

namespace Twinkle\Log\Drivers;


use Twinkle\Log\StorageInterface;

abstract class Log implements StorageInterface
{

    //是否批量写入
    public $useBuffer = false;

    //缓冲数组
    public $logQueue = [];

    //缓冲日志记录条数大小
    public $bufferSize = 100;

    public function __construct($config = [])
    {
        $this->init($config);
    }

    public function init($config)
    {
        $r = new \ReflectionClass($this);
        $ex = $this->getExcludeInitProperty();
        foreach ($config as $p => $v) {
            if (in_array($p, $ex)) continue;

            if ($r->getProperty($p)->isPublic()) {
                $this->{$p} = $v;
                continue;
            }

            if (($method = $this->hasSet($p)) !== false) {
                $this->$method($p, $v);
                continue;
            }

            throw new \Exception('Property `' . $p . '` not exists');
        }
    }

    protected function hasSet($key)
    {
        $key = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $key);

        $method = "set{$key}";

        if (method_exists($this, $method)) {
            return $method;
        }

        return false;
    }

    /**
     * 非构函数传入的参数
     * @return array
     */
    protected function getExcludeInitProperty()
    {
        return [];
    }

    abstract public function flushLogs();
}