<?php

class LinkController{

    //加载友情连接列表页
    public function index(){

        $conn = new Model('friendlink');
        $links = $conn->query("select * from friendlink where status=1 order by ordernum asc");
        require "./View/Link/index.html";
    }




    //加载添加友情链接页
    public function add(){
        require "./View/Link/add.html";
    }

    //执行友链添加
    public function insert()
    {
        //空数据判断
        if(empty($_POST['linkname']) || empty($_POST['content']) || empty($_POST['url']) || empty($_POST['ordernum']) || empty($_POST['status'])){
           echo "<script>alert('请不要提交空数据！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
            die;
        }

        //判断是否上传了图片
        if(!empty($_FILES['logo']['name'])){

            //执行图片上传
            //实例上传对象
            $upload = new Fileupload();

            //设置基本参数
            $upload->set('path','./Public/upload');
            $upload->set('maxsize',99999999999);

            //执行上传
            $res = $upload->upload('logo');

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
                'logo'=>$thumbname,
                'linkname'=>$_POST['linkname'],
                'content'=>$_POST['content'],
                'url'=>$_POST['url'],
                'ordernum'=>$_POST['ordernum'],
                'status'=>$_POST['status']
            );
        }else{
            //没有上传图片
            $data = array(
                'linkname'=>$_POST['linkname'],
                'content'=>$_POST['content'],
                'url'=>$_POST['url'],
                'ordernum'=>$_POST['ordernum'],
                'status'=>$_POST['status']
            );
        }

        //写入到数据库
        $conn = new Model('friendlink');
        $conn->add($data);
        if($conn){
            $this->index();
        }else{
            echo "<script>alert('友情连接添加失败');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
        }
    }


    //加载友链修改视图
    public function edit(){

        $id = $_GET['id'];
        $conn = new Model('friendlink');
        $link = $conn->find($id);
        require "./View/Link/edit.html";
    }


    //执行友链修改
    public function doEdit()
    {
        //获取ID
        $id = $_GET['id'];
        //空数据判断
        if(empty($_POST['linkname']) || empty($_POST['content']) || empty($_POST['url']) || empty($_POST['ordernum']) || empty($_POST['status'])){
            echo "<script>alert('请不要提交空数据！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
            die;
        }

        //判断是否上传了图片
        if(!empty($_FILES['logo']['name'])){

            //执行图片上传
            //实例上传对象
            $upload = new Fileupload();

            //设置基本参数
            $upload->set('path','./Public/upload');
            $upload->set('maxsize',99999999999);

            //执行上传
            $res = $upload->upload('logo');

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
                'id'=>$id,
                'logo'=>$thumbname,
                'linkname'=>$_POST['linkname'],
                'content'=>$_POST['content'],
                'url'=>$_POST['url'],
                'ordernum'=>$_POST['ordernum'],
                'status'=>$_POST['status']
            );
        }else{
            //没有上传图片
            $data = array(
                'id'=>$id,
                'linkname'=>$_POST['linkname'],
                'content'=>$_POST['content'],
                'url'=>$_POST['url'],
                'ordernum'=>$_POST['ordernum'],
                'status'=>$_POST['status']
            );
        }

        //修改内容
        $conn = new Model('friendlink');
        $conn->save($data);
        if($conn){
            $this->index();
        }else{
            echo "<script>alert('友情连接修改失败');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
        }
    }

    public function doDelete(){
        $id = $_GET['id'];
        $conn = new Model('friendlink');
        $res = $conn->delete($id);
        if($res){
            $this->index();
        }else{
            echo "<script>alert('删除失败！');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";

        }
    }



}