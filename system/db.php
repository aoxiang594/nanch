<?php
class db{
	protected $_config = array();

	protected $_rdb = null;

	protected $_wdb = null;

	public function __construct(array $config)
	{
		
		if(!isset($config['dbname']) || !isset($config['write']))
		{
			error_msg("Database Config Error","","error");
		}
		$this->_config = $config;
	}

	public function closeDb(){
		$this->_rdb = $this->_wdb = null;
	}
}

?>