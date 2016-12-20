<?php 

$menus = $data;

$icons = array(
	'admin' 	=> 'dashboard.png',
	'articles' 	=> 'posts.png',
	'media'		=> 'media.png',
	'comments'	=> 'notes.png',
	'money'		=> 'coin.png',
	'users'		=> 'users.png',
	'settings'	=> 'settings.png',
);

?>
<div id="primary_left">
	<div id="logo">
		<a href="/"><img src="<?php echo IMG_URL;?>admin/logo.png" alt="" /></a>
	</div> <!-- logo end -->

	<div id="menu"> <!-- navigation menu -->
		<ul>
			<?php foreach ($menus as $menu):?>
			<li class="tooltip<?php if($menu['action']==Module::getMethod()){echo ' current';}?>" title="<?php echo empty($menu['tooltip'])?$menu['name']:$menu['tooltip'];?>"><a href="<?php echo (empty($menu['children'])||!is_array($menu['children'])) ? '?m=content&c=admin&a='.$menu['action'] : '#';?>"><img src="<?php echo IMG_URL;?>admin/icons/small_icons_3/<?php echo $icons[(empty($menu['icon'])?$menu['action']:$menu['icon'])];?>" /><span><?php echo $menu['name'];?></span></a>
			<?php if (is_array($menu['children']) && !empty($menu['children'])):?>	
				<ul>
				<?php foreach ($menu['children'] as $child):?>
					<li<?php if(isset($_GET['do']) && $_GET['do']==$child['do']) echo ' class="active"';?>><a href="?m=content&c=admin&a=<?php echo $menu['action'];?>&do=<?php echo $child['do'];?>"><?php echo $child['name'];?></a></li>
				<?php endforeach;?>
				</ul>
			<?php endif;?>
			</li>
			<?php endforeach;?>
		</ul>
	</div> <!-- navigation menu end -->
</div> <!-- sidebar end -->
<div id="primary_right">
	<div class="inner">