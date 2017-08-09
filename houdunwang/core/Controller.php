<?php
namespace houdunwang\core;

class Controller{
// 定义私有变量用来传递地址
    private  $url= 'window.history.back()';
//   定义一个私有方法template用来储存地址的
    private  $template;
//    定义一个私有方法用来传递提示语句
    private $msg;
//    跳转
    protected function setRed($url){
        $this->url = "location.href='{$url}'";
//  向entry返回了这个对象
        return $this;
    }

//    成功的时候
    protected function success($msg){
        $this->msg = $msg;
        $this->template = './view/success.php';
        return $this;
    }
//    失败的时候
    protected  function error($msg){
        $this->msg = $msg;
        $this->template = './view/error.php';

        return $this;
    }
//  只要在houdunwang\core\Boot页面中找到appRun方法 echo就可以触发次方法
    public  function __toString(){
//      载入模板
        include $this->template;
//        必须返回一个字符串
        return '';
    }
}