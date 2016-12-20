<?php

class Reporter {
	
	const TABLE = 'vi_reporter';
	
	const STATUS_OK = 0;
	
	const MSG_OK = 'SUCCESS';
	
	private $site_id;
	
	private $act;
	
	private $collect_time;
	
	public function __construct($site_id, $act, $collect_time)
	{
		$this->site_id = $site_id;
		$this->act = $act;
		$this->collect_time = $collect_time;
	}
	
	private function save($msg, $status)
	{
		$data = array(
			'site_id'		=> $this->site_id,
			'act'			=> $this->act,
			'collect_time'	=> $this->collect_time,
			'msg'			=> $msg,
			'report_time'	=> time(),
			'status'		=> $status,		
		);
		if ( !DB::insert(Reporter::TABLE, $data) )
		{
			_C_Log::write('Reporter save data failed!');
		}
	}
	
	public static function collect_start($site_id, $act, $collect_time)
	{
		self::save($site_id, $act, $collect_time, self::MSG_OK, self::STATUS_OK);
	}

	public static function success($site_id, $act, $time_start, $time_end, $count_all, $count_save)
	{
		Reporter::save($site_id, $act, $time_start, $time_end, $count_all, $count_save, 0, 'SUCCESS');
	}
	
	public static function failed($site_id, $act, $time_start, $time_end, $count_all, $count_save, $msg)
	{
		Reporter::save($site_id, $act, $time_start, $time_end, $count_all, $count_save, 1, $msg);
	}
	
}

?>