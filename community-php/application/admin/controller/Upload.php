<?php

namespace app\admin\controller;

use app\admin\common\ReturnMsg;

class Upload extends Base
{
    public function upload($name)
    {
        $file = request()->file('file');
        $path = "/static/uploads/${name}/";
        $info = $file->move('.' . $path);
        if (!$info) {
            ReturnMsg::returnMsg([], 0, $file->getError(), -1);
        } else {
            $res = ["code" => 0, "msg" => '上传成功', "src" => $path . $info->getSaveName()];
            ReturnMsg::returnMsg($res, 0, $res['msg'], 0);
        }
    }
}