<?php 
	$data=DB::findOne(mogif::TABLE, array('id'=>$id));
	_C_View::show('header', array(
		'title'			=> $data['title'] . ' - VIVINICE.COM',
		'keywords'		=> '搞笑图片,动态图片,图片下载,搞笑gif',
		'description'	=> '搞笑图片' . $data['title'] . '下载。',
		'result'		=> array('class'=>'mogif', 'method'=>'show', 'data'=>$id),
	));
?>
<div id="templatemo_content">
	<div class="gif_box">
<?php if ( $data !== false):?>
		<h2><?php echo $data['title'];?></h2>
		<div class="content">
			<img src="<?php echo mogif::loading_src();?>" dat="<?php echo mogif::img_src($data['content']);?>" alt="点击下载-<?php echo $data['title'];?>" />
		</div>
		<div class="guide">
<?php $data=DB::findOne(mogif::TABLE, 'id=(select min(id) from '.mogif::TABLE.' where id>'.$id.')');?>
			<div class="float_l">上一页：<?php echo $data ? '<a href="'.Url::mkurl('mogif', 'show', $data['id']).'" title="'.$data['title'].'" target="_self">'.String::msubstr($data['title'], 0, 14).'</a>' : '没有了';?></div>
<?php $data=DB::findOne(mogif::TABLE, 'id=(select max(id) from '.mogif::TABLE.' where id<'.$id.')');?>
			<div class="float_r">下一页：<?php echo $data ? '<a href="'.Url::mkurl('mogif', 'show', $data['id']).'" title="'.$data['title'].'" target="_self">'.String::msubstr($data['title'], 0, 14).'</a>' : '没有了';?></div>
		</div>
<?php endif;?>
	</div>
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