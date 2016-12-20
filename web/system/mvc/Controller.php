<?php

class Controller {
	
	private $objects=array();
	
	private $name;
	
	public function __construct()
	{
		$this->name = Module::getClass();
	}
	
	public function &load($class, $package)
	{	
		if (!isset($this->objects[$class]) || !is_object($this->objects[$class]))
		{
			_C_App::assert(_C_App::load($class, $package)!==FALSE, $package .'.'.$class.' not found!');
		
			$this->objects[$class] = new $class();
		}
		
		return $this->objects[$class];
	}
	
	public function &model($name='')
	{ 
		if (!$name)
		{
			$name = $this->name;
		}
		
		$name = 'M_'.$name;
		
		return $this->load($name, 'model');
	}
	
	public function &view($name='')
	{
		if (!$name)
		{
			$name = $this->name;
		}
		
		$name = 'V_'.$name;
		
		return $this->load($name, 'view');
	}
	
	public function ASSERT($bool, $message=NULL)
	{
		if ($bool===FALSE)
		{
			$this->view()->error($message);
			throw new Exception();
		}
	}
	
	public function WHICH($bool, $success_msg=NULL, $error_msg=NULL)
	{
		$url = NULL;
		if ($bool === FALSE)
		{
			if (is_array($error_msg))
			{
				$url = $error_msg['url'];
				$error_msg = $error_msg['message'];
			}
			$this->view()->error($error_msg, $url);
		}
		else
		{
			if (is_array($success_msg))
			{
				$url = $error_msg['url'];
				$success_msg = $success_msg['message'];
			}
			$this->view()->success($success_msg, $url);
		}
		return $bool;
	}
	
	public function __call($func, $args)
	{
		$obj = NULL;
		if (strpos($func, 'M_')===0)
		{
			$obj = $this->model();
		}
		else if (strpos($func, 'V_')===0)
		{
			$obj = $this->view();
		}
		
		_C_App::assert(!is_null($obj), 'Object method not found - '.$func);
		
		$func = substr($func, 2);
		
		return call_user_func_array(array($obj, $func), $args);
	}
	
}

?>