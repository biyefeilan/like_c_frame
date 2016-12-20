<?php

class Htmler {
	
	const SUFFIX = '.html';
	
	public static function url_ptns($key=null)
	{
		$urls = array(
			'index'		=> '/index' 		. Htmler::SUFFIX, 	
			'cat_index'	=> '/a/_C_/index' 	. Htmler::SUFFIX,
			'cat_mlist'	=> '/a/_C_/l_D_' . Htmler::SUFFIX,
			'cat_show'	=> '/a/_C_/s_D_'	. Htmler::SUFFIX,	
		);
		return is_string($key) && isset($urls[$key]) ? $urls[$key] : $urls;
	}
	
	public static function url($class, $method, $data=null)
	{
		if ($class == 'index')
		{
			return self::url_ptns('index');
		}
		$ptn = self::url_ptns('cat_'.$method);
		if (!is_string($ptn))
		{
			exit('wrong ptn');
		}
		
		return str_replace(array('_C_', '_D_'), array($class, $data), $ptn);
	}
	
	public static function create_index($class='index')
	{
		return self::create($class, 'index');	
	}
	
	public static function create_list($class, $reset=false)
	{
		
		
	}
	
	public static function create($class, $method, $data=null)
	{
		$filename = self::path($class, $method, $data);
		$path = substr($filename, 0, strrpos($filename, DS));
		_C_File::mksdir($path);
		Url::$html = true;
		ob_start();
		$result = _C_Controller::_getResult($class, $method, $data);
		$result = _C_Controller::processResult($result, $class, $method, $data);
		_C_Controller::showResult($result);
		$data = ob_get_contents();
		ob_end_clean();
		Url::$html = false;
		return file_put_contents($filename, $data, LOCK_EX);
	}
	
	public static function path($class, $method, $data=null)
	{
		$path = str_replace('/', DS, self::url($class, $method, $data));
		return BASE_PATH . (strpos($path, DS)===0 ? $path : DS . $path);
	}
}

?>