<?php
final class Url {
	public static $html  = false;
	
	public static function mkurl($class, $method, $data=null)
	{	
		if (self::$html === true)
		{
			return Htmler::url($class, $method, $data);
		}
		
		if ($method=='index')
		{
			if (is_null($data))
			{
				if ($class=='index')
				{
					$class = null;
				}
				$method = null;
			}
		}
			
		$url = array();
		
		$mode = _C_Router::getMode();
		
		$config = _C_Config::vars('_reg');
		
		foreach (array($config['class']['uri']=>$class, $config['method']['uri']=>$method, $config['data']['uri']=>$data) as $k=>$v)
		{
			if (!empty($v))
				$url[] = $mode==0 ? $v : "{$k}={$v}";	
		}
		
		if (empty($url))
		{
			return '/';
		}
			
		$url = implode($mode == 0 ? '/' : '&', $url);
		
		if ($mode == 0)
		{
			//$url = '/index.php/' . $url;
			$url = '/' . $url;
			if (is_null($data) || is_null($method))
			{
				return $url . '/';
			} 
			return $url . _C_Router::URI_SUFFIX;
		}
		else
		{
			return '/?'.$url;
		}
	}
		
}

?>