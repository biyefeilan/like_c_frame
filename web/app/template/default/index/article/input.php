<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>article add</title>

</head>
<body>
<form method="post" action="" name="myform">
<input type="text" name="title" value="<?=$this->title;?>" />
<textarea rows="5" cols="20" name="summary"><?=$this->summary; ?></textarea>
<textarea rows="5" cols="20" name="content"><?=$this->content; ?></textarea>
<select name="type">
<?php foreach ($this->types as $id=>$name):?>
	<option value="<?=$id; ?>"<?php if ($id==$this->type) echo ' selected="selected"'?>><?=$name; ?></option>
<?php endforeach;?>
</select>
<input type="submit" value="提交" />
</form>
</body>
</html>