<?php View::load('header');?>
<div id="templatemo_content">
	<h2><?php echo $this->main['title'];?></h2>
	<div id="gallery">
		<ul>
<?php foreach ($this->main['list'] as $row):?>
			<li>
				<div class="left">
					<a href="<?php echo $row['link'];?>" class="pirobox" title="<?php echo $row['title'];?>" target="_blank"><img src="<?php echo $row['thumb'];?>" alt="<?php echo $row['title'];?>" /></a>
				</div>
				<div class="right">
					<h5><?php echo String::msubstr($row['title'], 0, 20);?></h5>
					<p><?php echo $row['title'];?></p>
					<div class="button"><a href="<?php echo $row['link'];?>" target="_blank">查看详情</a></div>
				</div>
				<div class="cleaner"></div>
			</li>
<?php endforeach;?>
		</ul>
	</div>
	<div id="pages_list"><?php echo View::pagesList($info, 'mobt', 'mlist');?></div>
</div>
<div id="templatemo_sidebar">
<?php View::load('side', $this->side);?>
</div>
<?php View::load('footer');?>