<?php
class M_article extends Model {
	
	private $_types;
	
	private $_count;
	
	private $_hit;
	
	private $_comment;
	
	private $_zan;
	
	private $M_article_tag;
	
	private $M_user_tag;
	
	private $M_rubbish;
	
	public function __construct()
	{
		parent::__construct('zmw_article');
		$this->_types = Module::controller()->model('type')->types();
		$this->_count = Module::controller()->model('article_count');
		$this->_hit = Module::controller()->model('article_hit');
		$this->_comment = Module::controller()->model('article_comment');
		$this->_zan = Module::controller()->model('article_zan');
		$this->M_article_tag = Module::controller()->model('article_tag');
		$this->M_user_tag = Module::controller()->model('user_tag');
		$this->M_rubbish = Module::controller()->model('article_rubbish');
	}
	
	public function types()
	{
		return $this->_types;
	}
	
	private function check($data)
	{
		$validers = array(
			'type' => array(new Valider(Valider::TYPE_ENUM, array_keys($this->_types)), 'type erorr'),
			'title' => array(new Valider(Valider::TYPE_REQUIRED), 'title rror'),
			'content' => array(new Valider(Valider::TYPE_REQUIRED),'content rror'),
		);
		
		foreach ($data as $name=>$value)
		{
			if (isset($validers[$name]))
			{
				if (!$validers[$name][0]->check($value))
				{
					$this->appendMessage($validers[$name][1]);
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	
	public function exists($id)
	{
		return $this->findOne('*', array('id'=>$id));
	}
	
	public function add($type, $title, $summary, $content, $tag)
	{
		if ($this->findOne('id', array('uid'=>$_SESSION['user']['id'], 'title'=>trim($title))))
		{
			$this->setMessage('alreay hav sum');
			return FALSE;
		}
		
		if ($_SESSION['user']['group']['article_publish_interval_limit'] > 0)
		{
			$row = $this->findOne('createtime', array('uid'=>$_SESSION['user']['id']), array('createtime'=>'DESC'));
			
			if ($row && SYS_TIME - $row['createtime'] < $_SESSION['user']['group']['article_publish_interval_limit'])
			{
				$this->setMessage('time limit');
				return FALSE;
			}		
		}
		
		$data = compact('type', 'title', 'summary', 'content');
		if (!$this->check($data))
		{
			return FALSE;
		}
		
		$data['createtime'] = SYS_TIME;
		$data['uid'] = $_SESSION['user']['id'];
		$data['author'] = $_SESSION['user']['username'];
		$data['status'] = 0;
		if (!$this->insert($data))
		{
			return FALSE;
		}
		$articleid = $this->insertId();
		$this->_count->init($articleid);
		$this->_hit->init($articleid);
		$this->article_tag($articleid, $tag);
		
		return TRUE;
	}
	
	public function del($id)
	{
		if (($row=$this->findOne('*', array('id'=>$id)))!==FALSE)
		{
			$this->M_rubbish->insert($row);
			if ($this->delete(array('id'=>$id)))
			{
				$this->_count->delete(array('id'=>$id));
				$this->_hit->delete(array('id'=>$id));
				$this->_comment->delete(array('articleid'=>$id));
				$this->_zan->delete(array('articleid'=>$id));
				
				foreach ($this->M_article_tag->select('tagid', array('articleid'=>$id)) as $row)
				{
					$this->M_user_tag->setTagNum($row['tagid']);
				}
				$this->M_article_tag->delete(array('articleid'=>$id));
			}
		}
		
		$this->M_user_tag->clearUserZeroTag($_SESSION['user']['id']);
		return TRUE;
	}
	
	public function getArticleShow($id)
	{
		$data = $this->findOne('*', array('id'=>$id));
		if (!$data)
		{
			$this->setMessage('not found');
			return FALSE;
		}
		
		$data['type'] = $this->_types[$data['type']];
		$this->_hit->plus($id);
		$data['hit'] = $this->_hit->get($id);
		$this->_count->setHit($id, $data['hit']['views']);
		$data['count'] = $this->_count->get($id);
		return $data;
	}
	
	public function getArticleTags($id)
	{
		$tagids = array();
		
		foreach ($this->M_article_tag->select('tagid', array('articleid'=>$id)) as $row)
		{
			$tagids[] = $row['tagid'];
		}
		
		$tags = array();
		
		foreach ($this->M_user_tag->select('id, name', 'id in (\''.implode('\',\'', $tagids).'\')') as $row)
		{
			$tags[$row['id']] = $row['name'];
		}
		
		return $tags;
	}
	
	public function getArticleEdit($id)
	{
		$data = $this->findOne('*', array('id'=>$id));
		if (!$data)
		{
			$this->setMessage('not found');
			return FALSE;
		}
		
		$data['tag'] = implode(' ', $this->getArticleTags($id));
		
		return $data;
	}
	
	public function get($id)
	{
		$data = $this->findOne('*', array('id'=>$id));
		if (!$data)
		{
			$this->setMessage('not found');
			return FALSE;
		}
		
		$data['type'] = $this->_types[$data['type']];
		$this->_hit->plus($id);
		$data['hit'] = $this->_hit->get($id);
		$this->_count->setHit($id, $data['hit']['views']);
		$data['count'] = $this->_count->get($id);
		return $data;
	}

	public function edit($id, $type, $title, $summary, $content, $tag)
	{
		$title = trim($title);
		if ($this->findOne('id', "id!='{$id}' AND uid='{$_SESSION['user']['id']}' AND title='{$title}'"))
		{
			$this->setMessage('alreay hav sum');
			return FALSE;
		}
		
		$data = compact('type', 'title', 'summary', 'content');
		$where = array('id'=>$id);
		if (!$this->check($data))
		{
			return FALSE;
		}
		if (!$this->update($data, $where))
		{
			return FALSE;
		}
		$this->article_tag($id, $tag);
		return TRUE;
	}
	
	public function pages($where, $order, $data, $page, $pagesize)
	{
		$infos = parent::pages($where, $order, $data, $page, $pagesize);
		$rows = $infos['rows'];
		foreach ($infos['rows'] as $i=>$row)
		{
			$row['type'] = $this->_types[$row['type']];
			$row['createtime'] = date('y/n/j', $row['createtime']);
			$infos['rows'][$i] = $row;
		}
		return $infos;
	}
	
	public function zan($articleid)
	{
		$uid = $_SESSION['user']['id'];
		$author = $_SESSION['user']['username'];
		if ($this->_zan->findOne('*', array('articleid'=>$articleid, 'uid'=>$uid)))
		{
			$this->setMessage('has do it');
			return FALSE;
		}
		$data = compact('articleid', 'uid', 'author');
		$data['dateline'] = SYS_TIME;
		$this->insert($data);
		$this->_count->setZan($articleid, $this->_zan->count(array('id'=>$articleid)));
		return TRUE;
	}
	
	public function delzan($articleid)
	{
		$uid = $_SESSION['user']['id'];
		$where = compact('articleid', 'uid');
		$this->_zan->delete($where);
		$this->_count->setZan($articleid, $this->_zan->count(array('id'=>$articleid)));
	}
	
	public function comment_add($articleid, $pid, $content, $score, $uid, $author, $email)
	{
		if (!$this->_comment->add($articleid, $pid, $content, $score, $uid, $author, $email))
		{
			$this->setMessage($this->_comment->getMessage());
			return FALSE;
		}
		$this->_count->setScore($articleid, $this->_comment->scoreAvg($articleid));
		$this->_count->setComment($articleid, $this->_comment->count(array('articleid'=>$articleid, 'pid'=>0)));
		return TRUE;
	}
	
	public function comment_del($id)
	{
		$row = $this->_comment->findOne('pid, articleid', array('id'=>$id));
		if ($row && $row['pid']==0)
		{
			$this->_count->setComment($id, $this->_comment->count(array('articleid'=>$row['articleid'], 'pid'=>0)));
		}
		$this->_comment->del($id);
	}
	
	public function article_tag($articleid, $tag)
	{
		$names = preg_split('/\s+/', trim(preg_replace('/[,，]/', ' ', $tag)));
		foreach ($names as $name)
		{
			$this->M_user_tag->add($name, $_SESSION['user']['uid']);
		}
		
		$tags = array();
		foreach ($this->M_user_tag->select('id, name', 'uid=\''.$_SESSION['user']['id'].'\' AND name in (\''.implode('\',\'', $names).'\')') as $row)
		{
			$tags[$row['id']] = $row['name'];
		}
		
		$this->M_article_tag->delete(array('articleid'=>$articleid));
		
		foreach (array_keys($tags) as $tagid)
		{
			$this->M_article_tag->insert(array('articleid'=>$articleid, 'tagid'=>$tagid));
			$this->M_user_tag->setTagNum($tagid);
		}
		
		$this->M_user_tag->clearUserZeroTag($_SESSION['user']['id']);
		
		return TRUE;
	}
}

?>