<form method="post" action="" name="myform">
<?php if (!Module::controller()->model('user')->isLogined()):?>
<input type="text" name="author" value="" />
<input type="text" name="email" value="" />
<?php else:?>
<?php if ($this->pid <= 0):?>
<input type="text" value="" name="score" />
<?php endif;?>
<?php endif;?>
<textarea rows="5" cols="20" name="content"></textarea>
<input type="submit" value="提交" />
</form>