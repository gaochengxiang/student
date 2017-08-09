<?php
//打印函数
function p($var){
//    给输出函数加样式这样看的更韩侃
    echo '<pre style="background: #eeeeee;padding: 5px">';
//    打印查看的数据内容
    print_r($var);
//    结束输出样式标签
    echo '</pre>';
}

/**
 * @param $path
 * 用c函数调用数据库
 */
function c($path){
//    将调用函数C时传过来的参数转换为数组，完成引入存在数据库参数的文件的操作，并将对应的参数返回给调用的对象
    $arr=explode('.',$path);
//    引入数据库参数所在的文件，并将文件内容复制给$config，
    $config = include '../system/config/' . $arr[0] . '.php';
//    判断返回的数组对应的键值存不存在，如果存在就直接使用，如果不存在就默认为NULL
    return isset($config[$arr[1]]) ? $config[$arr[1]] : NULL;
}

function go($ulr){
    header('Logion:'.$ulr);
    die;
}


