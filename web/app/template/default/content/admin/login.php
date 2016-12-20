<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Hello! Admin</title>
	
	<link type="text/css" href="<?php echo CSS_URL;?>admin/style.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo CSS_URL;?>admin/login.css" rel="stylesheet" />
	
	<script type='text/javascript' src='<?php echo JS_URL;?>jquery-1.7.2.min.js'></script>	<!-- jquery library -->
	<script type='text/javascript' src='<?php echo JS_URL;?>admin/iphone-style-checkboxes.js'></script> <!-- iphone like checkboxes -->

	<script type='text/javascript'>
		jQuery(document).ready(function() {
			jQuery('.iphone').iphoneStyle();
		});
	</script>
	
	<!--[if IE 8]>
		<script type='text/javascript' src='<?php echo JS_URL;?>admin/excanvas.js'></script>
		<link rel="stylesheet" href="<?php echo CSS_URL;?>admin/loginIEfix.css" type="text/css" media="screen" />
	<![endif]--> 
 
	<!--[if IE 7]>
		<script type='text/javascript' src='<?php echo JS_URL;?>admin/excanvas.js'></script>
		<link rel="stylesheet" href="<?php echo CSS_URL;?>admin/loginIEfix.css" type="text/css" media="screen" />
	<![endif]--> 
	
</head>
<body>
	<div id="line"><!-- --></div>
	<div id="background">
		<div id="container">
			<div id="logo">
				<img src="<?php echo IMG_URL;?>admin/logologin.png" alt="Logo" />
			</div>
			<div id="box"> 
				<form action="" method="post"> 
					<div class="one_half">
						<p><input name="username" value="" class="field" /></p>
						<!-- <p><input type="checkbox" name="remember" class="iphone" /><label class="fix">Remember me</label></p>  -->
					</div>
					<div class="one_half last">
						<p><input type="password" name="password" value="" class="field" />	</p>
						<p><input type="submit" value="Login" class="login" /></p>
					</div>
			</form> 
		</div> 
		
		</div>
	</div>
</body>
</html>