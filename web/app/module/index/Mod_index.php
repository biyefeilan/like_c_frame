<?php
class Mod_index extends Module {
	
	public static function _init()
	{	
		session_start();
		
		define('SYS_TIME', time());
		
		if (!isset($_SESSION['PREV_TIME']))
		{
			$_SESSION['PREV_TIME'] = SYS_TIME;
		}
			
		define('PREV_TIME', $_SESSION['PREV_TIME']);
		
		if (!parent::_init())
		{
			return FALSE;
		}
		
		if ((self::$class=='user' && !in_array(self::$method, array('login', 'register'))) || strpos(self::$method, 'user')===0)
		{
			if (!self::controller()->model('user')->isLogined())
			{
				self::controller()->view()->error('please login first!');
				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	public static function _destroy()
	{
		$_SESSION['PREV_TIME'] = SYS_TIME;
		return parent::_destroy();
	}
	
}

?>