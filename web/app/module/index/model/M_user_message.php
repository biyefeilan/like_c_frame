<?php
class M_user_message extends Model {
	
	public function __construct()
	{
		parent::__construct('zmw_member_message');
	}
	
	public function count_msg_send($uid)
	{
		return $this->count(array('fromuid'=>$uid));
	}
	
	public function count_msg_recv($uid)
	{
		return $this->count(array('touid'=>$uid));
	}
	
	public function count_msg_unread($uid)
	{
		return $this->count(array('touid'=>$uid, 'read'=>0));
	}
}

?>