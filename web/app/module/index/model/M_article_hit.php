<?php
class M_article_hit extends Model {
	
	public function __construct()
	{
		parent::__construct('zmw_article_hit');
	}
	
	public function init($articleid)
	{
		$data = array('id'=>$articleid, 'views'=>0, 'yesterdayviews'=>0, 'dayviews'=>0, 'weekviews'=>0, 'monthviews'=>0, 'updatetime'=>0);
		$this->insert($data);
		//return $data;
	}
	
	public function plus($id)
	{
		$row = $this->findOne('*', array('id'=>$id));
		if (!$row)
		{
			$data = $this->init($id);
		}
		else
		{
			$data['updatetime'] = SYS_TIME;
			
			$data['views'] = $row['views']+1;
			
			if (date('m', $row['updatetime']) != date('m', SYS_TIME))
			{
				$data['monthviews'] = 1;
			}
			else 
			{
				$data['monthviews'] = $row['monthviews']+1;
			}
			
			if (date('W', $row['updatetime']) != date('W', SYS_TIME))
			{
				$data['weekviews'] = 1;
			}
			else
			{
				$data['weekviews'] = $row['weekviews']+1;
			}
			
			if (date('Y-m-d', $row['updatetime']) == date('Y-m-d', SYS_TIME-24*3600))
			{
				$data['yesterdayviews'] = $row['dayviews'];
			}
			else if ($row['updatetime']-SYS_TIME > 24*3600)
			{
				$data['yesterdayviews'] = 0;
			}
			
			if (date('Y-m-d', $row['updatetime']) != date('Y-m-d', SYS_TIME))
			{
				$data['dayviews'] = 1;
			}
			else
			{
				$data['dayviews'] = $row['dayviews']+1;
			}
			
			$this->update($data, array('id'=>$id));
		}
		
		//return $data;
	}
	
	public function get($id)
	{
		$row = $this->findOne('*', array('id'=>$id));
		if (!$row)
		{
			$row = $this->init($id);
		}
		else
		{
			$data = array();
			if (date('m', $row['updatetime']) != date('m', SYS_TIME))
			{
				$data['monthviews'] = 0;
			}
			
			if (date('W', $row['updatetime']) != date('W', SYS_TIME))
			{
				$data['weekviews'] = 0;
			}
			
			if (date('Y-m-d', $row['updatetime']) == date('Y-m-d', SYS_TIME-24*3600))
			{
				$data['yesterdayviews'] = $row['dayviews'];
			}
			else if ($row['updatetime']-SYS_TIME > 24*3600)
			{
				$data['yesterdayviews'] = 0;
			}
			
			if (date('Y-m-d', $row['updatetime']) != date('Y-m-d', SYS_TIME))
			{
				$data['dayviews'] = 0;
			}
			
			if (!empty($data))
			{
				$this->update($data, array('id'=>$id));
				$row = array_merge($row, $data);
			}
			
		}
		return $row;
	}
	
	
}

?>