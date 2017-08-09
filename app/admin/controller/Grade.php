<?php
namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Grade as GradeModel;
class Grade extends Common {
    /**
     * 班级列表
     */
    public function lists(){
//        静态调用一个不存在的方法然后到houdunwang/model/base里面去找get方法get方法
//      base 然后返回model 获取到全部数据存在$data
        $data = GradeModel::get();
//        p($data);
        p(compact('data'));
        return View::make()->with(compact('data'));

    }
    /**
     * 添加
     */
    public function store(){
        if(IS_POST){
            GradeModel::save($_POST);
            return $this->setRed('?s=admin/grade/lists')->success('添加成功');
        }
        return View::make();
    }
    /**
     * 删除
     */
    public function remove(){
        GradeModel::where("gid={$_GET['gid']}")->destory();

        return $this->setRed('?s=admin/grade/lists')->success('删除成功');
    }
    /**
     * 编辑
     */
    public function update(){
//       或得到用户提交的gid
        $gid = $_GET['gid'];
        if(IS_POST){
//           update category set cname='娱乐' where cid=3;
            GradeModel::where("gid={$gid}")->update($_POST);
            return $this->setRed('?s=admin/grade/lists')->success('修改成功');

        }
        $oldData = GradeModel::find($gid);
        return View::make()->with(compact('oldData'));
    }
}