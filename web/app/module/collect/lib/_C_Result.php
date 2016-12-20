<?php

final class _C_Result 
{	
	public static function _init()
	{
		return _C_Util::call(_C_Config::vars('_C_Result/on_init'));
	}
	
	public static function _destroy()
	{
		return _C_Util::call(_C_Config::vars('_C_Result/on_destroy'));
	}
	
	public static function templateExists($template)
	{
		return file_exists(self::template($template));
	}
	
	public static function template($template) 
	{
		return _C_App::filePath ( $template, 'template');
	}
	
	public static function content($class, $method, $data_str)
	{
		$content = '';
		$result = _C_Result::_result($class, $method, $data_str);
		$result = _C_Result::_processResult($result, $class, $method, $data_str);
		if (is_array($result))
		{
			is_array ( $result['data'] ) && extract ( $result['data'] );
			ob_start();
			include (_C_Result::template($result['template']));
			$content = ob_get_contents();
			@ob_end_clean();
		}
		return $content;
	}
	
	/**
	*运行模型方法，返回结果
	*
	*/
	private static function _result($class, $method, $data_str)
	{	
		/*
		//对于data的处理，如果是偶数，则按照k=>v的方式
		$data = array ();
		$segs = explode ( '/', $data_str );
		if (count ( $segs ) > 0 && count ( $segs ) % 2 == 0)
		{
			for($i = 0; $i != count ( $segs ); $i += 2)
			{
				$data [$segs [$i]] = $segs [$i + 1];
			}
			//作为数据传给方法
			$data = array($data);
		}
		else
		{
			$data = $segs;
		}
		*/
		$data = explode ( '/', $data_str );

		$result = _C_Module::_call($class, $method, $data);
		
		$result_info = array (
				0 => $result, //result_type
				1 => array (), //result_config 这个会覆盖配置文件中结果的配置
				2 => array (), //数据
		);
		if (is_array ( $result ))
		{
			if (count ( $result ) == 2)
			{
				if (isset ( $result [1] ))
				{
					$result_info [2] = $result [1];
					unset ( $result [1] );
				}
				else
				{
					$result_info [2] = $result [0];
					unset ( $result [0] );
				}
			}
		
			$r = each ( $result );
			if (is_numeric ( $r [0] ))
			{
				$result_info [0] = $r [1];
			}
			else
			{
				$result_info [0] = $r [0];
				$result_info [1] = $r [1];
			}
		}
		
		
		if (in_array($result_info[0], _C_Result::resultTypes())) {
			return $result_info;
		}
		
		if (! class_exists ( $class ))
		{
			if (_C_Result::templateExists($class))
				$template = $class;
		}
		else
		{
			if (_C_Result::templateExists($class.DS.$method))
			{
				$template = $class.DS.$method;
			}
			else if (_C_Result::templateExists($class.DS.$method.DS.$data_str))
			{
				$template = $class.DS.$method.DS.$data_str;
			}
		}
			
		return isset($template) ? array(SHOW, array('template'=>$template), $data) : array(SHOW404, array(), $data);
	}
	
	public static function resultTypes() 
	{
		return array(
			'DATA' => '_C_data',
			'SUCCESS' => '_C_success',
			'ERROR' => '_C_error',
			'SHOW' => '_C_show',
			'SHOW404' => '_C_show404',
			'LOCATION' => '_C_location',
			'DIRECT' => '_C_direct',
			'JUMP' => '_C_jump',
		);
	}
	
