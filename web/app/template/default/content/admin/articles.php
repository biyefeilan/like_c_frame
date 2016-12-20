<div id="articles_page">
	<table class="normal fullwidth" style="display: none;">
		<thead>
			<tr>
				<th><input type="checkbox" class="checkall" name="checkall" /></th>
				<th>ID</th>
				<th>标题</th>
				<th>栏目</th>
				<th>作者</th>
				<th>提交者</th>
				<th>提交者组</th>
				<th>提交时间</th>
				<th>原创</th>
				<th>已审核</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<div class="submit_panel"><input type="button" value="审核通过" name="action_checked_pass" class="button" /> <input type="button" value="审核不通过" name="action_checked_unpass" class="button" /> <input type="button" value="删除" name="action_delete" class="button" /></div>
	<div class="page_list"></div>
</div>
<div id="article_edit" style="display:none;"></div>
<script type="text/javascript">
function show_articles(data) {
	$('.checkall').removeAttr('checked');
	if (data && data.rows && data.rows.length) {
		var trs = '';
		for(var i=0; i<data.rows.length; i++) {
			var row = data.rows[i];
			var tr = '';
			tr += '<tr'+(i%2==0?' class="odd"':'')+'>';
			tr += '<td>';
			tr += 		'<input type="checkbox" value="'+row.articleid+'" name="articleids[]" />';
			tr += '</td>';
			tr += '<td>';
			tr += 		row.articleid;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.title;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.category.name;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.author;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.username;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.groupname;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.createtime;
			tr += '</td>';
			tr += '<td>';
			tr += 		row.original=='1' ? '是':'否';
			tr += '</td>';
			tr += '<td>';
			tr += 		row.checked=='1' ? '是':'否';
			tr += '</td>';
			tr += '<td>';
			tr += 		'<a href="javascript:void(0);" id="action_edit_'+row.articleid+'" title="编辑" class="tooltip table_icon"><img src="<?php echo IMG_URL;?>admin/icons/actions_small/Pencil.png" alt="" /></a> <a href="javascript:void(0);" id="action_delete_'+row.articleid+'" title="删除" class="tooltip table_icon"><img src="<?php echo IMG_URL;?>admin/icons/actions_small/Trash.png" alt="" /></a>';
			tr += '</td>';
			tr += '</tr>';
			trs += tr;
		}
		$('#articles_page tbody').html(trs).parent().show();
		$('#articles_page .page_list').html(page_list('<?php echo Common::url();?>', data.page.count, data.page.current, show_articles));
		$('#articles_page input:button[name^="action_"]').unbind('click').bind('click',function(){
			var action = this.name.substr(7);
			if (action=='delete' && !confirm('确实要删除选中项？')) {
				return ;
			}
			var ids = [];
			$('input:checked[name="articleids[]"]').each(function(){
				ids.push(this.value);
			});
			if (ids.length>0) {
				load_page_json('<?php echo Common::url();?>', {"action":action, "page":data.page.current, "ids":ids.join(',')}, show_articles);
			}
		});
		$('#articles_page a[id^="action_"]').bind('click', function(){
			var arr = this.id.split('_');
			if (arr.length<3) {
				return ;
			}
			var action = arr[1];
			var id = arr[2];
			if (action=='delete') {
				if (confirm('确实删除该条记录？')) {
					load_page_json('<?php echo Common::url();?>', {"action":action, "page":data.page.current, "ids":id}, show_articles);
				}
			}
			if (action=='edit') {
				$.getJSON('<?php echo Common::url();?>', {"action":action, "id":id}, function(json){
					if (json=='NULL') {
						alert('文章已被删除!');
					} else {
						var fieldset = '';
						fieldset += '<form id="article_edit_form" action="">';
						fieldset += '<fieldset>';
						fieldset += '<legend>文章编辑</legend>';
						fieldset += '<p>';
						fieldset += '<label>ID</lable>';
						fieldset += '<input type="text" class="sf" name="article[articleid]" value="'+json.articleid+'" readonly="readonly" />';
						fieldset += '<span class="field_desc"></span>';
						fieldset += '</p>';
						
						fieldset += '<p>';
						fieldset += '<label>标题</lable>';
						fieldset += '<input type="text" class="lf" name="article[title]" value="'+json.title+'" />';
						fieldset += '<span class="field_desc"></span>';
						fieldset += '</p>';
						
						fieldset += '<p>';
						fieldset += '<label>副标题</lable>';
						fieldset += '<input type="text" class="lf" name="article[subtitle]" value="'+json.subtitle+'" />';
						fieldset += '<span class="field_desc"></span>';
						fieldset += '</p>';
						
						fieldset += '<p>';
						fieldset += '<label>作者</lable>';
						fieldset += '<input type="text" class="sf" name="article[author]" value="'+json.author+'" />';
						fieldset += '<span class="field_desc"></span>';
						fieldset += '</p>';
						
						fieldset += '<p>';
						fieldset += '<label>编者按</lable>';
						fieldset += '<textarea rows="5" cols="50" name="article[leaderette]">'+json.leaderette+'</textarea>';
						fieldset += '<span class="field_desc"></span>';
						fieldset += '</p>';

						fieldset += '<p>';
						fieldset += '<label>题记</lable>';
						fieldset += '<textarea rows="5" cols="50" name="article[preface]">'+json.preface+'</textarea>';
						fieldset += '<span class="field_desc"></span>';
						fieldset += '</p>';

						fieldset += '<p>';
						fieldset += '<label>正文</lable>';
						fieldset += '<textarea rows="10" cols="50" name="article[content]">'+json.content+'</textarea>';
						fieldset += '<span class="field_desc"></span>';
						fieldset += '</p>';

						fieldset += '<p>';
						fieldset += '<label>后记</lable>';
						fieldset += '<textarea rows="5" cols="50" name="article[postscript]">'+json.postscript+'</textarea>';
						fieldset += '<span class="field_desc"></span>';
						fieldset += '</p>';

						fieldset += '<p>';
						fieldset += '<label>栏目</lable>';
						fieldset += '<select name="article[catid]">'+json.category+'</select>';
						fieldset += '<span class="field_desc"></span>';
						fieldset += '</p>';
						
						fieldset += '<p>';
						fieldset += '<label>原创</lable>';
						fieldset += '<input type="checkbox" name="article[original]" value="1" '+(json.original==1?'checked="checked"':'')+' />';
						fieldset += '<span class="field_desc"></span>';
						fieldset += '</p>';
						
						fieldset += '<p><input class="button" type="button" id="article_edit_save" value="保存" /> <input class="button" type="button" onclick="$(\'#articles_page\').show();$(\'#article_edit\').hide();" value="取消" /></p>';
						fieldset += '</fieldset>';
						fieldset += '</form>'
						$('#articles_page').hide();
						$('#article_edit').html(fieldset).show();
						$('#article_edit_save').click(function(){
							$.post('<?php echo Common::url();?>',  $("#article_edit_form").serialize(), function(r){
								if (r=='0') {
									alert('保存失败');
								}
								$('#article_edit').hide();
								$('#articles_page').show();
								load_page_json('<?php echo Common::url();?>', data.page.current, show_articles);
							});
						});
					}
				});
			}
		});
	}
}

load_page_json('<?php echo Common::url();?>', 1, show_articles);
</script>