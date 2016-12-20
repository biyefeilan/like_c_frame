<?php 
class Ishuo extends Co_Collector {
	
	public function __construct($co_manager_id, $model)
	{
		parent::__construct($co_manager_id, $model);
	}
	
	public function do_work()
	{
		$url = 'http://meiwen.ishuo.cn/show/%d.html';
		$html = Curl::get('http://meiwen.ishuo.cn/');
		$lastest_id = 8000;
		$start_id = 6000;
		if (preg_match('/<div[^>]+class\s*=\s*"articlelist".*?<a[^>]+href\s*=\s*"\/show\/(\d+)\.html"/si', $html, $matches))
		{
			$lastest_id = (int)$matches[1];	
		}
		
		for ($id=$lastest_id; $id>$start_id; --$id)
		{
			$html = Curl::get(sprintf($url, $id));
			if (empty($html))
			{
				$this->add_message('None content collect, exit!');
				return;
			}
			if (preg_match('/<div[^>]+id\s*=\s*"article".*?<h1[^>]*>(.*?)<\/h1>.*?<div[^>]+class\s*=\s*"articlecontent">.*?<\/div>(.*?)<\/div>/si', $html, $matches))
			{
				if (!empty($matches[1]) && !empty($matches[2]) && strlen($matches[2]) > 200)
				{
					$data['title'] = mb_convert_encoding($matches[1], "gbk", "utf-8");
					$data['content'] = mb_convert_encoding($matches[2], "gbk", "utf-8");
					$data['author'] = 'ØýÃû';
					if ( !$this->addData($data))
					{
						return;
					}
				}
			}
		}
		
	}
}
?>