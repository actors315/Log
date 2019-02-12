<?php
/**
 * Created by PhpStorm.
 * User: huanjin
 * Date: 2019/2/12
 * Time: 21:43
 */

namespace Twinkle\Log;

use Psr\Log\Test\LoggerInterfaceTest;
use Psr\Log\Test\TestLogger;

class LoggerTest extends LoggerInterfaceTest
{

    public function getLogger()
    {
        return new TestLogger();
    }

    public function getLogs()
    {
        // TODO: Implement getLogs() method.
    }
}