<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2017/7/30
 * Time: 15:58
 */
//view类所在的空间名
namespace houdunwang\view;


/**
 * 定义一个View类用来自动调用本空间名里面的Base类里面的方法
 * @param $name [方法名称]
 * @param $arguments [方法传入的参数]
 */

class View{
//创建一个静态调用不存在的方法时执行的方法执行Base类中对应的方法
      public static function __callStatic($name, $arguments){
//     用来接收__tostring返回来的值
//     用来接收$this也就是当前对象的值
//     然后再次返回到index（）里面的with方法和make方法、
//     最后返回到 houdunwang\core\boot页面 的appRun方法 echo输出
          return call_user_func_array([new Base(),$name],$arguments);
      }
}