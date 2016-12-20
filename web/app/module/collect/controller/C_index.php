<?php

class C_index extends Controller {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{	
		$this->V_assign(array(
			'main' => array(
				array(
					'title'=> '',
					'list' => $this->model('movie')->list_lastest(16),
				),
				array(
					'title'=> '',
					'list' => $this->model('video')->list_lastest(16),
				),
// 				array(
// 					'title'=> '',
// 					'list' => $this->model('article')->list_lastest(16),
// 				),
			),
			'side' => array(
				array(
					'title' => '',
					'list' => $this->model('movie')->list_hit(),		
				),
				array(
					'title' => '',
					'list' => $this->model('video')->list_hit(),
				),
// 				array(
// 					'title' => '',
// 					'list' => $this->model('article')->list_hit(),
// 				),
			)
		))->show();
	}
	
}

?>