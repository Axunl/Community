<?php
/**
 * describe:
 * author:<axunl@1140718342@qq.com>
 * datetime:2020/3/30 0:50
 * */

namespace app\admin\controller;


use app\admin\common\Format;
use app\admin\common\Template;
use app\common\model\QuickModel;

class User extends Format
{
    function initialize()
    {
        parent::initialize();
        $this->isAdd = false;
    }

    public function user()
    {
        //构造搜索框
        $item[] = Template::setSearchItem("user_id", "用户id", 'input');
        $item[] = Template::setSearchItem("user_name", "用户名称", 'input');
        //设置表格头
        $cols[] = Template::setTableTitleItem("", "", "", "", "left", "", "", "", "", "checkbox");
        $cols[] = Template::setTableTitleItem("user_id", "ID", 60);
        $cols[] = Template::setTableTitleItem("user_name", "用户名");
        $cols[] = Template::setTableTitleItem("user_avatar_url", "用户头像", '', '#user_avatar_urlTpl');
        $cols[] = Template::setTableTitleItem("操作", "操作", "180", "", "right", "center", '#toolbar');
        $cols = Template::setTableTitle($cols);
        //设置模板
        $tpl[] = Template::setTplItem('img', "user_avatar_url");
        return view($this->renderListView, $this->returnTplListDataFormat($this, $item, $cols, $tpl));
    }

    public function editUser($id)
    {
        $d = QuickModel::getOneData($this->table, array($this->pk => $id));
        //构造编辑页面
        $data[] = Template::setEditItem("ID", "hidden", $this->pk, $d[$this->pk]);
        $data[] = Template::setEditItem("用户名", "text", 'user_name', $d['user_name']);
        $data[] = Template::setEditItem("用户头像", "img", 'user_avatar_url', $d['user_avatar_url']);
        return view($this->renderEditView, $this->returnTplEditDataFormat($this, $data));
    }
}