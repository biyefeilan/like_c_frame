<?php View::load('user/header');?>
<div class="mainbar">
	<div class="article">
		<form method="post" action="" name="myform">
		<table>
			<thead>
				<tr>
					<td colspan="2" class="center">修改密码</td>
				</tr>
				<tr>
					<td colspan="2"><font color="red"><?php echo $this->message;?></font></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>当前密码</th>
					<td><input type="password" value="" name="oldpwd" /></td>
				</tr>
				<tr>
					<th>新密码</th>
					<td><input type="password" value="" name="newpwd" /></td>
				</tr>
				<tr>
					<th>密码确认</th>
					<td><input type="password" value="" name="confirm" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" class="fr" value="保存" /></td>
				</tr>
			</tbody>
		</table>
		</form>
	</div>
</div>
<?php View::load('user/sidebar');?>
<?php View::load('user/footer');?>
