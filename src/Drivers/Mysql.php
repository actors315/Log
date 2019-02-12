<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2019/1/12
 * Time: 19:39
 */

namespace Twinkle\Log\Drivers;


use Twinkle\Library\Model\Model;
use Twinkle\Log\Format\MysqlLine;

class Mysql extends Log
{

    protected $model = null;

    public function __construct(Model $model, array $config = [])
    {
        $this->model = $model;
        parent::__construct($config);
    }

    public function process($level, $trace, $message, $context)
    {
        $log = new MysqlLine($message, $trace, $level, $context);
        $this->write($log->format());
    }

    public function write($log)
    {
        $this->model->insertData($log);
    }
}