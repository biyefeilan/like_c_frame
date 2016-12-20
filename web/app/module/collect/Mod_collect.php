<?php
class Mod_collect extends Module {
	
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
		
		DB::init();
		
		return TRUE;
	}

	public static function _destroy()
	{
		$_SESSION['PREV_TIME'] = SYS_TIME;
		return TRUE;
	}
	
}

?>