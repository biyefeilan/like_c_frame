<?php 
	$data=DB::findOne(moswf::TABLE, array('id'=>$id));
	_C_View::show('header', array(
		'title'			=> $data['title'].' - VIVINICE.COM',
		'keywords'		=> '��Ц��Ƶ,����˼����Ƶ',
		'description'	=> '��Ц��Ƶ' . $data['title'],
		'result'		=> array('class'=>'moswf', 'method'=>'show', 'data'=>$id),
	));
?>
<div id="templatemo_content">
	<div class="gif_box">
<?php if ( $data !== false ):?>
		<h2><?php echo $data['title'];?></h2>
		<div class="content">
			<object width="550" height="480" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
				<param value="<?php echo $data['content'];?>" name="movie">
				<param value="transparent" name="wmode">
				<param value="sameDomain" name="allowScriptAccess">
				<param value="true" name="allowFullScreen">
				<param value="&amp;auto_start=off" name="FlashVars">
				<embed width="550" height="480" allowscriptaccess="sameDomain" allownetworking="all" wmode="transparent" allowfullscreen="true" flashVars="auto_start=off" type="application/x-shockwave-flash" src="<?php echo $data['content'];?>">
			</object>
		</div>
		<div class="guide">
<?php $data=DB::findOne(moswf::TABLE, 'id=(select min(id) from '.mogif::TABLE.' where id>'.$id.')');?>
			<div class="float_l">��һҳ��<?php echo $data ? '<a href="'.Url::mkurl('moswf', 'show', $data['id']).'" title="'.$data['title'].'" target="_self">'.String::msubstr($data['title'], 0, 14).'</a>' : 'û����';?></div>
<?php $data=DB::findOne(moswf::TABLE, 'id=(select max(id) from '.mogif::TABLE.' where id<'.$id.')');?>
			<div class="float_r">��һҳ��<?php echo $data ? '<a href="'.Url::mkurl('moswf', 'show', $data['id']).'" title="'.$data['title'].'" target="_self">'.String::msubstr($data['title'], 0, 14).'</a>' : 'û����';?></div>
		</div>
<?php endif;?>
	</div>
</div>
<div id="templatemo_sidebar">
    
    <div class="sidebar_title">
		������Ƶ
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
		�����Ƽ�
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
		�������
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
		���µ�Ӱ
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
		��ЦͼƬ
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