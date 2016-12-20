<?php if ($this->do=='variable'):?>
<!-- 系统变量设置开始 -->
<form id="variablesform" method="post" action="">
<fieldset>
	<legend>系统变量设置</legend>
	<?php foreach ($this->variables as $variable):?>
	<p>
		<label><?php echo $variable['title'];?>:</label>
		<input class="sf" name="variables[<?php echo $variable['name'];?>]" type="text" value="<?php echo $variable['value'];?>" />
		<span class="field_desc"><?php echo $variable['desc'];?></span>
	</p>
	<?php endforeach;?>
	<div class="clearboth"></div>
	<p><input class="button" type="submit" value="Submit" /></p>
</fieldset>
</form>
<!-- 系统变量设置结束  -->
<?php endif;?>

<?php if ($this->do=='category'):?>
<!-- 栏目设置开始 -->
<form id="categoryform" method="post" action="">
<fieldset>
	<legend>系统栏目设置</legend>
	<table class="fancy fullwidth">
		<thead>
			<tr>
				<th>排序</th>
				<th>ID</th>
				<th>URI</th>
				<th>栏目</th>
				<th>数据量</th>
				<th>显示</th>
				<th>禁用</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($this->category as $cat):$i=-1;++$i?>
			<tr<?php if ($i%2==0):?> class="odd"<?php endif;?>>
				<td><input style="width: 30px;" name="category[sort][<?php echo $cat['catid'];?>]" type="text" value="<?php echo $cat['sort'];?>" /></td>
				<td><?php echo $cat['catid'];?></td>
				<td><?php echo $cat['cat'];?></td>
				<td style="text-align: left;"><?php echo $cat['space'], $cat['name'];?></td>
				<td><?php echo $cat['num'];?></td>
				<td><?php echo $cat['display']=='1' ? '是' : '否';?></td>
				<td><?php echo $cat['disabled']=='1' ? '是' : '否';?></td>
				<td>
					<a href="javascript:void(0);" title="编辑栏目" id="category_edit_<?php echo $cat['catid'];?>" class="tooltip table_icon"><img src="<?php echo IMG_URL;?>admin/icons/actions_small/Pencil.png" alt="" /></a> 
					<?php if ($cat['catpid']==0):?><a href="javascript:void(0);" id="category_add_<?php echo $cat['catid'];?>" title="添加栏目" class="tooltip table_icon"><img src="<?php echo IMG_URL;?>admin/icons/actions_small/add.png" alt="" /></a><?php endif;?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div id="category_edit_dialog"></div>
	<div class="clearboth"></div>
	<p><input class="button" type="submit" value="Submit" /></p>
