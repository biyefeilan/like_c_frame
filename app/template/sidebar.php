<div id="templatemo_sidebar">
<?php foreach ($sidebar as $k=>$v):?>
	<div class="sidebar_title">
		<?php echo $v['title'];?>
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
		<?php foreach ($v['infos'] as $info):?>
			<li><a href="#"><?php echo $info['title']?></a></li>
		<?php endforeach;?>
		</ul>
	</div>
	<?php if ($k != count($sidebar)):?>
	<div class="cleaner_h20"></div>
	<?php endif;?>
<?php endforeach;?>
</div>