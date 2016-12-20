<?php

final class meiwen {
	const TABLE = 'mo_meiwen';
	
	const MAIN_LIST_SIZE = 10;
	
	const SIDEBAR_LIST_SIZE = 5;
	
	public static function index()
	{
		return SHOW;
	}
	
	public static function mlist($page)
	{
		return array(SHOW, array('page'=>$page));
	}
	
	public static function show($id)
	{
		return array(SHOW, array('id'=>$id));
	}
	
	public static function getDescri($content)
	{
		if (preg_match('/<\/p>.*?<p[^>]*>(.*?)<\/p>/', $content, $matches))
		{
			$content = $matches[1];
		}
		return String::msubstr($content, 0, 50);;
	}
	
	public static function incHits($id)
	{
		$stat = new v_stat(self::TABLE);
		$stat->hit($id);
	}
	
	public static function getRandom($num=10)
	{
		return DB::findAll(self::TABLE, null, 'rand()', '*', $num);
	}
	
	public static function getDownLoadsTop($top=10)
	{
		//$stat = new v_stat(self::TABLE);
		//return DB::findAll(self::TABLE, 'id in ('.implode(',', $stat->getDownloads($top)).')', null, '*');
		return SHOW;
	}
	
	public static function getHitsTop($top=10)
	{
		$stat = new v_stat(self::TABLE);
		return DB::findAll(self::TABLE, 'id in ('.implode(',', $stat->getHits($top)).')', null, '*');
	}
	
	public static function getLastestHot($num)
	{
		$stat = new v_stat(self::TABLE);
		return DB::findAll(self::TABLE, 'id in ('.implode(',', $stat->getTopIdArr('hits', $num, 3)).')', null, '*');
	}
	
	public static function download()
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