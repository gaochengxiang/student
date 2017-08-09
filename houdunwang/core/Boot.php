<?php
//boot类所在的空间名
namespace houdunwang\core;

class Boot{
    /*
     * 初始化框架
     */
    public static function run(){
        self::hanleFrror();
//        执行初始化
         self::init();
        //执行应用
        self::appRun();



    }
    public static function hanleFrror(){
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    /**
     * 执行应用
     */
    protected static function appRun(){
        //      ?s=home/entry/index
//        默认访问home/entry/index 通过get参数的改变来访问不同的模板和不同的控制器以及方法
        $s= isset($_GET['s']) ?$_GET['s'] :"home/entry/index";
//        因为要访问不同的类文件  所以要组合类的文件名  因为entry是改变的 所以为了拿到他们  把get参数中的数据变成一个数组 方便抓取
        $arr=explode('/',$s);
        //        p($arr);
//        Array
//        (
//            [0] => home
//            [1] => entry
//            [2] => index
//         )
//      组合类名 app\home\controller\Entry
        define("APP",$arr[0]);
        //定义一个CONTROLLER常量
        define("CONTROLLER",$arr[1]);
//      定义一个ACTION常量
        define("ACTION",$arr[2]);
        //组合类名 \app\home\controller\Entry
        $className = "\app\\{$arr[0]}\controller\\".ucfirst($arr[1]);
//        p($className);
        /*1、把应用比如:"home"定义为常量APP
         * 2、在houdunwang/view/viwe.php文件里的view类的make方法组合模板路径，
         * home是默认应用，有可能是admin应用,不能写死home
        */
//        为了在View模型中 调用make方法拼接模板路径时使用
        echo call_user_func_array([new $className,$arr[2]],[]);
    }



    /*
     * 初始化
     */
    protected static function init(){
//        开启session
        session_id() || session_start();
        /*设置时区
//           PHP所取的时间是格林威治标准时间，所以和你当地的时间会有出入
        格林威治标准时间和北京时间大概差8个小时左右
        所以设置默认时区为北京时间
        */
        date_default_timezone_set('PRC');
        //定义是否POST提交的常量
        define('IS_POST', $_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
    }
}