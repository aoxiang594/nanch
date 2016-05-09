<?php
class model extends db{
	
	function __construct()
	{
		$config = load_file("db");

		parent::__construct($config['default']);
	}
}
?>