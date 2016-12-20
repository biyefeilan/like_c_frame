<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($data['title'])?$data['title']:'';?></title>
<meta name="keywords" content="<?php echo isset($data['keywords'])?$data['keywords']:'';?>" />
<meta name="description" content="<?php echo isset($data['description'])?$data['description']:'';?>" />
<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow" />
<link href="<?php echo CSS_URL;?>main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_URL;?>jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URL;?>article.js"></script>
<script type="text/javascript" src="<?php echo JS_URL;?>raty2.5.2/jquery.raty.min.js"></script>
</head>
<body>
<div id="templatemo_header_wrapper">
	<div id="templatemo_header">
    	<div id="site_title">
            <h1><a href="<?php echo SITE_URL;?>" target="_self"><img src="<?php echo IMG_URL;?>logo.png" alt="vivinice.com" /><span></span></a></h1>
        </div>
    </div>
</div>
<div id="templatemo_menu">            
    <ul>
    <?php foreach (array_merge( array(array('cat'=>'', 'name'=>'首页')),Common::nav()) as $nav):?>
    	<li><a href="?m=content&c=article&a=category&d=<?php echo $nav['cat'];?>"<?php echo (CURRENT_CATEGORY==$nav['cat'] ? ' class="current"' : '');?>><?php echo $nav['name'];?></a></li>
    <?php endforeach;?>
    </ul>
</div>
<div id="templatemo_main">