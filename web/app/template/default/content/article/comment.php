<?php View::load('article/header');?>
<div id="templatemo_content">
	<div id="gallery">
		<ul>
<?php foreach ($this->main['rows'] as $row):?>
			<li>
				<div class="comment">
					<p><?php echo $row['author'];?>[<?php echo $row['score'];?>分]：<?php echo $row['comment'];?></p>
					<div class="float_r"><?php echo date('Y/m/d', $row['dateline']);?> <input type="button" id="doagree_comment_<?php echo $row['commentid'];?>_1" value="言之有理(<?php echo $row['agree'];?>)" /><input type="button" id="doagree_comment_<?php echo $row['commentid'];?>_0" value="一派胡言(<?php echo $row['oppose'];?>)" /></div>
				</div>
			</li>
<?php endforeach;?>
		</ul>
	</div>
	<div id="pages_list"><?php echo Common::page_list($this->main['page'], 'content/article/comment/'.$this->articleid.'/{__PAGE__}');?></div>
</div>
<div id="templatemo_sidebar">
<?php View::load('article/side', $this->side);?>
</div>
<?php View::load('article/footer');?>