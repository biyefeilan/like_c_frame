<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>...</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="<?php echo CSS_URL;?>member.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_URL;?>jquery-1.7.2.min.js"></script>
</head>
<body>
<div class="main">
  <div class="header">
    <div class="header_resize">
    	<div class="logo">
			<h1><a href="?m=content&c=article&a=category"><span>最</span>美文</a><small> 用最美丽的文字写出最好的美文</small></h1>
		</div>
		<div class="menu_nav">
			<ul>
				<?php foreach (array_merge( array(array('cat'=>'', 'name'=>'首页')),Common::nav()) as $nav):?>
				<li<?php echo (CURRENT_CATEGORY==$nav['cat'] ? ' class="active"' : '');?>><a href="?m=content&c=article&a=category&d=<?php echo $nav['cat'];?>"><span><?php echo $nav['name'];?></span></a></li>
				<?php endforeach;?>
			</ul>        
		</div>
    </div>
  </div>
  <div class="clr"></div>
  <div class="content">
    <div class="content_resize">