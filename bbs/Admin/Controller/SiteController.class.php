<?php

class SiteController{

    public function index(){
        $conn = new  Model('config');
        $conf = $conn->limit(1)->select()[0];
        require "./View/Site/index.html";
    }


    //执行网站配置
    public function doConfig(){
        //获取ID
        $id = $_GET['id'];
        //空数据判断
        if(empty($_POST['webname']) || empty($_POST['keywords']) || empty($_POST['copy'])){
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
                'webname'=>$_POST['webname'],
                'keywords'=>$_POST['keywords'],
                'copy'=>$_POST['copy'],
                'status'=>$_POST['status']
            );
//            var_dump($data);
//            var_dump($_FILES);die;
        }else{
            //没有上传图片
            $data = array(
                'id'=>$id,
                'webname'=>$_POST['webname'],
                'keywords'=>$_POST['keywords'],
                'copy'=>$_POST['copy'],
                'status'=>$_POST['status']
            );
            //var_dump($data);die;
        }

        //修改内容
        $conn = new Model('config');
        $conn->save($data);
        if($conn){
            echo "<script>alert('修改成功');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
            $this->index();
        }else{
            echo "<script>alert('修改失败');window.location.href='{$_SERVER['HTTP_REFERER']}';</script>";
        }
    }
}