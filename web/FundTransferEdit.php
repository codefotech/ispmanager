<?php
extract($_POST);
$titel = "Fund Transfer";
$FundTransfer = 'active';
include('include/hader.php');
$FundTransferId = $idd;


//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'FundTransfer' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------


$e_id = $_SESSION['SESS_EMP_ID'];

$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
$Bank1 = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");

$sqls = mysql_query("SELECT * FROM fund_transfer WHERE id = '$FundTransferId'");
$rows = mysql_fetch_array($sqls);

if($user_type == 'admin' || $user_type == 'superadmin'){
?>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Edit Fund Transfer</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Fund Transfer</h5>
				</div>
				<form id="form" class="stdform" method="post" action="FundTransferEditSave" >
				<input type="hidden" value="<?php echo $e_id; ?>" name="entry_by" />
				<input type="hidden" value="<?php echo date('Y-m-d'); ?>" name="enty_date" /> 
				<input type="hidden" value="<?php echo $rows['id']; ?>" name="ids" />
				<input type="hidden" value="<?php echo $rows['fund_send']; ?>" name="old_fund_send" />
				<input type="hidden" value="<?php echo $rows['fund_received']; ?>" name="old_fund_received" />
				<input type="hidden" value="<?php echo $rows['transfer_amount']; ?>" name="old_transfer_amount" />
					<div class="modal-body">
					<p>
						<label>Fund Send By</label>
						<select name="fund_send" data-placeholder="Select a Bank" class="chzn-select input-xlarge"  style="text-align:center;">	
							<option value=""></option>
						<?php while ($row=mysql_fetch_array($Bank)) { ?>
							<option value="<?php echo $row['id'] ?>" <?php if($row['id'] == $rows['fund_send']){echo 'selected';} ?> ><?php echo $row['bank_name']?></option>
						<?php } ?>
						</select>
					</p>
					<p>
						<label>Fund Received By</label>
						<select name="fund_received" data-placeholder="Select a Bank" class="chzn-select input-xlarge"  style="text-align:center;">	
							<option value=""></option>
						<?php while ($row1=mysql_fetch_array($Bank1)) { ?>
							<option value="<?php echo $row1['id'] ?>" <?php if($row1['id'] == $rows['fund_received']){echo 'selected';} ?> ><?php echo $row1['bank_name']?></option>
						<?php } ?>
						</select>
					</p>
					<p>
						<label>Transfer Amount</label>
						<span class="field"><input id="" type="text" name="transfer_amount" value="<?php echo $rows['transfer_amount']; ?>" class="input-xlarge"></span>
					</p>
					<p>
						<label>Transfer Date</label>
						<span class="field"><input id="" type="text" readonly name="transfer_date" value="<?php echo $rows['transfer_date']; ?>" class="input-xlarge"></span>
					</p>
					<p>
						<label>Note</label>
						<span class="field"><textarea type="text" name="note" placeholder="Collection Note (If Any)"  id="" class="input-xxlarge" /><?php echo $rows['note']; ?></textarea></span>
					</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
				</form>			
			</div>
		</div>
	</div>
<?php
}}
else{
	include('include/index');
}
include('include/footer.php');
?>