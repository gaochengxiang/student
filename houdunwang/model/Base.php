<?php
//Base类所在的空间名
namespace houdunwang\model;
//PDO是个系统常量 不能再houdunwang\model这个命名空间下使用
use PDO;
//PDOException是个系统常量 不能再houdunwang\model这个命名空间下使用
use PDOException;
//创建一个base类用来执行连接数据库，查看数据库数据，
//修改数据的一些操作并对应的数据返回给对应的方法中
class Base {
    //保存PDO对象的静态属性
    private static $pdo = null;
    //保存表名属性
    private $table;
    //保存where
    private $where;
   // 当调用BASE类时自动执行这个方法，
    public function __construct($table) {
//    自动执行连接数据库方法
        $this->connect();
        $this->table=$table;
    }

//  连接数据库
    public function connect(){
        //如果pdo属性值为空 证明我们没有链接数据库 所以要执行 if里的代码
        if(is_null(self::$pdo)) {
                //访问c函数 然后访问配置项文件
                $dsn ='mysql:host='.c('database.db_host').';dbname=' .c('database.db_name');
                //使用PDO连接数据库，如果有异常错误，就会被catch捕捉到
                $pdo = new PDO( $dsn, c('database.db_user'), c('database.db_password') );
                //设置错误属性，要设置成异常错误，因为需要被catch捕获
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //exec执行没有结果集的操作,update,delete,insert..
                $pdo->exec("SET NAMES " . c('database.db_charset') );
                self::$pdo = $pdo;
            }

        }

    /**添加
     * @param $post
     * @return mixed
     */
    public function save($post){
 //        查询当前表的结构
//        需要获得表里面的字段$this->arc;
        $tableInfo=$this->q("desc {$this->table}");
//        创建一个空数组
//        用来保存当前的字段
        $tableFields=[];
//        获取当前表的字段
         foreach($tableInfo as $info){
             $tableFields[] = $info['Field'];
        }
//        循环$_POST提交过来的数据
//        因为有的时候会有其他的字段被上传过来，所以需要把不是表里的字段过滤掉，比如验证码字段
//        创建一个变量：用来保存过滤之后的字段--过滤掉其他字段，因为已经获得表里的字段，去除别的字段过滤即可
        $filterData=[];
        foreach($post as $f=>$v){
//            如果属于当前表的字段，那么保留，否则就过滤
            if(in_array($f,$tableFields)){
 //                保存属于当前字段的键值
//                $k是字段，$v是字段的值
                $filterData[$f]=$v;
            }
        }
//             Array
//		  (
//			[title] => 标题,
//			[click] => 100,
//		)

//        字段
//        获得传过来数据的键名
        $filed=array_keys($filterData);

        $filed=implode(',',$filed);

//        获得所有过滤后的值，用于组合sql的时候
        $values=array_values($filterData);
//        把获得的值转为字符，可以直接在sql语句里面调用
        $values='"'.implode('","',$values).'"';
//        组合sql添加语句
//        应为需要添加内容的表会有可能有变化，添加的内用也有可能会变化，所以不能写死
        $sql="INSERT INTO {$this->table} ({$filed}) VALUES ({$values})";
//        返回添加数据后的数据库的数据
        return $this->e($sql);

    }
    /**
     * where条件
     * @param $where
     *
     * @return $this
     */

//    创建方法：定义where条件
    public function where($where){
//        给$this->where属性赋值，把传进来的where条件返给$this->where，这样就能在这个类里面方便的调用where条件了
        $this->where=$where;
//        返回当前的Base这个类
//        需要进行链式操作
        return $this;
    }
    /**
     * 摧毁数据
     */
    public function destory(){
 //        判断：如果没有where条件的时候就终止代码，不在执行以下的代码
//        避免错误的操作把所有的数据删除
        if(!$this->where){
 //            不执行后面的代码，并且输出一个提示给用户
            exit('delete必须有where条件');
        }
//        用一个变量保存删除数据的sql指令，方便传参
        $sql = "DELETE FROM {$this->table} WHERE {$this->where}";
//        把删除的数据的sql指令传参给当前的e方法
//        会自动执行删除一条代码的指令
        return $this->e($sql);
    }

