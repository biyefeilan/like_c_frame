<?php View::load('user/header');?>
<style type="text/css">
table{ margin:100px auto 250px auto;}
.fr{float:right;}
.center{text-align:center;margin:0 auto;}
</style>
<form method="post" action="" name="myform">
<table>
	<thead>
		<tr>
			<td colspan="2" class="center">用户注册</td>
		</tr>
		<tr>
			<td colspan="2"><font color="red"><?php echo $this->message;?></font></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>用户名</th>
			<td><input type="text" value="" name="username" /></td>
		</tr>
		<tr>
			<th>密码</th>
			<td><input type="password" value="" name="password" /></td>
		</tr>
		<tr>
			<th>确认密码</th>
			<td><input type="password" value="" name="confirm" /></td>
		</tr>
		<tr>
			<th>邮件</th>
			<td><input type="text" value="" name="email" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" class="fr" value="注册" /></td>
		</tr>
	</tbody>
</table>
</form>
<?php View::load('user/footer');?>