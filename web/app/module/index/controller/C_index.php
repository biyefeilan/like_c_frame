<?php

class C_index extends Controller {
	
	public function index()
	{
		$this->V_show();
	}
	
	public function verify()
	{
		Image::verify();
	}
}

?>