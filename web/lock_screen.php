<!DOCTYPE html>
<?php session_start();
extract($_POST);
$old_pass = $_SESSION['SESS_EMP_PASS'];

$dfhh = sha1($pass);

if($dfhh != ''){


	if($old_pass == $dfhh){
		echo "<script>history.go(-2);</script>";
	}
}



?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">

    <title>Locked</title>

    <!-- Bootstrap core CSS -->
    <link href="css/a/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="css/a/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="css/a/css/style.css" rel="stylesheet">
    <link href="css/a/css/style-responsive.css" rel="stylesheet">
  </head>

  <body>
		<div class="container">
		<div id="showtime" style="margin-bottom: 200px;"></div>
	  			<div class="col-lg-4 col-lg-offset-4">
	  				<div class="lock-screen">
		  				<h2><a data-toggle="modal" href="#myModal"><i class="fa fa-lock" style="font-size: 100px;"></i></a></h2>
				          <!-- Modal -->
							<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
								<div class="mt">
									<div class="col-lg-12">
											<div style="float: none;">
													<div id="profile-02" style="background: #e8000033;height: 400px;margin: 35px auto;width: 28%;border-radius: 10px;">
														<div class="user">
															<img src="<?php if($_SESSION['SESS_EMP_IMG'] == ''){echo 'emp_images/no_img.jpg';}else{echo $_SESSION['SESS_EMP_IMG'];}?>" class="img-circle" width="130" height="130">
															<h3 style="text-transform: uppercase;color: white;"><?php echo $_SESSION['SESS_FIRST_NAME'];?></h3>
														</div>
													<form id="login" action="<?php echo $PHP_SELF;?>" method="post">
														<div class="user" style="padding-top: 15px;">
															<input type="hidden" class="" id="" name="user_id" value="<?php echo $_SESSION['SESS_USER_ID'];?>">
															<input type="hidden" class="" id="" name="wayyy" value="LockedScreen">
															<input type="password" class="form-control" name="pass" id="inputSuccess" placeholder="Inter Your Password" style="text-align: center;display: initial;width: 65%;border-bottom: 3px solid gray;border-top: 0px solid gray;border-right: 0px solid;border-left: 0px solid;background: transparent;font-weight: 600;font-size: 17px;border-radius: 0px;height: 42px;color: white;">
														</div>
														<div class="showback" style="background: transparent;box-shadow: none;">
															<button type="submit" class="btn btn-theme03" style="width: 70%;text-transform: uppercase;font-weight: bold;color: #fff;font-size: 13px;"><i class="fa fa-unlock" style="font-size: 16px;margin-right: 6px;"></i>Unlock Now</button>
														</div>
													</form>
														<p style="float: right;margin: 16px 10px 0 0;text-transform: uppercase;color: white;font-weight: bold;"><a href="index">Logout</a></p>
														<p style="float: Left;margin: 18px 0px 0px 5px;color: #48cfad;"><a href="https://tis.asthatec.com/" style="font-size: 10px;color: #48cfad;">© 2020. Astha Technology, v7.4</a></p>
													</div>
											</div><!--/ col-md-4 onclick="history.back()"  -->
									</div>
								</div>
							</div><!-- modal -->
	  				</div><!--lock-screen -->
	  			</div><!-- /col-lg-4 -->
	  	</div><!-- /container -->
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="css/a/js/jquery.js"></script>
    <script src="css/a/js/bootstrap.min.js"></script>

    <script class="include" type="text/javascript" src="css/a/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="css/a/js/jquery.scrollTo.min.js"></script>
    <script src="css/a/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="css/a/js/jquery.sparkline.js"></script>

    <!--common script for all pages-->
    <script src="css/a/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="css/a/js/sparkline-chart.js"></script>  

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="css/a/js/jquery.backstretch.min.js"></script>
	
    <script>
        $.backstretch("imgs/back.png", {speed: 500});
    </script>
  </body>
</html>
