<?php

	//前台主页控制器
	class IndexController
	{
		//加载前台主页面
		public function index()
		{
            //版块
            $conn = new Model('type');
            $sec = $conn->select();

            //友情连接
            $con_link = new Model('friendlink');
            $links = $con_link->select();
            //引入主页模板
			require "./View/Index/index.html";
		}



	}