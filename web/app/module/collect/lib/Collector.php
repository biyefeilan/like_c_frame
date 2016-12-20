<?php

abstract class Collector {

	private $_model;
	
	private $_messages = array();
	
	private $_lastestUniqueIds = array();

	public function __construct(CollectorModel $model)
	{
		$this->_model = $model;
	}

	protected function addData($data)
	{
		$unique_id = $this->_model->push($data);
		if ($unique_id === false)
		{
			return false;
		}
		
		if ( in_array($unique_id, $this->_lastestUniqueIds))
		{
			$this->_model->pop();
			return false;
		}
		
		return true;
	}
	
	abstract public function do_work();
	
	public function getModel()
	{
		return $this->_model;
	}
	
	protected function add_message($msg)
	{
		$this->_messages[] = $msg; 
	}
	
	public function getMessages()
	{
		return $this->_messages;
	}
}

?>