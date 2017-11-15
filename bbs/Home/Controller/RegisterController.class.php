<?php

	//加载注册页的控制器
	class RegisterController
	{
		//加载注册页方法
		public function index()
		{
			require './View/Register/index.html';
		}

		//执行用户注册的功能
		public function doRegister()
		{
			//1.判断用户是否提交了空数据
			if(empty($_POST['userName']) || empty($_POST['password']) || empty($_POST['surepass']) || empty($_POST['email'])){
				echo "<script>alert('不能提交空数据！');window.location.href='./index.php?c=register&a=index'</script>";
				die;
			}

			//2.判断用户输入的两次密码是否一致
			if($_POST['password'] != $_POST['surepass']){
				echo "<script>alert('两次密码不一致！');window.location.href='./index.php?c=register&a=index'</script>";
				die;
			}

			//3.判断该用户是否存在
			$user = new Model('user');
			$res = $user->where("userName='{$_POST['userName']}'")->select();

			//4.执行判断
			if($res){
				echo "<script>alert('用户名已被占用！');window.location.href='./index.php?c=register&a=index'</script>";
				die;
			}

			//5.拼装添加到user表的数组信息
			$userName = $_POST['userName'];
			$password = $_POST['password'];

			//6.放入新数组
			$data = array();
			$data['userName'] = $userName;
			$data['password'] = md5($password);
			$data['lastlogin'] = time();

			//7.执行添加
			$id = $user->add($data);
		
			//判断user表信息是否添加成功
			if($id){

				//8.拼装添加到userdetail表的数组信息
				$email = $_POST['email'];
				$ndata = array();
				$ndata['uid'] = $id;
				$ndata['email'] = $email;

				//9.实例化userdetail表
				$ud = new Model('userdetail');
				$nid = $ud->add($ndata);



				//10.判断userdetail表信息是否添加成功
				if($nid){
                    //记录注册动作
                    $record = new Model('history');
                    $re_data = array(
                        'uid'=>$id,
                        'type'=>2,
                        'ctime'=>time(),
                    );
                    $record->add($re_data);

					echo "<script>alert('用户注册成功！');window.location.href='./index.php?c=login&a=index'</script>";
				}else{
					echo "<script>alert('用户注册失败！');window.location.href='./index.php?c=register&a=index'</script>";
				}

				var_dump($data);
			}else{
				echo "<script>alert('用户注册失败！');window.location.href='./index.php?c=register&a=index'</script>";
				die;
			}
		}
	}