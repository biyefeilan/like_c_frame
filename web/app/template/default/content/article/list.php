<?php View::load('article/header');?>
<div id="templatemo_content">
	<div id="gallery">
		<ul>
<?php foreach ($this->main['rows'] as $row):?>
			<li>
				<div class="title"><a href="?m=content&c=article&a=show&d=<?php echo $row['articleid'];?>"><?php echo $row['title'];?></a></div>
				<div class="view"><?php echo $row['content'];?></div>
				<div class="info">Author:<?php echo $row['author'];?> Time:<?php echo date('Y/m/d', $row['createtime']);?> hit:<?php echo $row['hit'];?> comment:<?php echo $row['comment'];?></div>
				<div class="button"><a href="?m=content&c=article&a=show&d=<?php echo $row['articleid'];?>" target="_blank">阅读全文</a></div>
			</li>
<?php endforeach;?>
		</ul>
	</div>
	<div id="pages_list"><?php echo Common::page_list($this->main['page'], '?m=content&c=article&a=category&d='.$this->main['cat'].'/{__PAGE__}');?></div>
</div>
<div id="templatemo_sidebar">
<?php View::load('article/side', $this->side);?>
</div>
<?php View::load('article/footer');?>