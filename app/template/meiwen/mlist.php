<?php 
	_C_View::show('header', array(
		'title'			=> '美文列表 - VIVINICE.COM',
		'keywords'		=> '美文,文章,作文,散文,小说,名家,经典美文',
		'description'	=> '不可错过的美文。',
		'result'		=> array('class'=>'meiwen', 'method'=>'mlist', 'data'=>$page),
	));
?>
<div id="templatemo_content">
	<h2>精彩推荐</h2>
	<div id="gallery">
		<ul>
<?php 
	foreach (DB::page(meiwen::TABLE, NULL, array('collect_time'=>'desc'), array('id','title', 'content'), $page, meiwen::MAIN_LIST_SIZE, $info) as $article):
?>
			<li>
				<div class="left">
					<a href="<?php echo Url::mkurl('meiwen', 'show', $article['id']);?>" class="pirobox" title="<?php echo $article['title'];?>" target="_blank"><img src="<?php echo ImageRand::getImgUrl();?>" alt="<?php echo $article['title'];?>" /></a>
				</div>
				<div class="right">
					<h5><?php echo String::msubstr($article['title'], 0, 20);?></h5>
					<p><?php echo meiwen::getDescri($article['content']);?></p>
					<div class="button"><a href="<?php echo Url::mkurl('meiwen', 'show', $article['id']);?>" target="_blank">查看详情</a></div>
				</div>
				<div class="cleaner"></div>
			</li>
<?php endforeach;?>
		</ul>
	</div>
	<div id="pages_list"><?php echo View::pagesList($info, 'meiwen', 'mlist');?></div>
</div>
<div id="templatemo_sidebar">
    
	<div class="sidebar_title">
		最新美文
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (DB::findAll(meiwen::TABLE, null, array('collect_time'=>'DESC'), array('id', 'title'), mogif::SIDEBAR_LIST_SIZE) as $data):?>
			<li><a href="<?php echo Url::mkurl('meiwen', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>
	
	<div class="sidebar_title">
		精彩推荐
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (meiwen::getRandom() as $data):?>
			<li><a href="<?php echo Url::mkurl('meiwen', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>
	
	<div class="sidebar_title">
		点击排行
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (meiwen::getHitsTop() as $data):?>
			<li><a href="<?php echo Url::mkurl('meiwen', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
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