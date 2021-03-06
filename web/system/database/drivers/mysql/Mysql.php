<?php

class Mysql {
	private static $escape_char = '`';
	
	public static function init($config) {
		_C_App::assert ( isset ( $config ['database'] ), 'database must config' );
		$server = ! isset ( $config ['hostname'] ) ? 'localhost' : (is_numeric ( $config ['hostport'] ) ? $config ['hostname'] . ':' . $config ['hostport'] : $config ['hostname']);
		$username = isset ( $config ['username'] ) ? $config ['username'] : '';
		$password = isset ( $config ['password'] ) ? $config ['password'] : '';
		$database = $config ['database'];
		
		if (isset ( $config ['pconnect'] ) && $config ['pconnect'] === true) {
			$link = mysql_pconnect ( $server, $username, $password );
		} else {
			$link = mysql_connect ( $server, $username, $password, true );
		}
		
		_C_App::assert ( is_resource ( $link ), 'Database config error' );
		
		_C_App::assert ( mysql_select_db ( $database, $link ), 'Cant select db');
		
		$charset = isset ( $config ['charset'] ) ? $config ['charset'] : 'utf8';
		
		if (function_exists ( 'mysql_set_charset' )) {
			mysql_set_charset ( $charset, $link );
		} else {
			$charset_sql = 'SET NAMES ' . self::escapeString ( $charset, $link ) . (empty ( $config ['collate'] ) ? '' : ' COLLATE ' . self::escapeString ( $config ['collate'], $link ));
			mysql_query ( $charset_sql );
		}
		
		return $link;
	}
	
	public static function exec($link, $sql) {
		return mysql_query ( $sql, $link );
	}
	
	public static function truncate($link, $table){
		return self::exec($link, 'TRUNCATE TABLE '.self::$escape_char .$table . self::$escape_char);
	}
	
	public static function insertId($link) {
		return mysql_insert_id ( $link );
	}
	
	public static function count($link, $table, $where=null) {
		$where = is_null ( $where ) ? '' : ' WHERE ' . (is_array ( $where ) ? self::getSqlEqualStr ( $where, ' and ' ) : $where);
		$sql = 'SELECT COUNT(*) FROM ' . $table . $where;
		$r = self::exec ( $link, $sql );
		if (! is_resource ( $r ) && ! is_object ( $r ))
			return 0;
		$row = mysql_fetch_row ( $r );
		return $row [0];
	}
	
	public static function desc($link, $table) {
		$sql = 'DESC ' . $table;
		$results = array ();
		$res = self::exec ( $link, $sql );
		if (is_resource ( $res ) || is_object ( $res )) {
			while ( ($row = mysql_fetch_array ( $res, MYSQL_ASSOC )) !== false ) {
				$results [] = $row;
			}
		}
		return $results;
	}
	
	/**
	 * 
	 * @param string $table
	 * @param array $data
	 * @param resource $link
	 * @return bool
	 */
	public static function insert($link, $table, $data) {
		$fields = '';
		$values = '';
		foreach ( $data as $field => $value ) {
			$fields .= self::$escape_char . $field . self::$escape_char . ',';
			$values .= '\'' . self::escapeString ( $value ) . '\',';
		}
		$sql = 'INSERT INTO ' . self::$escape_char . $table . self::$escape_char . ' (' . substr ( $fields, 0, - 1 ) . ')VALUES(' . substr ( $values, 0, - 1 ) . ')';
		return self::exec ( $link, $sql );
	}
	
	private static function getSqlEqualStr($arr, $sp = ',') {
		if (! is_array ( $arr ) || count ( $arr ) < 1)
			return '';
		$str = '';
		foreach ( $arr as $k => $v ) {
			$str .= self::$escape_char . $k . self::$escape_char . '=\'' . self::escapeString ( $v ) . '\'' . $sp;
		}
		return substr ( $str, 0, strlen ( $str ) - strlen ( $sp ) );
	}
	
	public static function affectedRows($link) {
		return mysql_affected_rows ( $link );
	}
	
