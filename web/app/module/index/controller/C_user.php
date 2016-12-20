<?php

class C_user extends Controller {
	
	public function register()
	{
		if ($this->M_isLogined())
		{
			$this->V_error('you dont need register!');
			return FALSE;
		}
		if (!empty($_POST))
		{
			if ($this->M_add($_POST['username'], $_POST['password'], $_POST['email']))
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
			$this->V_show();
		}
	} 
	
	public function login()
	{
		if ($this->M_isLogined())
		{
			$this->V_error('user has logined');
			return FALSE;
		}
		if (!empty($_POST))
		{
			if ($this->M_login($_POST['username'], $_POST['password']))
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
			$this->V_assign(array('message'=>isset($_GET['msg']) ? $_GET['msg'] : ''))->show();
		}
	}
	
	public function home($id=0, $page=1)
	{
		$this->ASSERT(($user = $this->M_findOne('*', array('id'=>$id)))!==FALSE, 'user not exist');
		
		$infos = $this->model('article')->pages(array('uid'=>$id), array('createtime'=>'DESC'), 'title, type, createtime', $page, 10);
		
		$this->V_show();
	}
	
	public function index()
	{
		if (!$this->M_isLogined())
		{
			$this->V_direct('user', 'login', '', 'msg='.urlencode('请先登录'));
			return FALSE;
		}
		$this->V_show();
	}
	
	public function tag()
	{
		$this->V_assign(array('tags'=>$this->model('tag')->getTagsByUser($_SESSION['user']['id'])))->show();
	}
	
	public function write()
	{
		if (!empty($_POST))
		{
			$this->WHICH($this->M_write($_POST['type'], $_POST['title'], $_POST['summary'], $_POST['content'], $_POST['tag']), 'chenggong', $this->M_getMessage());
		}
		else
		{
			$this->V_template('write')->assign(array('types'=>$this->model('article')->types()))->show();
		}
	}
	
	public function writingmodify($id=-1)
	{
		$this->ASSERT(($row = $this->model('article')->getArticleEdit($id))!==FALSE, 'not exist');
		
		if (!empty($_POST))
		{
			$this->WHICH($this->M_writingmodify($id, $_POST['type'], $_POST['title'], $_POST['summary'], $_POST['content'], $_POST['tag']), 'chenggong', $this->M_getMessage());
		}
		else
		{
			$this->V_template('write')->assign(array_merge($row, array('types'=>$this->model('article')->types())))->show();
		}
	}
	
	public function writingdel($id=-1)
	{
		$this->WHICH($this->model('article')->del($id));
	}
	
	public function writing($page=1)
	{
		$infos = $this->model('article')->pages(array('uid'=>$_SESSION['user']['id']), array('createtime'=>'DESC'), 'id, title, type, createtime', $page, 10);
	
		$this->V_assign($infos)->show();
	}
	
	public function loginout()
	{
		$this->M_loginout();
		$this->V_success('成功');
	}
	
	public function msgsend($touid, $reply_id=0)
	{
		$to_user = $this->M_findOne('*', array('id'=>$touid));
		if (!$to_user)
		{
			$this->V_error('不存在的');
			return FALSE;
		}
		else if (!empty($_POST))
		{
			if (!$this->M_message_send($touid, $_POST['content'], $reply_id))
			{
				$this->V_error($this->M_getMessage());
			}
			else
			{
				$this->V_success();
			}
		}
		else 
		{
			$this->V_show();
		}
	}
	
}

?>