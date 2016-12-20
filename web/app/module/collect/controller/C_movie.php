<?php

class C_movie extends Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index($page=-1)
	{	
		$this->V_template('list')->assign(array(
			'main' => array(
				'title' => 'mm',
				'list' => $this->M_list_page($page),
			),
			'side' => array(
				array(
					'title' => '',
					'list' => $this->M_list_lastest(),		
				),
				array(
					'title' => '',
					'list' => $this->M_list_download(),
				),
				array(
					'title' => '',
					'list' => $this->M_list_hit(),
				),
				array(
					'title' => '',
					'list' => $this->M_list_hot(),
				),
			)
		))->show();
	}
	
	public function show($id)
	{
		$this->ASSERT(($data = $this->M_get($id))!==FALSE, 'not found');
		$this->V_assign(array(
			'data' => $data,
			'side' => array(
				array(
					'title' => '',
					'list' => $this->M_list_lastest(),		
				),
				array(
					'title' => '',
					'list' => $this->M_list_download(),
				),
				array(
					'title' => '',
					'list' => $this->M_list_hit(),
				),
				array(
					'title' => '',
					'list' => $this->M_list_hot(),
				),
			)
		))->show();
	}
	
	public function download($id)
	{
		if (!stristr($_SERVER['HTTP_HOST'],  'vivinice'))
			return ;
		$this->ASSERT(($data = $this->M_findOne(array('title', 'bt'), array('id'=>$id)))!==FALSE, 'not found');
		$this->M_download($id);
		$filename = sprintf('[%s]%s.torrent', 'vivinice.com', $data['title']);
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Type: application/x-bittorrent; charset=gbk');
		echo base64_decode($data['bt']);
	}
	
}

?>