<?php

class C_tag extends Controller {
	
	public function usertagadd()
	{
		if (!empty($_POST))
		{
			if ($this->M_add($_POST['name']))
			{
				$this->V_success('成功');
			}
			else
			{
				$this->V_error($this->M_getMessage());
			}
		}
		else
		{
			$this->V_template('input')->show();
		}
	}
	
	public function usertagedit($id=-1)
	{
		$data = $this->M_findOne('*', array('id'=>$id));
		if (!$data)
		{
			$this->V_error('不村子啊');
		}
		else if (!empty($_POST))
		{
			if ($this->M_edit($id, $_POST['name']))
			{
				$this->V_success('成功');
			}
			else
			{
				$this->V_error($this->M_getMessage());
			}
		}
		else
		{
			$this->V_template('input')->assign($data)->show();
		}
	}
}

?>