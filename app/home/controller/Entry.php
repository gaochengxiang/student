<?php
//命名一个app\home\controller空间为了能找到里面的方法;
namespace app\home\controller;
use houdunwang\core\Controller;
//载入houdunwang\core\的Controller类为了能找到里面的方法
use houdunwang\model\Model;
//载入houdunwang\model\Model为了能找到里面的方法
use houdunwang\view\View;

class Entry extends Controller{
    /**首页
     * @return mixed
     */
    public function index() {
        $data = Model::q("SELECT * FROM stu s JOIN grade g ON s.gid=g.gid");
        return View::make()->with(compact('data'));
    }
    public function show(){
        $data = Model::q("SELECT * FROM stu s JOIN grade g ON s.gid=g.gid WHERE s.sid=". $_GET['sid']);
//        p($data);
        return View::make()->with(compact('data'));
    }

}