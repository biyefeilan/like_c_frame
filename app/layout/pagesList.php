<style type="text/css">
#pages_list{
	font-size: 12px;
	font-family: Verdana, Geneva, sans-serif;
}
#pages_list a{
	text-decoration: none;
	float: left;
	border: 1px solid #E7ECF0;
	margin: 0 5px;
	color: #333;
	display: block;
	text-align:center;
	min-width: 22px;
	height: 22px;
}
#pages_list a:hover{
	background-color: #EBEBEB;
	border: 1px solid #FFFFFF;
	color: #333;
}
#pages_list .page_now{
	font-weight: bold;
	color: #000;	
}
</style>
<div id="pages_list">
    <?php foreach($links as $k=>$v) { ?>
		<a href="<?php echo $v;?>" target="_self"><span class="<?php echo $k==$page_now ? 'page_now' : '';?>"><?php echo $k;?></span></a>	
	<?php }?>
</div>