    /**主键
     * @return string
     */
     public function getPrikey(){
//        查询$this->table表的结构，需要获得主键
         $sql="DESC {$this->table}";
//        查询当前表的结构
//        需要获得表里面的字段
         $data=$this->q($sql);
         //获得表的主键
//        创建一个变量，用来存着主键的字段
        $primayKey='';
         //        循环数组，获得数组里面的所有数据，方便调用
         foreach($data as $v){
//            判断，如果数组里的key有PRI这个值，说明是主键
             if($v['Key'] =='PRI'){
 //                把主键的字段返给变量$primaryKey
                 $primayKey = $v['Field'];
                 break;
             }
         }
//        把主键的字段名返回去，方便调用
         return $primayKey;
     }

    public function find($aid){
//         一个变量存着主键的值，方便后面的调用
        $priKey=$this->getPrikey();
//        组合sql命令，查询一条数据
//        select * from stu where sex='男';
        $sql="SELECT * FROM {$this->table} WHERE {$priKey}={$aid}";
//          把sql语句传参给当前的q方法，就会获得想要查询的数据
        $data=$this->q($sql);
//        需要查询的数据默认是一个二维数组，为了更方便的操作，需要转成一维数组
        return current($data);
    }

    /**
     * 修改
     *///    创建方法：用来实现数据的修改功能
    public function update($data){
//        判断，如果没有where条件不会执行后面的代码，并且输出一个提示给用户
        if(!$this->where){
//            不执行下面的代码，并且提示用户一个信息
            exit('update必须有where条件');
        }
//        定义一个空的变量，用于后面保存数据
        $set='';
        foreach($data as $field=>$value){
//            把键名和相对应的键值固执给$set
            $set.="{$field}='{$value}',";
        }
//        去除$set右边的，
         $set=rtrim($set,',');
//        组合sql命令，替换一条数据
        $sql="UPDATE {$this->table} SET {$set} WHERE {$this->where}";
//        把sql语句传参给当前的e方法，就会替换想要替换的数据
        return $this->e($sql);
    }
    /*
         * 获取全部数据
         */
//    创建一个get方法用来获取对应表的所有数据
    public function get(){
//        获取传过来的对应的表的数据，将对应的表添加到获取所有数据的SQL语句中，并通过有结果集的操作完成获取数据，并将获取的数据转换才关联数组返回到对应的对象
        $sql= "SELECT * FROM {$this->table}";
//        通过有结果集的操作执行sql语句完成获取对应表的数据
        $result = self::$pdo->query( $sql );
//        将多去的数据转换成关联数组
        $data= $result->fetchAll(PDO::FETCH_ASSOC);

//        将转好的数据返回给当前的对象
        return $data;
    }

    /**
     * 执行有结果集的操作
     *
     * @param $sql
     */
    public function q( $sql ) {
//            执行从Model 里传来的sql语序
            $result = self::$pdo->query( $sql );
//            获取表中的所有和这个sql相关的语句 再把它返回到 Model
//            再从Model里返回到Entry  再返回到boot里面 让echo输出
            return $result->fetchAll( PDO::FETCH_ASSOC );
            //捕获PDO异常错误 $e 是异常对象

    }

    /**
     * 执行没有结果集的操作
     *
     * @param $sql
     */
    public function e( $sql ) {
//   执行从Model 里传来的sql语序
        $afRows = self::$pdo->exec( $sql );
//     获取表中的所有和这个sql相关的语句 再把它返回到 Model
//     再从Model里返回到Entry  再返回到boot里面 让echo输出
        return $afRows;
        //捕获PDO异常错误 $e 是异常对象
    }
}