<?php

(defined ( 'APP_PATH' )) || exit ( 'Access deny!' );

class Valider {
	
	const TYPE_REQUIRED = 'required';
	
	const TYPE_PCRE = 'pcre';
	
	const TYPE_ENUM = 'enum';
	
	public $type;
	
	public $rule;
	
	public function __construct($type='', $rule='')
	{
		$this->type = $type;
		$this->rule = $rule;
	}
	
	public function check($value)
	{
		$result = FALSE;
		switch ($this->type)
		{
			case Valider::TYPE_REQUIRED:
				$value = trim($value);
				$result = !!$value;
				break;
			case Valider::TYPE_PCRE:
				$result = !!preg_match($this->rule, $value);
				break;
			case Valider::TYPE_ENUM:
				$result = in_array($value, $this->rule);
				break;
		}
		
		return $result;
	}
}

?>