<?php

final class _C_Db {
	
	public static $_connections;
	
	public static function connect($connection) {
		
		$self_config = _C_Config::vars('_C_Db');
		
		if (!isset($self_config[$connection]))
			return false;
		
		$config = $self_config[$connection];
		
		self::$_connections [$connection] ['driver'] = isset ( $config ['driver'] ) ? $config ['driver'] : 'Mysql';
		
		if (!class_exists ( self::$_connections [$connection] ['driver'] ))
			return false;
		
		self::$_connections [$connection] ['link'] = call_user_func_array ( array (self::$_connections [$connection] ['driver'], 'init' ), array ('config' => $config ) );
		
		return is_resource(self::$_connections [$connection] ['link']);
	}
	
	public static function doCall($connection, $func, $table=null, $param_arr = array(), $check=false) 
	{
		$param[0] = self::$_connections [$connection] ['link'];
		if ($table !== null) 
		{
			$param[1] = $table;
		}
		$param_arr = array_merge ( $param, $param_arr );
		return call_user_func_array ( array (self::$_connections [$connection] ['driver'], $func ), $param_arr );
	}
}

?>