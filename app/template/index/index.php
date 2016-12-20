<?php _C_View::show('header'); ?>
<div id="templatemo_content">
	<div class="two_column float_l">
		<h2>电影</h2>
		<ul class="templatemo_list">
<?php foreach (DB::findAll(mobt::TABLE, null, array('collect_time'=>'DESC'), 'id, title', 32) as $data):?>
			<li><a title="<?php echo $data['title'];?>" href="<?php echo Url::mkurl('mobt', 'show', $data['id']);?>" target="_blank"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	<div class="two_column float_r">
		<h2>视频</h2>
		<ul class="templatemo_list">
<?php foreach (DB::findAll(moswf::TABLE, null, array('collect_time'=>'DESC'), 'id, title', 32) as $data):?>
			<li><a title="<?php echo $data['title'];?>" href="<?php echo Url::mkurl('moswf', 'show', $data['id']);?>" target="_blank"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
</div>
<div id="templatemo_sidebar">
	<div class="sidebar_title">
		视频推荐
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (moswf::getHitsTop(14) as $data):?>
			<li><a href="<?php echo Url::mkurl('moswf', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>  

	<div class="sidebar_title">
		电影推荐
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (mobt::getDownLoadsTop(14) as $data):?>
			<li><a href="<?php echo Url::mkurl('mobt', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
</div>
<?php _C_View::show('footer'); ?>