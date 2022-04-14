<?php

namespace app\admin\common;

class ReturnMsg
{
    /**
     * 针对数据json格式 后台通用版
     * @param array $data 数据数组
     * @param int $count 条数
     * @param string $msg 提示消息
     * @param int $code 状态码 0成功 -1失败
     * */
    public static function returnMsg($data = [], $count = 0, $msg = '成功返回数据', $code = 0)
    {
        echo json_encode([
            'code' => $code,
            'msg' => $msg,
            'count' => $count,
            'data' => $data
        ], 256);
        exit;
    }

    /**
     * 表单json返回
     * @param string $status 状态
     * @param string $msg 易读消息
     */
    public static function returnFormMsg($status = 'ok', $msg = '')
    {
        echo json_encode([
            'code' => 0,
            'status' => $status,
            'msg' => $msg
        ], 256);
    }
}
