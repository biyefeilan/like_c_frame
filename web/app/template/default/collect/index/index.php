<?php View::load('header');?>
<div id="templatemo_content">
<?php foreach ($this->main as $i=>$info):?>
	<div class="two_column float_<?php echo $i%2==0 ? 'l' : 'r';?>">
		<h2><?php echo $info['title'];?></h2>
		<ul class="templatemo_list">
		<?php foreach ($info['list'] as $data):?>
			<li><a title="<?php echo $data['title'];?>" href="<?php echo $data['link'];?>" target="_blank"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
		<?php endforeach;?>
		</ul>
	</div>
<?php endforeach;?>
</div>
<div id="templatemo_sidebar">
<?php View::load('side', $this->side);?>
</div>
<?php View::load('footer');?>