	public static function update($link, $table, $data, $where = null) {
		$where = is_null ( $where ) ? '' : ' WHERE ' . (is_array ( $where ) ? self::getSqlEqualStr ( $where, ' and ' ) : $where);
		$sql = 'UPDATE ' . self::$escape_char . $table . self::$escape_char . ' SET ' . (is_array($data) ? self::getSqlEqualStr ( $data ) : $data) . $where;
		return self::exec ( $link, $sql );
	}
	
	public static function delete($link, $table, $where = null, $limit = null) {
		$where = is_null ( $where ) ? '' : ' WHERE ' . (is_array ( $where ) ? self::getSqlEqualStr ( $where, ' and ' ) : $where);
		$limit = is_null ( $limit ) ? '' : ' LIMIT ' . $limit;
		$sql = 'DELETE FROM ' . self::$escape_char . $table . self::$escape_char . $where . ' ' . $limit;
		return self::exec ( $link, $sql );
	}
	
	private static function getOrderSQL($arr){
		foreach ($arr as $k=>$v){
			$sqls[] = self::$escape_char . $k . self::$escape_char . ' ' . $v;
		}
		return implode(',', $sqls);
	}
	
	/**
	 * 查询
	 * @param string $sql
	 * @param resource $link
	 * @return array
	 */
	public static function select($link, $table, $data = '*', $where = null, $order = null, $limit = null, $group=null) {
		$where = is_null ( $where ) ? '' : ' WHERE ' . (is_array ( $where ) ? self::getSqlEqualStr ( $where, ' and ' ) : $where);
		$limit = is_null ( $limit ) ? '' : ' LIMIT ' . $limit;
		$data = is_array($data) ? (self::$escape_char.implode(self::$escape_char.','.self::$escape_char,$data).self::$escape_char) : $data;
		$order = is_null ( $order ) ? '' : ' ORDER BY ' . (is_array ( $order ) ? self::getOrderSQL ( $order ) : $order);
		$group = is_null ( $group ) ? '' : ' GROUP BY ' . (is_array ( $group ) ? self::$escape_char.implode ( self::$escape_char.','.self::$escape_char, $group ).self::$escape_char : $group);
		$sql = 'SELECT ' . $data . ' FROM ' . self::$escape_char . $table . self::$escape_char . $where . ' ' . $group . ' ' . $order . ' ' . $limit;
		$results = array ();
		$res = self::exec ( $link, $sql );
		if (is_object ( $res ) || is_resource ( $res )) {
			while ( ($row = mysql_fetch_array ( $res, MYSQL_ASSOC )) !== false ) {
				$results [] = $row;
			}
		}
		return $results;
	}
	
	public static function findOne($link, $table, $data='*', $where=NULL , $order=NULL, $group=NULL)
	{
		$data = self::select($link, $table, $data, $where, $order, 1, $group);
		if (! empty ( $data ))
			return $data [0];
		return FALSE;
	}
	
	private static function escapeString($str, $link = null) {
		if (is_array ( $str )) {
			foreach ( $str as $key => $val ) {
				$str [$key] = self::escapeString ( $val, $link );
			}
			
			return $str;
		}
		
		if (function_exists ( 'mysql_real_escape_string' ) && is_resource ( $link )) {
			$str = mysql_real_escape_string ( $str, $link );
		} else if (function_exists ( 'mysql_escape_string' )) {
			$str = mysql_escape_string ( $str );
		} else {
			$str = addslashes ( $str );
		}
		
		return $str;
	}
	
	public static function fields($link, $table) 
	{
		static $fields_info;
		if (!isset($fields_info[(string)$link][$table]))
		{
			$table_info = self::desc($link, $table);
			$fields_info[(string)$link][$table] = array();
			foreach ( $table_info as $info )
			{
				$fields_info[(string)$link][$table][$info ['Field']] = isset($info['Default']) ? (string)$info['Default'] : FALSE;
			}
		}
		return $fields_info[(string)$link][$table];
	}
	
	public static function hasError($link)
	{
		return mysql_errno($link) != 0;
	}
	
	public static function lastError($link)
	{
		return 'MYSQL ERROR('.mysql_errno($link).'): ' . mysql_error();
	}
}

?>