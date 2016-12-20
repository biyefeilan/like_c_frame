<?php

(defined ( 'APP_PATH' )) || exit ( 'Access deny!' );

class Input {
	
	public $name;
	
	public $type;
	
	public $value;
	
	public function __construct($name='', $type='', $value='')
	{
		$this->name = $name;
		$this->type = $type;
		$this->value = $value;
	}
	
	public function __toString()
	{
		return '<input name="'.$this->name.'" type="'.$this->type.'" value="'.$this->value.'" />';
	}
}

?>