</fieldset>
</form>
<script type="text/javascript">
var categories = [];
<?php foreach ($this->category as $cat):?>
categories.push(<?php echo json_encode($cat);?>);
<?php endforeach;?>
$(function(){
	$('#category_edit_dialog').dialog({
		autoOpen:false,//该选项默认是true，设置为false则需要事件触发才能弹出对话框  
		title:'栏目编辑',//对话框的标题  
		width:400,//默认是300  
		modal:true//设置为模态对话框  
	});
	
	$('a[id^="category_add_"]').click(function(){
		var arr = $(this).attr('id').split('_');
		var tr = '';
		tr += '<tr>';
		tr += '<td><input type="text" style="width:30px" name="category[add][sort][]" value="0" /></td>';
		tr += '<td><input type="hidden" name="category[add][catpid][]" value="'+arr[2]+'" />0</td>';
		tr += '<td><input type="text" class="sf" name="category[add][cat][]" value="" /></td>';
		tr += '<td><input type="text" class="sf" name="category[add][name][]" value="" /></td>';
		tr += '<td>0</td>';
		tr += '<td><input type="checkbox" name="category[add][display][]" checked="checked" /></td>';
		tr += '<td><input type="checkbox" name="category[add][disabled][]" checked="checked" /></td>';
		tr += '<td><a href="javascript:void(0);" onclick="$(this).closest(\'tr\').remove();" title="删除" class="tooltip table_icon"><img src="<?php echo IMG_URL;?>admin/icons/actions_small/Trash.png" alt="" /></a> </td>';
		tr += '</tr>';
		$(this).closest('tr').after(tr);
	});

	$('a[id^="category_edit_"]').click(function(){
		var arr = $(this).attr('id').split('_');
		var data;
		for (var i=0; i<categories.length; i++){
			if (categories[i].catid == arr[2]) {
				data = categories[i];
				break;
			}
		}

		if (data){
			var fieldset = '';
			fieldset += '<form method="post" action="">';
			fieldset += '<fieldset>';
			fieldset += '<legend>栏目编辑</legend>';
			fieldset += '<p>';
			fieldset += '<label>ID</lable>';
			fieldset += '<input type="text" name="category[edit][catid]" value="'+data.catid+'" readonly="readonly" />';
			fieldset += '<span class="field_desc"></span>';
			fieldset += '</p>';
			fieldset += '<p>';
			fieldset += '<label>URI</lable>';
			fieldset += '<input type="text" name="category[edit][cat]" value="'+data.cat+'" />';
			fieldset += '<span class="field_desc"></span>';
			fieldset += '</p>';
			fieldset += '<p>';
			fieldset += '<label>栏目</lable>';
			fieldset += '<input type="text" name="category[edit][name]" value="'+data.name+'" />';
			fieldset += '<span class="field_desc"></span>';
			fieldset += '</p>';
			fieldset += '<p>';
			fieldset += '<label>显示</lable>';
			fieldset += '<input type="checkbox" name="category[edit][display]" value="1" '+(data.display==1?'checked="checked"':'')+' />';
			fieldset += '<span class="field_desc"></span>';
			fieldset += '</p>';
			fieldset += '<p>';
			fieldset += '<label>禁用</lable>';
			fieldset += '<input type="checkbox" name="category[edit][disabled]" value="1" '+(data.disabled==1?'checked="checked"':'')+' />';
			fieldset += '<span class="field_desc"></span>';
			fieldset += '</p>';
			fieldset += '<p><input class="button" type="submit" value="保存" /></p>';
			fieldset += '</fieldset>';
			fieldset += '</form>'
			$('#category_edit_dialog').html(fieldset).dialog('open');
			
		}
	});
});
</script>
<!-- 栏目设置结束 -->
<?php endif;?>

<?php if ($this->do=='hotword'):?>
<!-- 热词设置开始 -->
<form id="hotwordform" method="post" action="">
<fieldset>
	<legend>热词设置</legend>
	<div class="panel"><a href="javascript:void(0);" title="编辑" id="hotword_edit_<?php echo $row['name'];?>" class="tooltip table_icon"><img src="<?php echo IMG_URL;?>admin/icons/actions_small/add.png" alt="" /></a></div>
	<table class="fancy fullwidth">
		<thead>
			<tr>
				<th>热词</th>
				<th>URI</th>
				<th>数据量</th>
				<th>替换</th>
				<th>显示</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($this->hotword as $row):$i=-1;++$i?>
			<tr<?php if ($i%2==0):?> class="odd"<?php endif;?>>
				<td><?php echo $row['word'];?></td>
				<td><?php echo $row['name'];?></td>
				<td><?php echo $row['num'];?></td>
				<td><?php echo $row['replace']=='1' ? '是' : '否';?></td>
				<td><?php echo $row['display']=='1' ? '是' : '否';?></td>
				<td>
					<a href="javascript:void(0);" title="编辑" id="hotword_edit_<?php echo $row['name'];?>" class="tooltip table_icon"><img src="<?php echo IMG_URL;?>admin/icons/actions_small/Pencil.png" alt="" /></a> 
					<a href="javascript:void(0);" title="删除" id="hotword_delete_<?php echo $row['name'];?>" class="tooltip table_icon"><img src="<?php echo IMG_URL;?>admin/icons/actions_small/Trash.png" alt="" /></a>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<div id="hotword_dialog"></div>
	<div class="clearboth"></div>
	<p><input class="button" type="submit" value="Submit" /></p>
</fieldset>
</form>
<!-- 热词设置结束 -->
<?php endif;?>