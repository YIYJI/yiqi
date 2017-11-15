<?php
	
	//Model类
	class Model
	{
		//成员属性
		public $tableName;	//存储表名
		public $link;		//存储链接数据库独享
		public $fields;		//存储除主键外的字段信息
		public $pk;			//存储主键信息
		public $field;		//存储查询字段条件
		public $where;		//存储查询条件
		public $order;		//存储排序条件
		public $limit;		//存储分页条件

		//构造方法
		public function __construct($tableName)
		{
			$this->tableName = $tableName;

			//1.连接数据库，并判断
			$link = mysqli_connect(HOST,USER,PASS)or die('数据库链接失败！');
		
			//2.设置字符集
			mysqli_set_charset($link,CHARSET);

			//3.选择数据库
			mysqli_select_db($link,DBNAME);

			//将$link数据库对象存入属性中即可
			$this->link = $link;

			//调用获取所有字段和主键信息的方法
			$this->getAllFields();
		}

		// 获取表中所有字段以及主键信息的方法
		public function getAllFields()
		{
			//获取指定表中的字段信息
			$sql = "desc ".$this->tableName;
			$result = mysqli_query($this->link,$sql);

			//定义存储字段信息的空数组
			$fields = array();
			$pk = '';

			//解析结果集
			while($rows = mysqli_fetch_assoc($result)){
				if($rows['Key']=='PRI'){
					$pk = $rows['Field'];
				}else{
					$fields[] = $rows['Field'];
				}
			}

			//将主键和字段信息存储到属性当中
			$this->pk = $pk;
			$this->fields = $fields;
		}

		//过滤信息的方法
		public function filterData($data)
		{
			//过滤字段信息
			foreach($data as $k=>$v){
				//判断我们所传递的信息的下标是否与表字段相符
				if(!in_array($k,$this->fields) && $k!=$this->pk){
					//判断模式
					if(MODE==1){
						unset($data[$k]);
					}else if(MODE==2){
						die('抱歉，您所传递的数组中包含非法字段！字段名：'.$k);
					}
				}
			}

			//返回过滤后的信息
			return $data;
		}

		//添加方法
		//$data = array('name'=>'张三','sex'=>'w','age'=>20,'job'=>1);
		/*						||
								\/											*/					
		//insert into yihongyuan (name,sex,age,job) values ('张三','w',20,1);
		public function add($data)
		{
			//过滤字段
			$data = $this->filterData($data);

			//获取数组中的下标
			$keys = array_keys($data);

			//拼接字段sql语句
			$keys_sql = implode(',',$keys);

			//获取数组中的值
			$vals = array_values($data);

			//拼接值sql语句
			$vals_sql = "'".implode("','",$vals)."'";

			//4.定义添加的sql语句,并发送执行
			$sql = "insert into ".$this->tableName." (".$keys_sql.") values (".$vals_sql.")";

            $result = mysqli_query($this->link, $sql);

			//5.判断是否添加成功
			if($result!=false && mysqli_affected_rows($this->link)>0){
				return mysqli_insert_id($this->link);
			}else{
				return false;
			}
		}

		//删除方法
		public function delete($id)
		{
			//封装删除的sql语句
			$sql = "delete from ".$this->tableName." where ".$this->pk." = ".$id;
            //var_dump($sql);die;
			$bool = mysqli_query($this->link,$sql);

			//判断是否删除成功
			if($bool!=false && mysqli_affected_rows($this->link)>0){
				return mysqli_affected_rows($this->link);
			}else{
				return false;
			}
		}

		//修改方法
		public function save($data)
		{
			//过滤数组
			$data = $this->filterData($data);

			//定义一个存储修改条件的变量
			$set = "";
			$where = "";

			//判断是否有主键信息array_key_exists()
			if(!array_key_exists($this->pk,$data)){
				echo "<script>alert('您传递的信息当中，没有主键信息！请检查！');window.location.href='{$_SERVER['HTTP_REFERER']}'</script>";
				die;
			}

			//遍历数组
			foreach($data as $k=>$v){
				//判断是不是主键
				if($k!=$this->pk){
					$set .= $k."='".$v."',";
				}else{
					$where = ' where '.$k.'='.$v;
				}
			}

			//去掉修改条件右侧的逗号
			$set = rtrim($set,',');

			//拼装修改的sql语句
			$sql = "update ".$this->tableName." set ".$set.$where;
            //var_dump($sql);die;
			$bool = mysqli_query($this->link,$sql);

			//判断
			if($bool!=false && mysqli_affected_rows($this->link)>0){
				return mysqli_affected_rows($this->link);
			}else{
				return false;
			}
		}

		//查询单条
		public function find($id)
		{
			//拼装查询单挑的sql语句
			$sql = "select * from ".$this->tableName." where ".$this->pk." = ".$id;
			$result = mysqli_query($this->link,$sql);

			//判断
			if($result!=false && mysqli_num_rows($result)>0){
				//解析结果集
				return mysqli_fetch_assoc($result);
			}else{
				return false;
			}
		}

		//查询多条
		public function select()
		{
			//判断是否有字段信息
			$f = "";
			if(!empty($this->field)){
				$f = $this->field;
			}else{
				$f = '*';
			}

			//判断是否有搜索条件
			$w = "";
			if(!empty($this->where)){
				$w = " where ".$this->where;
			}

			//判断是否有排序条件
			$o = "";
			if(!empty($this->order)){
				$o = " order by ".$this->order;
			}

			//判断是否有分页条件
			$l = "";
			if(!empty($this->limit)){
				$l = " limit ".$this->limit;
			}

			//拼装sql语句
			$sql = "select ".$f." from ".$this->tableName." ".$w." ".$o." ".$l;

			$result = mysqli_query($this->link,$sql);

			//判断
			if($result!=false && mysqli_num_rows($result)>0){

				//定义一个存储所有信息的空数组
				$data = array();

				//解析结果集
				while($rows = mysqli_fetch_assoc($result)){
					$data[] = $rows;
				}

				//调用清空条件的方法
				$this->clearCondition();

				return $data;
			}else{
				return false;
			}
		}

		//清空搜索条件的方法
		public function clearCondition()
		{
			//清空查询条件的属性信息
			$this->field = "";
			$this->where = "";
			$this->order = "";
			$this->limit = "";
		}

		//封装字段信息的方法
		public function field($field)
		{
			$this->field = $field;
			return $this;
		}

		// 封装搜索条件的方法
		public function where($where)
		{
			$this->where = $where;
			return $this;
		}

		//封装排序条件的方法
		public function order($order)
		{
			$this->order = $order;
			return $this;
		}

		//封装排序条件的方法
		public function limit($limit)
		{
			$this->limit = $limit;
			return $this;
		}

		//封装统计条数的方法
		public function count()
		{
			//封装sql语句
			$sql = "select count(*) sum from ".$this->tableName;
			$result = mysqli_query($this->link, $sql);

			//判断
			if($result!=false && mysqli_num_rows($result)>0){

				//解析结果集
				return mysqli_fetch_assoc($result)['sum'];
			}else{
				return false;
			}
		}


        //发送原生语句的方法
        public function query($sql)
        {
            //var_dump($sql);
            //按空格拆分sql语句
            $res = explode(' ',$sql)[0];

            //var_dump($sql);
            //判断用户发送了什么语句
            switch($res){
                case "insert":

                    //发送sql语句
                    $bool = mysqli_query($this->link,$sql);

                    //判断
                    if($bool!=false && mysqli_affected_rows($this->link)>0){

                        //返回添加成功数据的id
                        return mysqli_insert_id($this->link);
                    }else{
                        return false;
                    }

                    break;

                case "delete":

                    //发送sql语句
                    $bool = mysqli_query($this->link,$sql);

                    //判断
                    if($bool!=false && mysqli_affected_rows($this->link)>0){

                        //返回添加成功数据的id
                        return mysqli_affected_rows($this->link);
                    }else{
                        return false;
                    }

                    break;

                case "update":

                    //发送sql语句
                    $bool = mysqli_query($this->link,$sql);

                    //判断
                    if($bool!=false && mysqli_affected_rows($this->link)>0){

                        //返回添加成功数据的id
                        return mysqli_affected_rows($this->link);
                    }else{
                        return false;
                    }

                    break;

                case "select":

                    //发送sql语句
                    $result = mysqli_query($this->link,$sql);

                    //定义存储所有信息的变量
                    $data = array();

                    //判断是否查询成功
                    if($result!=false && mysqli_num_rows($result)>0){

                        //解析结果集
                        while($rows = mysqli_fetch_assoc($result)){
                            $data[] = $rows;
                        }

                        //返回结果
                        return $data;
                    }else{
                        return false;
                    }

                    break;
            }
            var_dump($res);
        }

		//析构方法
		public function __destruct()
		{
			//关闭数据库
			mysqli_close($this->link);
		}
	}