	/**
	 * 处理结果
	 * @param array or string $result
	 * 1. result_type (string) result_type为SUCCESS ERROR DIRECT SHOW JUMP SHOW404中的一种
	 * 2. array(result_type, array()) array()为模型的数据，为模版显示
	 * 		e.g.array(SHOW, array('info'=>''hello world))
	 * 3. array(result_type=>array(), array()) result_type同上所对的value为一些设置
	 * 		e.g.array(SHOW=>array('template'=>'..'), array('content'=>'hello world'))
	 * 4. array(result_type) e.g. array(SHOW);
	 * $result必须有一个result_type，Result::VIEW_DATA可有可无
	 */
	private static function _processResult($result, $class='', $method='', $data_str='')
	{	
		$class = empty($class) ? strtolower(_C_Router::getClass()) : $class;
		$method = empty($method) ? strtolower(_C_Router::getMethod()) : $method;
		$data_str = empty($data_str) ? _C_Router::getData() : $data_str;
		$self_config = _C_Config::vars('_C_Result');
		$self_config = is_array($self_config)? $self_config : array();
		
		list($result_type, $result_config, $result_data) = $result;

		$m_config = _C_Config::vars($class);
		
		$m_config = is_array($m_config) && isset($m_config[$method]) && is_array($m_config[$method]) ? $m_config[$method] : array();
		//要传给模板的数据
		$data = null;
		//模板
		$template = null;
		
		switch ($result_type)
		{
			case DIRECT:
				if (!empty($result_config))
				{
					$uri = $result_config;
				}
				else if (isset ( $m_config [DIRECT] ))
				{
					$uri = $m_config [DIRECT];
				}
				else if (isset($self_config[DIRECT]))
				{
					$uri = $self_config[DIRECT];
				}
				
				if (!isset($uri) || !$uri) $uri = 'index';
				
				$segs = explode ( '/', trim ( $uri, '/' ) );
				if (($count = count ( $segs )) < 4)
				{
					switch ($count) {
						case 1 : //改变method重新组合
							$method = $segs [0];
							break;
						case 2 : //改变class和method重新组合
							$class = $segs [0];
							$method = $segs [1];
							break;
						case 3 : //改变class/method/data重新组合
							$class = $segs [0];
							$method = $segs [1];
							$data_str = $segs [2];
							break;
						default :
							break;
					}
				}
				return self::_processResult(self::_result($class, $method, $data_str), $class, $method, $data_str);
				break;
			case SUCCESS :
				if (!is_array($result_config))
				{
					if (is_string($result_config))
						$result_config = array('message'=>$result_config);
					//more...
				}
				$data = array_merge ( $result_config, $result_data );
				$data = array (
						'title' => isset ( $data ['title'] ) ? $data ['title'] : $self_config[SUCCESS]['title'],
						'message' => isset ( $data ['message'] ) ? $data ['message'] : $self_config[SUCCESS]['message']
				);
				break;
	
			case ERROR :
				if (!is_array($result_config))
				{
					if (is_string($result_config))
						$result_config = array('message'=>$result_config);
					//more...
				}
				$data = array_merge ( $result_config, $result_data );
				$data = array (
						'title' => isset ( $data ['title'] ) ? $data ['title'] : $self_config[ERROR]['title'],
						'message' => isset ( $data ['message'] ) ? $data ['message'] : $self_config[ERROR]['message']
				);
				break;
	
			case SHOW :
				if (is_string($result_config))
					$result_config = array('template'=>$result_config);
				//more...
				$data = $result_data;
				break;
	
			case JUMP :
				if (!is_array($result_config))
				{
					if (is_string($result_config))
						$result_config = array('message'=>$result_config);
					//more...
				}
				$data = array_merge ( $result_config, $result_data );
				$data = array (
						'title' => isset ( $data ['title'] ) ? $data ['title'] : $self_config[JUMP]['title'],
						'message' => isset ( $data ['message'] ) ? $data ['message'] : $self_config[JUMP]['message'],
						'link' => isset ( $data ['link'] ) ? $data ['link'] : $self_config[JUMP]['link'],
						'time' => isset ( $data ['time'] ) ? $data ['time'] : $self_config[JUMP]['time']
				);
				break;
	
			case SHOW404 :
				$data = array ('error_msg' =>'Page not found!');
				break;
				
			case LOCATION:
				_C_Response::addHeader(array('Location: '. (is_string($result_config) ? $result_config : (is_string($result_data) ? $result_data : '/'))));
				return FALSE;
				break;
			default:
				_C_App::triggerError('Result Type: ' . $result_type .' Not Found!');
				break;
		}
		
		if (isset ( $result_config['template'] ))
		{
			$template = $result_config['template'];
		}
		else if (isset($m_config[$result_type]) && isset ( $m_config [$result_type] ['template']))
		{
			$template = $m_config [$result_type] ['template'];
		}
		else 
		{
			if ($result_type == SHOW)
			{
				$template = $class.DS.$method;
			}
			else if (isset($self_config[$result_type]) && isset($self_config[$result_type]['template']))
			{
				$template = $self_config[$result_type]['template'];
			}	
		}
		
		if (empty($template) || _C_Result::templateExists($template) === false)
		{
			if (!empty($template) && _C_Result::templateExists($class.'/'.$template))
			{
				$template = $class.DS.$template;
			}
			else if (_C_Result::templateExists($class.'/'.$method))
			{
				$template = $class.DS.$method;
			}
			else
			{
				return self::_processResult(SHOW404);
			}
		}
		return array('template'=>$template, 'data'=>$data);
	}
}

?>