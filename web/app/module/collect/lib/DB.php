<?php

final class DB extends _C_Db {
	
	private static $_table;
	
	private static $_connection;
	
	public static function init($connection = 'default')
	{
		if (isset(self::$_connection) && is_resource(self::$_connections[self::$_connection]['link']))
		{
			return true;	
		}
		if (self::connect($connection))
		{
			self::$_connection = $connection;	
			return true;
		}
		return false;	
	}
	
	public static function affectedRows()
	{
		return self::doCall(self::$_connection, 'affectedRows');
	}
	
	public static function count($table, $where=null) 
	{
		return self::doCall (self::$_connection, 'count', $table, array($where) );
	}
	
	public static function truncate($table)
	{
		return self::doCall (self::$_connection, 'truncate', $table);
	}
	
	public static function desc($table) 
	{
		return self::doCall (self::$_connection, 'desc', $table);
	}
	
	public static function insert($table, $data) 
	{
		return self::doCall (self::$_connection, 'insert', $table, array ($data ));
	}
	
	public static function update($table, $data, $where) 
	{
		return self::doCall (self::$_connection, 'update', $table, array ($data, $where ) , true);
	}
	
	public static function delete($table, $where=null, $limit=null) 
	{
		return self::doCall (self::$_connection, 'delete', $table, array ($where, $limit ) , true);
	}
	
	public static function findAll($table, $where, $order, $data, $limit=null, $group=null) 
	{
		return self::doCall (self::$_connection, 'select', $table, array ($data, $where, $order, $limit, $group ) , true);
	}
	
	public static function findOne($table, $where=null, $order=null, $data='*', $group=null) 
	{
		$data = self::doCall (self::$_connection, 'select', $table, array ($data, $where, $order, '1', $group), true);
		if (! empty ( $data ))
			return $data [0];
		return false;
	}
	
	public static function exists($table, $where, $check=false) {
		$result = self::doCall (self::$_connection, 'select', $table, array ('*', $where, null, '1' ), $check );
		return empty ( $result ) ? false : true;
	}
	
	/**
	 * ��ǰҳ��d��ȡ
	 * @param string $table
	 * @param string or array $where
	 * @param string or array $order
	 * @param string $data
	 * @param int $page_size
	 * @param array $info
	 * @return array
	 */
	public static function page($table, $where, $order, $data, $page, $page_size, &$info)
	{
		$records_count = DB::count($table, $where);
		$pages_count = ceil($records_count / $page_size);
		$page = min(max((int)$page, 1), $pages_count);
		$limit = ($page_size * ($page-1)) . ',' . $page_size;
		
		$info = array(
				'page_now' => $page,
				'page_size' => $page_size,
				'records_count' => $records_count,
				'pages_count' => $pages_count,
		);
		
		$infos = array();
		
		if ($records_count > 0)
		{
			$infos = self::doCall (self::$_connection, 'select', $table, array ($data, $where, $order, $limit) , true);;
		}
		
		return $infos;
	}
	
	public static function pages($table, $where, $order, $data, $page, $page_size=10)
	{
		$records_count = DB::count($table, $where);
		$pages_count = ceil($records_count / $page_size);
		$page = min(max((int)$page, 1), $pages_count);
		$limit = ($page_size * ($page-1)) . ',' . $page_size;
		
		$infos = array();
		
		if ($records_count > 0)
		{
			$infos = self::doCall (self::$_connection, 'select', $table, array ($data, $where, $order, $limit) , true);;	
		}
		
		return array(
			'data' => $infos,
			'info' => array(
				'page_now' => $page,
				'page_size' => $page_size,
				'records_count' => $records_count,
				'pages_count' => $pages_count,	
			),
		);
	}	
	
	public static function lastError()
	{
		return self::doCall(self::$_connection, 'lastError');
	}
	
	public static function destroy(){}
	
	
	const ARTICLES = 'articles';
	const FUNNY = 'vi_funny';
	const VISITE  = 'vi_site';
	const COLLECT = 'vi_collect';
	
}

?>