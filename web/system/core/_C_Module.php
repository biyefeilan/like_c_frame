<?php

final class _C_Module
{
	private static $module;
	
	public static function _init()
	{
		$module = _C_Router::getModule();
		
		_C_App::addPackages(array(
			'module' => array (
				'path' => APP_PATH . DS . 'module' . DS . $module . DS,
				'type' => _C_App::types ( 'class' )
			),
				
			'template' => array (
				'path' => APP_PATH . DS . 'template' . DS . _C_App::style() . DS . $module . DS,
				'type' => _C_App::types( 'template' )
			),
				
			'mvc' => array(
				'path' => SYSTEM_PATH . DS . 'mvc' . DS,
				'type' => _C_App::types( 'class' )
			),
			
			'controller' => array (
				'path' => APP_PATH . DS . 'module' . DS . $module . DS . 'controller' . DS,
				'type' => _C_App::types ( 'class' )
			),
				
			'model' => array (
				'path' => APP_PATH . DS . 'module' . DS . $module . DS . 'model' . DS,
				'type' => _C_App::types ( 'class' )
			),
			
			'view' => array (
				'path' => APP_PATH . DS . 'module' . DS . $module . DS . 'view' . DS,
				'type' => _C_App::types ( 'class' )
			),
			
			'lib' => array (
				'path' => APP_PATH . DS . 'module' . DS . $module . DS . 'lib' . DS,
				'type' => _C_App::types ( 'class' )
			),
		));
		
		$module = 'Mod_'.$module;
		
		_C_App::assert(!class_exists($module, FALSE) && _C_App::load($module, 'module')!==FALSE, 'Module <'._C_Router::getModule().'> not found!');
		
		self::$module = $module;
		
		return call_user_func(array(self::$module, '_init'));
	}
	
	public static function _destroy()
	{
		return call_user_func(array(self::$module, '_destroy'));
	}
	
	public static function _run()
	{
		return call_user_func(array(self::$module, '_run'));
	}
}

?>