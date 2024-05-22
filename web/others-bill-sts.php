<?php 
session_start(); // NEVER FORGET TO START THE SESSION!!!
$userr_typp = $_SESSION['SESS_USER_TYPE'];
$paid_by = $_SESSION['SESS_EMP_ID'];
include("conn/connection.php");
$bill_sts=$_GET['bill_sts'];

if($userr_typp == 'admin' || $userr_typp == 'superadmin'){
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$paid_by' ORDER BY bank_name");
}

if($bill_sts == 'Paid'){
?>
<input type="hidden" name="paid_by" value="<?php echo $paid_by;?>" />
<p>
<label>Bank*</label>
	<span class="field">
		<select placeholder="Type Of bank" name="bank" style="width:20%;" required="">
			<option value=""></option>
			<?php while ($rowBank=mysql_fetch_array($Bank)) { ?>
			<option value="<?php echo $rowBank['id'] ?>"><?php echo $rowBank['bank_name'];?> (<?php echo $rowBank['emp_id']; ?>)</option>
			<?php } ?>
		</select>
	</span>
</p>
<p>
<label>Method*</label>
<span class="field">
	<select class="chzn-select" name="method" style="width:20%;" required="" onChange="getRoutePoint22(this.value)"> 
		<option value="Cash">CASH</option>
		<option value="Bank">BANK</option>
		<option value="Online">ONLINE</option>
	</select>
</span>
</p>
<div id="Pointdiv1"></div>
<p>
<label>Send Receipt SMS?</label>
<span class="field">
		<input type="radio" name="sentsms" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="Yes" checked="checked"> Yes &nbsp; &nbsp;
		<input type="radio" name="sentsms" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="No"> No
	</span>
</p>

<?php 
}
else{}
?>
