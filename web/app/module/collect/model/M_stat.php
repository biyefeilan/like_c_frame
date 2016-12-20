<?php
class M_stat extends Model {
	private $_table;
	
	private $_date;
	
	public function __construct()
	{
		parent::__construct('v_stat');
		$this->_date  = date('Y-m-d', SYS_TIME);
	}
	
	public function setTable($table)
	{
		$this->_table = $table;
	}
	
	private function inc($field, $id)
	{
		$this->update("`{$field}`=`{$field}`+1", array('v_table'=>$this->_table, 'v_id'=>$id, 'v_date'=>$this->_date));
		if ($this->affectedRows() == 0)
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
			$this->insert($data);
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
		
		$ids = array();
		foreach ($this->findAll('v_id', implode(' and ', $where), array($field=>'DESC'), $top) as $row)
		{
			$ids[] = $row['v_id'];
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