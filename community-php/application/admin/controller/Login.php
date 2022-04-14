<?php

namespace app\admin\controller;

use app\admin\common\ReturnMsg;
use app\api\controller\AdminUser;
use app\common\model\QuickModel;
use think\Controller;

class Login extends Controller
{
    public function login()
    {
        return view();
    }

    public function doLogin()
    {
        ['username' => $userName, 'password' => $password, 'vercode' => $captcha] = $this->request->param();//解构赋值
        if (!captcha_check($captcha)) {
            ReturnMsg::returnFormMsg('no', '验证码错误');
            return;
        };
        $user = QuickModel::getOneData('admin_user', [
            'user_account' => $userName,
            'user_password' => md5($password)
        ]);
        if (!$user) {
            ReturnMsg::returnFormMsg('no', '账号或密码错误');
            return;
        } else {
            session('adminUser', $user);
            ReturnMsg::returnFormMsg('ok', '');
        }
    }

    public function logout()
    {
        session('adminUser', null);
        $this->success('退出成功','/admin/login/login');
    }
}