<?php
session_start();
include('company_info.php');
include("conn/connection.php") ;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title> Locked </title>
<link rel="stylesheet" href="css/login.css" type="text/css" />
<link rel="stylesheet" href="css/style.shinyblue.css" type="text/css" />
<link rel="icon" type="images/png" href="images/favicon.png"/>

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#login').submit(function(){
            var u = jQuery('#username').val();
            var p = jQuery('#password').val();
            if(u == '' && p == '') {
                jQuery('.login-alert').fadeIn();
                return false;
            }
        });
    });
</script>
</head>

<body class="login-page" style="">
	<div class="login-box-lock">
		<div class="login-logo">
			Locked
		</div>
		<div class="login-box-body">
			<div class="leftside">
				<img class="lock-avatar" src="<?php echo $_SESSION['SESS_EMP_IMG']; ?>">
			</div>
			<div class="rightside">
				<form id="login" action="login_exec_lock" method="post">
					<div class="lock-form">
						<h4><?php echo $_SESSION['SESS_FIRST_NAME']; ?></h4>
						<input type="hidden" class="form-control" name="username" id="login" value="<?php echo $_SESSION['SESS_USER_ID']; ?>" placeholder="Enter your username" />
					</div>
					<div class="form-group">
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" />
					</div>
					<div class="form-group">
						<input class="btn btn-info form-control" type="submit" value="Login" style="pointer-events: all; cursor: pointer;">
					</div>
					<div class="form-group footr">
						<div class="clearfix"> </div>
					</div>
					
				</form>
			</div>
		</div><!--loginpanelinner-->
		<div class="login-footer">
			<?php echo $footer; ?>
		</div>
	</div><!--loginpanel-->
</body>
</html>
