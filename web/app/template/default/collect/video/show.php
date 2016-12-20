<?php View::load('header');?>
<div id="templatemo_content">
	<div class="gif_box">
<?php if ( $data ):?>
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
			<div class="float_l">上一篇<?php echo $data['prev'] ? '<a href="'.$data['prev']['link'].'" title="'.$data['prev']['title'].'" target="_self">'.String::msubstr($data['prev']['title'], 0, 16).'</a>' : '没有了';?></div>
			<div class="float_r">下一篇<?php echo $data['next'] ? '<a href="'.$data['next']['link'].'" title="'.$data['next']['title'].'" target="_self">'.String::msubstr($data['next']['title'], 0, 16).'</a>' : '没有了';?></div>
		</div>
<?php endif;?>
	</div>
</div>
<div id="templatemo_sidebar">
<?php View::load('side', $this->side);?>
</div>
<?php View::load('footer');?>