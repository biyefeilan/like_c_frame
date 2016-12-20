<?php 
	$title = isset($title) ? $title : 'VIVINICE.COM - 简单，自由，快乐';
	$keywords = isset($keywords) ? $keywords : '最新电影,美文赏析,bt下载,电影下载,搞笑视频,搞笑图片';
	$description = isset($description) ? $description : 'vivinice.com以简单，自由，快乐为宗旨，提供最新电影种子下载，搞笑图片，在线搞笑视频和精品美文等轻松幽默的作品，愿您快乐每一天。';
	$class = isset($result) && isset($result['class']) ? $result['class'] : _C_;
	$method = isset($result) && isset($result['method']) ? $result['method'] : _A_;
	$data = isset($result) && isset($result['data']) ? $result['data'] : _D_;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title><?php echo $title;?></title>
<meta name="keywords" content="<?php echo $keywords;?>" />
<meta name="description" content="<?php echo $description;?>" />
<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow" />
<link href="<?php echo CSS_URL;?>main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_URL;?>jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo JS_URL;?>com.js"></script>
<script type="text/javascript">var PAGEID = '<?php echo momgr::getPageId($class, $method, $data);?>';</script>
</head>
<body>

<div id="templatemo_header_wrapper">
	<div id="templatemo_header">
    	
    	<div id="site_title">
        
            <h1><a href="<?php echo SITE_URL;?>" target="_self"><img src="<?php echo IMG_URL;?>logo.png" alt="vivinice.com" /><span>简单 自由 快乐</span></a></h1>
            
        </div>
        
    </div>
</div>

<div id="templatemo_menu">            
    <ul>
    <?php foreach (Config::$categories as $k=>$v):?>
    	<?php if ( $v ):?>
    	<li><a href="<?php echo Url::mkurl($k, 'index');?>"<?php echo $k==$class ? ' class="current"' : '';?>><?php echo $v;?></a></li>
    	<?php endif;?>
    <?php endforeach;?>
    </ul>

</div>

<div id="templatemo_main">