<?php

class CollectorModel extends Model {
	
	private $_collector;
	
	private $_fields;
	
	private $_extra_fields = array(
			'id'		=> 'id',
			'uid'		=> 'unique_id',
			'time'		=> 'collect_time',
			'manager'	=> 'Co_Manager_id',
	);
	
	private $_collect_fields = array();
	
	private $_unique_ids = array();
	
	private $_extra_data = array();
	
	private $_collect_data = array();
	
	private $_data = array();
	
	private $_index = 0;
	
	public function __construct($collector, $model)
	{		
		parent::__construct($model);
		$this->_collector = $collector;
		
		foreach ($this->desc($this->_table) as $row)
		{
			$this->_fields[] = $row['Field'];
		}
		
		$this->_collect_fields = array_diff($this->_fields, $this->_extra_fields);
		
		$this->_index = 0;
	}
	
	public function getUniqueId($data)
	{
		return md5(implode('vivinice.com', $data));
	}
	
	public function push($data)
	{
		$new_data = array();
		foreach ($data as $field=>$val)
		{
			if (in_array($field, $this->_collect_fields))
			{
				$new_data[$field] = $val;
			}
		}
		$unique_id = $this->getUniqueId($new_data);
		if ( in_array($unique_id, $this->_unique_ids) )
		{
			return false;
		}
		$this->_unique_ids[$this->_index] = $unique_id;
		$this->_collect_data[$this->_index] = $new_data;
		$this->_extra_data[$this->_index] = array(
			$this->_extra_fields['uid']		=> $unique_id,
			$this->_extra_fields['time']	=> time(),
			$this->_extra_fields['manager'] => 0,
		);
		$this->_data[$this->_index] = array_merge($this->_collect_data[$this->_index], $this->_extra_data[$this->_index]);
		$this->_index += 1;
		return $unique_id;
	}
	
	public function pop()
	{
		$this->_index -= 1;
		$data = $this->_data[$this->_index];
		unset($this->_data[$this->_index], $this->_unique_ids[$this->_index], $this->_collect_data[$this->_index], $this->_extra_data[$this->_index]);
		return $data;
	}
		
	public function getExtraData()
	{
		return $this->_extra_data;
	}
	
	public function getCollectData()
	{
		return $this->_collect_data;
	}
	
	public function getData($co_manager_id)
	{
		foreach ($this->_data as $k => $v)
		{
			$v[$this->_extra_fields['manager']] = $co_manager_id;
			$this->_data[$k] = $v;
		}
		return $this->_data;
	}
	
	/**
	 * 
	 * @param uint $co_manager_id
	 * @param uint $count
	 */
	public function getLastestUniqueIds($co_manager_id=0, $count = 100)
	{
		$unique_ids = array();
		foreach (DB::findAll($this->_table, ($co_manager_id==0 ? null : array($this->_extra_fields['manager']=>$co_manager_id)), array($this->_extra_fields['time']=>'desc'), $this->_extra_fields['uid']) as $row)
		{
			$unique_ids[] = $row[$this->_extra_fields['uid']];
		}
		return $unique_ids;
	}
}

?>