<div class="sidebar">
	<div class="gadget">
		<h2>管理中心</h2>
		<div class="clr"></div>
		<ul class="sb_menu">
			<li><a href="?m=content&c=user">管理首页</a></li>
            <li><a href="?m=content&c=user&a=article">我的文章</a></li>
            <li><a href="?m=content&c=user&a=write">写文章</a></li>
            <li><a href="?m=content&c=user&a=rubbish">回收站</a></li>
            <li><a href="?m=content&c=user&a=passwd">修改密码</a></li>
            <li><a href="?m=content&c=user&a=logout">登出</a></li>
		</ul>
	</div>
	<div class="gadget">
		<div class="search">
			<form id="form" name="form" method="post" action="">
				<span>
					<input name="q" type="text" class="keywords" id="textfield" maxlength="50" value="Search..." />
					<input name="b" type="image" src="<?php echo IMG_URL;?>member/search.gif" class="button" />
				</span>
			</form>
		</div>
	</div>
	<div class="gadget">
		<!--<h2>名人名言</h2>-->
		<?php if (($words = Common::wisewords())!==false):?>
		<div class="clr"></div>
		<p>   <img src="<?php echo IMG_URL;?>member/test_1.gif" alt="image" width="19" height="20" /> <em><?php echo $words['words'];?></em>.<img src="<?php echo IMG_URL;?>member/test_2.gif" alt="image" width="19" height="20" /></p>
		<p style="float:right;"><strong><?php echo $words['author'];?></strong></p>
		<?php endif;?>
	</div>
</div>