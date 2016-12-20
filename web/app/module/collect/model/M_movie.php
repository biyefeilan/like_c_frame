<?php
class M_movie extends Model {
	private $M_stat;
	
	public function __construct()
	{
		parent::__construct('mo_bt');
		$this->M_stat = Module::controller()->model('stat');
		$this->M_stat->setTable('mo_bt');
	}
	
	public function list_page($page)
	{
		$data = $this->M_pages(NULL, array('collect_time'=>'DESC'), array('id','title', 'content'), $page, 10);
		foreach ($data['rows'] as $i => $row)
		{
			$data['thumb'] = $this->get_content_img($row['content']);
			$data['link'] = $this->show_link($row['id']);
			unset($row['content']);
			$data['rows'][$i] = $row;
		}
		return $data;
	}
	
	public function get($id) 
	{
		if (($data=$this->M_findOne('*', array('id'=>$id)))===FALSE)
		{
			return FALSE;
		}
		$data['uri'] = _C_Router::mkurl(Module::getModule(), 'movie', 'download', $id);
		$data['prev'] = $this->M_findOne('id, title', 'id>'.$data['id'], array('id'=>'ASC'));
		$data['prev']['link'] = $this->show_link($data['prev']['id']);
		$data['next'] = $this->M_findOne('id, title', 'id<'.$data['id'], array('id'=>'DESC'));
		$data['next']['link'] = $this->show_link($data['next']['id']);
		return $data;
	}
	
	public function list_lastest($num=5) 
	{
		$rows = array();
		foreach ($this->findAll(array('id', 'title'), NULL, array('collect_time'=>'DESC'), $num) as $row)
		{
// 			$row = String::msubstr($row['title'], 0, 16);
			$rows[] = $row;
		}
		return $rows;
	} 
	
	public function list_random()
	{
		$rows = array();
		foreach ($this->findAll(array('id', 'title'), NULL, 'rand()', 10) as $row)
		{
// 			$row = String::msubstr($row['title'], 0, 16);
			$rows[] = $row;
		}
		return $rows;
	}
	
	public function list_download()
	{
		$rows = array();
		foreach ($this->findAll('*', 'id in ('.implode(',', $this->M_stat->getDownloads(10)).')') as $row) 
		{
// 			$row = String::msubstr($row['title'], 0, 16);
			$rows[] = $row;
		}
		return $rows;
	}
	
	public function list_hit($num=10)
	{
		$rows = array();
		foreach ($this->findAll('*', 'id in ('.implode(',', $this->M_stat->getHits($num)).')') as $row)
		{
// 			$row = String::msubstr($row['title'], 0, 16);
			$rows[] = $row;
		}
		return $rows;
	}
	
	public function list_hot()
	{
		$rows = array();
		foreach ($this->findAll('*', 'id in ('.implode(',', $this->M_stat->getTopIdArr('hits', 10, 7)).')') as $row)
		{
// 			$row = String::msubstr($row['title'], 0, 16);
			$rows[] = $row;
		}
		return $rows;
	}
	
	public function download($id)
	{
		$this->M_stat->download($id);
	}
	
	public function show_link($id)
	{
		return _C_Router::mkurl(Module::getModule(), 'movie', 'show', $id);
	}

	public function get_content_img($content)
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
}

?>