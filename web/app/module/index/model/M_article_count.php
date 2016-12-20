<?php
class M_article_count extends Model {
	
	public function __construct()
	{
		parent::__construct('zmw_article_count');
	}
	
	public function init($articleid)
	{
		$data = array('id'=>$articleid, 'score'=>0, 'hit'=>0, 'comment'=>0, 'agree'=>0, 'oppose'=>0);
		$this->insert($data);
		return $data;
	}
	
	public function setHit($articleid, $hit)
	{
		$this->update(array('hit'=>$hit), array('id'=>$articleid));
	}
	
	public function setScore($articleid, $score)
	{
		$this->update(array('score'=>$score), array('id'=>$articleid));
	}
	
	public function setComment($articleid, $comment)
	{
		$this->update(array('comment'=>$comment), array('id'=>$articleid));
	}
	
	public function setZan($articleid, $zan)
	{
		$this->update(array('zan'=>$zan), array('id'=>$articleid));
	}
	
	public function get($articleid)
	{
		return $this->findOne('*', array('id'=>$articleid));
	}
}

?>