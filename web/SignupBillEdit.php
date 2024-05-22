<?php
$titel = "Payment";
$SignupBill = 'active';
include('include/hader.php');
$id = $_GET['id'];

$res = mysql_query("SELECT * FROM bill_signup WHERE id = '$id'");
$row = mysql_fetch_array($res);$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");						
?>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="SignupBill"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-folder-open"></i></div>
        <div class="pagetitle">
            <h1>Edit Bill</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Bill</h5>
				</div>
				<form id="" name="form1" class="stdform" method="post" action="SignupBillUpdate">
				<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="user_id" />
				<input type="hidden" value="<?php echo $id; ?>" name="id" />
					<div class="modal-body">
						<p>	
							<label>Clients </label>
							<span class="field">
								<input type ="hidden" name="c_id" value="<?php echo $row['c_id']; ?>">
								<input type="text" name="" id="" class="input-xxlarge" value="<?php echo $row['c_id'];?>" readonly />
							</span>
						</p>
						<p>	
							<label>Bill Type </label>
							<select data-placeholder="Bill Type" name="bill_type" style="width:540px;" class="chzn-select">
								<option value="1" <?php if($row['bill_type'] == '1') echo 'selected' ?>>Signup Bill</option>
								<option value="2" <?php if($row['bill_type'] == '2') echo 'selected' ?>>Reactivation Charge</option>
								<option value="3" <?php if($row['bill_type'] == '3') echo 'selected' ?>>Others Bill</option>
							</select>
						</p>												<p>								<label>Bank</label>							<select data-placeholder="Select a bank" name="bank" class="chzn-select"  style="width:540px;" required="">								<option value=""></option>								<?php while ($rowBank=mysql_fetch_array($Bank)) { ?>									<option value="<?php echo $rowBank['id'] ?>" <?php if($rowBank['id'] == $row['bank']) echo 'selected'; ?> ><?php echo $rowBank['bank_name']?></option>								<?php } ?>							</select>						</p>
						<p>
							<label>Amount </label>
							<span class="field"><input type="text" name="amount" id="" class="input-xxlarge" value="<?php echo $row['amount'];?>" /></span>
						</p>
						<p>
							<label>Notes </label>
							<span class="field"><textarea type="text" name="bill_dsc" placeholder="Write Your Bill Note" id="" class="input-xxlarge" /><?php echo $row['bill_dsc'];?></textarea></span>
						</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn">Reset</button>
						<button class="btn btn-primary" type="submit">Update</button>
					</div>
				</form>			
			</div>
		</div>
	</div>
<?php
include('include/footer.php');
?>