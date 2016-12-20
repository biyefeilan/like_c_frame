<?php
class M_user extends Model {
	
	private $M_message;
	
	private $M_group;
	
	private $M_article;
	
	public function __construct()
	{
		parent::__construct('zmw_member');
		$this->M_message = Module::controller()->model('user_message');
		$this->M_group = Module::controller()->model('user_group');
		$this->M_article = Module::controller()->model('article');
	}
	
	public function write($type, $title, $summary, $content, $tag)
	{
		if (!$this->M_article->add($type, $title, $summary, $content, $tag))
		{
			$this->setMessage($this->M_article->getMessage());
			return FALSE;
		}
		return TRUE;
	}
	
	public function writingmodify($id, $type, $title, $summary, $content, $tag)
	{
		if (!$this->M_article->edit($id, $type, $title, $summary, $content, $tag))
		{
			$this->setMessage($this->M_article->getMessage());
			return FALSE;
		}
		return TRUE;
	}
	
	
	private function check($data)
	{
		$validers = array(
			'username' => array(new Valider(Valider::TYPE_PCRE, '/^[\x{4e00}-\x{9fa5}]{2,6}$|^[a-zA-Z]\w{3,19}$/u'), 'username rror'),
			'password' => array(new Valider(Valider::TYPE_PCRE, '/^[a-zA-Z0-9_!@#$%^&*-]{4,20}$/'),'passwrod rror'),
			'email' => array(new Valider(Valider::TYPE_PCRE, '/^[_.0-9a-z-a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$/i'),'email rror'),
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
	
	public function login($username, $password)
	{
		$where = compact('username', 'password');
		if (!$this->check($where))
		{
			return FALSE;
		}
		$where['password'] = $this->encodePwd($where['password']);
		$user = $this->findOne('*', $where);
		if (!$user)
		{
			$this->appendMessage('user not found!');
			return FALSE;
		}
		$data['lastdate'] = SYS_TIME;
		
		$data['lastip'] = _C_Router::getClientIp();
		
		$data['loginnum'] = $user['loginnum']+1;
		
		$this->update($data, array('id'=>$user['id']));
		
		$_SESSION['user']['username'] = $user['username'];
		$_SESSION['user']['id'] = $user['id'];
		$_SESSION['user']['email'] = $user['email'];
		$_SESSION['user']['groupid'] = $user['groupid'];
		$_SESSION['user']['group'] = $this->M_group->findOne('*', array('id'=>$user['groupid']));
		
		return TRUE;
	}
	
	public function isLogined()
	{
		return !empty($_SESSION['user']);
	}
		
	private function encodePwd($password)
	{
		return md5($password);
	}
	
	public function add($username, $password, $email)
	{
		$data = compact('username', 'password', 'email');
		if (!$this->check($data))
		{
			return FALSE;
		}
		$data['password'] = $this->encodePwd($data['password']);
		
		if ($this->findOne('id', array('username'=>$data['username'])))
		{
			$this->setMessage('name alreay exists!');
			return FALSE;
		}
		
		if ($this->findOne('id', array('email'=>$data['email'])))
		{
			$this->setMessage('email alreay exists!');
			return FALSE;
		}
		
		$data['regdate'] = SYS_TIME;
		
		$data['lastdate'] = SYS_TIME;
		
		$data['regip'] = _C_Router::getClientIp();
		
		$data['lastip'] = _C_Router::getClientIp();
		
		$data['loginnum'] = 0;
		
		$data['groupid'] = 1;
		
		$data['islock'] = 0;
		
		if (!$this->insert($data))
		{
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function loginout()
	{
		$_SESSION['user'] = NULL;
		unset($_SESSION);
		session_destroy();
	}
	
	public function message_send($to_uid, $content, $reply_id)
	{
		$valider = new Valider(Valider::TYPE_REQUIRED);
		if (!$valider->check($content))
		{
			$this->setMessage('empty msg');
			return FALSE;
		}
		
		$data = array();
		$data['pid'] = max(0, $reply_id);
		$data['fromuid'] = $_SESSION['user']['id'];
		$data['fromuser'] = $_SESSION['user']['username'];
		$data['touid'] = $to_uid;
		$data['read'] = 0;
		$data['sendtime'] = SYS_TIME;
		$data['locked'] = 0;
		$data['hide'] = 0;
		
		if ($_SESSION['user']['group']['message_send_limit'] > 0 && $this->M_message->count_msg_send($_SESSION['user']['id']) > $_SESSION['user']['group']['message_send_limit'])
		{
			$this->setMessage('msg limit ');
			return FALSE;
		}
		
		if ($_SESSION['user']['group']['message_recv_limit'] > 0 && $this->M_message->count_msg_recv($_SESSION['user']['id']) > $_SESSION['user']['group']['message_recv_limit'])
		{
			$data['hide'] = 1;
		}
		
		$this->M_message->insert($data);
		return TRUE;
	}
	
	public function message_send_list()
	{
		
	}
	
	public function message_recv_list()
	{
		
	}
	
	public function message_read($id)
	{
		if (!($row=$this->M_message->findOne('*', array('id'=>$id))))
		{
			$this->setMessage('message nto fou');
			return FALSE;
		}
		
		$this->M_message->update('read=read+1', array('id'=>$id));
		
		return $row;
	}
	
	public function message_locked($id)
	{
		if (!($row=$this->M_message->findOne('*', array('id'=>$id))))
		{
			$this->setMessage('message nto fou');
			return FALSE;
		}
		
		if ($row['locked']==0)
		{
			$this->M_message->update(array('locked'=>1), array('id'=>$id));
		}
		
		return TRUE;
	}
	
	public function message_unlocked($id)
	{
		if (!($row=$this->M_message->findOne('*', array('id'=>$id))))
		{
			$this->setMessage('message nto fou');
			return FALSE;
		}
		
		if ($row['locked']==1)
		{
			$this->M_message->update(array('locked'=>0), array('id'=>$id));
		}
		
		return TRUE;
	}
	
	public function message_del($ids=array())
	{
		$this->M_message->delete('id in (\''.implode('\',\'', $ids).'\') AND locked!=1');
		
		if ($_SESSION['user']['group']['message_recv_limit'] > 0)
		{
			$rows = $this->M_message->select('id', array('hide'=>1), 'sendtime ASC', $_SESSION['user']['group']['message_recv_limit']);
			if (!empty($rows))
			{
				$ids = array();
				foreach ($rows as $row)
				{
					$ids[] = $row['id'];
				}
			}
			$this->M_message->update(array('hide'=>0), 'id in (\''.implode('\',\'', $ids).'\')');
		}
		
		return TRUE;
	}
	
}

?>