<?php
$titel = "Fund Transfer Add";
include('include/hader.php');

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
	<div class="box box-primary">
		<div class="box-header">
			<div class='hil' style="font-size: 13px;padding: 0 5px 0 5px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #317eac;font-weight: bold;"> Fund Transfer Add </div>
		</div>
			<form class="stdform" method="post" action="FundTransferSave" onsubmit='disableButton()'>
			<input type="hidden" value="<?php echo $e_id; ?>" name="entry_by" />
			<input type="hidden" value="<?php echo date('Y-m-d'); ?>" name="enty_date" /> 
					<div class="modal-body">
						
							<p>	
								<select data-placeholder="Choose Send By" name="fund_send" class="chzn-select" style="width:100%;" required="">
									<option value=""></option>
										<?php while ($row1=mysql_fetch_array($Bank1)) {?>
									<option value="<?php echo $row1['id']; ?>"><?php echo $row1['bank_name'];?> <?php echo $row1['emp_id']; ?></option>
										<?php } ?>
								</select>
							</p>
								<select data-placeholder="Choose Fund Receiver" name="fund_received" class="chzn-select" style="width:100%;" required="">
										<?php while ($row=mysql_fetch_array($Bank)) { ?>
									<option value="<?php echo $row['id']; ?>"><?php echo $row['bank_name'];?> <?php echo $row['emp_id']; ?></option>
										<?php } ?>
								</select>
							</p>
							<p>
								<input type="text" name="transfer_amount" placeholder="Amount" id="" required="" style="width:30%;" />
							</p>
							<p>
								<input type="hidden" name="transfer_date" placeholder="Transfer Date" class="input-xlarge" readonly required="" value="<?php echo date("Y-m-d");?>"/>
							</p>
							<p>
								<textarea type="text" name="note" placeholder="Note" id="" class="input-xxlarge" /></textarea>
							</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit" id="submitdisabl">Submit</button>
					</div>
			</form>	
	</div>

<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
function disableButton() {
        var btn = document.getElementById('submitdisabl');
        btn.disabled = true;
        btn.innerText = 'Posting...'
}
</script>