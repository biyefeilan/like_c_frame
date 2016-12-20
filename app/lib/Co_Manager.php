<?php
class Co_Manager {
	
	const TABLE = 'Co_Manager';
	
	public static function do_work()
	{
		set_time_limit(300);
		ignore_user_abort(true);
		ini_set('pcre.backtrack_limit', '900000');
		ini_set('pcre.recursion_limit', '900000');
		
		$score = 0;
		
		foreach(DB::findAll(self::TABLE, array('status'=>0), array('id'=>'asc'), '*') as $task)
		{
			if (
					($task['interval_time'] > 0 && (SYS_TIME-$task['collect_time'] > $task['interval_time'])) &&
					($task['collecting'] == 0 || ($task['collect_maxtime']>0 && SYS_TIME-$task['collect_time'] > $task['collect_maxtime'] )) &&
					(DB::update(self::TABLE, array('collecting'=>1, 'collect_time'=>SYS_TIME), array('id'=>$task['id'])) && DB::affectedRows() > 0)
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
				
				$collector = new $task['collector']($task['id'], $task['model']);
				$reporter  = new Co_Reporter($task['id'], $task['collector']); 
				
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
				
				DB::update(self::TABLE, array('collecting'=>0, 'collect_time'=>time()), array('id'=>$task['id']));
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