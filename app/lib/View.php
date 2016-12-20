<?php
final class View {
	/**
	*
	*@param $info 直接调用DB::pages()方法返回的info
	*'info' => array(
	*			'page_now' => $page,
	*			'page_size' => $page_size,
	×			'records_count' => $records_count,
	×			'pages_count' => $pages_count,	
	×		),
	*/
	public static function pagesList($info, $c, $m, $max_list=10)
	{
		$link = Url::mkurl($c, $m, '{__PAGE__}');
		
		$list_count = $max_list = max($max_list, 5);
		
		$page_start = $page_end = $info['page_now'];
		
		for ($i=0; $list_count!=0 && $i<$max_list; ++$i)		
		{
			if ($page_start > 1)
			{
				--$page_start;
				--$list_count;
			}
			if ($page_end < $info['pages_count']+1)
			{
				++$page_end;
				--$list_count;
			}
		}
		
		$links = array();
		
		if ($info['page_now'] > 1)
		{
			$links['<上一页'] = str_replace('{__PAGE__}', $info['page_now']-1, $link);
		}
		
		for ($i = $page_start; $i<$page_end; ++$i)
		{
			$links[$i] = str_replace('{__PAGE__}', $i, $link); 	
		}
		
		if ($info['page_now'] < $info['pages_count'])
		{
			$links['下一页>'] = str_replace('{__PAGE__}', $info['page_now']+1, $link);
		}
		
		$str = '';
		foreach($links as $k=>$v) 
		{ 
			$str .= '<a href="'.$v.'" target="_self"><span class="'.($k==$info['page_now'] ? 'page_now' : '').'">'.$k.'</span></a>';
		}
		
		return $str;
	}
	/*
	public static function pagesList($info, $link, $max_list=10)
	{
		if (strpos($link, '?') !== false)
		{
			$pices = explode('?', $link, 2);
			$pices[1] = preg_replace('/(.*)page=[^&]*&*(.*)/', '\\1\\2', $pices[1]);
			$link = $pices[0] . '?page={__PAGE__}' . (empty($pices[1]) ? '' : '&'.$pices[1]);
			if ($link[strlen($link)-1] == '&')
				$link = substr($link, 0, -1);
		}
		else if (strpos($link, '#') !== false)
		{
			$link = preg_replace('/(.*)(#.*)/', '\\1?page={__PAGE__}\\2', $link);
		}
		else
		{
			$link .= '?page={__PAGE__}';
		}
	
		$max_list = max($max_list, 5);
	
		$page_start = $page_end = $info['page_now'];
	
		for ($i=0; $i<$max_list; ++$i)
		{
			if ($page_start > 1)
			{
				--$page_start;
				--$max_list;
			}
			if ($page_end < $info['pages_count']+1)
			{
				++$page_end;
				--$max_list;
			}
		}
	
		$links = array();
	
		for ($i = $page_start; $i<$page_end; ++$i)
		{
			$links[$i] = str_replace('{__PAGE__}', $i, $link);
		}
	
		$info['links'] = $links;
	
		$str =  _C_View::layout('pagesList', $info);
	
		return $str === false ? '' : $str;
	}
	*/
	
	public static function artSlides($pos_id, $total=10)
	{	
		$recommends = DB::findAll(DB::ARTPOS, array('id'=>$pos_id), array('sort'=>'DESC'), '*', $total);
		
		$tail_count = $total - count($recommends);
		
		if ($tail_count > 0)
		{
			$find_recommends = DB::findAll(DB::ARTICLE, array('status'=>'0'), array('hits'=>'DESC'), 'id, title, author, guide, img, description, url, add_time, hits', $tail_count);
		
			$recommends = array_merge($recommends, $find_recommends);
		}
		$format['slides'] 		= '<div class="slides_container">%s</div><ul class="pagination">%s</ul>';
		$format['container']    = '<div><h2>%s</h2>%s</div>';
		$format['pagination']   = '<li><a href="#">%d %s</a></li>';
		$slides['container']    = '';
		$slides['pagination']   = '';
		foreach ($recommends as $i => $article)
		{
			$slides['container'] .= sprintf($format['container'], $article['title'], $article['guide']); 
			$slides['pagination'] .= sprintf($format['pagination'], $i+1, $article['title']);
		}
		
		return sprintf($format['slides'], $slides['container'], $slides['pagination']);
	}
}
?>