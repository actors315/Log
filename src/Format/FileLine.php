<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2019/1/12
 * Time: 16:41
 */

namespace Twinkle\Log\Format;


class FileLine extends Base
{

    /**
     * 格式化日志
     * @return string
     */
    public function format()
    {
        return vsprintf("[%s] [%s] %s [%s] %s %s" . PHP_EOL,
            [
                $this->requestId,
                $this->createTime,
                empty($this->location) ? '' : "file[{$this->location['file']}]  line[{$this->location['line']}]",
                $this->level,
                $this->message,
                json_encode($this->content),
            ]
        );
    }

    public function __toString()
    {
        return $this->format();
    }

}