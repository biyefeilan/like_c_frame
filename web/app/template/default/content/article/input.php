<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>article add</title>

</head>
<body>
<form method="post" action="" name="myform">
<input type="text" name="title" value="<?=$this->title;?>" />
<textarea rows="3" cols="20" name="preface"><?=$this->preface; ?></textarea>
<textarea rows="5" cols="20" name="content"><?=$this->content; ?></textarea>
<textarea rows="3" cols="20" name="postscript"><?=$this->postscript; ?></textarea>
<select name="catid"><?=$this->category;?></select>
<input type="submit" value="提交" />
</form>
</body>
</html>