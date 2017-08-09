<?php
namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\view\View;
use Gregwar\Captcha\CaptchaBuilder;
use system\model\User;
class Login extends Controller {
    /**首页
     * @return mixed
     */
    public function index(){
//       存入账号和密码
        $password= password_hash('admin',PASSWORD_DEFAULT);
        echo $password;
        if(IS_POST){
            $post = $_POST;

//          验证码：如果用户提交的验证码不等于$_session里面的验证码那么就返回
            if(strtolower($post['captcha']) != $_SESSION['captcha']){
//               返回验证码错误
                return $this->error('验证码错误');
            }
//            用户名
            $data = User::where( "username='{$post['username']}'" )->get();
            if ( ! $data ) {
                return $this->error( '用户名不存在' );
            }
//          判断如果用户提交的密码和和数据库里面的哈希值进行比对如果不等于就返回密码错误
            if(!password_verify($post['password'],$data[0]['password'])){
                return $this->error('密码错误');
            }
//           七天免登陆
            if(isset($_POST['auto'])){
                setcookie(session_id(),session_name(),time()+7 * 24 *3600,'/' );
            }else{
                setcookie(session_id(),session_name(),0,'/');
            }
//            Array
//            (
//                [captcha] => c2b
//                [user] => Array
//            (
//                [uid] => 1
//                [username] => admin
//                )
//
//            )
//            把用户名和密码存到session里面
            $_SESSION['user'] = [
                'uid'      => $data[0]['uid'],
                'username' => $data[0]['username'],
            ];
//            p($_SESSION);
            return $this->setRed( '?s=admin/entry/index' )->success( '登陆成功' );

        }
        return View::make();
    }

    /**
     * 获取验证码
     */
    public function captcha(){
        $str = substr(md5(microtime(true)),0,3);
        $builder = new CaptchaBuilder($str);
        $builder->build();
        header('Content-type: image/jpeg');
        $builder->output();
        $_SESSION['captcha'] = strtolower($builder->getPhrase());
    }
//    退出
    public function out(){
//        删除session
        session_unset();
        session_destroy();
        return $this->setRed('?s=admin/login/index')->success('退出成功');
    }
}