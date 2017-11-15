<?php

	class LoginController
	{
		//加载登录页魔板
		public function index()
		{
			//判断用户是否登录
			if(isset($_SESSION['uid'])){
				echo "<script>alert('您已登陆！无需重复登录！');window.location.href='./index.php?c=index&a=index'</script>";
				die;
			}
			require "./View/Login/index.html";
		}

		//执行用户登录的方法
		public function doLogin()
		{
			//获取用户提交信息
			$userName = $_POST['userName'];
			$password = $_POST['password'];

			//实例化表
			$user = new Model('user');

            //判断用户是否被禁用
            $login_info = $user->where("userName="."'".$userName."'")->select()[0];

            if($login_info && $login_info['status']==0){
                echo "<script>alert('该账号已被禁止登陆！');window.location.href='./index.php?c=index&a=index'</script>";
                die;
            }

			//开始判断
			$res = $user->where("userName='{$userName}' && password='".md5($password)."'")->select();

			if($res){
				//将登录成功用户的id存储session
				$_SESSION['uid'] = $res[0]['id'];

                //修改用户最后登录时间
                $user->save(
                    array(
                        'id' => $res[0]['id'],
                        'lastlogin' => time()
                    )
                );

                $record = new Model('history');

                //判断今天是否登录过,没登录过就加积分
                $ud = new Model('userdetail');
                $today = mktime(0,0,0,date('d'),date('m'),date('y'));
                $has = $record->where("uid=".$_SESSION['uid']." and type=1 and ctime>".$today)->select();
                if(!$has){
                    $jifen = $ud->query("update userdetail set score=score+1 where uid=".$_SESSION['uid']);
                }

                //记录登陆动作
                $re_data = array(
                    'uid'=>$_SESSION['uid'],
                    'type'=>1,
                    'ctime'=>time(),
                );
                $record->add($re_data);

				echo "<script>alert('恭喜，登录成功！');window.location.href='./index.php?c=index&a=index'</script>";
			}else{
				echo "<script>alert('抱歉，登录失败！');window.location.href='./index.php?c=login&a=index'</script>";
			}
			//var_dump($_POST);
		}

		//执行用户退出的方法
		public function doLogout()
		{
			//1.销毁session中的uid
			unset($_SESSION['uid']);

			//2.提示用户
			echo "<script>alert('恭喜，退出成功！');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
		}
	}