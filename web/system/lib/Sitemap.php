<?php

final class Sitemap {
	
	const NEWLINE = "\r\n";
	
	const URL_MAX = 15000;
	
	private static $_domain = 'http://www.vivinice.com/';
	
	private static $_xml = array();
	
	private static $_filename = '';
	
	public static function create($check = true)
	{
		set_time_limit(0);
		self::$_filename = BASE_PATH . DS . 'sitemap.xml';
		$lastmod = date('Y-m-d', SYS_TIME);
		
		$info = array(
			'mobt'	=> mobt::TABLE,
			'mogif'	=> mogif::TABLE,
			'moswf'	=> moswf::TABLE,	
			'meiwen'=> meiwen::TABLE,	
		);
		
		if ($check && file_exists(self::$_filename) &&  $lastmod == date('Y-m-d', filemtime(self::$_filename)))
		{
			return ;
		}
		else 
		{
			file_put_contents(self::$_filename, '');
		}
		self::$_xml[] = '<?xml version="1.0" encoding="utf-8"?>';
		self::$_xml[] = '<urlset>';
		self::$_xml = array_merge(self::$_xml, self::url(self::$_domain, $lastmod, 'always', '1.0'));
		foreach ($info as $c => $table)
		{
			$loc = str_replace(array('&'), array('&amp'), substr(self::$_domain, 0, -1).Url::mkurl($c, 'index'));
			self::$_xml = array_merge(self::$_xml, self::url($loc, $lastmod, 'always', '1.0'));
			foreach (DB::findAll($table, null, array('id'=>'DESC'), 'id', self::URL_MAX>0 ? self::URL_MAX : null) as $row)
			{
				if (self::check())
				{
					self::$_xml[]='';
					self::save();
				}
				$loc = str_replace(array('&'), array('&amp'), substr(self::$_domain, 0, -1).Url::mkurl($c, 'show', $row['id']));
				self::$_xml = array_merge(self::$_xml, self::url($loc, $lastmod, 'always', '0.9'));
			}
		}
		
		self::$_xml[] = '</urlset>';
		self::save();
	}
	
	private static function check()
	{
		return count(self::$_xml) > 5000;
	}
	
	private static function save()
	{
		file_put_contents(self::$_filename, implode(self::NEWLINE, self::$_xml), FILE_APPEND);
		self::$_xml = array();
	}
	
	private static function url($loc, $lastmod=null, $changefreq=null, $priority=null)
	{
		$url[] = '<url>';
		$url[] = "<loc>{$loc}</loc>";
		$url[] = is_null($lastmod) ? '' : "<lastmod>{$lastmod}</lastmod>";
		$url[] = is_null($changefreq) ? '' : "<changefreq>{$changefreq}</changefreq>";
		$url[] = is_null($priority) ? '' : "<priority>{$priority}</priority>";
		$url[] = '</url>'; 
		return $url;
	}
}

?>