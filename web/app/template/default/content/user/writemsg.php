<?php View::load('user/header');?>
<div class="mainbar">
	<div class="article">
		<h2><span>写</span>文章</h2><div class="clr"></div>
			<form action="" method="post" id="msgform">
			<ol>
			<li>
				<label for="who"><font color="red">*</font>收件人</label>
				<input type="text" name="who" value="<?php echo $this->who;?>" />
			</li>
			<li>
				<label for="message"><font color="red">*</font>消息</label>
            	<textarea rows="8" cols="20" name="message"><?php echo $this->message; ?></textarea>
			</li>
			<li>
            	<input type="button" class="button" value="发送" id="send" />
            	<input type="button" class="button" value="存草稿" id="draft" />
            	<div class="clr"></div>
          	</li>
          	</ol>
          	</form>
	</div>
</div>
<?php View::load('user/sidebar');?>
<?php View::load('user/footer');?>