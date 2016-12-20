<div id="table_page" style="display: none;">
	<table class="normal fullwidth">
		<thead>
			<tr>
				<th><input type="checkbox" class="checkall" name="checkall" /></th>
				<th>ID</th>
				<th>图像</th>
				<th>用户名</th>
				<th>email</th>
				<th>所在组</th>
				<th>经验</th>
				<th>积分</th>
				<th>登录次数</th>
				<th>最后时间</th>
				<th>注册时间</th>
				<th>冻结</th>
				<th>审核</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<div class="submit_panel"><input type="button" value="审核通过" name="action_checked_pass" class="button" /> <input type="button" value="删除" name="action_delete" class="button" /></div>
	<div class="page_list"></div>
</div>
<script type="text/javascript">
function show_table_page(data) {
	$('.checkall').removeAttr('checked');
	if (data && data.rows && data.rows.length) {
		var trs = '';
		for(var i=0; i<data.rows.length; i++) {
			var row = data.rows[i];
			var tr = '';
			tr += '<tr'+(i%2==0?' class="odd"':'')+'>';
			tr += '<td>';
			tr += 		'<input type="checkbox" value="'+row.userid+'" name="ids[]" />';
			tr += '</td>';
			tr += '<td>';
			tr += 		row.userid;
			tr += '</td>';
			tr += '<td>';
			tr += 		'<img src="<?php echo IMG_URL;?>admin/avatar.png" alt="" />';
			tr += '</td>';
			tr += '<td>';
			tr += 		row.username;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.email;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.group.name;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.exp;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.credit;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.loginnum;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.lastdate;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.regdate;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.islocked=='1' ? '是':'否';
			tr += '</td>';
			tr += '<td>';
			tr += 		row.checked=='1' ? '是':'否';
			tr += '</td>';
			tr += '<td>';
			tr += 		'<a href="#" title="编辑" class="tooltip table_icon"><img src="<?php echo IMG_URL;?>admin/icons/actions_small/Pencil.png" alt="" /></a> <a href="#" title="删除" class="tooltip table_icon"><img src="<?php echo IMG_URL;?>admin/icons/actions_small/Trash.png" alt="" /></a>';
			tr += '</td>';
			tr += '</tr>';
			trs += tr;
		}
		$('#table_page tbody').html(trs);
		$('#table_page .page_list').html(page_list('<?php echo Common::url();?>', data.page.count, data.page.current, show_table_page));
		$('#table_page').show();
		$('#table_page input:button[name^="action_"]').unbind('click').bind('click',function(){
			var action = this.name.substr(7);
			if (action=='delete' && !confirm('确实要删除选中项？')) {
				return ;
			}
			var ids = [];
			$('input:checked[name="ids[]"]').each(function(){
				ids.push(this.value);
			});
			if (ids.length>0) {
				load_page_json('<?php echo Common::url();?>', {"action":action, "page":data.page.current, "ids":ids.join(',')}, show_table_page);
			}
		});
	}
}

load_page_json('<?php echo Common::url();?>', 1, show_table_page);
</script>