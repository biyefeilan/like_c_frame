<?php 
	_C_View::show('header', array(
		'title'			=> '搞笑视频  - VIVINICE.COM',
		'keywords'		=> '搞笑视频',
		'description'	=> '聚集最新最火的搞笑视频。',
		'result'		=> array('class'=>'moswf', 'method'=>'index', 'data'=>null),
	));
?>
<div id="templatemo_content">
	<h2>精彩推荐</h2>
	<div id="gallery">
		<ul>
<?php foreach (DB::page(moswf::TABLE, NULL, array('collect_time'=>'desc'), array('id','title','content'), 1, mogif::MAIN_LIST_SIZE, $info) as $article):?>
			<li>
				<div class="left">
					<a href="<?php echo Url::mkurl('moswf', 'show', $article['id']);?>" class="pirobox" title="<?php echo $article['title'];?>" target="_blank">
						<img src="<?php echo mogif::loading_src();?>" dat="<?php echo mogif::img_src(IMG_URL . 'not_found.jpg', false);?>" alt="<?php echo $article['title'];?>" /></a>
					</a>
				</div>
				<div class="right">
					<h5><?php echo String::msubstr($article['title'], 0, 18);?></h5>
					<p><?php echo $article['title'];?></p>
					<div class="button"><a href="<?php echo Url::mkurl('moswf', 'show', $article['id']);?>" target="_blank">查看详情</a></div>
				</div>
				<div class="cleaner"></div>
			</li>
<?php endforeach;?>
		</ul>
	</div>
	<div class="more"><a href="<?php echo Url::mkurl('moswf', 'mlist', '2');?>">更多》</a></div>
</div>
<div id="templatemo_sidebar">
    
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
	
	<div class="cleaner_h20"></div>
	
	<div class="sidebar_title">
		精彩推荐
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (moswf::getRandom() as $data):?>
			<li><a href="<?php echo Url::mkurl('moswf', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
<?php endforeach;?>
		</ul>
	</div>
	
	<div class="cleaner_h20"></div>
	
	<div class="sidebar_title">
		点击排行
	</div>
	<div class="sidebar_box">
		<ul class="templatemo_list">
<?php foreach (moswf::getHitsTop() as $data):?>
			<li><a href="<?php echo Url::mkurl('moswf', 'show', $data['id']);?>" title="<?php echo $data['title'];?>"><?php echo String::msubstr($data['title'], 0, 16);?></a></li>
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

</div>
<?php _C_View::show('footer'); ?>