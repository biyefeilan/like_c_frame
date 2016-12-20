<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>article add</title>

</head>
<body>
<?php foreach ($this->articles as $article):?>
<div><?=$article['title'];?>  <?=$article['type'];?></div>
<?php endforeach;?>
</body>
</html>