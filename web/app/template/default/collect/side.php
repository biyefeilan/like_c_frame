<?php foreach ($data as $i=>$info):?>
	<div class="sidebar_title"><?php echo $info['title'];?></div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
		<?php foreach ($info['list'] as $row):?>
			<li><a href="<?php echo $row['link'];?>" title="<?php echo $row['title'];?>"><?php echo String::msubstr($row['title'], 0, 16);?></a></li>
		<?php endforeach;?>
		</ul>
	</div>
	<?php if ($i+1 < count($this->side)):?>
	<div class="cleaner_h20"></div>
	<?php endif;?>
<?php endforeach;?>