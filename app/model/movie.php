<?php

final class movie {

	public static function index()
	{
		return SHOW;
	}
	
	
	
	public static function _init()
	{
		return true;
	}
	
	public static function _destroy()
	{
		return true;
	}
	
	private function __construct(){
	}
}

?>