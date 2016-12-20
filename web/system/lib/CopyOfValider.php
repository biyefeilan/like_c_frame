<?php

(defined ( 'APP_PATH' )) || exit ( 'Access deny!' );

class Valider {
	
	const TYPE_REQUIRED = 'required';
	
	const TYPE_PCRE = 'pcre';
	
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
				$result = !!$value;
				break;
			case Valider::TYPE_PCRE:
				$result = !!preg_match($this->rule, $value);
				break;
		}
		
		return $result;
	}
	
	public static function validersCheck($validers, $data)
	{
		foreach ($data as $name=>$value)
		{
			if (isset($validers[$name]))
			{
				if (!$validers[$name]->check($value))
				{
					return FALSE;
				}
			}
		}
		return TRUE;
	}
}

?>