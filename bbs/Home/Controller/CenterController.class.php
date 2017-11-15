<?php

	//个人中心控制器
	class CenterController
	{
		//加载个人中心主页
		public function index()
		{
			if(isset($_SESSION['uid'])){
                //查询当前登录这的信息
                $ud = new Model('userdetail');
                $res = $ud->where("uid={$_SESSION['uid']}")->select();
                require "./View/Center/index.html";
            }else{
                require "./View/Login/index.html";
            }


		}

		//执行用户信息修改的方法
		public function update()
		{
			//获取修改的信息
			$data = $_POST;

			//实例化userdetail表
			$ud = new Model('userdetail');
			$res = $ud->where('uid='.$_SESSION['uid'])->select();

			//获取登陆者id
			$data['id'] = $res[0]['id'];

			//执行修改
			$res1 = $ud->save($data);

			//判断
			if($res1){
				echo "<script>alert('恭喜，修改成功！');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
			}else{
				echo "<script>alert('抱歉，修改失败！');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
				die;
			}
		}



		//加载修改头像页
        public function photo()
        {
            //查询当前登录这的信息
            $ud = new Model('userdetail');
            $res = $ud->where("uid={$_SESSION['uid']}")->select();
            require "./View/Center/photo.html";
        }

        //执行头像修改
        public function doPhoto()
        {
//            //判断是否提交
//            if(empty($_FILES['photo']['name'])){
//                echo "<script>alert('请先选择一张图片');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
//                die;
//            }
            //实例上传对象
            $upload = new Fileupload();

            //设置基本参数
            $upload->set('path','./Public/upload');
            $upload->set('maxsize',99999999999);

            //执行上传
            $res = $upload->upload('photo');

            //判断是否上传成功
            if(!$res){
                $er = $upload->getErrorMsg();
                echo $er;
                die;
            }

            //获取上传后的文件名称
            $filename = $upload->getFileName();

            //实例化缩略对象
            $thumb = new Image('./Public/upload');

            //执行缩略，并获取缩略后的文件名称
            $thumbname = $thumb->thumb($filename,100,100,'th_');

            //判断是否缩略成功
            if(!$thumbname){
                echo "<script>alert('头像缩略时发生错误！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
                die;
            }

            //修改数据库中原图的名称为新图
            $pic = new Model('userdetail');
            $data = $pic->where('uid='.$_SESSION['uid'])->select();
            $data[0]['photo'] = $thumbname;
            $res2 = $pic->save($data[0]);

            //判断所有操作的结果
            if(!$res && $thumb && $res2){
                echo "<script>alert('头像上传失败！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
            }else{
                echo "<script>alert('头像上传成功！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
            }
        }

        //加载密码修改页面
        public function psw(){
            if(isset($_SESSION['uid'])){
                //查询当前登录这的信息
                $ud = new Model('userdetail');
                $res = $ud->where("uid={$_SESSION['uid']}")->select();
                require "./View/Center/psw.html";
            }else{
                require "./View/Login/index.html";
            }

        }


        //执行密码修改
        public function doPsw(){

            //数据判断
            if(empty($_POST['psw']) || empty($_POST['confirm']) || empty($_POST['pre_psw'])) {
                echo "<script>alert('请不要提交空数据');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
                die;
            }

            if($_POST['psw']!=$_POST['confirm']){
                echo "<script>alert('两次密码不一致');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
                die;
            }
            $con1 = new Model('user');
            $pre = $con1->find($_SESSION['uid'])['password'];

            if(md5($_POST['pre_psw'])!=$pre){
                echo "<script>alert('原密码错误');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
                die;
            }

            $data = array(
                'id'=>$_SESSION['uid'],
                'password'=>md5($_POST['psw'])
            );

            $res = $con1->save($data);

            //
            if($res){
                echo "<script>alert('密码修改成功！');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
            }else{
                echo "<script>alert('密码修改失败');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
            }
        }
	}