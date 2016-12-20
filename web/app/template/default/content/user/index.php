<?php View::load('user/header');?>
<div class="mainbar">
	<div class="article">
		<h2>Hi <span><?php echo $this->username;?></span></h2>
		<div class="clr"></div>
		<table class="userinfo">
			<tr>
				<th>等级</th>
				<td><?php echo $_SESSION['user']['group']['name'];?></td>
			</tr>
			<tr>
				<th>经验</th>
				<td><?php echo $this->exp;?></td>
			</tr>
			<tr>
				<th>金币</th>
				<td><?php echo $this->credit;?></td>
			</tr>
			<tr>
				<th>登录IP</th>
				<td><?php echo $this->lastip;?></td>
			</tr>
			<tr>
				<th>登录时间</th>
				<td><?php echo date('Y-m-d H:i:s', $this->lastdate);?></td>
			</tr>
			<tr>
				<th>登录次数</th>
				<td><?php echo $this->loginnum;?></td>
			</tr>
		</table>
	</div>
</div>
<?php View::load('user/sidebar');?>
<?php View::load('user/footer');?>