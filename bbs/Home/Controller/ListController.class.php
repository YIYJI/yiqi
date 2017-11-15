<?php

	//前台列表页控制器
	class ListController
	{
		//加载列表页面
		public function index()
		{


            //基本信息
            $conn = new Model('post');
//            $conn2 = new Model('post');
            $where = "recycle=0 and tid=".$_GET['tid'];

            //分页程序必备的参数
            $page = isset($_GET['p'])?$_GET['p']:'1';	//当前页码
            $maxRows = 0;	//总条数
            $pageSize = 10;	//每页条数
            $maxPage = 0;	//总页数

            //求得总条数
            $maxRows = $conn->query("select count(*) as sum from post where ".$where)[0]['sum'];

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
            $posts = $conn->query('select * from post where '.$where." order by top desc,ctime desc ".$limit);

            require "./View/List/index.html";

		}

		public function detail($id=null){
            //获取帖子id
            if(!$id){
                $id = $_GET['id'];
            }



            //获取帖子信息
            $conn = new Model('post');
            $conn->query("update post set count=count+1 where id=".$id);
            $post = $conn->find($id);

            if($post['recycle']==1){
                require "./View/Public/404.html";
                die;
            }

            //获取作者信息
            $conn2 = new Model('userdetail');
            $author = $conn2->where('uid='.$post['uid'])->select();
            $author = $author[0];

            //获取回复信息
//            $conn3 = new Model('reply');
//            $replies = $conn3->select();


            //回复的分页信息
            $where = " pid=".$id;
            $page = isset($_GET['p'])?$_GET['p']:'1';	//当前页码
            $maxRows = 0;	//总条数
            $pageSize = 2;	//每页条数
            $maxPage = 0;	//总页数

            //求得总条数
            $maxRows = $conn->query("select count(*) as sum from reply where ".$where)[0]['sum'];

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
            $replies = $conn->query('select * from reply where '.$where." order by ctime asc ".$limit);


            require "./View/Post/detail.html";
        }


        //加载发帖页
        public function add(){

            if(isset($_SESSION['uid'])){
                //获取版块id
                $tid = $_GET['tid'];

                //获取版块信息
                $conn01 = new Model('type');
                $typeinfo = $conn01->find($tid);
                require "./View/Post/add.html";
            }else{
                require "./View/Login/index.html";
            }

        }


        //执行发表帖子
        public function insert(){
            //数据判断
            if(empty($_POST['title']) || empty($_POST['content'])) {
                echo "<script>alert('请不要提交空数据');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
                die;
            }

            //获取提交的数据
            $data=array(
                'tid' => $_GET['tid'],
                'uid' => $_SESSION['uid'],
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'ctime' => time(),
                'reply'=>$_POST['reply']
            );

            //将数据写入数据库
            $conn = new Model('post');
            $res = $conn->add($data);

            //增加用户积分
            $conn03 = new Model('userdetail');
            $userinfo = $conn03->where("uid=".$_SESSION['uid'])->select()[0];
            $res2 = $conn03->query("update userdetail set score=score+20 where id=".$userinfo['id']);

            //判断结果
            if($res && $res2){
                //记录发帖动作
                $record = new Model('history');
                $re_data = array(
                    'uid'=>$_SESSION['uid'],
                    'type'=>3,
                    'ctime'=>time(),
                    'target_id'=>$res,
                    'content'=>$_POST['title']
                );
                $record->add($re_data);

                $this->detail($res);
            }else{
                echo "<script>alert('发帖失败！');window.localtion.href='{$_SERVER['HTTP_REFERER']}'</script>";
            }

        }


        //加载回复页面
        public function reply(){

            //判断用户是否5登录了
            if(!isset($_SESSION['uid'])){
                require "./View/Login/index.html";
                die;
            }
            //获取帖子id
            $pid = $_GET['pid'];

            require "./View/Post/reply.html";
        }


        //执行回复
        public function doReply(){
            //判断数据
            if(empty($_POST['content'])) {
                echo "<script>alert('请不要提交空数据');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
                die;
            }

            $conn02 = new Model('reply');
            //获取之前有几条回复
            $position = $conn02->query("select count(*) as count from reply where pid=".$_GET['pid'])[0]['count'];
            //var_dump($position);die;

            //获取基本信息
            $position = $position+1;
            $data = array(
                'pid' => $_GET['pid'],
                'uid' => $_SESSION['uid'],
                'content' => $_POST['content'],
                'ctime' => time(),
                'position'=> $position
            );

            //写入到数据库

            $res1 = $conn02->add($data);

            //增加用户积分
            $conn03 = new Model('userdetail');
            $userinfo = $conn03->where("uid=".$_SESSION['uid'])->select()[0];
            $res2 = $conn03->query("update userdetail set score=score+5 where id=".$userinfo['id']);

            //判断结果
            if($res1 && $res2){
                //记录回复动作
                $record = new Model('history');
                $re_data = array(
                    'uid'=>$_SESSION['uid'],
                    'type'=>4,
                    'ctime'=>time(),
                    'target_id'=>$_GET['pid'],
                    'content'=>$_POST['content']
                );
                $record->add($re_data);
                echo "<script>alert('回复成功！');</script>";
                $this->detail($_GET['pid']);
            }else{
                echo "<script>alert('回复失败！');window.localtion.href='{$_SERVER['HTTP_REFERER']}'</script>";
            }

        }

        //加载列表页面
        public function search()
        {
//
//
//
//            //查询所有user用户的信息
//            $user = new Model('post');
//
//            //存储搜索信息的数组
//            $whereList = array();
//            $urlList = array();
//
//            //判断是否搜索了姓名信息
//            if(!empty($_REQUEST['userName'])){
//                $whereList[] = " userName like '%{$_REQUEST['userName']}%'";
//                $urlList[] = "userName={$_REQUEST['userName']}";
//            }
//
//            //定义存储搜素语句的变量
//            $where = "";
//            $url = "";
//
//            //判断搜索条件是否存在
//            if(!empty($whereList)){
//                $where = " where ".implode(' && ',$whereList);
//                $url = "&".implode('&',$urlList);
//            }
//
//            //分页程序必备的参数
//            $page = isset($_GET['p'])?$_GET['p']:'1';	//当前页码
//            $maxRows = 0;	//总条数
//            $pageSize = 20;	//每页条数
//            $maxPage = 0;	//总页数
//
//            //总条数
//            $maxRows = $user->query("select count(*) as sum from user".$where)[0]['sum'];
//
//            //总页数
//            $maxPage = ceil($maxRows / $pageSize);
//
//            //限制页码越界
//            if($page > $maxPage){
//                $page = $maxPage;
//            }
//            if($page < 1){
//                $page = 1;
//            }
//
//            //拼装分页语句
//            $limit = '';
//            $limit = ' limit '.(($page-1)*$pageSize).','.$pageSize;
//
//            //发送语句
//            $users = $user->query('select * from user'.$where.$limit);
//
//
////==========================================
            $post = new Model('post');

            //定义存储搜素语句的变量

            if(!empty($_REQUEST['neirong'])){
                $where = " where title like '%{$_REQUEST['neirong']}%' ";
                $url = "&title={$_REQUEST['neirong']}";

            }else{
                    //var_dump($_GET['title']);
                $where = " where title like '%{$_GET['title']}%'";
                $url = "&title={$_GET['title']}";
            }


            //分页程序必备的参数
            $page = isset($_GET['p'])?$_GET['p']:'1';	//当前页码
            $maxRows = 0;	//总条数
            $pageSize = 10;	//每页条数
            $maxPage = 0;	//总页数

            //总条数
            $maxRows = $post->query("select count(*) as sum from post".$where)[0]['sum'];

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

            $posts = $post->query('select * from post'.$where.$limit);


            require "./View/Post/search.html";

        }


	}