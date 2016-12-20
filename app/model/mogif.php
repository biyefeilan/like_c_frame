<?php

final class mogif {
	
	const TABLE = 'mo_funny_image';
	
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
	
	public static function img($src)
	{
		if (!stristr($_SERVER['HTTP_HOST'],  'vivinice'))
			exit;
		
		$src = base64_decode($src);
		
		$img = Curl::get($src, array(CURLOPT_TIMEOUT=>30));
		if (empty($img))
		{
			if (time() - SYS_TIME <= 5)
			{
				$replace 	= array('.gif',    '.jpeg');
				$search		= array('src.gif', 'src.jpg');
				$src = str_ireplace($search, $replace, $src);
				DB::delete(self::TABLE, array('content'=>$src));
			}
			$src = IMG_URL . 'not_found.jpg';
			$img = Curl::get($src);
		}
		
		$ext = substr($src, strrpos($src, '.')+1);
		$config = Config::vars('_C_Response');
		$content_type = isset($config['mime_types'][$ext]) ? $config['mime_types'][$ext] : 'image/*';
		
		header("Content-Type: {$content_type}");
		
		exit($img);
	}
	
	public static function loading_src()
	{
		return IMG_URL . 'loading.gif';
	}
	
	public static function img_src($src, $replace=true)
	{
		if ($replace === true)
		{
			$search 	= array('.gif',    '.jpeg');
			$replace	= array('src.gif', 'src.jpg');
			$src = str_ireplace($search, $replace, $src);
		}
		return base64_encode($src);
	}
	
	public static function download($id)
	{
		/*
		if (!stristr($_SERVER['HTTP_HOST'],  'vivinice'))
			exit;
		if (false!==($data = DB::findOne(mogif::TABLE, array('id'=>$id), null, array('title', 'content'))))
		{
			$stat = new v_stat(self::TABLE);
			$stat->download($id);
			$search 	= array('.gif',    '.jpeg');
			$replace	= array('src.gif', 'src.jpg');
			$src = str_ireplace($search, $replace, $data['content']);
			$ext = substr($src, strrpos($src, '.')+1);
			$filename = sprintf('[%s]%s.%s', 'vivinice.com', $data['title'], $ext);
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			$config = Config::vars('_C_Response');
			$content_type = isset($config['mime_types'][$ext]) ? $config['mime_types'][$ext] : 'image/*';
			header("Content-Type: {$content_type}");
			exit ( Curl::get($src) );
		}
*/
		exit('warning!');
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
		return DB::findAll(self::TABLE, 'id in ('.implode(',', $stat->getTopIdArr('hits', $num, 3)).')', null, '*');
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