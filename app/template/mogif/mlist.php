<?php 
	_C_View::show('header', array(
		'title'			=> '搞笑图片列表 - VIVINICE.COM',
		'keywords'		=> '搞笑图片,动态图片,图片下载,搞笑gif,动态图片列表',
		'description'	=> '最新最火的搞笑图片，动态gif图片列表。',
		'result'		=> array('class'=>'mogif', 'method'=>'mlist', 'data'=>$page),
	));
?>
<div id="templatemo_content">
	<h2>精彩推荐</h2>
	<div id="gallery">
		<ul>
<?php foreach (DB::page(mogif::TABLE, NULL, array('collect_time'=>'desc'), array('id','title','content'), $page, mogif::MAIN_LIST_SIZE, $info) as $article):?>
			<li>
				<div class="left">
					<a href="<?php echo Url::mkurl('mogif', 'show', $article['id']);?>" class="pirobox" title="<?php echo $article['title'];?>" target="_blank"><img src="<?php echo mogif::loading_src();?>" dat="<?php echo mogif::img_src($article['content'], false);?>" alt="<?php echo $article['title'];?>" /></a>
				</div>
				<div class="right">
					<h5><?php echo $article['title'];?></h5>
					<p><?php echo $article['title'];?></p>
					<div class="button"><a href="<?php echo Url::mkurl('mogif', 'show', $article['id']);?>" target="_blank">查看详情</a></div>
				</div>
				<div class="cleaner"></div>
			</li>
<?php endforeach;?>
		</ul>
	</div>
	<div id="pages_list"><?php echo View::pagesList($info, 'mogif', 'mlist');?></div>
</div>
<div id="templatemo_sidebar">
    
	<div class="sidebar_title">
		最新图片
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
		精彩推荐
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (mogif::getRandom() as $data):?>
			<li><a href="<?php echo Url::mkurl('mogif', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>
    
	<div class="sidebar_title">
		下载排行
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (mogif::getDownLoadsTop() as $data):?>
			<li><a href="<?php echo Url::mkurl('mogif', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>
	
	<div class="sidebar_title">
		点击排行
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (mogif::getHitsTop() as $data):?>
			<li><a href="<?php echo Url::mkurl('mogif', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>
	
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