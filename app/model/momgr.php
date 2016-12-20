<?php

final class momgr {
	
	public static function index()
	{
		$page_id = isset($_GET['i']) ? base64_decode($_GET['i']) : 'unknown';
		if ($page_id != 'unknown')
		{
			list($class, $method, $data) = explode('-', $page_id);
			if ($method=='show')
			{
				if (method_exists($class, 'incHits'))
				{
					call_user_func_array(array($class, 'incHits'), array('id'=>$data));
				}
			}
		}
		if (Co_Manager::do_work() > 0)
		{
			//Htmler::create_index();
		}
		//momgr::tongji();
		//Sitemap::create();
		exit;
	}
	
	public static function getPageId($class, $method, $data)
	{
		return base64_encode(implode('-', array($class, $method, $data)));
	}
	
	public static function error($v_table, $v_id)
	{
		$table = 'v_error';
		$data['v_lastest_time'] = date('Y-m-d H:i:s',SYS_TIME);
		$data['v_table'] 		= $v_table;
		$data['v_id']			= $v_id;
		$data['v_count']		= 1;
		$data['v_minsecs']		= SYS_TIME - PREV_TIME;
		if ( ($info=DB::findOne($table, array('v_table'=>$data['v_table'], 'v_id'=>$data['v_id'])))!==false)
		{
			$data['count'] = $info['count']+1;
			$data['v_minsecs'] = min($data['v_minsecs'], $info['v_minsecs']);
			DB::update($table, $data, array('id'=>$info['id']));
		}
		else
		{
			DB::insert($table, $data);
		}
	}
	
	private static function tongji()
	{
		$table = 'v_tongji';
		$data['addr'] 			= _C_Router::getClientIp();
		$data['lastest_time'] 	= date('Y-m-d H:i:s',SYS_TIME);
		$data['host'] 			= $_SERVER['HTTP_HOST'];
		$data['msg']			= 'OK';
		$data['count']			= 1;
		$data['use_time']	= 0;
		if (PREV_TIME == SYS_TIME)
		{
			$data['msg'] = 'warning! No record PREV_TIME';
		}
		if ( ($info=DB::findOne($table, array('addr'=>$data['addr'])))!==false)
		{
			$data['count'] = $info['count']+1;
			$data['use_time'] = $info['use_time'] + (SYS_TIME - PREV_TIME);
			DB::update($table, $data, array('id'=>$info['id']));
		}
		else
		{
			$data['use_time'] = SYS_TIME - PREV_TIME;
			DB::insert($table, $data);
		}
	}
	
	public static function _init()
	{
		return true;
	}
	
	public static function _destroy()
	{
		return true;
	}

}

?>