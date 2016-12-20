<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>article add</title>

</head>
<body>
<ul>
<?=$this->info['records_count'];?>
<?php foreach ($this->rows as $row):?>
<li>[<?=$row['type']?>] <?=$row['title'];?> <?=$row['createtime'];?> <a href="?c=user&m=writingmodify&d=<?=$row['id'];?>">edit</a> <a href="?c=user&m=writingdel&d=<?=$row['id'];?>">del</a></li>
<?php endforeach;?>
</ul>
</body>
</html>