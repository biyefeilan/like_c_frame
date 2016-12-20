<?php

(defined ( 'APP_PATH' )) || exit ( 'Access deny!' );

final class _C_Router 
{	
	const MODE_PATHINFO = 0;
	
	const MODE_QUERY = 1;
	
	private static $config=array();
	
	public static function _init() 
	{
		self::$config = _C_Config::vars('_C_Router');

		$segs = _C_Router::filter(self::_uriInfo());
		
		if (self::$config['rule_in'] !== FALSE) 
		{
			$segs = explode('/', self::_inRewrite(implode('/', $segs)), 4);
		}
		
		self::$_module = !isset($segs[0]) || !preg_match('/^[a-z]\w+$/i', $segs[0]) ? self::$config['uri']['module']['default'] : $segs[0];
		
		self::$_class = !isset($segs[1]) || !preg_match('/^[a-z]\w+$/i', $segs[1]) ? self::$config['uri']['class']['default'] : $segs[1];
		
		self::$_method = !isset($segs[2]) || !preg_match('/^[a-z]\w+$/i', $segs[2]) ? self::$config['uri']['method']['default'] : $segs[2];
		
		self::$_data = isset($segs[3]) ? $segs[3] : self::$config['uri']['data']['default'];
		
		if (isset(self::$config['uri']['module']['global']))
			define(self::$config['uri']['module']['global'], self::$_module);
		
		if (isset(self::$config['uri']['class']['global']))
			define(self::$config['uri']['class']['global'], self::$_class);
			
		if (isset(self::$config['uri']['method']['global']))
			define(self::$config['uri']['method']['global'], self::$_method);
			
		if (isset(self::$config['uri']['data']['global']))
			define(self::$config['uri']['data']['global'], self::$_data);
		
// 		echo '/'.self::$_module.'/'.self::$_class.'/'.self::$_method.'/'.self::$_data;
		
		return TRUE;
	}
	
	public static function _destroy()
	{
		if (self::$config['rule_out'] !== FALSE) 
		{
			self::_outRewrite();
		}
	}
	
	private static function _outRewrite()
	{
		$content = _C_Response::content();
		$config = self::$config['uri'];
		$m = $config['module']['query'];
		$c = $config['class']['query'];
		$a = $config['method']['query'];
		$d = $config['data']['query'];
		if (preg_match_all('@<a\s+href\s*=\s*([\'|"])\s*\?(('.$m.'=|'.$c.'=|'.$a.'=|'.$d.'=)[^\\1]*?)\\1.*?</a>@i', $content, $matches))
		{
			$count = count($matches[0]);
			$links = array();
			for ($i=0; $i<$count; $i++) {
				if (preg_match('@(?:'.$m.'=([^&]*))?(?:&(?:amp;)?)?(?:'.$c.'=([^&]*))?(?:&(?:amp;)?)?(?:'.$a.'=([^&]*))?(?:&(?:amp;)?)?(?:'.$d.'=([^&]*))?(.*)@i', $matches[2][$i], $infos))
				{
					$links[$matches[0][$i]][0] = $infos[1];
					$links[$matches[0][$i]][1] = $infos[2];
					$links[$matches[0][$i]][2] = $infos[3];
					$links[$matches[0][$i]][3] = $infos[4];
					$links[$matches[0][$i]][4] = preg_replace('/^(&(amp;))+/', '', $infos[5]);
					
				}
			}
			foreach ($links as $link=>$segs)
			{
				list($module, $class, $method, $data, $query) = $segs;
					
				$url = self::mkurl($module, $class, $method, $data, $query);
				
				$new_link = preg_replace('@href\s*=\s*([\'|"])[^\\1]*?\\1@i', 'href="'.$url.'"', $link);
				
				$content = str_replace($link, $new_link, $content);
			}
		}

		_C_Response::setContent($content);
	}
	
	public static function mkurl($module, $class, $method, $data='', $query='')
	{
		$config = self::$config['uri'];
		if (!$module) {
			$module = $config['module']['default'];
		}
		if (!$class) {
			$class = $config['class']['default'];
		}
		if (!$method) {
			$method = $config['method']['default'];
		}
		if ((!$data || $data==$config['data']['default'])&&$module==$config['module']['default']&&$class==$config['class']['default']&&$method==$config['method']['default'])
		{
			$module = $class = $method = $data = NULL;
		}
			
		$url = "$module/$class/$method/$data/";
			
		$url = trim(preg_replace ('#//+#', '/', $url ), '/');
		
		$url = self::_parse($url, self::$config['rule_out']) . ($query ? '?'.$query : '');
		
		if (self::$config['url_mode'] == self::MODE_PATHINFO)
		{
			self::$config['script'] = trim(self::$config['script'], '/');
			$url = '/' . $url;
			if (self::$config['script']) {
				$url = '/'. self::$config['script'] . $url;
			}
		}
		
		return $url;
	}
	
	private static function _inRewrite($uri)
	{
		$uri = $uri ? trim($uri, '/') : '/';
		
// 		$suflen = strlen(self::$config['suff']);
	
// 		if (strripos($uri, self::$config['suff']) === strlen($uri) - $suflen)
// 		{
// 			$uri = substr($uri, 0, 0-$suflen);
// 		}
		
		return self::_parse($uri, self::$config['rule_in']);
	}
	
