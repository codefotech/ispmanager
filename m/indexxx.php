<?php
session_start();
include('../web/company_info.php');
unlink('error_log');
if($com_sts == '0'){
?>

<!DOCTYPE html>
<html>
<head>
<!-- Original URL: http://pixelcreattor.com/demos/taxiadmin/sign-in.html
Date Downloaded: 2/6/2018 9:58:00 PM !-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title><?php echo $comp_name;?></title>
         <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
		<link rel="icon" type="images/png" href="images/favicon.png"/>
        <link rel="stylesheet" href="icss/bootstrap.min.css" />
		 
        <!-- Theme style -->
        <link rel="stylesheet" href="icss/main-style.min.css" />
        <link rel="stylesheet" href="icss/skins/all-skins.min.css" />
        <link rel="stylesheet" href="icss/demo.css" />
</head>
<body class="skin-indigo-gradient login-page">
         <div class="box-login" style="width: 75%;margin-top: 30%;">
			<div class="result"></div>
             <div class="box-login-body">
				<div class="CompanyLogo" style="margin-left: 20px;"><img src="images/logo.png" alt="Logo" style="width: 85%;margin-bottom: 15px;" /></div>
				<?php if(isset($_SESSION['ERRMSG_ARR']) != ''){ ?>
					<div class="alert alert-danger">
						<button data-dismiss="alert" class="close" type="button">&times;</button>
						<strong><?php echo $_SESSION['ERRMSG_ARR'];?></strong>
					</div>
				<?php } ?>
				 <form class="login-form form-signin" action="login_exec" method="POST" autocomplete="on">
					<input type="hidden" name="location_service" value="<?php echo $location_service;?>"/>
                     <div class="form-group">
                         <input class="form-control login-input username" type="text" name='username' id='username' placeholder="Username" autofocus />
                     </div>
                     <div class="form-group">
                         <input class="form-control login-input password" type="password" name='password' id='password' placeholder="Password" />
                     </div>
                     <div class="form-group">
					 <input type="checkbox" name="rememberme">Remember Me
                     </div>
                     <div class="form-group">
                         <button type="submit" style="height: 40px;" class="btn btn-block btn-primary">Login</button>
                     </div>
                 </form>
             </div>
         </div>
<?php
// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>
</body>
</html>
 
<?php } else{ ?>
<div style="font-size: 30px;color: blue;font-weight: bold;text-align: center;margin-top: 70px;">Account has been</div> <div style="font-size: 40px;color: red;font-weight: bold;text-align: center;margin-top: 10px;">Terminated</div><div style="font-size: 20px;font-weight: bold;text-align: center;margin-top: 10px;">by</div> <div style="font-size: 25px;color: green;font-weight: bold;text-align: center;margin-top: 10px;">Asthatec</div><div style="font-size: 17px;color: green;font-weight: bold;text-align: center;margin-top: 10px;">[Contact: 01717561922]</div>
<?php } if($location_service == '1'){ ?>
<script>
var x = document.getElementById("location");

function getLocation() {
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
} else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
}
}

function showPosition(position) {
x.innerHTML = "<input type='hidden' name='latitude' value='" + position.coords.latitude + "'><input type='hidden' name='longitude' value='" + position.coords.longitude + "'>";
}


window.onload=getLocation();
</script>
<?php } ?>