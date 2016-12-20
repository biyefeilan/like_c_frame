<?php
class M_user_group extends Model {
	
	public function __construct()
	{
		parent::__construct('zmw_member_group');
	}
	
	public function get($gid)
	{
		return $this->findOne('*', array('id'=>$gid));
	}
}

?>