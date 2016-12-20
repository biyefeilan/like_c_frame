<?php
class M_type extends Model {
	public function __construct()
	{
		parent::__construct('zmw_type');
	}
	
	public function before_insert(&$data)
	{
		parent::before_insert($data);
		
		if ($this->findOne('id', array('name'=>$data['name'])))
		{
			$this->setMessage('name alreay exists!');
		}
		
		return $this->emptyMessage();
	}
	
	public function before_update(&$data, &$where)
	{
		parent::before_insert($data);
		
		if ($this->findOne('id', "id!='{$where['id']}' AND name='{$data['name']}'"))
		{
			$this->setMessage('name alreay exists!');
		}
	
		return $this->emptyMessage();
	}
	
	public function types()
	{
		static $types;
		if (isset($types))
		{
			return $types;
		}
		
		foreach ($this->select() as $row)
		{
			$types[$row['id']] = $row['name'];
		}
		return $types;
	}
}

?>