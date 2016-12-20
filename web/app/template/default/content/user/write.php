<?php View::load('user/header');?>
<div class="mainbar">
	<div class="article">
		<h2><span>写</span>文章</h2><div class="clr"></div>
			<form action="" method="post">
			<ol>
			<li>
				<label for="title"><font color="red">*</font>标题</label>
				<input type="text" name="title" value="<?php echo $this->title;?>" />
			</li>
			<li>
				<label for="title">副标题</label>
				<input type="text" name="subtitle" value="<?php echo $this->subtitle;?>" />
			</li>
			<li>
				<label for="author">作者</label>
            	<input type="text" name="author" value="<?php echo $this->author;?>" />
			</li>
			<li>
				<label for="title">编者按</label>
				<textarea rows="3" cols="20" name="leaderette"><?php echo $this->leaderette;?></textarea>
			</li>
			<li>
				<label for="Preface">题记</label>
            	<textarea rows="3" cols="50" name="preface"><?php echo $this->preface; ?></textarea>
			</li>
			<li>
				<label for="content"><font color="red">*</font>正文</label>
            	<textarea rows="8" cols="20" name="content"><?php echo $this->content; ?></textarea>
			</li>
			<li>
				<label for="postscript">后记</label>
            	<textarea rows="3" cols="20" name="postscript"><?php echo $this->postscript; ?></textarea>
			</li>
			<li>
				<label><font color="red">*</font>栏目</label>
            	<select name="catid"><?php echo $this->category;?></select>
			</li>
			<li>
				<label><font color="red">*</font>原创</label>
            	<input type="radio" name="original" value="1"<?php if ($this->original=='1') echo ' checked="checked"'; ?>> 是
            	<input type="radio" name="original" value="0"<?php if (!$this->original) echo ' checked="checked"'; ?>> 否
			</li>
			<li>
            	<input type="image" name="submit" src="<?php echo IMG_URL;?>member/submit.gif" class="send" />
            	<div class="clr"></div>
          	</li>
          	</ol>
          	</form>
	</div>
</div>
<?php View::load('user/sidebar');?>
<?php View::load('user/footer');?>