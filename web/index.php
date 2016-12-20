<?php
/*
define('SITE_DOMAIN', 'www.vivinice.com');
define('SITE_NAME', 'VIVINICE');
define('SITE_URL', 'http://www.vivinice.com/');

if(strtolower($_SERVER['HTTP_HOST']) != SITE_DOMAIN )
{
	if (strtolower($_SERVER['REQUEST_URI']) === '/index.php')
	{
		$_SERVER['REQUEST_URI'] = '/';
	}
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: http://'.SITE_DOMAIN.$_SERVER['REQUEST_URI']);
	exit;
}
*/
/*
if (strpos($_SERVER['HTTP_HOST'], 'zuimeiwen') !==false)
{
	header('Location: http://www.vivinice.com/');
	define('SITE_NAME', '������');
	define('SITE_URL', 'http://www.zuimeiwen.com/');
	define('SITE_DOMAIN', 'www.zuimeiwen.com');
}
else if (strpos($_SERVER['HTTP_HOST'], 'vivinice') !==false)
{
	define('SITE_NAME', 'VIVINICE');
	define('SITE_URL', 'http://www.vivinice.com/');
	define('SITE_DOMAIN', 'www.vivinice.com');
}
else
{
	header('Location: http://www.vivinice.com/');
	define('SITE_NAME', 'VIVINIKO');
	define('SITE_URL', 'http://www.viviniko.com/');
	define('SITE_DOMAIN', 'www.viviniko.com');
}
*/

define('ENVIRONMENT', 'development');

include ('app/boot.php');
