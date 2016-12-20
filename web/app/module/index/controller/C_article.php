<?php

class C_article extends Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function useradd()
	{
		if (!empty($_POST))
		{
			if ($this->M_add($_POST['type'], $_POST['title'], $_POST['summary'], $_POST['content']))
			{
				$this->V_success('成功');
			}
			else
			{
				$this->V_error($this->M_getMessage());
			}
		}
		else
		{
			$this->V_template('input')->assign(array('types'=>$this->M_types()))->show();
		}
	}

	public function useredit($id=-1)
	{
		$data = $this->M_findOne('*', array('id'=>$id, 'uid'=>$_SESSION['user']['id']));
		if (!$data)
		{
			$this->V_error('不村子啊');
		}
		else if (!empty($_POST))
		{
			if ($this->M_edit($id, $_POST['type'], $_POST['title'], $_POST['summary'], $_POST['content']))
			{
				$this->V_success('成功');
			}
			else
			{
				$this->V_error($this->M_getMessage());
			}
		}
		else
		{
			$data['types'] = $this->_types;
			$this->V_template('input')->assign($data)->show();
		}
	}
	
	public function userlist()
	{
		$artiles = array();
		foreach ($this->M_select('id, title, createtime, type, flower, hate, status', array('uid'=>$_SESSION['user']['id'])) as $row)
		{
			$row['type'] = $this->_types[$row['type']];
			$artiles[] = $row;
		}
		$this->V_assign(array('articles'=>$artiles))->show();
	}
	
	public function show($id)
	{
		$data = $this->M_get($id);
		if (!$data)
		{
			$this->V_error($this->M_getMessage());
		}
		else 
		{
			$this->V_assign($data)->show();
		}
	}
	
	public function userzan($id)
	{
		if (!$this->M_zan($id))
		{
			$this->V_error($this->M_getMessage());
		}
		else 
		{
			$this->V_success();
		}
	}
	
	public function userdelzan($id)
	{
		$this->M_delzan();
		$this->V_success();
	}
	
	public function commentadd($articleid=-1, $pid=0)
	{
		$article = $this->M_findOne('id', array('id'=>$articleid));
		if (!$article)
		{
			$this->V_error('不存在');
			return FALSE;
		}
		$pid = (int)$pid;
		if ($pid>0)
		{
			$comment = $this->model('article_comment')->findOne('id', array('id'=>$pid));
			if (!$comment)
			{
				$this->V_error('不存在');
				return FALSE;
			}
		
		}
		
		if (!empty($_POST))
		{
			if (!isset($_POST['author']) && !$this->model('user')->islogined())
			{
				$this->appendMessage('error');
			}
				
			$_POST['uid'] = 0;
			if (!isset($_POST['author']))
			{
				$_POST['author'] = $_SESSION['user']['username'];
				$_POST['email'] = $_SESSION['user']['email'];
				$_POST['uid'] = $_SESSION['user']['id'];
			}
				
			if ($this->M_comment_add($articleid, $pid, $_POST['content'], isset($_POST['score']) ? $_POST['score'] : -1, $_POST['uid'], $_POST['author'], $_POST['email']))
			{
				$this->V_success('成功');
			}
			else
			{
				$this->V_error($this->M_getMessage());
			}
		}
		else
		{
			$this->V_assign(array('pid'=>$pid))->show();
		}
	}
	
	public function usercommentdel($id)
	{
		$this->M_comment_del($id);
	}
	
}

?>