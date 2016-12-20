<?php 
	_C_View::show('header', array(
		'title'			=> '最新电影列表 - VIVINICE.COM',
		'keywords'		=> '最新电影下载,高清电影,bt下载',
		'description'	=> '最新高清电影bt种子下载列表。',
		'result'		=> array('class'=>'mobt', 'method'=>'mlist', 'data'=>$page),
	));
?>
<div id="templatemo_content">
	<h2>精彩推荐</h2>
	<div id="gallery">
		<ul>
<?php 
	foreach (DB::page(mobt::TABLE, NULL, array('collect_time'=>'desc'), array('id','title', 'content'), $page, mobt::MAIN_LIST_SIZE, $info) as $article):
?>
			<li>
				<div class="left">
					<a href="<?php echo Url::mkurl('mobt', 'show', $article['id']);?>" class="pirobox" title="<?php echo $article['title'];?>" target="_blank"><img src="<?php echo mogif::loading_src();?>" daturl="<?php echo mobt::img($article['content']);?>" dat="<?php echo mogif::img_src(mobt::img($article['content']), false);?>" alt="<?php echo $article['title'];?>" /></a>
				</div>
				<div class="right">
					<h5><?php echo String::msubstr($article['title'], 0, 20);?></h5>
					<p><?php echo $article['title'];?></p>
					<div class="button"><a href="<?php echo Url::mkurl('mobt', 'show', $article['id']);?>" target="_blank">查看详情</a></div>
				</div>
				<div class="cleaner"></div>
			</li>
<?php endforeach;?>
		</ul>
	</div>
	<div id="pages_list"><?php echo View::pagesList($info, 'mobt', 'mlist');?></div>
</div>
<div id="templatemo_sidebar">
    
	<div class="sidebar_title">
		最新电影
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (DB::findAll(mobt::TABLE, null, array('collect_time'=>'DESC'), array('id', 'title'), mogif::SIDEBAR_LIST_SIZE) as $data):?>
			<li><a href="<?php echo Url::mkurl('mobt', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>
	
	<div class="sidebar_title">
		精彩推荐
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (mobt::getRandom() as $data):?>
			<li><a href="<?php echo Url::mkurl('mobt', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>
	
	<div class="sidebar_title">
		下载排行
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (mobt::getDownLoadsTop() as $data):?>
			<li><a href="<?php echo Url::mkurl('mobt', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>
	
	<div class="sidebar_title">
		点击排行
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (mobt::getHitsTop() as $data):?>
			<li><a href="<?php echo Url::mkurl('mobt', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>

	<div class="sidebar_title">
		搞笑图片
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (DB::findAll(mogif::TABLE, null, array('collect_time'=>'DESC'), array('id', 'title'), mogif::SIDEBAR_LIST_SIZE) as $data):?>
			<li><a href="<?php echo Url::mkurl('mogif', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>

	<div class="sidebar_title">
		最新视频
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (DB::findAll(moswf::TABLE, null, array('collect_time'=>'DESC'), array('id', 'title'), mogif::SIDEBAR_LIST_SIZE) as $data):?>
			<li><a href="<?php echo Url::mkurl('moswf', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>

</div>
<?php _C_View::show('footer'); ?>