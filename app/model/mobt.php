<?php

final class mobt {
	const TABLE = 'mo_bt';
	
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
	
	public static function incHits($id)
	{
		$stat = new v_stat(self::TABLE);
		$stat->hit($id);
	}
	
	public static function img($content)
	{
		if (preg_match('/<img[^>]+src\s*=\s*"([^"]+)"/', $content, $matches))
		{
			$img = $matches[1];
		}
		else
		{
			$img = IMG_URL . 'not_found.jpg';
		}
		return $img;
	}
	
	public static function download($id)
	{
		if (!stristr($_SERVER['HTTP_HOST'],  'vivinice'))
			exit;
		if (empty($_SERVER['HTTP_REFERER'])){
			exit;
		}
		if (false!==($data = DB::findOne(mobt::TABLE, array('id'=>$id), null, array('title', 'bt'))))
		{
			$stat = new v_stat(self::TABLE);
			$stat->download($id);
			$filename = sprintf('[%s]%s.torrent', 'vivinice.com', $data['title']);
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Content-Type: application/x-bittorrent; charset=gbk');
			exit ( base64_decode($data['bt']));
		}
		exit;
	}
	
	public static function getRandom($num=10)
	{
		return DB::findAll(self::TABLE, null, 'rand()', '*', $num);
	}
	
	public static function getDownLoadsTop($top=10)
	{
		$stat = new v_stat(self::TABLE);
		return DB::findAll(self::TABLE, 'id in ('.implode(',', $stat->getDownloads($top)).')', null, '*');
	}
	
	public static function getHitsTop($top=10)
	{
		$stat = new v_stat(self::TABLE);
		return DB::findAll(self::TABLE, 'id in ('.implode(',', $stat->getHits($top)).')', null, '*');
	}
	
	public static function getLastestHot($num)
	{
		$stat = new v_stat(self::TABLE);
		return DB::findAll(self::TABLE, 'id in ('.implode(',', $stat->getTopIdArr('hits', $num)).')', null, '*');
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