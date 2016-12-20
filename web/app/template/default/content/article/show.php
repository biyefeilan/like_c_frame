<?php View::load('article/header');?>
<div id="templatemo_content">
	<div class="gif_box">
		<h2><?php echo $this->title;?></h2>
		<div class="content"><?php echo $this->content;?></div>
		<div class="guide">
			<div class="float_l">上一篇<?php echo is_array($this->prev) ? '<a href="?m=content&c=article&a=show&d='.$this->prev['articleid'].'" title="'.$this->prev['title'].'" target="_self">'.String::msubstr($this->prev['title'], 0, 16).'</a>' : '没有了';?></div>
			<div class="float_r">下一篇<?php echo is_array($this->next) ? '<a href="?m=content&c=article&a=show&d='.$this->next['articleid'].'" title="'.$this->next['title'].'" target="_self">'.String::msubstr($this->next['title'], 0, 16).'</a>' : '没有了';?></div>
		</div>
		<div class="cleaner"></div>
	</div>
	<div id="gallery">
		<ul>
<?php foreach ($this->comment['list'] as $row):?>
			<li>
				<div class="comment">
					<p><?php echo $row['author'];?>[<?php echo $row['score'];?>分]：<?php echo $row['comment'];?></p>
					<div class="float_r"><?php echo date('Y/m/d', $row['dateline']);?> <input type="button" id="doagree_comment_<?php echo $row['commentid'];?>_1" value="言之有理(<?php echo $row['agree'];?>)" /><input type="button" id="doagree_comment_<?php echo $row['commentid'];?>_0" value="一派胡言(<?php echo $row['oppose'];?>)" /></div>
				</div>
			</li>
<?php endforeach;?>
		</ul>
	</div>
	<?php if (Common::get_variable('comment_allow')):?>
	<div id="comment_box">
		<form action="" name="myform" method="post">
		<div><textarea rows="5" cols="67" name="comment" id="comment"><?php if (!isset($_SESSION['user'])) {echo '你好游客，登录后评论。';}?></textarea></div>
		<div id="score_star" class="float_l"></div><div id="score_handle">0</div><div class="float_r"><input type="submit" value="发表评论" name="submit" /></div><div class="cleaner"></div>
		
		</form>
	</div>
	<?php endif;?>
</div>
<div id="templatemo_sidebar">
<?php View::load('article/side', $this->side);?>
</div>
<?php View::load('article/footer');?>