<?php
/**
 * 底层DB Operation
 */
//数据库表中id，全部以  table_id为标准，
class db{
	public $sql = null;

	protected $_config = array();

	protected $rdb = null;

	protected $wdb = null;

	protected $table = null;//完整的表名

	protected $simple_table = null;//简略表名，去除前缀后

	protected $primary_id = null;//表的主键，id，标准为table_id

	protected $field = array();//表字段，最后要用缓存

	protected $prefix = null;
	public function __construct(array $config)
	{

		if(!isset($config['dbname']) || !isset($config['write']))
		{
			error_msg("Database Config Error","","error");
		}

		$this->_config = $config;
		$this->prefix = $this->_config['prefix'];
	}

	// 建立PDO连接
	protected function _connect($config){

		if(!isset($config['dbhost']) || !isset($config['username']) || !isset($config['password']))
		{
			error_msg("Database Config Error","","error");
		}
		$driver_options = array();
		if(isset($this->_config['charset']))
		{
			$driver_options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES '.$this->_config['charset'];
		}
		$dsn = 'mysql:'.'host='.$config['dbhost'].';dbname='.$this->_config['dbname'];
		if(isset($config['port']))
		{
			$dsn .=  ';port=' . $config['port'];
		}
		$db = new PDO($dsn,$config['username'],$config['password'],$driver_options);
		//Notice:还需要增加判断是否连接成功
		
		//取得表字段
		$this->get_field($db);
		return $db;
	}
	//读
	protected function _rconnect()
	{
		if($this->rdb)
		{
			return $this->rdb;
		}
		if(!isset($this->_config['read']))
		{
			$this->rdb = $this->_wconnect();
		}else{
			$this->rdb = $this->_connect($this->_config['read']);
		}
		return $this->rdb;
	}


	//写
	protected function _wconnect()
	{
		if($this->wdb)
		{
			return $this->wdb;
		}
		if(!isset($this->_config['write']))
		{
			$this->wdb = $this->_rconnect();
		}else{
			$this->wdb = $this->_connect($this->_config['write']);
		}

		return $this->wdb;
	}

	public function closeDb(){
		$this->rdb = $this->wdb = null;
	}

	protected function set_table($table_name = "")
	{
		$this->table = $this->prefix.$table_name;
		$this->simple_table = $table_name;
		$this->primary_id = $table_name."_id";
		
	}

	

	/**
	 * [query 读操作]
	 * @param  string $sql [description]
	 * @return [type]      [description]
	 */
	public function query($sql = "")
	{
		if(!empty($sql))
		{
			$this->sql = $sql;
		}
		$statement = $this->rdb->query($this->sql);
		if($statement == false)
		{
			
			rr($this->rdb->errorInfo());
			return false;
		}else
		{
			return $statement;
		}
		
		
	}


	/**
	 * [getOne 获取表中某个字段]
	 * @param  string  $where [description]
	 * @param  string  $field [description]
	 * @param  string  $order [description]
	 * @param  integer $limit [description]
	 * @return [type]         [description]
	 */
	public function getOne($where = false,$field = false,$order = false,$limit = 1)
	{
		if(!$field)
		{
			$field = $this->primary_id;
		}
		$this->create_sql($where,$field,$order,$limit);
		$statement = $this->query();
		$data = $statement->fetch(PDO::FETCH_ASSOC);
		return $data[$field];
	}

	/**
	 * [getRow 获取一行数据]
	 * @param  boolean $where [description]
	 * @param  boolean $field [默认取表中所有字段]
	 * @param  boolean $order [description]
	 * @param  integer $limit [description]
	 * @return [type]         [description]
	 */
	public function getRow($where = false,$field = false,$order = false,$limit = 1)
	{
		if(!$field)
		{
			$field = implode(",",$this->field);
		}
		$this->create_sql($where,$field,$order,$limit);
		$statement = $this->query();
		$data = $statement->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	/**
	 * [getAll 获取所有数据]
	 * @param  boolean $where [description]
	 * @param  boolean $field [默认取表中所有字段]
	 * @param  boolean $order [description]
	 * @param  integer $limit [默认取出所有数据]
	 * @return [type]         [description]
	 */
	public function getAll($where = false,$field = false,$order = false,$limit = false)
	{
		if(!$field)
		{
			$field = implode(",",$this->field);
		}
		$this->create_sql($where,$field,$order,$limit);
		$statement = $this->query();
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $data;
	}
	public function create_sql($where = false,$field = false,$order = false,$limit)
	{


		$this->check_field($field);
		if($where)
		{
			$where = " where 1 AND ".$where;
		}
		if($order)
		{
			$order = " ORDER BY ".$order;
		}else
		{
			$order = " ORDER BY ".$this->primary_id." ASC ";
		}
		if($limit)
		{
			$limit = " limit ".$limit;
		}
		$this->sql =  "SELECT ".$field." FROM ".$this->table.$where.$order.$limit;
		
	}
	/**
	 * [check_field 检查是否存在改field]
	 * @param  string $field [field列表，string,]
	 * ]		 [如果存在  不在数据库字段列表中的field  直接die]
	 */
	public function check_field($field = "")
	{
		$field = explode(",",$field);
		$error_field = "";
		if(is_array($field))
		{
			$error_field = array_diff($field,$this->field);
			
			//Notice:这里的错误处理最后可能要再优化，不能直接die
			try{
				if(!empty($error_field))
				{
					$error_field = implode(",",$error_field);
					throw new Exception($error_field."不存在与数据库表字段中");
				}
			}catch(Exception $e)
			{
				echo $e->getMessage();
			}
				
				
			
		}
		return true;
	}

	/**
	 * [get_field 获取表field]
	 * @return [type] [description]
	 */
	public function get_field($db)
	{
		//Notice:这个地方最后应该要用缓存区保存数据，文件缓存之类
		$statement = $db->query("DESC ".$this->table);
		$result = $statement->fetchAll();

		foreach($result as $key=>$val)
		{
			$this->field[] = $val['Field'];
		}
		
	}
	
}

?>