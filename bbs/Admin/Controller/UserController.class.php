<?php
	
	//用户控制器
	class UserController
	{
		//加载用户主页
		public function index()
		{

            //查询所有user用户的信息
            $user = new Model('user');

            //存储搜索信息的数组
            $whereList = array();
            $urlList = array();

            //判断是否搜索了姓名信息
            if(!empty($_REQUEST['userName'])){
                $whereList[] = " userName like '%{$_REQUEST['userName']}%'";
                $urlList[] = "userName={$_REQUEST['userName']}";
            }

            //定义存储搜素语句的变量
            $where = "";
            $url = "";

            //判断搜索条件是否存在
            if(!empty($whereList)){
                $where = " where ".implode(' && ',$whereList);
                $url = "&".implode('&',$urlList);
            }

            //分页程序必备的参数
            $page = isset($_GET['p'])?$_GET['p']:'1';	//当前页码
            $maxRows = 0;	//总条数
            $pageSize = 20;	//每页条数
            $maxPage = 0;	//总页数

            //总条数
            $maxRows = $user->query("select count(*) as sum from user".$where)[0]['sum'];

            //总页数
            $maxPage = ceil($maxRows / $pageSize);

            //限制页码越界
            if($page > $maxPage){
                $page = $maxPage;
            }
            if($page < 1){
                $page = 1;
            }

            //拼装分页语句
            $limit = '';
            $limit = ' limit '.(($page-1)*$pageSize).','.$pageSize;

            //发送语句
            $users = $user->query('select * from user'.$where.$limit);

            //权限列表
            $auth = array("普通用户","一般管理员","超级管理员");

            //状态列表
            $status = array('禁用','开启');

            require "./View/User/main_list.html";

		}


		//加载用户列表页
		public function add(){

            require "./View/User/main_info.html";

        }


        //加载用户添加页
        public function insert(){

            //实例化对象并添加user数据
            $conn = new Model('user');
            $re = $conn->add(
                array(
                    'userName' => $_POST['userName'],
                    'password' => md5($_POST['password']),
                    'auth' => $_POST['auth'],
                    'lastlogin' => time()
                )
            );
            ////实例化对象并添加userdetail数据
            $user = new Model('userdetail');
            $re2 = $user->add(
                array(
                    'uid' => $re,
                    'email' => $_POST['email'],
                )
            );

            //判断结果
            if($re && $re2){
                //echo '<script>alert("添加成功！");window.localcation.href="/index.php?c=user&a=index";</script>';
                $this->index();
                echo '<script>alert("添加成功！");</script>';
            }else{
                echo '<script>alert("添加失败！");window.localcation.href="/index.php?c=user&a=add";</script>';
            }
        }


        //加载用户编辑页
        public function edit(){

            $id = $_GET['id'];

            //获取用户基本信息
            $u = new Model('user');
            $user = $u->find($id);

            //获取用户详细信息
            $ud = new Model('userdetail');
            $userdetail = $ud->where('uid='.$id)->select();

            require "./View/User/edit.html";
        }

        //执行用户修改
        public function update(){

            //修改用户基本信息
            $user = new Model('user');
            $userinfo = $user->find($_GET['id']);

            //判断提交的数据是否与原数据相同
            if($userinfo['auth']!=$_POST['auth']){
                //执行修改
                $res1 = $user->save(
                    array(
                        'id'=> $_GET['id'],
                        'auth' => $_POST['auth']
                    )
                );
            }else{
                $res1 = true;
            }

            //通过uid获取detail表中的id
            $ud = new Model('userdetail');
            $uid = $ud -> where('uid='.$_GET['id'])->select();
            $id = $uid[0]['id'];

            //判断提交的数据是否与原数据相同
            if($uid[0]['nickName']==$_POST['nickName'] || $uid[0]['email']==$_POST['email'] || $uid[0]['qq']==$_POST['qq'] || $uid[0]['sex']==$_POST['sex']){
                $ud->save(
                    array(
                        'id' => $id,
                        'nickName' => $_POST['nickName'],
                        'emial' => $_POST['email'],
                        'qq' => $_POST['qq'],
                        'sex' => $_POST['sex']
                    )
                );
                $res2 = true;
            }else{
                //修改用户详细信息
                $res2 = $ud->save(
                    array(
                        'id' => $id,
                        'nickName' => $_POST['nickName'],
                        'emial' => $_POST['email'],
                        'qq' => $_POST['qq'],
                        'sex' => $_POST['sex']
                    )
                );
            }
            //判断结果
            if($res1 && $res2){
                echo "<script>alert('用户修改成功！');</script>";
            }else{
                echo "<script>alert('用户修改失败！');</script>";
            }
            $this->index();

        }


//        //加载用户搜索页
//        public function search(){
//            $search = new Model('user');
//            $re= $search->where("userName='".$_POST['userName']."'")->select();
//            require "./View/User/main_list.html";
//
//        }


        public function delete(){

            $id = $_GET['id'];
            $user = new Model('user');

            //删除user表中的数据
            $res1 = $user->delete($id);

            //根据uid获取userdetail表中的id
            $userdetail = new Model('userdetail');
            $user2 = $userdetail->where('uid='.$id)->select();
            $id = $user2[0]['id'];

            //删除userdetail表中的数据
            $res2 = $userdetail->delete($id);

            //判断结果
            if($res1 && $res2){
                echo "<script>alert('删除用户成功！');</script>";
            }else{
                echo "<script>alert('删除用户失败！');</script>";
            }

            //返回用户列表页
            $this->index();
        }


        //更改用户状态 [开启or禁用]
        public function status(){

            //获取用户ID
            $id = $_GET['id'];

            //获取用户信息
            $user = new Model('user');
            $userinfo = $user->find($id);

            //执行状态的修改
            if($userinfo['status']==1){
                $res = $user->save(
                    array(
                        'id' => $id,
                        'status' => 0
                    )
                );
            }else{
                $res = $user->save(
                    array(
                        'id' => $id,
                        'status' => 1
                    )
                );
            }

//            //判断结果
//            if($res){
//                echo "<script>alert('用户状态修改成功！')</script>";
//                //require './View/User/main_list.html';
//            }else{
//                echo "<script>alert('用户状态修改失败！')</script>";
//
//            }

            //返回用户列表页
            $this->index();

        }

    //重置用户密码
    public function resetPsw(){

        //获取用户id
        $id = $_GET['id'];

        //实例化并获取用户信息
        $conn = new Model('user');
        $info = $conn->find($id);

        //判断密码是否为123456
        if(md5(123456)==$info['password']) {
            echo "<script>alert('密码重置成功！新密码为123456')</script>";
            $this->index();
            die();
        }

        //执行密码重置
        $res = $conn->save(
            array(
                'id' =>$id,
                'password' => md5(123456)
            )
        );
        //判断结果
        if($res){
            echo "<script>alert('密码重置成功！新密码为123456')</script>";
        }else{
            echo "<script>alert('密码重置失败！')</script>";
        }
        $this->index();

    }

    public function main(){
        require "./View/Index/main.html";
    }


    //加载用户操作视图
    public function record(){

        $conn = new Model('history');
        $order = "ctime desc";

        //分页程序必备的参数
        $page = isset($_GET['p'])?$_GET['p']:'1';	//当前页码
        $maxRows = 0;	//总条数
        $pageSize = 10;	//每页条数
        $maxPage = 0;	//总页数

        //求得总条数
        $maxRows = $conn->query("select count(*) as sum from history")[0]['sum'];

        //求得总页数
        $maxPage = ceil($maxRows / $pageSize);

        //限制页码越界
        if($page > $maxPage){
            $page = $maxPage;
        }
        if($page < 1){
            $page = 1;
        }

        //拼装分页语句
        $limit = '';
        $limit = ' limit '.(($page-1)*$pageSize).','.$pageSize;

        //发送语句
        $records = $conn->query('select * from history order by '.$order.$limit);

        require "./View/Index/record.html";
    }


	}