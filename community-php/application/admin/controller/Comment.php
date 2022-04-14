<?php
/**
 * describe:
 * author:<axunl@1140718342@qq.com>
 * datetime:2020/3/30 2:00
 * */

namespace app\admin\controller;


use app\admin\common\Format;
use app\admin\common\Template;
use app\common\model\QuickModel;

class Comment extends Format
{
    public function initialize()
    {
        parent::initialize();
        $this->isEdit = false;
        $this->isAdd = false;
    }

    public function comment()
    {
        $user = QuickModel::getData('user');
        //构造搜索框
        $item[] = Template::setSearchItem("comment_id", "评论ID", 'input');
        $item[] = Template::setSearchItem("question_id", "问题ID", 'input');
        $item[] = Template::setSearchItem("user_id", "只看他的评论", 'select', $user, 'user_id', 'user_name');
        //设置表格头
        $cols[] = Template::setTableTitleItem("", "", "", "", "left", "", "", "", "", "checkbox");
        $cols[] = Template::setTableTitleItem("comment_id", "ID", 60);
        $cols[] = Template::setTableTitleItem("question_id", "问题ID");
        $cols[] = Template::setTableTitleItem("reply_id", "评论人名字", '', '#reply_idTpl');
        $cols[] = Template::setTableTitleItem("user_id", "被评论人名字", '', '#user_idTpl');
        $cols[] = Template::setTableTitleItem("comment_content", "评论内容");
        $cols[] = Template::setTableTitleItem("create_time", "创建时间");
        $cols[] = Template::setTableTitleItem("操作", "操作", "180", "", "right", "center", '#toolbar');
        $cols = Template::setTableTitle($cols);
        //设置模板
        $tpl[] = Template::setTplItem('text', "reply_id", $user, 'user_id', 'user_name');
        $tpl[] = Template::setTplItem('text', "user_id", $user, 'user_id', 'user_name');
        return view($this->renderListView, $this->returnTplListDataFormat($this, $item, $cols, $tpl));
    }
}