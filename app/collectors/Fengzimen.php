<?php

class Fengzimen extends Co_Collector {

	private $_url_ptn = 'http://zhan.renren.com/fengzimen?page=%d&from=pages&checked=true';
	
	private $_page_start = 0;
	
	private $_page_end	 = 24;
	
	private $_auto_end	 = true;
	
	private $_sleep 	 = 0;
	
	private $_block_ptns = array(
			'/<article.*?<\/article>/si',
	);
	
	private $_detail_ptns = array(
			'video' => '/<div[^>]+class\s*=\s*"post-content"[^>]*>.*?<div[^>]+class\s*=\s*"video-holder".*?<h[1-6][^>]*>(.*?)<\/h[1-6]>.*?<embed[^>]+src\s*=\s*"(.*?)"/si',
	);
	
	/**
	 * 
	 * @param uint $co_manager_id
	 * @param string $model
	 */
	public function __construct($co_manager_id, $model)
	{
		parent::__construct($co_manager_id, $model);
	}
	
	public function do_work()
	{	
		for ($i=$this->_page_start; $i<=$this->_page_end; ++$i)
		{
			$page_data = array();
			$url = sprintf($this->_url_ptn, $i);
			$html =  Curl::get($url);
			if ($html === false || empty($html))
				continue;
			foreach ($this->_block_ptns as $block_ptn)
			{
				if (preg_match_all($block_ptn, $html, $articles))
				{
					//只匹配一个模式
					break;
				}
			}
			foreach ($articles[0] as $article)
			{
				$data = array();
				foreach ($this->_detail_ptns as $ptn)
				{
					if (preg_match($ptn, $article, $matches))
					{
						$title = mb_convert_encoding($matches[1], "gbk", "utf-8");
						$content = mb_convert_encoding($matches[2], "gbk", "utf-8");
						if (empty($title) || empty($content))
						{
							continue;
						}
						$data['title'] = $title;
						$data['content'] = $content;
						$data['type'] = strpos($matches[2], '.swf') !== false ? 1 : 0;
						
						if (!$this->addData($data))
						{
							return ;
						}
						
						$page_data[] = $data;
						//只匹配一个模式
						break;
					}
				}
		
			}
			if ($this->_auto_end)
			{
				if (empty($page_data))
					break;
			}
			if ($this->_sleep>0) sleep($this->_sleep);
		}
	}
}

?>