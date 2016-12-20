<?php (defined ( 'APP_PATH' )) || exit ( 'Access deny!' );

final class _C_Config 
{
	private static $vars;
	
	public static function _init() 
	{
		_C_App::assert((self::$vars=_C_App::load('config_core', 'conf'))!==FALSE, 'Load configure file failed!');
		
		$config = self::$vars['_C_Config'];
		
// 		if (!empty($config['lang']))
// 		{
// 			self::$_packages['lang']['path'] .= $config['lang'] . DS;
// 		}
		
		error_reporting ( isset($config['error_reporting_level']) ? E_ALL : $config['error_reporting_level'] );
		
		_C_App::assert ( is_bool ( $config['debug'] ) && is_bool ( $config['error_log'] ), 'app setting error.' );
		
		if ($config['debug'] === true)
		{
			ini_set ( 'display_errors', 'on' );
		}
		else
		{
			ini_set ( 'display_errors', 'off' );
			($config['error_log'] === true) ? set_error_handler ( array ('_C_App', '_errorHandler' ) ) : error_reporting ( 0 );
		}
	
		date_default_timezone_set ( isset($config['time_zone']) ? $config['time_zone'] : date_default_timezone_get());
		
		if (! ini_get ( 'safe_mode' ) && is_numeric ( $config['app_max_time'] ))
		{
			set_time_limit ( $config['app_max_time'] );
		}
		
		if (ini_get ( 'magic_quotes_gpc' ) === '1')
		{
			isset ( $_REQUEST ) && _C_Util::stripslashes ( $_REQUEST );
			isset ( $_POST ) && _C_Util::stripslashes ( $_POST );
			isset ( $_GET ) && _C_Util::stripslashes ( $_GET );
			isset ( $_COOKIE ) && _C_Util::stripslashes ( $_COOKIE );
		}
		
		if ($config['auto_trim_gpc'] === true) {
			isset ( $_REQUEST ) && _C_Util::trim ( $_REQUEST );
			isset ( $_POST ) && _C_Util::trim ( $_POST );
			isset ( $_GET ) && _C_Util::trim ( $_GET );
			isset ( $_COOKIE ) && _C_Util::trim ( $_COOKIE );
		}
		
		if (!defined('SITE_URL'))
		{
			if (isset($config['site_url']) && !empty($config['site_url']) && preg_match('@^https?://@i', $config['site_url']))
			{
				$base_url = $config['site_url'];
			}
			else
			{
				$s = '';
				if (isset($_SERVER['HTTPS']))
				{
					if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
					{
						$s = 's';
					}
				}
				else
				{
					if (isset($_SERVER['SCRIPT_URI']) && stripos($_SERVER['SCRIPT_URI'], 'https://') === 0)
					{
						$s = 's';
					}
				}
				if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST']))
				{
					$httpHost = $_SERVER['HTTP_HOST'];
				}
				else if (isset($_ENV['HTTP_HOST']) && !empty($_ENV['HTTP_HOST']))
				{
					$httpHost = $_ENV['HTTP_HOST'];
				}
				else
				{
					$httpHost = getenv('HTTP_HOST');
				}
		
				if (isset($httpHost) && $httpHost) {
					$base_url = 'http' . $s . '://' . $httpHost . '/';
				} else {
					$base_url = '/';
				}
			}
			define ( 'SITE_URL', $base_url );
		}
		
		if (!defined('IMG_URL'))
		{
			if (!isset($config['img_url'])) 
			{
				$config['img_url'] = 'static/img';
			}
			if (!preg_match('@^https?://@i', $config['img_url'])) 
			{
				$config['img_url'] = SITE_URL . trim($config['img_url'],'/') . '/';
			}
			define('IMG_URL', $config['img_url']);
		}
		
		if (!defined('JS_URL'))
		{
			if (!isset($config['js_url']))
			{
				$config['js_url'] = 'static/js';
			}
			if (!preg_match('@^https?://@i', $config['js_url']))
			{
				$config['js_url'] = SITE_URL . trim($config['js_url'],'/') . '/';
			}
			define('JS_URL', $config['js_url']);
		}
		
		if (!defined('CSS_URL'))
		{
			if (!isset($config['css_url']))
			{
				$config['css_url'] = 'static/css';
			}
			if (!preg_match('@^https?://@i', $config['css_url']))
			{
				$config['css_url'] = SITE_URL . trim($config['css_url'],'/') . '/';
			}
			define('CSS_URL', $config['css_url']);
		}
		
		return TRUE;
	}
	
	public static function vars($key)
	{
		if (isset(self::$vars[$key])) {
			return self::$vars[$key];
		}
		if (strpos($key, '/') === FALSE) {
			return isset(self::$vars[$key]) ? self::$vars[$key] : NULL;
		}
		$segs = explode('/', $key);
		$vars = NULL;
		switch (count($segs)) 
		{
			case 2:
				$vars = isset(self::$vars[$segs[0]][$segs[1]]) ? self::$vars[$segs[0]][$segs[1]] : NULL;
				break;
			case 3:
				$vars = isset(self::$vars[$segs[0]][$segs[1]][$segs[2]]) ? self::$vars[$segs[0]][$segs[1]][$segs[2]] : NULL;
				break;
			case 4:
				$vars = isset(self::$vars[$segs[0]][$segs[1]][$segs[2]][$segs[3]]) ? self::$vars[$segs[0]][$segs[1]][$segs[2]][$segs[3]] : NULL;
				break;
			case 5:
				$vars = isset(self::$vars[$segs[0]][$segs[1]][$segs[2]][$segs[3]][$segs[4]]) ? self::$vars[$segs[0]][$segs[1]][$segs[2]][$segs[3]][$segs[4]] : NULL;
				break;
			default:
				break;
		}
		self::$vars[$key] = $vars;
		return $vars;
	}
}
?>