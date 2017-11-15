<?php

class SectionController{

    public function index(){
        $conn = new Model('type');
        $sec = $conn->query("select *,concat(path,'-',id) as npath from type order by npath;");
        require "./View/Section/main_menu.html";
    }

    //加载添加父版块视图
    public function add(){
        require "./View/Section/section_add.html";
    }


    //执行添加父版块
    public function insert(){
        //空数据判断
        if(empty($_POST['name'])){
            echo "<script>alert('请不要提交空数据！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
            die;
        }
        $name = $_POST['name'];
        $type = new Model('type');
        $id = $type->query("insert into type (name) values ('{$name}')");
        if($id){
            $this->index();
        }else{
            echo "<script>alert('父分区添加失败！');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
        }

    }

    //加载修改父分区视图
    public function editFa(){
        $id = $_GET['id'];
        $conef = new Model('type');
        $fa = $conef->find($id);
        require "./View/Section/editfa.html";
    }


    //执行修改父分区
    public function doEditFa(){
        //空数据判断
        if(empty($_POST['name'])){
            echo "<script>alert('请不要提交空数据！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
            die;
        }
        $id = $_GET['id'];
        $conef2 = new Model('type');
        $res = $conef2->save(
            array(
                'id'=>$id,
                'name'=>$_POST['name'],
                'status'=>$_POST['status']
            )
        );

        if($res){
            $this->index();
        }else{
            echo "<script>alert('修改失败！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
        }

    }


    //执行删除父分区
    public function deleteFa(){
        $id = $_GET['id'];
        $conn = new Model('type');
        $conn->delete($id);

        //判断结果
        if($conn){
            $this->index();
        }else{
            echo "<script>alert('父分区删除失败！');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
        }
     }

    //加载添加子版块的视图
    public function addSon(){

        require "./View/Section/addson.html";

    }


    //执行添加子版块
    public function doAddson(){
        //空数据判断
        if(empty($_POST['name'])){
            echo "<script>alert('请不要提交空数据！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
            die;
        }
        //判断是否上传了图片
        if(!empty($_FILES['blogo']['name'])){

            //执行图片上传
            //实例上传对象
            $upload = new Fileupload();

            //设置基本参数
            $upload->set('path','./Public/upload');
            $upload->set('maxsize',99999999999);

            //执行上传
            $res = $upload->upload('blogo');

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
            $data = array(
                'pid'=>$_GET['pid'],
                'blogo'=>$thumbname,
                'name'=>$_POST['name'],
                'path'=>"0-".$_GET['pid']
            );
        }else{
            //没有上传图片
            $data = array(
                'pid'=>$_GET['pid'],
                'name'=>$_POST['name'],
                'path'=>"0-".$_GET['pid']
            );
        }
        //var_dump($data);

        //写入到数据库
        $conn = new Model('type');
        $conn->add($data);
        if($conn){
            $this->index();
        }else{
            echo "<script>alert('添加失败');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
        }
    }

    //加载修改子版块视图
    public function editSon(){
        $id = $_GET['id'];
        $cones= new Model('type');
        $son = $cones->find($id);
        require "./View/Section/editson.html";
    }

    //执行子版块修改
    public function doEditSon(){
        //空数据判断
        if(empty($_POST['name'])){
            echo "<script>alert('请不要提交空数据！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
            die;
        }
        //判断是否上传了图片
        if(!empty($_FILES['blogo']['name'])){

            //执行图片上传
            //实例上传对象
            $upload = new Fileupload();

            //设置基本参数
            $upload->set('path','./Public/upload');
            $upload->set('maxsize',99999999999);

            //执行上传
            $res = $upload->upload('blogo');

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
            $data = array(
                'id'=>$_GET['id'],
                'blogo'=>$thumbname,
                'name'=>$_POST['name'],
                'status'=>$_POST['status']
            );
            var_dump($_FILES);
        }else{
            //没有上传图片
            $data = array(
                'id'=>$_GET['id'],
                'name'=>$_POST['name'],
                'status'=>$_POST['status']
            );
        }

        //写入到数据库
        $conn = new Model('type');
        $conn->save($data);
        if($conn){
            $this->index();
        }else{
            echo "<script>alert('修改失败');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
        }
    }


    //执行子版块删除
    public function deleteSon(){
        $id = $_GET['id'];
        $zi = new Model('type');
        $res_zi = $zi->delete($id);
        if($res_zi){
            $this->index();
        }else{
            echo "<script>alert('修改失败');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
        }
    }

    //查看子版块中的帖子
    public function topic(){

        $conn = new Model('post');
        $where = "recycle=0 and tid=".$_GET['tid']." ";
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
}