<?php

namespace app\admin\controller;

use app\common\model\QuickModel;
use think\Controller;

class Base extends Controller
{
    public function initialize()
    {
        if (!session('adminUser')) {
            $url = url('admin/login/login');
            echo "<script language=JavaScript> alert('账号登陆过期请重新登陆'); parent.parent.location.href='$url';</script>";
            exit;
        }
        $this->check_user_power(request()->controller() . "/" . request()->action());
    }

    /**
     * 校检访问列表
     * @param $visit_name
     * @return bool
     */
    private function check_user_power($visit_name)
    {
        //先获取所有的action
        $actions = QuickModel::getData("admin_action", array(["action_code", 'not null']));
        $code = [];
        foreach ($actions as $k => $v) {
            $code[] = strtolower($v['action_code']);
        }
        if (!in_array(strtolower($visit_name), $code)) {
            return true;//不需要判断权限的网址
        }
        $user = session('adminUser');
        if ($user['user_status'] != 1) {
            echo '账号已经禁止登陆';
            exit;
        }
        //没有全部权限
        //通过用户的角色id获取权限
        $role = QuickModel::getOneData('admin_role', array("role_id" => $user['role_id']));
        $visit_list = explode(',', $role['role_visit_list']);
        $flag = 0;
        foreach ($visit_list as $k => $v) {
            $action = QuickModel::getOneData('admin_action', array("action_id" => $v));
            if (strtolower($action['action_code']) == strtolower($visit_name)) {
                $flag = 1;
            }
        }
        if (!$flag) {
            echo "您没有权限访问";
            exit;
        }
    }
}