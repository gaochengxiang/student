<?php
namespace app\admin\controller;
use houdunwang\view\View;
use system\model\User as UserModel;

class User extends Common {
    /**
     * 修改密码
     */
    public function changePassword(){
        if(IS_POST){
            $post = $_POST;
            //1.先比对旧密码是否正确

//            where("uid=" . $_SESSION['user']['uid'])->
            $user = UserModel::get();
//            p($user);
//            p($_SESSION['user']['uid']);exit;
            if(!password_verify($post['oldPassword'],$user[0]['password'])){
                return $this->error('旧密码错误');
            }
            //2.两次密码是否一致
            if($post['newPassword'] != $post['confirmPassword']){
                return $this->error('两次密码不一致');
            }
            //3.修改
            $data = ['password'=>password_hash($post['newPassword'],PASSWORD_DEFAULT)];
            UserModel::where('uid=' . $_SESSION['user']['uid'])->update($data);

            //清除session重新登录
            session_unset();
            session_destroy();

            return $this->setRed('?s=admin/login/index')->success('修改成功');


        }
        return View::make();
    }
}