<?php 
class Tao123 extends Co_Collector {
	
	public function __construct($co_manager_id, $model)
	{
		parent::__construct($co_manager_id, $model);
	}
	
	public function do_work()
	{
		$url = 'http://api.tao123.com/neiye/xiaohua/api.php?methods=GetList&callback=jsonp&type=new&date=1&page=%d&length=20';
		//http://api.tao123.com/neiye/xiaohua/api.php?callback=jsonp1357455438389&id=99864&methods=GetXiaohua&_=1357455439012
		for ($page=1; $page<9999999; ++$page)
		{
			$html = Curl::get(sprintf($url, $page));
			if (empty($html))
			{
				$this->add_message('None content collect, exit!');
				return;
			}
			if (preg_match('/({.*})/si', $html, $matches))
			{
				$json = json_decode($matches[1], true);
				if (isset($json['GetList'], $json['GetList']['data']) )
				{
					$infos = $json['GetList']['data'];
					if (empty($infos))
					{
						return;
					}
					foreach ($infos as $info)
					{
						$data['title'] = mb_convert_encoding($info['title'], "gbk", "utf-8");
						$data['content'] = $info['pic_path'];
						if ( !$this->addData($data))
						{
							return;
						}
					}
				}
			}
			else
			{
				$this->add_message('None content matched, exit!');
				return;
			}
		}
		
	}
	
	public static function test()
	{
		$url = 'http://api.tao123.com/neiye/xiaohua/api.php?methods=GetList&callback=jsonp&type=new&date=1&page=%d&length=20';
		$page = 1;
		if (preg_match('/({.*})/si', Curl::get(sprintf($url, $page)), $matches))
		{
			$json = json_decode($matches[1], true);
			if (isset($json['GetList'], $json['GetList']['data']) )
			{
				$infos = $json['GetList']['data'];
				if (empty($infos))
				{
					return;
				}
				foreach ($infos as $info)
				{
					$data['title'] = mb_convert_encoding($info['title'], "gbk", "utf-8");;
					$data['content'] = $info['pic_path'];
				}
			}
		}
	
	}

}
?>