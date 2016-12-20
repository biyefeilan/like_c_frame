<?php View::load('user/header');?>
<div class="mainbar">
<?php foreach ($this->main['rows'] as $row):?>
	<div class="article" id="article_<?php echo $row['articleid'];?>">
		<h2><?php echo $row['title'];?></h2>
		<div class="clr"></div>
		<p>Author:<?php echo $row['author'];?>  Time:<?php echo $row['createtime'];?>  hit:<?php echo $row['hit'];?></p>
		<div class="clr"></div>
		
		<?php echo String::msubstr($row['content'], 0, 200);?>
		
		<p><a href="?m=content&c=article&a=show&d=<?php echo $row['articleid'];?>">Read</a> | <a href="?m=content&c=user&a=write&d=<?php echo $row['articleid'];?>">Edit</a> | <a href="javascript:restore(<?php echo $row['articleid'];?>);void(0);">Restore</a></p>
	</div>
<?php endforeach;?>
<?php if ($this->main['page']['count']>0):?>
	<div class="article" style="padding:5px 20px 2px 20px;">
		<p><?php echo $this->main['page']['current'];?>/<?php echo $this->main['page']['count'];?> <span class="butons"><?php echo Common::page_list($this->main['page'], '?m=content&c=user&a=article&d=%s');?></span></p>
	</div>
<?php endif;?>
</div>
<?php View::load('user/sidebar');?>
<script type="text/javascript">
function restore(id)
{
	$.post('<?php echo Common::url('content', 'user', 'do_rubbish', 'restore');?>', {"id":id}, function(r){
		if (r=='1') {
			if ($('[id^="article_"]').length==1){
				window.location.reload();
			} else {
				$('#article_'+id).remove();
			}
		} else {
			alert('...');
		}
	});
}
</script>
<?php View::load('user/footer');?>