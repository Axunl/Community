<?php

namespace app\admin\common;

/**
 * 视图layui模板构造类
 * @link https://www.layui.com/doc/modules/table.html#options 手册
 */
class Template
{
    /**
     * 渲染搜索项数据
     * @param string $item 对应该表中的字段名称
     * @param string $name 搜索框显示的中文名称
     * @param string $type 搜索类型 input 输入框  select 选择框 datetime 时间
     * @param array $d select时的数据 [[0,$option_value][1,$option]]
     * @param int $option_value select的value值下标
     * @param int $option select对应的名称下标
     * @param string $placeholder 提示语
     * @return array 渲染搜索项数据数组
     */
    public static function setSearchItem($item, $name = '', $type, $d = [], $option_value = 0, $option = 1, $placeholder = "")
    {
        $data = array("item" => $item, "name" => $name, "type" => $type, "data" => $d, "option_value" => $option_value, "option" => $option);
        if (!$placeholder) {
            $data['placeholder'] = "请输入" . $placeholder;
        } else {
            $data['placeholder'] = $placeholder;
        }
        return $data;
    }


    /**
     * 渲染表头标题数据
     * @param string $field 该表中字段的名字
     * @param string $title 该字段中文名称
     * @param int $minWidth 最小宽度
     * @param string $templet 准换模板名字 ex:*Tpl
     * @param string $fixed 固定列。可选值有：left（固定在左）、right（固定在右）。一旦设定，对应的列将会被固定在左或右，不随滚动条而滚动。
     * @param string $align 单元格排列方式。可选值有：left（默认）、center（居中）、right（居右)
     * @param string $toolbar 绑定工具条模板。可在每行对应的列中出现一些自定义的操作性按钮
     * @param string $totalRow 用于显示自定义的合计文本。layui 2.4.0 新增
     * @param bool $sort 是否允许排序（默认：false）。
     * @param string $type 设定列类型。可选值有：normal（常规列，无需设定）checkbox（复选框列）radio（单选框列，layui 2.4.0 新增）numbers（序号列）space（空列）
     * @param bool $hide 是否初始隐藏列，默认：false。layui 2.4.0 新增
     * @param string $style 自定义style
     * @return array 渲染表头标题数据数组
     */
    public static function setTableTitleItem($field, $title, $minWidth = 120, $templet = "", $fixed = "left", $align = "center", $toolbar = "", $totalRow = "", $sort = true, $type = "normal", $hide = false, $style = '')
    {
        $data['field'] = $field;
        $data['title'] = $title;
        $data['sort'] = $sort;
        $data['type'] = $type;
        $data['hide'] = $hide;
        if ($totalRow) {
            $data['totalRow'] = $totalRow;
        }
        if ($minWidth) {
            $data['minWidth'] = $minWidth;
        }
        if ($templet) {
            $data['templet'] = $templet;
        }
        if ($fixed) {
            $data['fixed'] = $fixed;
        }
        if ($align) {
            $data['align'] = $align;
        }
        if ($toolbar) {
            $data['toolbar'] = $toolbar;
        }
        if ($style) {
            $data['style'] = $style;
        }
        return $data;
    }

    /**
     * 构造表数据
     * @param array $item 表数组
     * @return string 表字符串
     */
    public static function setTableTitle($item)
    {
        $obj = "[[";
        foreach ($item as $k => $v) {
            $obj .= json_encode($v, JSON_UNESCAPED_UNICODE);
            $obj .= ",";
        }
        //去掉最后一个逗号
        $obj = substr($obj, 0, strlen($obj) - 1);
        $obj .= "]]";
        //替换"true" 为true
        $obj = str_replace('"true"', "true", $obj);
        return $obj;
    }

    /**
     * tpl转化
     * @param string $type 转化类型 text 文字  img 图片  video 视频
     * @param string $item 对应的转化tpl
     * @param array $data text对应数组
     * @param int $key_item text的value值下标
     * @param int $value_item text对应的名称下标
     * @return array tpl转化数组
     */
    public static function setTplItem($type, $item, $data = [], $key_item = 0, $value_item = 1)
    {
        return array("type" => $type, "item" => $item, "data" => $data, "key_item" => $key_item, "value_item" => $value_item);
    }

    /**
     * 设置添加|编辑列表
     * @param string $label 字段显示名字
     * @param string $type 编辑类型 text 文本 datetime 时间 hidden 隐藏域 textarea 文本域 img 图片 select 选择框 file 文件 video 视频 richText 富文本
     * @param string $name 该表中的字段名称
     * @param string $value 对应该表中的字段值
     * @param array $option 类型为select/checkbox的时候用到，一个二维数组 数组里面，第一个是option的值，一个是option显示的内容
     * @param string $word 提示词
     * @return  array 渲染编辑页数据
     */
    public static function setEditItem($label = '', $type, $name, $value, $option = [], $word = "")
    {
        return array("label" => $label, "type" => $type, "name" => $name, "value" => $value, "option" => $option, "word" => $word);
    }

    /**
     * 渲染页面数据集合
     * @param array $item 搜索框数据集合
     * @param array $cols 表格行数据集合
     * @param array $tpl 表格行转化类型数据集合
     * @param string $table 表格
     * @param string $editUrl 编辑路径url
     * @param string $doEditUrl 处理编辑路径
     * @param int $id 主键id
     * @param bool $isEdit 是否显示添加按钮
     * @param bool $isDelete 是否显示删除按钮
     * @param string $getUrl 处理获取数据的url
     * @param string $searchUrl 处理搜索数据的url
     * @param string $addUrl 处理添加数据的url
     * @param string $deleteUrl 处理删除数据的url
     * @return array 页面数据
     */
    public static function setTemplateData($item = [], $cols = [], $tpl = [], $table, $editUrl, $id, $doEditUrl = '', $isEdit = true, $isAdd = true, $isDelete = true, $getUrl = '', $searchUrl = '', $addUrl = '', $deleteUrl = '')
    {
        return [
            "item" => $item,
            "cols" => $cols,
            "tpl" => $tpl,
            "table" => $table,
            "time" => time(),
            'editUrl' => $editUrl,
            'id' => $id,
            'doEditUrl' => $doEditUrl,
            'isEdit' => $isEdit,
            'isAdd' => $isAdd,
            'isDelete' => $isDelete,
            'getUrl' => $getUrl,
            'searchUrl' => $searchUrl,
            'addUrl' => $addUrl,
            'deleteUrl' => $deleteUrl
        ];
    }

}
