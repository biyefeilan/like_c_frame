<?php
class M_index extends Model {
	private $article_tag;
	
	public function __construct()
	{
		parent::__construct('zmw_article');
		$this->article_tag = Module::controller()->model('article_tag');
	}
	
}

?>