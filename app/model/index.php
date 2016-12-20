<?php
class Index {
	
	public static function index() 
	{
		return SHOW;
	}
	
	public static function test()
	{
		Sitemap::create(false);
		//Htmler::create_index();
		//Htmler::create_index('mogif');
		//Htmler::create_index('mobt');
		exit;
	}

	public static function _init()
	{
		return true;
	}
	
	public static function _destroy()
	{
		return true;
	}
	
	private function __construct(){}
}

?>