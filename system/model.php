<?php
class model extends db{
	public  $db;
	function __construct($table)
	{
		$config = load_file("db");

		parent::__construct($config['default']);
		parent::set_table($table);
		$this->_rconnect($config['default']);
		
	}
}
?>