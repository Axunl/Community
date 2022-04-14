<?php

namespace app\admin\controller;

use app\admin\common\ReturnMsg;
use app\common\model\QuickModel;

class Data extends Base
{
    /**
     * 获取表格数据
     */
    public function getData($table)
    {
        $limit = $_GET['limit'];
        $page = $_GET['page'];
        $data = QuickModel::getData($table, "", $limit, $page);
        ReturnMsg::returnMsg($data, count(QuickModel::getData($table)));
    }

    /**
     * 搜索表格数据
     */
    public function searchData($table)
    {
        $d = [];
        $page = $_POST['page'];
        $limit = $_POST['limit'];
        unset($_POST['page']);
        unset($_POST['limit']);
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
        ReturnMsg::returnMsg($data, $count);
    }

    /**
     * 编辑数据
     */
    public function editData($table, $id)
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
        QuickModel::editData($table, array($id => $_POST[$id]), $_POST);
        ReturnMsg::returnMsg([], '', '成功');
    }

    /**
     * 删除数据
     */
    public function deleteData($table, $where, $data)
    {
        $data = explode(',', $data);
        foreach ($data as $k => $v) {
            if ($v) QuickModel::deleteData($table, array($where => $v));
        }
        ReturnMsg::returnMsg([], '', '成功');
    }

    /**
     * 添加数据
     */
    public function addData($table)
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
        $data = $_POST;
        QuickModel::addData($table, $data);
        ReturnMsg::returnMsg([], '', '成功');
    }
}
