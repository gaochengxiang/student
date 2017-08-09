<?php
namespace app\admin\controller;

use houdunwang\core\Controller;

class Common extends Controller {

    public function __construct(){
//      判断有没有session 如果没有的话就登录
        if(!isset($_SESSION['user'])){
//          如果没有登录的话跳转链接
            go('?s=admin/login/index');
        }
    }

}