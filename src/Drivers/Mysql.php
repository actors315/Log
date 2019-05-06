<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2019/1/12
 * Time: 19:39
 */

namespace Twinkle\Log\Drivers;

use Twinkle\Log\Format\MysqlLine;

class Mysql extends Log
{

    protected $model = null;

    public function __construct($model, array $config = [])
    {
        $this->model = $model;
        parent::__construct($config);
    }

    public function process($level, $trace, $message, $context)
    {
        $log = new MysqlLine($message, $trace, $level, $context);
        if ($this->useBuffer) {
            $this->logQueue[] = $log->format();
            if (count($this->logQueue) >= $this->bufferSize) {
                $this->flushLogs();
            }
        } else {
            $this->write([$log->format()]);
        }
    }

    public function write($logList)
    {
        $this->model->batchInsert($logList);
    }


    public function flushLogs()
    {
        if (count($this->logQueue)) {
            $tempList = $this->logQueue;
            $this->logQueue = [];
            $this->write($tempList);
        }
    }
}