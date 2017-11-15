<?php

class TopicController{

    //加载帖子列表
    public function index(){

        $conn = new Model('post');
        //$where = "recycle=0";

        //判断是否是搜索
        if(!empty($_REQUEST['title'])){
            $where = " title like '%{$_REQUEST['title']}%' and recycle=0 ";
            $url = "&title={$_REQUEST['title']}";

        }else if(!empty($_GET['title'])){
            //var_dump($_GET['title']);
            $where = " title like '%{$_GET['title']}%' and recycle=0 ";
            $url = "&title={$_GET['title']}";
        }else{
            $where = " recycle=0 ";
            $url="";
        }


        $order = "ctime desc,id desc ";

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
        $topics = $conn->query('select * from post where '.$where." order by ".$order.$limit);


        require "./View/Topic/list.html";
    }


    //将帖子放入回收站
    public function doClosed(){
        $id = $_GET['pid'];
        $conn = new Model('post');
        $conn->save(
            array(
                'id'=>$id,
                'recycle'=>1
            )
        );
        $this->index();
    }


    //将帖子移出回收站
    public function open(){
        $id = $_GET['pid'];
        $conn = new Model('post');
        $conn->save(
            array(
                'id'=>$id,
                'recycle'=>0
            )
        );
        $this->closed();
    }


    //加载回收站页面
    public function closed(){

        $conn = new Model('post');

        //判断是否是搜索
        if(!empty($_REQUEST['title'])){
            $where = " title like '%{$_REQUEST['title']}%' and recycle=1 ";
            $url = "&title={$_REQUEST['title']}";

        }else if(!empty($_GET['title'])){
            //var_dump($_GET['title']);
            $where = " title like '%{$_GET['title']}%' and recycle=1 ";
            $url = "&title={$_GET['title']}";
        }else{
            $where = " recycle=1 ";
            $url="";
        }

        $order = "ctime desc,id desc ";

        //分页程序必备的参数
        $page = isset($_GET['p'])?$_GET['p']:'1';	//当前页码
        $maxRows = 0;	//总条数
        $pageSize = 5;	//每页条数
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
        $topics = $conn->query('select * from post where '.$where." order by ".$order.$limit);


        require "./View/Topic/closed.html";
    }


    //加载帖子修改液
    public function updateTopic(){
        $id = $_GET['pid'];
        $conn = new Model('post');
        $topic = $conn->find($id);

        require "./View/Topic/update.html";
    }

    //执行帖子修改
    public function doUpdate(){
        $id = $_GET['pid'];
        $conn = new Model('post');
        $data = array(
            'id'=>$id,
            'title'=>$_POST['title'],
            'content'=>$_POST['content'],
            'reply'=>$_POST['reply']
        );
        $res = $topic = $conn->save($data);
        if($res){
            $this->index();
        }
    }


    //从回收站删除帖子
    public function deleteFromClosed(){
        $id = $_GET['pid'];
        $conn = new Model('post');
        $conn->delete($id);
        $this->closed();
    }


    //执行帖子加精和取消
    public function elite(){
        $pid = $_GET['id'];
        $elite = $_GET['elite'];
        $conn = new Model('post');

        if($elite==1){
            $res = $conn->save(
                array(
                    'id'=>$pid,
                    'elite'=>0
                )
            );
        }else{
            $res = $conn->save(
                array(
                    'id'=>$pid,
                    'elite'=>1
                )
            );
        }
        if($res){
            $this->index();
        }else{
            echo "<script>alert('修改失败')</script>";
        }
    }


    //执行置顶加精和取消
    public function top(){
        $pid = $_GET['id'];
        $top = $_GET['top'];
        $conn = new Model('post');

        if($top==1){
            $res = $conn->save(
                array(
                    'id'=>$pid,
                    'top'=>0
                )
            );
        }else{
            $res = $conn->save(
                array(
                    'id'=>$pid,
                    'top'=>1
                )
            );
        }
        if($res){
            $this->index();
        }else{
            echo "<script>alert('修改失败')</script>";
        }
    }


    //加载回帖列表
    public function reply(){

        $conn = new Model('reply');
        $order = " ctime desc ";

        //判断是否传入了id
        if(isset($_GET['pid'])){
            $where = " where pid=".$_GET['pid'];
            $url="&pid=".$_GET['pid'];
        }else{
            $where="";
            $url="";
        }
        //分页程序必备的参数
        $page = isset($_GET['p'])?$_GET['p']:'1';	//当前页码
        $maxRows = 0;	//总条数
        $pageSize = 10;	//每页条数
        $maxPage = 0;	//总页数

        //求得总条数
        $maxRows = $conn->query("select count(*) as sum from reply ".$where)[0]['sum'];

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
        $replies = $conn->query('select * from reply '.$where.' order by '.$order.$limit);

        require "./View/Topic/reply.html";
    }

    public function deleteReply(){
        $id = $_GET['id'];
        $conn_dr = new Model('reply');
        $res = $conn_dr->delete($id);

        //判断结果
        if($res){
            $this->reply();
        }else{
            echo "<script>alert('删除失败');window.localcation.href='{$_SERVER['HTTP_REFERER']}';</script>";
        }
    }

}