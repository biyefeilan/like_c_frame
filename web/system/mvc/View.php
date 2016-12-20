<?php

class View {
	
	private $_templates=array();
	
	private $_data = NULL;
	
	private $_content = '';
	
	private $_template = '';
	
	private $_assigned = FALSE;
	
	public function __construct($folder)
	{
		$this->_templates[] = $folder.'/';
		
		if ($folder != '')
		{
			$this->_templates[] = '';
		}
	}
	
	public function template($name, $search=FALSE)
	{
		foreach ($this->_templates as $folder)
		{
			$tpl = _C_App::filePath ( $folder.$name, 'template');
			if (file_exists($tpl) || !$search)
			{
				break;
			}
		}
		
		$this->_template = $tpl;
		
		return $this;
	}
	
	public function assign($data=NULL)
	{
		_C_App::assert(file_exists($this->_template), "Template[{$this->_template}] not found!");
		$this->_assigned = TRUE;
		$this->_data = is_array($data) ? $data : array('data' => $data);
		ob_start();
		include ($this->_template);
		$this->_content = ob_get_contents();
		@ob_end_clean();
		return $this;
	}
	
	public function show()
	{
		echo $this->content();
	}
	
	public function content()
	{
		if (!$this->_assigned)
		{
			$this->assign();
		}
		return $this->_content;
	}
	
	public function import($name, $data=NULL) 
	{
		$this->template($name, TRUE)->assign(array('data'=>$data))->show();
	}
	
	public function getData()
	{
		return $this->_data;
	}
	
	public function __get($name)
	{
		return isset($this->_data[$name]) ? $this->_data[$name] : '';
	}
	
	public static function load($name, $data=NULL)
	{
		if ($data) 
		{
			$data = array('data' => $data);
			extract($data);
		}
		@include (_C_App::filePath ($name, 'template'));
	}
	
	public static function show404()
	{
		View::load('show404');
	}
	
	public static function direct($module, $class, $method, $data='', $query='', $reffer='')
	{
		if (!empty($reffer))
		{
			$query .= (empty($query) ? '' : '&').'reffer='.urlencode($reffer);
		}
		View::location(_C_Router::mkurl($module, $class, $method, $data, $query));
	}
	
	public static function location($url)
	{
		_C_Response::addHeader(array('Location'=>$url));
	}
	
	public static function error($message=NULL, $url=NULL)
	{
		View::load('error', $message);
	}
	
	public static function success($message=NULL, $url=NULL)
	{
		View::load('success', $message);
	}
}

?>