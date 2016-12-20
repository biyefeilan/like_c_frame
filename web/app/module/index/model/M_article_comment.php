<?php
class M_article_comment extends Model {
	public function __construct()
	{
		parent::__construct('zmw_article_comment');
	}
	
	public function scoreAvg($articleid)
	{
		$scores = array();
		foreach ($this->select('score', array('articleid'=>$articleid)) as $row)
		{
			$scores[] = $row['score'];
		}
		return array_sum($scores)/count($scores);
	}
	
	public function add($articleid, $pid, $content, $score, $uid, $author, $email)
	{
		if ($pid > 0)
		{
			
		}
		else
		{
			if ($this->findOne('id', array('articleid'=>$articleid, 'email'=>$email)))
			{
				$this->setMessage('ping lun guo le!');
				return FALSE;
			}
			
			if ($_SESSION['user']['group']['comment_publish_interval_limit'] > 0)
			{
				$row = $this->findOne('dateline', array('email'=>$email, 'pid'=>0));
				if ($row && SYS_TIME - $row['dateline'] < $_SESSION['user']['group']['comment_publish_interval_limit'])
				{
					$this->setMessage('time limit');
					return FALSE;
				}
			}
			$score = max(0, $score);
			$score = min(100, $score);
		}
				
		$data = compact('articleid', 'pid', 'content', 'score', 'author', 'email', 'uid');
		$data['dateline'] = SYS_TIME;
		$data['agree'] = 0;
		$data['oppose'] = 0;
		
		$this->insert($data);
		
		return TRUE;
	}
	
	public function del($id)
	{
		$ids[] = $id;
		if (($child = $this->findOne('id', array('pid'=>$id)))!==FALSE)
		{
			$ids[] = $child['id'];
		}
		return $this->delete("id in ('".implode('\',\'', $ids)."')");
	}
}

?>