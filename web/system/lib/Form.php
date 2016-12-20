<?php

(defined ( 'APP_PATH' )) || exit ( 'Access deny!' );

class Form {
	
	private $name;
	
	private $action;
	
	private $method;
	
	private $id;
	
	private $target='';
	
	private $auth = FALSE;
	
	private $authnow = FALSE;
	
	private $data = array();
	
	private $elements = array();
	
	private $validers = array();

	private $messages = array();
	
	private $errname = '';
	
	public function __construct($action='', $name='myform', $method='post')
	{
		$this->name = $name;
		$this->action = $action;
		$this->method = $method;
		$this->data = $this->method=='post' ? $_POST : $_GET;
	}
	
	public function setName($name)
	{
		$thi->name = $name;	
	}
	
	public function setAction($action, $ext1=NULL, $ext2=NULL)
	{
		if (is_null($ext1))
		{
			$this->action = $action;
		}
		$this->action = "?c={$action}&m={$ext1}".(is_null($ext2) ? '' : '&d='.$ext2);
	}
	
	public function setMethod($method)
	{
		$this->method = $method;
	}
	
	public function __toString()
	{
		$form[] = "<form name=\"{$this->name}\" method=\"{$this->method}\" action=\"{$this->action}\">";
		foreach ($this->elements as $element)
		{
			$form[] = (string)$element;
		}
		if ($this->auth)
		{
			$form[] = $this->getAuth();
		}
		$form[] = '<form>';
		return implode('', $form);
	}
	
	public function appendHtml($element)
	{
		$this->elements[] = $element;
		return $this;
	}
	
	public function append($element, $valider=NULL, $message='')
	{
		if (!is_null($valider))
		{
			$this->validers[$element->name] = $valider;
			$this->messages[$element->name] = $message;
		}
		return $this->appendHtml($element);
	}
	
	public function setValiders($validers)
	{
		$this->validers = $validers;
	}
	
	public function check()
	{
		foreach ($this->validers as $name=>$valider)
		{
			if (!$valider->check($this->getData($name)))
			{
				$this->errname = $name;
				return FALSE;
			}	
		}
		return TRUE;
	}
	
	public function getMessage()
	{
		return $this->messages[$this->errname];
	}
	
	public function setAuth($auth=TRUE)
	{
		$this->auth = $auth;
	}
	
	public function getAuth()
	{
		$string = substr(md5(uniqid(mt_rand(), true)), 0, 20);
		$name = substr($string, 0, 10);
		$value = substr($string, 10);
		$_SESSION['form'][$this->name]['auth']['name'] = $name;
		$_SESSION['form'][$this->name]['auth']['value'] = $value;
		$_SESSION['form'][$this->name]['auth']['string'] = $string;
		
		return '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
	}
	
	public function checkAuth()
	{
		if (!$this->auth || !isset($_SESSION['form'][$this->name]['auth']))
		{
			return FALSE;
		}
		$name = $_SESSION['form'][$this->name]['auth']['name'];
		$value = $_SESSION['form'][$this->name]['auth']['value'];
		$string = $_SESSION['form'][$this->name]['auth']['string'];
		unset($_SESSION['form'][$this->name]['auth']);
		$value2 = $this->getData($name);
		return $value == $value2 && $string == $name.$value2;
	}
	
	public function assignData($data)
	{
		if (is_array($data) && !empty($data))
		{
			foreach ($this->elements as $element)
			{
				if (isset($data[$element->name]))
				{
					$element->value = $data[$element->name];
				}
			}
		}
		return $this;
	}
	
	public function getData($name=NULL)
	{
		return is_null($name) ? $this->data : (isset($this->data[$name]) ? $this->data[$name] : NULL);
	}

}

?>