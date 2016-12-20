<?php
class v_stat {
	
	const TABLE = 'v_stat';
	
	private $_table;
	
	private $_date;
	
	public function __construct($table)
	{
		$this->_table = $table;
		$this->_date  = date('Y-m-d', SYS_TIME);
	}
	
	private function inc($field, $id)
	{
		DB::update(self::TABLE, "`{$field}`=`{$field}`+1", array('v_table'=>$this->_table, 'v_id'=>$id, 'v_date'=>$this->_date));
		if (DB::affectedRows() == 0)
		{
			$data = array(
				'v_table'		=> $this->_table,		
				'v_id'			=> $id,
				'v_date'		=> $this->_date,
				'v_hits'		=> 0,
				'v_downloads'	=> 0,
				'v_ups'		=> 0,
			);
			$data[$field] = 1;
			DB::insert(self::TABLE, $data);
		}
		return true;
	}
	
	public function getTopIdArr($field, $top, $day=0)
	{
		$where[] = "v_table='{$this->_table}'";
		if ($day != 0)
		{
			$day = abs($day);
			$where[] = "DATEDIFF('{$this->_date}', v_date)<{$day}";
		}
		$data = DB::findAll(self::TABLE, implode(' and ', $where), array($field=>'DESC'), 'v_id', $top);
		if ($top - count($data) > 0)
		{
			$data = array_merge($data, DB::findAll($this->_table, null, array('collect_time' => 'DESC'), 'id', 2*$top));
		}
		$ids = array();
		foreach ($data as $arr)
		{
			if (count($ids) == $top)
			{
				break;
			}
			$arr['id'] = isset($arr['v_id']) ? $arr['v_id'] : $arr['id'];
			if (!in_array($arr['id'], $ids))
			{
				$ids[] = $arr['id'];
			}
		}
		return $ids;
	}
	
	public function getHits($top, $day=0)
	{
		return $this->getTopIdArr('v_hits', $top, $day);
	}
	
	public function hit($id)
	{
		return $this->inc('v_hits', $id);
	}
	
	public function getDownloads($top, $day=0)
	{
		return $this->getTopIdArr('v_downloads', $top, $day);
	}
	
	public function getUps($top, $day=0)
	{
		return $this->getTopIdArr('v_ups', $top, $day);
	}
	
	public function download($id)
	{
		return $this->inc('v_downloads', $id);
	}
	
	public function up($id)
	{
		return $this->inc('v_ups', $id);
	}
}

?>