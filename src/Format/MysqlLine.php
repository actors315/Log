<?php
/**
 * Created by PhpStorm.
 * User: xiehuanjin
 * Date: 2019/1/12
 * Time: 16:41
 */

namespace Twinkle\Log\Format;


class MysqlLine extends Base
{

    /**
     * 格式化日志
     * @return array
     */
    public function format()
    {
        return [
            'request_id' => $this->requestId,
            'create_time' => strtotime($this->createTime),
            'location' => empty($this->location) ? '' : "file[{$this->location['file']}]  line[{$this->location['line']}]",
            'level' => $this->level,
            'message' => $this->message,
            'content' => json_encode($this->content),
        ];
    }
}