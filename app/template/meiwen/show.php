<?php 
	$data=DB::findOne(meiwen::TABLE, array('id'=>$id));
	_C_View::show('header', array(
		'title'			=> $data['title'].' - VIVINICE.COM',
		'keywords'		=> '美文,文章',
		'description'	=> '美文，'.$data['title'],
		'result'		=> array('class'=>'meiwen', 'method'=>'show', 'data'=>$id),
	));
?>
<div id="templatemo_content">
	<div class="gif_box">
<?php if ($data !== false):?>
		<h2><?php echo $data['title'];?></h2>
		<div class="content">
			<?php echo $data['content'];?>
		</div>
		<div class="guide">
<?php $data=DB::findOne(meiwen::TABLE, 'id=(select min(id) from '.meiwen::TABLE.' where id>'.$id.')');?>
			<div class="float_l">上一页：<?php echo $data ? '<a href="'.Url::mkurl('meiwen', 'show', $data['id']).'" title="'.$data['title'].'" target="_self">'.String::msubstr($data['title'], 0, 16).'</a>' : '没有了';?></div>
<?php $data=DB::findOne(meiwen::TABLE, 'id=(select max(id) from '.meiwen::TABLE.' where id<'.$id.')');?>
			<div class="float_r">下一页：<?php echo $data ? '<a href="'.Url::mkurl('meiwen', 'show', $data['id']).'" title="'.$data['title'].'" target="_self">'.String::msubstr($data['title'], 0, 16).'</a>' : '没有了';?></div>
		</div>
<?php endif;?>
	</div>
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