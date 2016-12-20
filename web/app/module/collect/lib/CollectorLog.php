<?php
class CollectorLog {
	
	private $_data = array();
	
	private static $_results = array(
			0	=> 'SUCCESS',
			1	=> 'ERROR',
	);
	
	public function __construct($collector)
	{
		$this->_data = array(
				'collector'		=> $collector,
				'start'			=> '',
				'end'			=> '',
				'total'			=> 0,
				'save'			=> 0,
				'message'		=> '',
				'result'		=> self::$_results[0],
		);
	}
	
	/**
	 * Y-m-d H:i:s
	 * @param string $time
	*/
	public function set_start($time=null)
	{
		$this->_data['start'] = is_null($time) ? date('Y-m-d H:i:s', time()) : $time;
		return $this;
	}
	
	/**
	 * Y-m-d H:i:s
	 * @param string $time
	 */
	public function set_end($time=null)
	{
		$this->_data['end'] = is_null($time) ? date('Y-m-d H:i:s', time()) : $time;
		return $this;
	}
	
	public function inc_total()
	{
		++$this->_data['total'];
	}
	
	public function inc_save()
	{
		++$this->_data['save'];
	}
	
	public function add_message($message)
	{
		$this->_data['message'][] = '[' . date('Y-m-d H:i:s') . '] '.$message;
		return $this;
	}
	
	/**
	 *
	 * @param int $result
	 */
	public function set_result($result=0)
	{
		$this->_data['result'] = self::$_results[$result];
		return $this;
	}
	
	/**
	 *
	 * @return bool
	 */
	public function save()
	{
		$this->_data['message'] = is_array($this->_data['message']) ? implode("\r\n", $this->_data['message']) : '';
		return Module::controller()->model('collector_log')->insert($this->_data);
	}

}

?>