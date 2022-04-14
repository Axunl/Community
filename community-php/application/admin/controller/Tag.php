<?php
/**
 * describe:
 * author:<axunl@1140718342@qq.com>
 * datetime:2020/3/30 1:11
 * */

namespace app\admin\controller;


use app\admin\common\Format;
use app\admin\common\Template;
use app\common\model\QuickModel;

class Tag extends Format
{
    public function tag()
    {
        //构造搜索框
        $item = [];
        //设置表格头
        $cols[] = Template::setTableTitleItem("", "", "", "", "left", "", "", "", "", "checkbox");
        $cols[] = Template::setTableTitleItem("tag_id", "ID", 60);
        $cols[] = Template::setTableTitleItem("tag_name", "标签名");
        $cols[] = Template::setTableTitleItem("操作", "操作", "180", "", "right", "center", '#toolbar');
        $cols = Template::setTableTitle($cols);
        //设置模板
        $tpl[] = [];
        return view($this->renderListView, $this->returnTplListDataFormat($this, $item, $cols, $tpl));
    }

    public function editTag($id)
    {
        $d = QuickModel::getOneData($this->table, array($this->pk => $id));
        //构造编辑页面
        $data[] = Template::setEditItem("ID", "hidden", $this->pk, $d[$this->pk]);
        $data[] = Template::setEditItem("标签名", "text", 'tag_name', $d['tag_name']);
        return view($this->renderEditView, $this->returnTplEditDataFormat($this, $data));
    }
}