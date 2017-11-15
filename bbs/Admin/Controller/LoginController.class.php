<?php

/**
 * 用户登录处理
 * 
 * @author jyy 
 * @email ；
 */

class LoginController
{
    //加载登录页的方法
    public function index()
    {
        //判断用户是否登录
        if(isset($_SESSION['id'])){
            echo "<script>alert('抱歉，您已登陆，无需重复登录！');window.location.href='./index.php?c=index&a=index'</script>";
            die;
        }
        require "./View/Login/index.html";
    }

    //加载验证码图片的方法
    public function codeimg()
    {
        //实例化验证码类
        $vcode = new Vcode();

        //生成验证码图像
        $vcode->doimg();

        //获取验证码的数字
        $code = $vcode->getCode();

        //将生成的验证码存储到session中
        $_SESSION['code'] = $code;
    }

    //执行用户登录验证
    public function doLogin()
    {
        //先判断验证码是否一致
        $code = $_POST['code'];

        //获取SESSION中存储的验证码
        if($code!=$_SESSION['code']){
            echo "<script>alert('抱歉，验证码输入不正确！');window.location.href='index.php?c=login&a=index'</script>";
            die;
        }

        //获取账号密码
        $userName = $_POST['userName'];
        $password = $_POST['password'];

        //实例化Model类
        $user = new Model('user');

        //提取用户信息
        $info = $user->where('userName="'.$userName.'"')->select();
        $auth = $info[0]['auth'];

        //查询指定账号密码的用户是否存在
        $res = $user->where('userName="'.$userName.'" && password="'.md5($password).'"')->select();

        //判断权限
        if($auth == 0){

            //没有权限
            echo "<script>alert('你的账户无权登录后台！');window.location.href='./index.php?c=login&a=index'</script>";
            die;
        }else{
            //有权限，在判断用户名和密码是否吻合
            if($res){
                $_SESSION['id'] = $res[0]['id'];
                echo "<script>alert('恭喜，登录成功！');window.location.href='./index.php?c=index&a=index'</script>";
            }else{
                echo "<script>alert('抱歉，用户名或密码错误！');window.location.href='./index.php?c=login&a=index'</script>";
                die;
            }
        }
    }

    /**
     * 退出登录
     *
     * @params int $uid
     */
    public function doLogout($uid = '')
    {
        //检测session
        unset($_SESSION['id']);

        echo "<script>alert('恭喜，退出成功！');window.location.href='./index.php?c=login&a=index'</script>";

    }
}