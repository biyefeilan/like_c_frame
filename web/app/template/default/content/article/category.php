<?php View::load('article/header');?>
<div id="templatemo_content">
<?php foreach ($this->main as $i=>$info):?>
	<div class="two_column float_<?php echo $i%2==0 ? 'l' : 'r';?>">
		<h2><a href="?m=content&c=article&a=category&d=<?php echo $info['cat'];?>" target="_blank"><?php echo $info['catname'];?></a></h2>
		<ul class="templatemo_list">
		<?php foreach ($info['list'] as $data):?>
			<li><a href="?m=content&c=article&a=show&d=<?php echo $data['articleid'];?>" title="<?php echo $data['title'];?>" target="_blank"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
		<?php endforeach;?>
		</ul>
	</div>
<?php endforeach;?>
</div>
<div id="templatemo_sidebar">
<?php View::load('article/side', $this->side);?>
</div>
<?php View::load('article/footer');?>