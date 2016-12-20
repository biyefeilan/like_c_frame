<?php

class Model {
	
	private $_connection='';
	private $_table='';
	private $_funcs = array('insertId', 'affectedRows', 'count', 'truncate', 'desc', 'insert', 'update', 'delete', 'select', 'findOne', 'fields', 'hasError', 'lastError');
	private $_message = array();
	
	public function __construct($table, $connection='default')
	{
		if (!isset(_C_Db::$_connections[$connection]) || !is_resource(_C_Db::$_connections[$connection]['link']))
		{
			_C_App::assert(_C_Db::connect($connection), 'connect datebase error');
		}
		$this->_table = $table;
		$this->_connection = $connection;
	}
	
	public function appendMessage($message)
	{
		$this->_message[] = $message;
	}
	
	public function setMessage($message)
	{
		$this->_message[0] = $message;
	}
	
	public function emptyMessage()
	{
		return empty($this->_message);
	}
	
	public function getMessage()
	{
		return implode('', $this->_message);
	}
	
	public function halt($msg='')
	{
		exit($msg.$this->lastError());
	}
	
	private function _callMethodExists($method, &$args)
	{
		if (method_exists($this, $method))
		{
			$params = array();
			foreach ($args as $i=>$arg)
			{
				$params[$i] = &$args[$i];
			}
			if (!call_user_func_array(array($this, $method), $params))
			{
				return FALSE;
			}
		}
		return TRUE;
	}
	
	public function __call($func, $args)
	{
		_C_App::assert(in_array($func, $this->_funcs), 'Method <'.$func.'> not found!');
		if ($this->_callMethodExists('before_'.$func, $args) === FALSE)
		{
			return FALSE;
		}
		$result = _C_Db::doCall($this->_connection, $func, $this->_table, $args);
		return $this->_callMethodExists('after_'.$func, $result) === FALSE ? FALSE : $result;
	}
	
	public function before_insert(&$data)
	{
		$this->filterData($data);
		return TRUE;
	}
	
// 	//we dont need now
// 	public function after_insert($result)
// 	{
// 		return $result;
// 	}
	
	public function before_update(&$data, &$where)
	{
		$this->filterData($data);
		return TRUE;
	}
	
	public function filterData(&$data)
	{
		if (is_array($data))
		{
			$data = array_intersect_key($data, $this->fields());
		}
	}

	public function pages($where, $order, $data, $page, $page_size=10)
	{
		$records_count = $this->count($where);
		$pages_count = (int)ceil($records_count / $page_size);
		$page = min(max((int)$page, 1), $pages_count);
		$limit = ($page_size * ($page-1)) . ',' . $page_size;
		
		$rows = array();
		
		if ($records_count > 0)
		{
			$rows = $this->select($data, $where, $order, $limit);	
		}
		
		return array(
			'rows' => $rows,
			'page' => array(
				'current' => $page,
				'size' => $page_size,
				'record' => $records_count,
				'count' => $pages_count,	
			),
		);
	}	
}

?>