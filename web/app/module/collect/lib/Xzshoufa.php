<?php 
class Xzshoufa extends Co_Collector {
	
	public function __construct($co_manager_id, $model)
	{
		parent::__construct($co_manager_id, $model);
	}
	
	public function do_work()
	{
		$url = 'http://www.xzshoufa.com/';
		if (preg_match('/<div[^>]+class\s*=\s*"new".*?<\/div>/si', Curl::get($url), $blocks))
		{
			preg_match_all('/<a[^>]+href\s*=\s*"([^"]+)"[^>]*?>(.*?)<\/a>/si', $blocks[0], $matches);
			for ($i=0; $i<count($matches[1]); ++$i)
			{
				$infos[$i]['title'] = mb_convert_encoding($matches[2][$i], "gbk", "utf-8");
				$infos[$i]['link'] = stripos($matches[1][$i], 'http')===0 ? $matches[1][$i] : ($matches[1][$i]=='/' ? $url.substr($matches[1][$i], 1) : $url.$matches[1][$i]);
			}
		}
		
		foreach ($infos as $info)
		{
			if (preg_match('/<div[^>]+class\s*=\s*"content"[^>]*>(.*?)<\/div>/si', Curl::get($info['link']), $match_content))
			{
				$match_content = mb_convert_encoding($match_content[1], "gbk", "utf-8");
				if (preg_match('@(.*?)<img[^>]+src\s*=\s*"\s*http://img04.taobaocdn.com/imgextra/i4/229823360/T2NldIXghXXXXXXXXX_!!229823360.jpg.*?<a[^>]+href\s*=\s*"([^"]*?)".*@si', $match_content, $matches_content))
				{
					if (preg_match('/<div[^>]id\s*=\s*"download_ok".*?<a[^>]+href\s*=\s*"([^"]*?)"/si', Curl::get($matches_content[2]), $match_html))
					{
						if (preg_match('@<a[^>]+href\s*=\s*"(http://h\.dyshoufa\.com/d\.php\?c=[^"]+)".*@si', Curl::get($match_html[1]), $downs))
						{
							$bt = Curl::get($downs[1]);
							if (!empty($bt))
							{
								$data['title']	 = $info['title'];
								$data['content'] = $matches_content[1];
								$data['bt']		 = base64_encode($bt);
								if (!$this->addData($data))
								{
									return;
								}
							}
						}
						
					}
				}
			}
		}
	}
	
	public static function download($id)
	{
		$data = DB::findOne('mo_bt', array('unique_id'=>$id));
		$filename = sprintf('[%s]%s.torrent', 'vivinice.com', $data['title']);
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Type: application/x-bittorrent; charset=gbk');
		exit ( base64_decode($data['bt']));
	}
	
	public static function test()
	{
		$url = 'http://www.xzshoufa.com/';
		//echo Curl::get('http://h.dyshoufa.com/d.php?c=KR13559284211355929220');
		$html = Curl::get($url);
		if (preg_match('/<div[^>]+class\s*=\s*"new".*?<\/div>/si', $html, $blocks))
		{
			preg_match_all('/<a[^>]+href\s*=\s*"([^"]+)"[^>]*?>(.*?)<\/a>/si', $blocks[0], $matches);
			for ($i=0; $i<count($matches[1]); ++$i)
			{
				$infos[$i]['title'] = mb_convert_encoding($matches[2][$i], "gbk", "utf-8");
				$infos[$i]['link'] = stripos($matches[1][$i], 'http')===0 ? $matches[1][$i] : ($matches[1][$i]=='/' ? $url.substr($matches[1][$i], 1) : $url.$matches[1][$i]);
			}
		}
		
		foreach ($infos as $info)
		{
			$html = Curl::get($info['link']);
			if (preg_match('/<div[^>]+class\s*=\s*"content"[^>]*>(.*?)<\/div>/si', $html, $match_content))
			{
				$match_content = mb_convert_encoding($match_content[1], "gbk", "utf-8");
				if (preg_match('@(.*?)<img[^>]+src\s*=\s*"\s*http://img04.taobaocdn.com/imgextra/i4/229823360/T2NldIXghXXXXXXXXX_!!229823360.jpg.*?<a[^>]+href\s*=\s*"([^"]*?)".*@si', $match_content, $matches_content))
				{
					if (preg_match('/<div[^>]id\s*=\s*"download_ok".*?<a[^>]+href\s*=\s*"([^"]*?)"/si', Curl::get($matches_content[2]), $match_html))
					{
						if (preg_match('@<a[^>]+href\s*=\s*"(http://h\.dyshoufa\.com/d\.php\?c=[^"]+)".*@si', Curl::get($match_html[1]), $downs))
						{
							$bt = Curl::get($downs[1]);
							if (!empty($bt))
							{
								$data['title']	 = $info['title'];
								$data['content'] = $matches_content[1];
								$data['bt']		 = $bt;
								
								$filename = sprintf('[%s]%s.torrent', 'vivinice.com', $data['title']);
								//header('charset: gbk');
								header('Content-Disposition: attachment; filename="' . $filename . '"');
								header('Content-Type: application/x-bittorrent; charset=gbk');
								echo ( base64_decode(base64_encode($bt))	);
								exit;
							}
						}
						
					}
					//var_dump($html);
				}
				//var_dump($content);
				exit;
			}
		}
	}

}
?>