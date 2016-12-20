<?php (defined ( 'APP_PATH' )) || exit ( 'Access deny!' );

final class _C_Config 
{
	private static $_vars = array(
		'_reg' => array(
			'module'	=> array(
				'global' => '_M_',
				'uri'	 => 'm',
			),
			'class' 	=> array(
				'global' => '_C_',
				'uri'	 => 'c',
			),
			'method'	=> array(
				'global' => '_A_',
				'uri'	 => 'a',
			),
			'data'		=> array(
				'global' => '_D_',
				'uri'	 => 'd',
			),
		),
	);
	
	public static function _controller_init()
	{
		if (class_exists('Config', false) && in_array('_controller_init', get_class_methods('Config')))
		{
			return Config::_controller_init();
		}
		return true;
	}
	
	public static function _controller_destory()
	{
		if (class_exists('Config', false) && in_array('_controller_destory', get_class_methods('Config')))
		{
			return Config::_controller_destory();
		}
		return true;
	}
	
	public static function _model_init($class, $method, $data)
	{
		if (class_exists('Config', false) && in_array('_model_init', get_class_methods('Config')))
		{
			return Config::_model_init($class, $method, $data);
		}
		return true;
	}
	
	public static function _model_destroy($class, $method, $data)
	{
		if (class_exists('Config', false) && in_array('_model_destroy', get_class_methods('Config')))
		{
			return Config::_model_destroy($class, $method, $data);
		}
		return true;
	}
	
	public static function _resultDef()
	{
		define('DATA', 		'_C_data');
		define('SUCCESS',   '_C_success');
		define('ERROR', 	'_C_error');
		define('SHOW', 		'_C_show');
		define('SHOW404', 	'_C_show404');
		define('DIRECT', 	'_C_direct');
		define('JUMP', 		'_C_jump');
	}
	
	public static function vars($class)
	{
		if (class_exists('Config', false) && ($tmp = Config::vars($class)) !== NULL )
		{
			return self::$_vars[$class] = $tmp;
		}
		
		return isset(self::$_vars[$class]) ? self::$_vars[$class] : NULL;
	}
}
?>