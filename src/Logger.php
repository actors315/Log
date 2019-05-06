<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2019/1/12
 * Time: 16:09
 */

namespace Twinkle\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Logger implements LoggerInterface
{
    protected $logger;

    use LoggerTrait;

    public function __construct(StorageInterface $storage)
    {
        $this->logger = $storage;
    }

    public function log($level, $message, array $context = array())
    {
        if (isset($context['trace'])) {
            $trace = $context['trace'];
            unset($context['trace']);
        } else {
            $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        }
        $trace = !empty($trace) ? $trace[1] : [];
        $this->logger->process($level, $trace, $message, $context);
    }

    public function __destruct()
    {
        $this->logger->flushLogs();
    }
}