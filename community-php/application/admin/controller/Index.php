<?php

namespace app\admin\controller;

class Index extends Base
{
    public function index()
    {
        $this->assign('adminUser', session('adminUser'));
        return view();
    }
}