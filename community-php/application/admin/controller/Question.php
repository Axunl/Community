<?php
/**
 * describe:
 * author:<axunl@1140718342@qq.com>
 * datetime:2020/3/30 1:16
 * */

namespace app\admin\controller;


use app\admin\common\Format;
use app\admin\common\ReturnMsg;
use app\admin\common\Template;
use app\common\model\QuickModel;
use think\Db;

class Question extends Format
{
    public function initialize()
    {
        parent::initialize();
        $this->getUrl = $this->customGet();
        $this->searchUrl = $this->customSearch();
        $this->isAdd = false;
    }

    public function question()
    {
        //构造搜索框
        $item[] = Template::setSearchItem("user_id", "用户id", 'input');
        $item[] = Template::setSearchItem("user_name", "用户名称", 'input');
        //设置表格头
        $cols[] = Template::setTableTitleItem("", "", "", "", "left", "", "", "", "", "checkbox");
        $cols[] = Template::setTableTitleItem("question_id", "ID", 60);
        $cols[] = Template::setTableTitleItem("user_id", "用户ID");
        $cols[] = Template::setTableTitleItem("user_name", "用户名称");
        $cols[] = Template::setTableTitleItem("question_title", "问题标题");
        $cols[] = Template::setTableTitleItem("question_description", "问题描述");
        $cols[] = Template::setTableTitleItem("tag", "标签");
        $cols[] = Template::setTableTitleItem("read_num", "阅读数");
        $cols[] = Template::setTableTitleItem("操作", "操作", "180", "", "right", "center", '#toolbar');
        $cols = Template::setTableTitle($cols);
        //设置模板
        $tpl[] = [];
        return view($this->renderListView, $this->returnTplListDataFormat($this, $item, $cols, $tpl));
    }

    public function editQuestion($id)
    {
        $tag = QuickModel::getData('tag');
        $d = QuickModel::getOneData($this->table, array($this->pk => $id));
        //构造编辑页面
        $data[] = Template::setEditItem("ID", "hidden", $this->pk, $d[$this->pk]);
        $data[] = Template::setEditItem("问题标题", "text", 'question_title', $d['question_title']);
        $data[] = Template::setEditItem("问题描述", "richText", 'question_description', $d['question_description']);
        $d['tag'] = explode(',', $d['tag']);
        $t = [];
        foreach ($tag as $key => $val) {
            if (in_array($val["tag_id"], $d['tag'])) {
                $t[] = [$val["tag_id"], $val["tag_name"], "checked"];
            } else {
                $t[] = [$val["tag_id"], $val["tag_name"], ""];
            }
        }
        $data[] = Template::setEditItem("标签", "checkbox", 'tag', "", $t);
        $data[] = Template::setEditItem("阅读数", "text", 'read_num', $d['read_num']);
        return view($this->renderEditView, $this->returnTplEditDataFormat($this, $data));
    }

    public function getQuestion($table)
    {
        $limit = $_GET['limit'];
        $page = $_GET['page'];
        $data = Db::name($table)
            ->alias('q')
            ->leftJoin('user u', 'q.user_id=u.user_id')
            ->field('q.*,u.user_name')
            ->select();
        foreach ($data as $k => $v) {
            $data[$k]['question_description'] = '点击编辑查看';
        }
        ReturnMsg::returnMsg($data, count(QuickModel::getData($table)));
    }

    public function searchQuestion($table)
    {
        $d = [];
        $page = $_POST['page'];
        $limit = $_POST['limit'];
        unset($_POST['page']);
        unset($_POST['limit']);
        if ($_POST['user_name']) {
            $user = QuickModel::getOneData('user', ['user_name' => $_POST['user_name']]);
            $_POST['user_id'] = $user['user_id'];
            unset($_POST['user_name']);
        }
        foreach ($_POST as $k => $v) {
            if ($v == null || $v === 0 || $v === "0") {
                unset($_POST[$k]);
            } else {
                $d[] = array($k, "like", '%' . $v . '%');
            }
        }
        if ($_POST) {
            $data = QuickModel::getData($table, $d, $limit, $page);
            $count = count(QuickModel::getData($table, $d));
        } else {
            $data = QuickModel::getData($table, "", $limit, $page);
            $count = count(QuickModel::getData($table));
        }
        foreach ($data as $k => $v) {
            $data[$k]['question_description'] = '点击编辑查看';
        }
        ReturnMsg::returnMsg($data, $count);
    }
}