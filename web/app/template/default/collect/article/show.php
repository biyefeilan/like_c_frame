<?php View::load('header');?>
<div id="templatemo_content">
	<div class="gif_box">
<?php if ( $data ):?>
		<h2><?php echo $data['title'];?></h2>
		<div class="content"><?php echo $data['content'];?></div>
		<div class="guide">
			<div class="float_l">上一篇<?php echo $data['prev'] ? '<a href="'.$data['prev']['link'].'" title="'.$data['prev']['title'].'" target="_self">'.String::msubstr($data['prev']['title'], 0, 16).'</a>' : '没有了';?></div>
			<div class="float_r">下一篇<?php echo $data['next'] ? '<a href="'.$data['next']['link'].'" title="'.$data['next']['title'].'" target="_self">'.String::msubstr($data['next']['title'], 0, 16).'</a>' : '没有了';?></div>
		</div>
<?php endif;?>
	</div>
</div>
<div id="templatemo_sidebar">
<?php View::load('side', $this->side);?>
</div>
<?php View::load('footer');?>