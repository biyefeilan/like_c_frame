<?php
class M_user_tag extends Model {
	private $article_tag;
	
	public function __construct()
	{
		parent::__construct('zmw_user_tag');
		$this->article_tag = Module::controller()->model('article_tag');
	}
	
	public function setTagNum($tagid)
	{
		$num = $this->article_tag->count(array('tagid'=>$tagid));
		$this->update(array('num'=>$num), array('id'=>$tagid));
		return $num;
	}
	
	public function clearUserZeroTag($uid)
	{
		$this->delete(array('num'=>0, 'uid'=>$uid));
	}
	
	public function add($name, $uid)
	{
		$data = array();
		if (!preg_match('/^[\x{4e00}-\x{9fa5}]{1,10}$|^[a-zA-Z]\w{1,20}$/u', $name))
		{
			$this->setMessage('error name');
			return FALSE;
		}
			
		if ($this->M_tag->findOne('id', array('name'=>$name, 'uid'=>$uid)))
		{
			$this->setMessage('tag exists');
			return FALSE;
		}
		$data['name'] = $name;
		$data['uid'] = $uid;
		$data['status'] = 1;
		$data['num'] = 0;
		
		return $this->insert($data);
	}
	
	public function before_update($data, $where)
	{
		parent::before_insert($data);
		if (!preg_match('/^[\x{4e00}-\x{9fa5}]{1,10}$|^[a-zA-Z]\w{1,20}$/u', $data['name']))
		{
			$this->setMessage('name erro');
			return FALSE;
		}
		
		$id = isset($where['id']) ? $where['id'] : $data['id'];
		
		$name = isset($data['name']) ? $data['name'] : $where['name'];
		
		if ($this->findOne('id', "id!='{$id}' AND name='{$name}'"))
		{
			$this->setMessage('name alreay exists!');
			return FALSE;
		}
		
		return TRUE;
	}

	
	public function getTagsByUser($uid)
	{
		$tags = array();
		foreach ($this->select('id, name', array('uid'=>$uid)) as $row)
		{
			$tags[$row['id']] = $row['name'];
		}
		return $tags;
	}
}

?>