<?php


namespace app\admin\controller;


use app\admin\common\ReturnMsg;
use app\admin\common\Template;
use app\admin\common\Format;
use app\common\model\QuickModel;

class AdminUser extends Format
{
    public function initialize()
    {
        parent::initialize();
        $this->addUrl = $this->customAdd();
        $this->doEditUrl = $this->customDoEditUrl();
    }

    public function user()
    {
        $role = QuickModel::getData('admin_role');
        //构造搜索框
        $item = [];
        //设置表格头
        $cols[] = Template::setTableTitleItem("", "", "", "", "left", "", "", "", "", "checkbox");
        $cols[] = Template::setTableTitleItem($this->pk, "ID");
        $cols[] = Template::setTableTitleItem("user_account", "账号");
        $cols[] = Template::setTableTitleItem("role_id", "角色", 60, "#role_idTpl");
        $cols[] = Template::setTableTitleItem("user_status", "用户状态", '', '#user_statusTpl');
        $cols[] = Template::setTableTitleItem("create_time", "创建时间");
        $cols[] = Template::setTableTitleItem("操作", "操作", 180, "", "right", "center", '#toolbar');
        $cols = Template::setTableTitle($cols);
        //设置模板
        $tpl[] = Template::setTplItem('text', "role_id", $role, 'role_id', 'role_name');
        $tpl[] = Template::setTplItem('text', "user_status", [[1, "正常"], [2, "禁用"]]);
        return view($this->renderListView, $this->returnTplListDataFormat($this, $item, $cols, $tpl));
    }

    public function editUser($id)
    {  //角色
        $role = QuickModel::getData('admin_role');
        $temp = [];
        foreach ($role as $k => $v) {
            $temp[] = array($v['role_id'], $v['role_name']);
        }
        $role = $temp;
        $d = QuickModel::getOneData($this->table, array($this->pk => $id));
        //构造编辑页面
        $data[] = Template::setEditItem("ID", "hidden", $this->pk, $d[$this->pk]);
        $data[] = Template::setEditItem("账号", "text", 'user_account', $d['user_account']);
        $data[] = Template::setEditItem("密码", "text", 'user_password', $d['user_password']);
        $data[] = Template::setEditItem('角色', 'select', 'role_id', $d['role_id'], $role);
        $data[] = Template::setEditItem("状态", "select", 'user_status', $d['user_status'], [[1, "正常"], [2, "禁用"]]);
        return view($this->renderEditView, $this->returnTplEditDataFormat($this, $data));
    }

    public function addUser($table)
    {
        unset($_POST['file']);
        unset($_POST[$this->pk]);
        $data = $_POST;
        if (QuickModel::getOneData($table, ['user_account' => $data['user_account']])) {
            ReturnMsg::returnMsg([], '', '账号已存在', -1);
        } else {
            $data['user_password'] = md5($data['user_password']);
            QuickModel::addData($table, $data);
            ReturnMsg::returnMsg([], '', '成功');
        }
    }

    public function doEditUser($id, $table)
    {
        unset($_POST['file']);
        //循环一遍，
        foreach ($_POST as $k => $v) {
            if (is_array($v)) {
                $str = "";
                foreach ($v as $kk => $vv) {
                    $str .= $vv;
                    $str .= ",";
                }
                $str = substr($str, 0, strlen($str) - 1);
                $_POST[$k] = $str;
            }
        }
        $_POST['user_password'] = md5($_POST['user_password']);
        QuickModel::editData($table, array($id => $_POST[$id]), $_POST);
        ReturnMsg::returnMsg([], '', '成功');
    }
}