<?php
/**
 * Created by PhpStorm.
 * User: Think
 * Date: 2017/7/30
 * Time: 15:57
 */
//Model类所在的空间名
namespace houdunwang\model;

/**
 * 定义一个Model类用来自动调用本空间名里面的Base类里面的方法
 * Class Model
 * @package houdunwang\model
 */
class Model{
//创建一个静态调用不存在的方法时执行的方法执行Base类中对应的方法
    public static function __callStatic($name, $arguments){
//        将这个类的类名获取
          $className = get_called_class();
        //system\model\Arc
        //strrchr字符串截取 变成 \Arc
        //ltrim 去除左边的\ 变成 Arc
        //strtolower 变成 arc
        $table= strtolower(ltrim(strrchr($className,'\\'),'\\'));

        //   将base类中对应的方法返回的操作和数据返回到entry中的对应的方法中
     return  call_user_func_array([new Base($table),$name],$arguments);
    }
}