<?php 
	$data=DB::findOne(mobt::TABLE, array('id'=>$id));
	$summary = '';
	if (preg_match('@简\s*介(.*)@sim', $data['content'], $matches)) {
		$summary = strip_tags($matches[1]);
	} else {
		$summary = strip_tags($data['content']);
	}
	$summary = preg_replace('@\s|　@', '', $summary);
	if (strlen($summary)>200) {
		$summary = mb_substr($summary, 0, 200);
	}
	_C_View::show('header', array(
		'title'			=> '最新电影'.$data['title'].'迅雷bt免费下载 -VIVINICE.COM',
		'description'	=> '最新电影'.$data['title'].'迅雷bt免费下载。'.$summary,
		'result'		=> array('class'=>'mobt', 'method'=>'show', 'data'=>$id),
	));
?>
<div id="templatemo_content">
	<div class="gif_box">
<?php if ($data !== false):?>
		<h2><?php echo $data['title'];?></h2>
		<div class="content">
			<?php echo $data['content'];?>
		</div>
		<div class="download">
			<a href="<?php echo Url::mkurl('mobt', 'download', $data['id']);?>" target="_self"><img alt="下载" src="<?php echo IMG_URL;?>download.png" /></a>
		</div>
		<div class="guide">
<?php $data=DB::findOne(mobt::TABLE, 'id=(select min(id) from '.mobt::TABLE.' where id>'.$id.')');?>
			<div class="float_l">上一页：<?php echo $data ? '<a href="'.Url::mkurl('mobt', 'show', $data['id']).'" title="'.$data['title'].'" target="_self">'.String::msubstr($data['title'], 0, 16).'</a>' : '没有了';?></div>
<?php $data=DB::findOne(mobt::TABLE, 'id=(select max(id) from '.mobt::TABLE.' where id<'.$id.')');?>
			<div class="float_r">下一页：<?php echo $data ? '<a href="'.Url::mkurl('mobt', 'show', $data['id']).'" title="'.$data['title'].'" target="_self">'.String::msubstr($data['title'], 0, 16).'</a>' : '没有了';?></div>
		</div>
<?php endif;?>
	</div>
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