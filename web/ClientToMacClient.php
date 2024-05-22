<?php
$titel = "Transfer Client To MAC Client";
$Clients = 'active';
include('include/hader.php');
ini_alter('date.timezone','Asia/Almaty');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($userr_typ == 'admin' || $userr_typ == 'superadmin') {
if($userr_typ == 'mreseller') {
$result=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid, e.minimum_day FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id = '$e_id'");
}
else{
$result=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid, e.minimum_day FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' AND z.z_id = '$z_id'");

}
 $row = mysql_fetch_assoc($result);


$query1er="SELECT p_id, p_name, p_price, bandwith, mk_profile FROM package WHERE mk_profile = '$mk_profile' AND z_id = '$z_id'";
$result1345=mysql_query($query1er);
$row2ffdf = mysql_fetch_assoc($result1345);
$mac_pack_id = $row2ffdf['p_id'];
$mac_pack_name = $row2ffdf['p_name'];
$mac_pack_price = $row2ffdf['p_price'];
$mac_pack_bandwith = $row2ffdf['bandwith'];

if($mac_pack_id == ''){
$query1="SELECT p_id, p_name, p_price, bandwith, mk_profile FROM package WHERE z_id = '$z_id' order by id ASC";
$result1=mysql_query($query1);
}

$sql2oo ="SELECT last_id, terminate, e_name FROM emp_info WHERE z_id = '$z_id'";
$query2oo = mysql_query($sql2oo);
$row2ff = mysql_fetch_assoc($query2oo);
$idzff = $row2ff['last_id'];
$reseller_terminate = $row2ff['terminate'];
$eeename = $row2ff['e_name'];
$com_id = $idzff + 1;

$sql1q = mysql_query("SELECT c_id, SUM(bill_amount) AS totbill FROM billing_mac WHERE z_id = '$macz_id'");
$rowq = mysql_fetch_array($sql1q);


$sql1z1 = mysql_query("SELECT p.id, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p
						WHERE p.z_id = '$macz_id' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);

$aaaa = $rowwz['retotalpayments']-$rowq['totbill'];

$sss1m = mysql_query("SELECT reseller_logo, billing_type FROM emp_info WHERE z_id ='$z_id'");
$sssw1m = mysql_fetch_assoc($sss1m);

$billing_typee = $sssw1m['billing_type'];

if($mac_user == '1'){
$sql1zfff = mysql_query("SELECT SUM(b.bill_amount) AS craditamount, b.z_id, e.e_name AS resellername, e.e_id AS resellerid, z.z_name AS resellerzone FROM billing_mac AS b 
LEFT JOIN emp_info AS e ON e.z_id = b.z_id
LEFT JOIN zone AS z ON z.z_id = e.z_id

WHERE b.c_id = '$c_id'");
$rowwzddd = mysql_fetch_array($sql1zfff);

$craditamount = $rowwzddd['craditamount'];
$resellernameee = $rowwzddd['resellername'];
$reselleriddd = $rowwzddd['resellerid'];
$resellerzoneee = $rowwzddd['resellerzone'];
}
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" onclick="history.back()"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
			<?php if($aaaa > 0 && $billing_typee == 'Prepaid' || $billing_typee == 'Postpaid'){?>
				<h1>Add MAC Client</h1>
			<?php  } else{ ?>
				 <h3>You have not sufficient balance to add new client.</h3>
			<?php  } ?>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
			<?php if($reseller_terminate == '1'){ ?> <br><h3 style="margin-left: 20px;color: red;">[<?php echo $eeename; ?>] Account Has Been Terminated. Not Possible to Add Client. Contact Administrator.</h3><br><?php } else{; ?>
				<div class="modal-header">
					<h5>Transfer Client To MAC Client</h5>
				</div>
					<form id="form" class="stdform" method="post" action="ClientToMacClientQuery" enctype="multipart/form-data">
						<input type="hidden" name="u_type" value="client" />
						<input type="hidden" name="line_typ" value="1" />
						<input type='hidden' name='wayyyyyy' value='<?php echo $wayyyyyy; ?>'/> 
						<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="old_p_id" value="<?php echo $p_id; ?>" />
						<input type="hidden" name="mkid" value="<?php echo $mk_id; ?>" />
						<input type="hidden" name="mac_user" value="<?php echo $mac_user; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
							<div class="modal-body">
							<div style="float: left;width: 50%;">
								<p>
									<label style="width: 130px;">Company ID</label>
									<span class="field" style="margin-left: 0px;"><input type="text" style="width:140px;" name="com_id" id="" readonly class="input-xlarge" value = "<?php echo $com_id; ?>" /></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">MAC Area*</label>
									<span class="field" style="margin-left: 0px;"><h4 style="margin-top: 15px;"><b><?php echo $row['z_name']; ?> - <?php echo $row['resellername']; ?> (<?php echo $row['resellerid']; ?>)</b></h4>
									<?php if($userr_typ == 'mreseller') { ?>
										<input type="hidden" name="z_id" value="<?php echo $macz_id; ?>" />
									<?php } else{ ?>
										<input type="hidden" name="z_id" value="<?php echo $row['z_id']; ?>" />
									<?php } ?>
									</span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">Package*</label>
									<span class="field" style="margin-left: 0px;">
										<?php if($mac_pack_id != '') { ?>
											<h4 style="margin-top: 15px;"><b><?php echo $mac_pack_name; ?> - <?php echo $mac_pack_price.'TK'; ?> (<?php echo $mac_pack_bandwith; ?>)</b></h4>
											<input type="hidden" name="p_id" value="<?php echo $mac_pack_id; ?>" />
											<?php } else{ ?>
												<select data-placeholder="Choose a Package" class="chzn-select" style="width:250px;" name="p_id" id="p_id" required="" >
													<option value=""></option>
														<?php while ($row1=mysql_fetch_array($result1)) { ?>
													<option value="<?php echo $row1['p_id']?>"><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
														<?php } ?>
												</select>
										<?php } ?><br>
									</span>
									<label style="width: 130px;"></label>
									<span id="dayprice" style="font-weight: bold;"></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">Activation Days*</label>
									<span class="field" style="margin-left: 0px;font-weight: bold;"><input type="text" name="duration" id="duration" style="width:80px;font-weight: bold;font-size: 20px;height: 20px;" placeholder="30" required=""></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;"></label>
									<span class="field" style="margin-left: 0px;color: red;font-weight: bold;">[Minimum <?php echo $row['minimum_day'];?> Days]</span>
								</p>
							</div>
								
								
							<div style="margin-left: 48%;">
								
								<p>
									<label style="width: 130px;font-weight: bold;">Client Name*</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="c_name" value="<?php echo $c_id;?>" id="" readonly required="" style="width:240px;" /></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">PPPoE ID*</label>
									<input type="text" name="c_id" id="name" placeholder="User id must be at least 3 characters long" value="<?php echo $c_id;?>" readonly style="width:240px;" required="" />
								</p>
								<p>
									<label class="control-label" for="passid" style="width: 130px;font-weight: bold;">Login Password*</label>
									<div class="controls"><input type="text" name="passid" style="width:240px;" style="width:240px;" size="12" value="<?php echo $passid;?>" readonly required="" /></div>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">Bill Calculation</label>
										<span class="formwrapper" style="margin-left: 0;">
										<input type="radio" name="qcalculation" value="Auto"> Auto &nbsp; &nbsp;
										<input type="radio" name="qcalculation" value="Manual" checked="checked"> Manual &nbsp; &nbsp;
									</span>
								</p>
							</div>

							<br>
							<br>
							<br>
							<br>
							<?php if($mac_user == '1'){?>
							<p>
							<label style="width: 130px;font-weight: bold;"></label>
									<span class="field" style="margin-left: 0px;font-weight: bold;font-size: 15px;"><a style="color: red;">Worning:</a> If you submit this from, <a style="color: red;"><?php echo $craditamount;?></a> TK will credited in <a style="color: red;"><?php echo $resellerzoneee;?> (<?php echo $resellernameee;?> - <?php echo $reselleriddd;?>)</a> account balance.</span>
							</p>
							<?php } ?>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn">Reset</button>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
					</form>	
				<?php } ?>					
			</div>
		</div>
	</div>
<?php
}
else{ echo 'You Are Not Authorized For This Action.';}
}
else{
	include('include/index');
}
include('include/footer.php');
?>

<?php if($mac_pack_id != ''){?>
<script type="text/javascript">
$(document).ready(function()
{    
 $("#duration").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#dayprice").html('checking...');
   $.ajax({
    
    type : 'POST',
	url  : "duration-packageprice-calculation.php?p_id="+<?php echo $mac_pack_id;?>,
    data : $(this).serialize(),
    success : function(data)
        {
              $("#dayprice").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#dayprice").html('');
  }
 });
 
});
</script>
<?php } else{?>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="p_id"]').on('change',function(){
           var CatID1 = jQuery(this).val();
           if(CatID1)
			{
				$(document).ready(function()
				{    
				 $("#duration").keyup(function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 0)
				  {  
				   $("#dayprice").html('checking...');

				   $.ajax({
					
					type : 'POST',
					url  : "duration-packageprice-calculation.php?p_id="+CatID1,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#dayprice").html(data);
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#dayprice").html('');
				  }
				 });
				});
			}
        });
});
</script>
<?php } ?>
<style>
.ui-spinner-buttons{display: none;}
</style>