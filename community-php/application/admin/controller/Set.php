<?php

namespace app\admin\controller;

use app\admin\common\ReturnMsg;
use app\common\model\QuickModel;

header("Content-Type: text/html;charset=utf-8");


class Set extends Base
{
    /**
     * 返回渲染
     * @return \think\response\View
     */
    public function setPassword()
    {
        return view('password');
    }

    /**
     * 处理修改密码
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function doSetPassword()
    {
        $admin_user = session('adminUser');
        if (
            isset($_REQUEST['oldPassword']) && !empty($_REQUEST['oldPassword']) &&
            isset($_REQUEST['password']) && !empty($_REQUEST['password']) &&
            isset($admin_user['user_id']) && !empty($admin_user['user_id']) &&
            trim($_REQUEST['password'] == trim($_REQUEST['repassword']))
        ) {
            $password = trim($_REQUEST['password']);
            $data['user_password'] = md5($password);
            $oldPassword = trim($_REQUEST['oldPassword']);
            $where['user_password'] = md5($oldPassword);
            $where['user_id'] = $admin_user['user_id'];
            $yesOrNo = db('admin_user', [], false)->where($where)->find();
            if (!$yesOrNo) {
                ReturnMsg::returnFormMsg('no', '旧密码不对');
                exit;
            }
            $ret = db('admin_user', [], false)->where($where)->update($data);
            if ($ret) {
                session('adminUser', null);
                ReturnMsg::returnFormMsg('ok', '成功');
            } else {
                ReturnMsg::returnFormMsg('no', '失败或新密码跟旧密码相同');
            }
        } else {
            ReturnMsg::returnFormMsg('no', '参数错误');
        }
    }

    /**
     * 渲染用户协议
     * @return \think\response\View
     */
    public function setUserAgree()
    {
        $set = QuickModel::getOneData('set', ['set_id' => 1]);
        $this->assign('desc', $set['set_user_agree']);
        return view();
    }

    /**
     * 处理用户协议
     */
    public function doUserAgree()
    {
        $desc = input('desc');
        $desc = str_replace("\\", "/", $desc);
        QuickModel::editData('set', ['set_id' => 1], array('set_user_agree' => $desc));
        ReturnMsg::returnFormMsg('ok', '成功');
    }


    /**
     * 富文本上传图片
     */
    //单图片上传分享主图
    public function uploadImg()
    {
        $upload = new Upload();
        $res = $upload->upload('layedit');//传文件夹名称过去
        $res['data']['src'] = $res['src'];
        return $res;
    }

}
