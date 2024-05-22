<?php
$titel = "Network Active Conniction";
$Network = 'active';
include('include/hader.php');
$mk_id = $_GET['id'];
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Network' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
	<div class="pageheader">
        <div class="searchbar">
		<a id="growl2" class="btn"><small>Long live growl message</small></a> <a id="growl" class="btn"><small>Basic growl</small></a>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Realtime Active Connections</h1>
        </div>
			
    </div><!--pageheader-->					
	<?php if($sts == 'inactive') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!! [<?php echo $ccc_id;?>]</strong> Successfully Inactive from Your Mikrotik.			
	</div><!--alert-->
	<?php } if($sts == 'macaddNo') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!! [<?php echo $ccc_id;?>]</strong> Successfully Unbind in Your Mikrotik Secret.			
	</div><!--alert-->
	<?php } if($sts == 'macaddYes') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!! [<?php echo $ccc_id;?>]</strong> Successfully Bind in Your Mikrotik Secret.			
	</div><!--alert-->
	<?php } ?>
	<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
<form id="form2" class="stdform" method="post" action="MACClientAdd1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
						<div class="popdiv">
								<div id='Pointdiv1'></div>
						</div>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->
		<div class="box box-primary">

			<div class="box-header" id='responsecontainer1' style="font-size: 20px;padding: 15px 0px 2px 15px;">
			</div>
			<div class="box-body" id='responsecontainer'>

					
			</div>			
		</div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}

function checksts(){
    return confirm('Wanna Active this Client!!  Are you sure?');
}

function checksts1(){
    return confirm('Inactive this Client in Mikrotik!!  Are you sure?');
}

function checkLock(){
    return confirm('Are you sure?  Do u know what are you doing?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
 $(document).ready(function() {
 	 $("#responsecontainer").load("AutoActiveClients.php?id=<?php echo $mk_id;?>");
 	 $("#responsecontainer1").load("AutoActiveClientsCount.php?ids=<?php echo $mk_id;?>");
   var refreshId = setInterval(function() {
      $("#responsecontainer").load('AutoActiveClients.php?id=<?php echo $mk_id;?>');
	  $("#responsecontainer1").load('AutoActiveClientsCount.php?ids=<?php echo $mk_id;?>');
   }, 500000);
   $.ajaxSetup({ cache: false });
});
</script>