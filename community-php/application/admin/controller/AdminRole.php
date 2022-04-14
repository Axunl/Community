<?php

namespace app\admin\controller;

use app\admin\common\Format;
use app\admin\common\Template;
use app\common\model\QuickModel;

class AdminRole extends Format
{
    public function role()
    {
        //构造搜索框
        $item[] = Template::setSearchItem("role_name", "角色名称", 'input');
        //设置表格头
        $cols[] = Template::setTableTitleItem("", "", "", "", "left", "", "", "", "", "checkbox");
        $cols[] = Template::setTableTitleItem("role_id", "ID", 60);
        $cols[] = Template::setTableTitleItem("role_name", "名称");
        $cols[] = Template::setTableTitleItem("role_visit_list", "可访问的方法列表");
        $cols[] = Template::setTableTitleItem("role_descr", "描述");
        $cols[] = Template::setTableTitleItem("操作", "操作", "180", "", "right", "center", '#toolbar');
        $cols = Template::setTableTitle($cols);
        //设置模板
        $tpl = [];
        return view($this->renderListView, $this->returnTplListDataFormat($this, $item, $cols, $tpl));
    }

    /**
     * 编辑角色
     */
    public function editRole($id)
    {
        //获取模块
        $actions = QuickModel::getData("admin_action", array(["action_code", 'neq', '0']));
        //获取角色
        $role = QuickModel::getOneData('admin_role', array('role_id' => $id));
        $data[] = Template::setEditItem('id', 'hidden', 'role_id', $role['role_id']);
        $data[] = Template::setEditItem('角色', 'text', 'role_name', $role['role_name']);
        $data[] = Template::setEditItem('描述', 'text', 'role_descr', $role['role_descr']);
        //重新组合一遍角色
        $d = [];
        $roles = explode(",", $role["role_visit_list"]);
        foreach ($actions as $key => $val) {
            if (in_array($val["action_id"], $roles)) {
                $d[] = [$val["action_id"], $val["action_name"], "checked"];
            } else {
                $d[] = [$val["action_id"], $val["action_name"], ""];
            }
        }
        $data[] = Template::setEditItem('权限', 'checkbox', 'role_visit_list', "", $d);
        return view($this->renderEditView, $this->returnTplEditDataFormat($this, $data));
    }


}
