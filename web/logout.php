<?php
session_start();
session_destroy();
//$msg=urlencode("Logged out successfully");
$titel = "Logout";
include('include/hade_logout.php');
include('include/manu_logout.php');
include("conn/connection.php") ;

?>
	<div class="maincontentinner">
		<div class="errortitle" style="color:red;">
			<div class="errorbtns animate8 fadeInUp">
				<p style="font-size: 40px; margin-top: 35px; color:rgb(255, 0, 0); text-transform: uppercase;"> Logout.....!!!</p>
			</div>
		</div>
	</div>
		<script language="javascript">
			function redirect()
				{
				location.href="<?php echo "index"; ?>"; //?msg=$msg
				}
			setTimeout("redirect()",4000);
		</script>
<?php
include('include/footer.php');
?>