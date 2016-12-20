<?php

(defined ( 'APP_PATH' )) || exit ( 'Access deny!' );
/**
 * _C_App
 * @author Jone
 *
 */
final class _C_App {
	
	private static $_TYPES = array (
		'config' 	=> 'T_CONFIG', 
		'class'  	=> 'T_CLASS',
		'template'  => 'T_TEMPLATE'
	);
	
	public static function types($key) {
		return isset ( self::$_TYPES [$key] ) ? self::$_TYPES [$key] : _C_App::triggerError ( 'No such key ' . $key . ' in TYPES' );
	}
	
	private static $_packages;
	
	private static function _initPackages() 
	{
		if (!isset(self::$_packages))
		{
			self::$_packages = array (
			
				'core' => array (
					'path' => SYSTEM_PATH . DS . 'core' . DS, 
					'type' => _C_App::types ( 'class' )
				), 
					
				'mysql' => array (
					'path' => SYSTEM_PATH . DS . 'database' . DS . 'drivers' . DS . 'mysql' . DS,
					'type' => _C_App::types ( 'class' )
				),
				
				'lang' => array(
					'path' => APP_PATH . DS . 'lang' . DS,
					'type' => _C_App::types('class'),
				),
					
				'conf'   => array (
					'path' => APP_PATH . DS . 'conf' . DS . _C_App::environment() . DS,
					'type' => _C_App::types ( 'config' )
				),
			);
		}
	}
	
	public static function filePath($filename, $package) 
	{
		return self::$_packages [$package] ['path'] . $filename . PHP_SUFFIX;
	}
	
	public static function getPackageType($package) {
		return isset ( self::$_packages [$package] ['type'] ) ? self::$_packages [$package] ['type'] : false;
	}
	
	public static function getPackagesByType($type) 
	{
		$packages = array ();
		foreach ( self::$_packages as $name => $package ) 
		{
			if (isset ( $package ['type'] ) && isset ( self::$_TYPES [$type] ) && $package ['type'] == self::$_TYPES [$type])
				$packages [] = $name;
		}
		return $packages;
	}
	
	public static function getPackagePath($package) 
	{
		return isset ( self::$_packages [$package] ) && isset ( self::$_packages [$package] ['path'] ) ? self::$_packages [$package] ['path'] : null;
	}
	
	
	public static function getPackageFiles($package, $pattern = '*.php') 
	{
		$files = glob ( self::getPackagePath ( $package ) . $pattern );
		return $files === false ? array () : $files;
	}
	
	public static function addPackages($packages) 
	{
		foreach ( $packages as $package => $val ) 
		{
			_C_App::assert(! isset ( self::$_packages [$package] ), 'Package ' .$package.' already exists');
			self::$_packages [$package] = $val;
		}
	}
	
	//----------------------------------------------------------------------------------------
	
	private static $_loaded = array();
	
	private static function _autoLoad($class) 
	{
		foreach ( self::$_packages as $package => $val ) 
		{
			if (isset ( $val ['type'] ) && $val ['type'] == self::$_TYPES ['class']) 
			{
				self::load ( $class, $package );
				if (class_exists($class, false)) 
				{
					break;
				}
			}
		}
	}
	
	public static function load($filename, $package)
 	{
		if (file_exists ( $file = self::filePath ( $filename, $package ) )) 
		{
			self::$_loaded[$package][$filename] = include $file;
			return self::$_loaded[$package][$filename];
		} 
		else 
		{
			//echo $file.'<br />';
			return false;
		}
	}
	
	public static function getLoaded()
	{
		return self::$_loaded;
	}
	
	//----------------------------------------------------------------------------------------

	private static $_style = 'default';
	
	public static function setStyle($style)
	{
		self::$_style = $style;
	}
	
	public static function style()
	{
		return self::$_style;
	}
	
// 	private static $_module = 'index';
	
// 	public static function setModule($module) 
// 	{
// 		self::$_module = $module;
// 	}
	
// 	public static function module() 
// 	{
// 		return self::$_module;
// 	}
	
	private static $_environment = 'production'; 
	
	public static function environment()
	{
		return self::$_environment;
	}
	
	public static function setEnvironment($environment) 
	{
		self::$_environment = $environment;
	}
	
	//----------------------------------------------------------------------------------------
	
	public static function _init()
	{
		self::_initPackages ();
		
		spl_autoload_register ( array ('_C_App', '_autoLoad' ) );
		
		_C_Bench::mark('app');
		
		_C_App::assert(_C_Config::_init(), 'Config init failed!');
		
		_C_App::assert(_C_Router::_init(), 'Router init failed!');
		
		_C_App::assert(_C_Response::_init(), 'Response init failed!');
	}
	
	/**
	 * run()
	 */
	public static function _run() 
	{	
		if (_C_Module::_init()===TRUE)
		{	
			_C_Module::_run();
			_C_Module::_destroy();
		}
	}
	
	public static function _shutdown()
	{
		_C_Router::_destroy();
		
// 		_C_Bench::mark('app');
// 		_C_Bench::show('app');
		
		_C_Response::output();
	}
	
	public static function _errorHandler($errno, $errstr, $errfile, $errline) {
		if (! (error_reporting () & $errno)) {
			return true;
		}
		
		$error_msg = '[' . date ( 'Y-m-d H:i:s', time () ) . '] ';
		switch ($errno) {
			case E_USER_ERROR :
				$error_msg .= "ERROR: [$errno] $errstr, ";
				$error_msg .= "fatal error on line $errline in file $errfile";
				$error_msg .= ', PHP ' . PHP_VERSION . ' (' . PHP_OS . '), client IP: [' . _C_Router::getClientIp () . '], ';
				$error_msg .= "aborting...\r\n";
				_C_Log::write ( $error_msg );
				exit ( 1 );
				break;
			
			case E_USER_WARNING :
				$error_msg .= "WARNING: [$errno] $errstr\r\n";
				break;
			
			case E_USER_NOTICE :
				$error_msg .= "NOTICE: [$errno] $errstr\r\n";
				break;
			
			default :
				$error_msg .= "Unknown error type: [$errno] $errstr\r\n";
				break;
		}
		_C_Log::write ( $error_msg );
		return true;
	}
	
	/**
	 * @param bool $expression
	 * @param string $error_msg
	 * @access public 
	 */
	public static function assert($expression, $error_msg = 'An error occured!') {
		//var_dump(debug_backtrace());
		! $expression && _C_App::triggerError ( $error_msg, E_USER_ERROR );
	}
	
	/**
	 * @param string $error_msg
	 * @param int $error_type
	 */
	public static function triggerError($error_msg, $error_type = E_USER_ERROR) {
		trigger_error ( $error_msg, $error_type );
	}
	
}
?>