<?php
class Module {
	protected static $module;
	
	protected static $class;
	
	protected static $method;
	
	protected static $data;
	
	public static function getModule()
	{
		return self::$module;
	}
	
	public static function getClass()
	{
		return self::$class;
	}
	
	public static function getMethod()
	{
		return self::$method;
	}
	
	public static function getData()
	{
		return self::$data;
	}
	
	private static $controller;
	public static function controller()
	{
		return self::$controller;
	}
	
	private static $model;
	public static function model()
	{
		return self::$model;
	}
	
	private static $view;
	public static function view()
	{
		return self::$view;
	}
	
	public static function _init()
	{
		self::$module = _C_Router::getModule();
		self::$class = _C_Router::getClass();
		self::$method = _C_Router::getMethod();
		self::$data = _C_Router::getData();
		
		$controller = 'C_'.self::$class;
		
		if (!class_exists($controller, FALSE))
		{
			_C_App::load($controller, 'controller');
		}
		
		if (!class_exists($controller, FALSE))
		{
			View::show404();
			return FALSE;
		}
		
		if (!in_array ( self::$method, array_map ( 'strtolower',  get_class_methods($controller)) ))
		{
			View::show404();
			return FALSE;
		}
		
		self::$controller = new $controller();
		self::$model = self::$controller->model();
		self::$view = self::$controller->view();
		self::$view->template(self::$method);
		return TRUE;
	}
	
	public static function _run()
	{
		$controller = self::$controller;
		
		$methods = get_class_methods($controller);
		
		if (in_array('_init', $methods) && ($data=call_user_func(array($controller, '_init'))!==TRUE))
		{
			self::$controller->view()->error($data);
		}
		
		try {
			$data = call_user_func_array ( array ($controller, self::$method ), self::$data ? explode('/', self::$data) : array());
		} catch (Exception $e) {
			
		}
		
		if (in_array('_destroy', $methods))
		{
			call_user_func_array(array($controller, '_destroy'), array());
		}
		
		return isset($data) ? $data : NULL;
	}
	
	public static function _destroy()
	{
		return TRUE;
	}
}

?>