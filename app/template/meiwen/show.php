<?php 
	$data=DB::findOne(meiwen::TABLE, array('id'=>$id));
	_C_View::show('header', array(
		'title'			=> $data['title'].' - VIVINICE.COM',
		'keywords'		=> '����,����',
		'description'	=> '���ģ�'.$data['title'],
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
			<div class="float_l">��һҳ��<?php echo $data ? '<a href="'.Url::mkurl('meiwen', 'show', $data['id']).'" title="'.$data['title'].'" target="_self">'.String::msubstr($data['title'], 0, 16).'</a>' : 'û����';?></div>
<?php $data=DB::findOne(meiwen::TABLE, 'id=(select max(id) from '.meiwen::TABLE.' where id<'.$id.')');?>
			<div class="float_r">��һҳ��<?php echo $data ? '<a href="'.Url::mkurl('meiwen', 'show', $data['id']).'" title="'.$data['title'].'" target="_self">'.String::msubstr($data['title'], 0, 16).'</a>' : 'û����';?></div>
		</div>
<?php endif;?>
	</div>
</div>
<div id="templatemo_sidebar">
    
	<div class="sidebar_title">
		��������
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
		�����Ƽ�
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
		�������
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
	
	<div class="cleaner_h20"></div>

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

</div>
<?php _C_View::show('footer'); ?>