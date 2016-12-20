<?php

class C_collector extends Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function work()
	{
		set_time_limit(300);
		ignore_user_abort(true);
		ini_set('pcre.backtrack_limit', '900000');
		ini_set('pcre.recursion_limit', '900000');
	
		$score = 0;
		
		foreach($this->M_findAll('*', array('status'=>0), array('id'=>'asc')) as $task)
		{
			if (
			($task['interval_time'] > 0 && (SYS_TIME-$task['collect_time'] > $task['interval_time'])) &&
			($task['collecting'] == 0 || ($task['collect_maxtime']>0 && SYS_TIME-$task['collect_time'] > $task['collect_maxtime'] )) &&
			($this->M_update(array('collecting'=>1, 'collect_time'=>SYS_TIME), array('collector'=>$task['collector'])) && $this->M_affectedRows() > 0)
			)
			{
				if ( !class_exists($task['collector']) )
				{
					self::log("{$task['collector']} not found");
					continue;
				}
	
				if ( !$task['model'])
				{
					self::log("{$task['model']} is not a valid model");
					continue;
				}
	
				$collector = new $task['collector']($task['model']);
				$reporter = new CollectorLog($task['collector']);
	
				try
				{
					$reporter->set_start();
					$collector->do_work();
					$reporter->set_end();
				}
				catch (Exception $e)
				{
					$reporter->set_result(1);
					$reporter->add_message("{$task['collector']} work error({$e->getMessage()}) at line {$e->getLine()}");
					$reporter->save();
					continue;
				}
				foreach ($collector->getMessages() as $message)
				{
					$reporter->add_message($message);
				}
	
				foreach ($collector->getModel()->getData($task['id']) as $data)
				{
					$reporter->inc_total();
					if ( DB::insert($task['model'], $data))
					{
						$reporter->inc_save();
						++$score;
					}
					else
					{
						$reporter->add_message('add Model data error at line '.__LINE__ .','.DB::lastError());
					}
				}
				if (!$reporter->save())
				{
					self::log("add Report data error at line {__LINE__}".DB::lastError());
				}
				
				$this->M_update(array('collecting'=>0, 'collect_time'=>time()), array('collector'=>$task['collector']));
			}
		}
		return $score;
	}
	
	private function log($msg)
	{
		_C_Log::write('[' . date('Y-m-d H:i:s') . '] '.__CLASS__.': ' . $msg);
	}
	
}

?>