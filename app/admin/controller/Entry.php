<?php
//命名一个app\home\controller空间为了能找到里面的方法;
namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\view\View;

class Entry extends Common {
    /**
     * 默认首页
     */
    public function index(){

        return View::make();
    }
}