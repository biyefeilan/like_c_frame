<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo SITE_URL;?>" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $this->title;?></title>
<script type="text/javascript">
var time_stay = parseInt(time) || 3;
time_stay++;
function count_time()
{
	$('time_show').innerHTML = --time_stay;
	if (time_stay==0)
	{
		window.location.href = '<?php echo $this->url;?>';
	}
	else
	{
		setTimeout(count_time, 1000);
	}
}

function $(id)
{
	return document.getElementById(id);
}
window.onload = function(){count_time();}
</script>
</head>

<body>
	<h1><?php echo $this->title;?></h1>
	<div><?php echo $this->message;?></div>
	<div>
		<span id="time_show"></span><a href="<?php echo $this->url;?>" target="_self"></a>
	</div>
</body>
</html>

