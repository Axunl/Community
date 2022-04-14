<?php

namespace app\common\model;

use think\Db;

class QuickModel
{
    private static $useSoftDelete = false;//开启软删除

    //获取单个数据
    public static function getOneData($table, $where = null)
    {
        if (self::$useSoftDelete) {
            return Db::name($table)->where($where)->where(['delete_time' => null])->find();
        } else {
            return Db::name($table)->where($where)->find();
        }
    }

    //获取多个数据
    public static function getData($table, $where = "", $limit = "", $page = "", $order = "")
    {
        $query = Db::name($table);
        if ($where) {
            $query->where($where);
        }
        if ($limit && $page) {
            $query->page($page, $limit);
        }
        if ($order) {
            $query->order($order);
        }
        if (self::$useSoftDelete) {
            return $query->where(['delete_time' => null])->select();
        } else {
            return $query->select();
        }
    }

    //算数据
    public static function countData($table, $where)
    {
        if (self::$useSoftDelete) {
            return Db::name($table)->where($where)->where(['delete_time' => null])->count();
        } else {
            return Db::name($table)->where($where)->count();
        }

    }

    //添加数据
    public static function addData($table, $data)
    {
        return Db::name($table)->insertGetId($data);
    }

    //编辑数据
    public static function editData($table, $where, $data)
    {
        if (self::$useSoftDelete) {
            return Db::name($table)->where($where)->where(['delete_time' => null])->update($data);
        } else {
            return Db::name($table)->where($where)->update($data);
        }
    }

    //自增字段
    public static function incData($table, $where, $field, $step)
    {
        if (self::$useSoftDelete) {
            Db::name($table)->where($where)->where(['delete_time' => null])->setInc($field, $step);
        } else {
            Db::name($table)->where($where)->setInc($field, $step);
        }
    }

    //自减字段
    public static function decData($table, $where, $field, $step)
    {
        if (self::$useSoftDelete) {
            Db::name($table)->where($where)->where(['delete_time' => null])->setDec($field, $step);
        } else {
            Db::name($table)->where($where)->setDec($field, $step);
        }

    }


    //删除数据
    public static function deleteData($table, $where)
    {
        if (self::$useSoftDelete) {
            return Db::name($table)->where($where)->update(['delete_time' => date('Y-m-d H:i:s')]);
        } else {
            return Db::name($table)->where($where)->delete();
        }
    }
}