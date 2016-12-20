<?php

abstract class Co_Collector {
	
	/**
	 * 
	 * @var Co_Model
	 */
	private $_model;
	
	protected $_co_manager_id;
	
	private $_messages = array();
	
	private $_lastestUniqueIds = array();
	
	public function __construct($co_manager_id, $model)
	{
		$this->_co_manager_id = $co_manager_id;
		$this->_model  = new Co_Model($model);
		$this->_lastestUniqueIds = $this->_model->getLastestUniqueIds($this->_co_manager_id);
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
	
	/**
	 * set model and report
	 */
	abstract public function do_work();
	
	/**
	 * @return Co_Model
	 */
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