	private static function _parse($uri, $config)
	{
		if (is_array($config))
		{
			if (isset ( $config[$uri] ))
			{
				$uri = $config[$uri];
			}
			else
			{
				foreach ( $config as $pattern => $replacement )
				{
					if (preg_match ( '#^' . $pattern . '$#', $uri ))
					{
						if (strpos ( $replacement, '$' ) !== false && strpos ( $pattern, '(' ) !== false)
						{
							$replacement = preg_replace ( '#^' . $pattern . '$#', $replacement, $uri );
						}
		
						$uri = $replacement;
						break;
					}
				}
			}
		}
		return $uri;
	}
	
	private static function filter($segs)
	{
		_C_Util::trim($segs);
		return $segs;
	}
	
	private static function _uriInfo()
	{
		static $uri;
		if (isset($uri))
		{
			return $uri;
		}
	
		if (isset(self::$config['url_mode']) && self::$config['url_mode'] == _C_Router::MODE_PATHINFO)
		{
			if ((php_sapi_name () == 'cli' || defined ( 'STDIN' )))
			{
				$argv = $_SERVER ['argv'];
				$uri = strpos($argv [0], '/')===0 ? $argv [0] : '/'.$argv [0];
			}
				
			if (isset($_SERVER ['PATH_INFO']) && !empty ( $_SERVER ['PATH_INFO'] ))
			{
				$uri = $_SERVER ['PATH_INFO'];
			}
			else if (isset ( $_SERVER ['REQUEST_URI'] ) && isset ( $_SERVER ['SCRIPT_NAME'] ))
			{
				if (strpos ( $_SERVER ['REQUEST_URI'], $_SERVER ['SCRIPT_NAME'] ) === 0)
				{
					$uri = substr ( $_SERVER ['REQUEST_URI'], strlen ( $_SERVER ['SCRIPT_NAME'] ) );
				}
				else if (strpos ( $_SERVER ['REQUEST_URI'], dirname ( $_SERVER ['SCRIPT_NAME'] ) ) === 0)
				{
					$uri = substr ( $_SERVER ['REQUEST_URI'], strlen ( dirname ( $_SERVER ['SCRIPT_NAME'] ) ) );
				}
			}
				
			if (!isset($uri))
			{
				if (isset ( $_SERVER ['PHP_SELF'] ) && isset ( $_SERVER ['SCRIPT_NAME'] ))
				{
					$uri = str_replace ( $_SERVER ['SCRIPT_NAME'], '', $_SERVER ['PHP_SELF'] );
				}
				else if (isset ( $_SERVER ['QUERY_STRING'] ) && trim ( $_SERVER ['QUERY_STRING'], '/' ) != '')
				{
					$uri = $_SERVER ['QUERY_STRING'];
				}
			}
				
			if (isset($uri) && strpos ( $uri, '?' ) !== false)
			{
				list ( $uri ) = explode ( '?', $uri, 2 );
			}
				
			$uri = explode('/', trim(preg_replace ('#//+#', '/', $uri ), '/'));
		}
		else
		{
			$uri = array();
			$uri[0] = isset($_GET[self::$config['uri']['module']['query']]) ? $_GET[self::$config['uri']['module']['query']]  : '';
			$uri[1] = isset($_GET[self::$config['uri']['class']['query']]) ? $_GET[self::$config['uri']['class']['query']]  : '';
			$uri[2] = isset($_GET[self::$config['uri']['method']['query']]) ? $_GET[self::$config['uri']['method']['query']] : '';
			$uri[3] = isset($_GET[self::$config['uri']['data']['query']]) ? (is_array($_GET[self::$config['uri']['data']['query']]) ? implode('/', $_GET[self::$config['uri']['data']['query']]) : $_GET[self::$config['uri']['data']['query']]) : '';
		}
	
		return $uri;
	}
	
//--------------------------------------------------------------------
	
	private static $_module;
	
	private static $_class;
	
	private static $_method;
	
	private static $_data;
	
	public static function getModule()
	{
		return self::$_module;
	}
	
	public static function getClass()
	{
		return self::$_class;	
	}
	
	public static function getMethod()
	{
		return self::$_method;	
	}
	
	public static function getData()
	{
		return self::$_data;	
	}
	
//---------------------------------------------------------------
	
	public static function getClientIp() 
	{
		static $client_ip;
		if (isset($client_ip)) return $client_ip;
		$client_ip = null;
		if ((isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] ) && ($ips = $_SERVER ['HTTP_X_FORWARDED_FOR'])) || ($ips = getenv ( 'HTTP_X_FORWARDED_FOR' )))
		{
			$client_ip = preg_replace ( '/(?:,.*)/', '', $ips );
		}
		if (! $client_ip || stristr ( $client_ip, 'unknown' ) !== false)
		{
			$client_ip = isset ( $_SERVER ['HTTP_CLIENT_IP'] ) ? $_SERVER ['HTTP_CLIENT_IP'] : getenv ( 'HTTP_CLIENT_IP' );
		}
		if (! $client_ip || stristr ( $client_ip, 'unknown' ) !== false)
		{
			$client_ip = isset ( $_SERVER ['REMOTE_ADDR'] ) ? $_SERVER ['REMOTE_ADDR'] : getenv ( 'REMOTE_ADDR' );
		}
		return $client_ip = trim ( $client_ip );
	}
	
	private function __construct() {}
	
	private function __clone() {}
}

?>