<?php
$titel = "Fund Transfer";
$FundTransfer = 'active';
include('include/hader.php');
extract($_POST);


//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'FundTransfer' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

if($user_type == 'admin' || $user_type == 'superadmin'){
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
}
if($user_type == 'admin' || $user_type == 'superadmin'){
	$Bank1 = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
}
else{
	$Bank1 = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id != '' ORDER BY bank_name");
}

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Fund Transfer</h1>
        </div>
    </div><!--pageheader-->
	<?php if ($stat == 'done'){?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			 <strong>Successfully!!</strong> Your data successfully Inserted In Your Database.
		</div>
	<?php } ?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Fund Transfer</h5>
				</div>
					<form id="" name="form1" class="stdform" method="post" action="FundTransferSave" onsubmit='disableButton()'>
						<div class="modal-body" style="min-height: 180px;">
							<input type="hidden" value="<?php echo $e_id; ?>" name="entry_by" />
							<input type="hidden" value="<?php echo date('Y-m-d'); ?>" name="enty_date" /> 
							<input type="hidden" name="transfer_date" value="<?php echo date("Y-m-d");?>" />
							<table class="table table-bordered table-invoice" style="width:100%">
								<tr>
									<td style="font-weight: bold;font-size: 12px;width: 15%;">Fund Send By Bank*</td>
									<td style="width: 35%;">
										<select data-placeholder="Choose Send By Bank" name="fund_send" id="fund_send" class="chzn-select"  style="width:100%;" required="">
											<option></option>
												<?php while ($row=mysql_fetch_array($Bank1)) { ?>
											<option value="<?php echo $row['id'] ?>"><?php echo $row['bank_name']?></option>
												<?php } ?>
										</select>
									</td>
									<td rowspan="5">
										<div id="resultpack" style="font-weight: bold;"></div>
									</td>
							   </tr>
								<tr>
									<td style="font-weight: bold;font-size: 12px;">Fund Received By Bank*</td>
									<td style="">
										<select data-placeholder="Select a Receiver Bank" name="fund_received" class="chzn-select"  style="width:100% ;" required="">
											<option></option>
												<?php while ($row1=mysql_fetch_array($Bank)) { ?>
											<option value="<?php echo $row1['id'] ?>"><?php echo $row1['bank_name']?></option>
												<?php } ?>
										</select>
										</td>
								</tr>
								<tr>
									<td style="font-weight: bold;font-size: 12px;">Transfer Amount*</td>
									<td style="font-size: 18px;font-weight: bold;color: maroon;"><input type="text" name="transfer_amount" placeholder="" style="width:80px;font-weight: bold;font-size: 20px;height: 20px;margin-bottom: 5px;" required="">৳</td>
								</tr>
								<tr>
									<td style="font-weight: bold;font-size: 12px;">NOTE</td>
									<td style=";"><textarea type="text" name="note" placeholder="Optional" id="" class="input-xlarge" /></textarea></td>
								</tr>
							</table><br>
						</div>
						<div class="modal-footer">
							<button type="reset" class="btn ownbtn11">Reset</button>
							<button class="btn ownbtn2" type="submit" id="submitdisabl">Submit</button>
						</div>
					</form>	
			</div>
		</div>
	</div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>

<script type="text/javascript">  
$(document).ready(function()
				{   
		 jQuery('select[name="fund_send"]').on('change',function(){
				  var fund_send = jQuery(this).val(); 
				   $.ajax({
					type : 'POST',
					url  : "fund-balance-check.php",
					data : jQuery(this),
					success : function(data)
						{
							  $("#resultpack").html(data);
						   }
					});
					return false;
				 });
				 });

function disableButton() {
        var btn = document.getElementById('submitdisabl');
        btn.disabled = true;
        btn.innerText = 'Posting...'
}
</script>