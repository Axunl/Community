<?php

namespace app\admin\common;

use app\admin\controller\Base;
use think\helper\Str;

/**
 * 格式化
 * */
class Format extends Base
{
    protected $table;//表格
    protected $pk;//主键
    protected $urlPrefixes;//url前缀
    protected $getUrl;//获取数据
    protected $searchUrl;//获取搜索数据
    protected $addUrl;//处理添加数据
    protected $editUrl;//编辑路径
    protected $doEditUrl;//处理编辑
    protected $deleteUrl;//处理删除数据
    protected $uploadUrl;//上传路径
    protected $isEdit;//是否显示编辑按钮
    protected $isAdd;//是否显示添加按钮
    protected $isDelete;//是否显示删除按钮
    protected $renderListView;//渲染的listView
    protected $renderEditView;//渲染的editView

    public function initialize()
    {
        parent::initialize();
        $this->initConfig();
    }

    private function initConfig()
    {
        $request = $this->request;
        $this->table = Str::snake($request->controller());
        $exp = explode('_', $this->table);
        $this->pk = end($exp) . '_id';
        $this->urlPrefixes = end($exp);
        $this->getUrl = url('admin/Data/getData', array("table" => $this->table));
        $this->searchUrl = url('admin/Data/searchData', array("table" => $this->table));
        $this->addUrl = url('admin/Data/addData', array("table" => $this->table));
        $this->editUrl = '/admin/' . Str::snake($this->request->controller()) . $this->editUrlFormat($this->urlPrefixes);
        $this->doEditUrl = url('admin/Data/editData', array("table" => $this->table, "id" => $this->pk));
        $this->deleteUrl = "/admin/Data/deleteData/table/$this->table";
        $this->uploadUrl = url("admin/Upload/upload", array("name" => $this->table));
        $this->isEdit = true;
        $this->isAdd = true;
        $this->isDelete = true;
        $this->renderListView = "template/list";
        $this->renderEditView = "template/edit";
    }

    protected function customGet()
    {
        return url('admin' . str_replace('/', '', $this->request->root()) . '/' . $this->request->controller() . $this->getUrlFormat($this->urlPrefixes), array("table" => $this->table));
    }

    protected function customSearch()
    {
        return url('admin' . str_replace('/', '', $this->request->root()) . '/' . $this->request->controller() . $this->searchUrlFormat($this->urlPrefixes), array("table" => $this->table));
    }

    protected function customAdd()
    {
        return url('admin' . str_replace('/', '', $this->request->root()) . '/' . $this->request->controller() . $this->addUrlFormat($this->urlPrefixes), array("table" => $this->table));
    }

    protected function customDoEditUrl()
    {
        return url('admin' . str_replace('/', '', $this->request->root()) . '/' . $this->request->controller() . $this->doEditUrlFormat($this->urlPrefixes), array("id" => $this->pk, "table" => $this->table));
    }

    protected function returnTplListDataFormat($object, $item = [], $cols = [], $tpl = [])
    {
        return Template::setTemplateData($item, $cols, $tpl, $object->table, $object->editUrl, $object->pk, $object->doEditUrl, $object->isEdit, $object->isAdd, $object->isDelete, $object->getUrl, $object->searchUrl, $object->addUrl, $object->deleteUrl);
    }

    protected function returnTplEditDataFormat($object, $data)
    {
        return array("data" => $data, "uploadUrl" => $object->uploadUrl, "time" => time());
    }

    private function editUrlFormat($name)
    {
        $name = ucfirst($name);
        return "/edit$name";
    }

    private function doEditUrlFormat($name)
    {
        $name = ucfirst($name);
        return "/doEdit$name";
    }

    private function addUrlFormat($name)
    {
        $name = ucfirst($name);
        return "/add$name";
    }

    private function getUrlFormat($name)
    {
        $name = ucfirst($name);
        return "/get$name";
    }
    private function searchUrlFormat($name)
    {
        $name = ucfirst($name);
        return "/get$name";
    }
}