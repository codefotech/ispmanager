<?php
$titel = "Payment";
$Billing = 'active';
include('include/hader.php');
 
$id = $_GET['id'];
extract($_POST);
ini_alter('date.timezone','Asia/Almaty');

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Billing' AND $user_type = '1'"); 
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '11' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(128, $access_arry)){
//---------- Permission -----------

$result = mysql_query("SELECT c_id, c_name, cell, address, con_sts, b_date, payment_deadline, breseller, mac_user FROM clients WHERE c_id = '$id'");
$row = mysql_fetch_array($result);	

if($row['con_sts'] == 'Inactive'){
	$collin = "style='color: red;'";
}
else{
	$collin = "style='color: green;'";
}

if($row['mac_user'] == '0'){
$resss = mysql_query("SELECT c_id FROM payment WHERE c_id = '$id'");
$rowsss = mysql_fetch_array($resss);
$c_idd = $rowsss['c_id'];

if($c_idd == '')
{
	$res = mysql_query("SELECT c_id, SUM(bill_amount) AS amt FROM billing WHERE c_id = '$id'");
	$rows = mysql_fetch_array($res);
	$pay = $rows['amt'];
	$Dew = $rows['amt'];
}

else{
$res = mysql_query("SELECT l.amt, t.dic, t.pay FROM
					(
						SELECT c_id, SUM(bill_amount) AS amt FROM billing WHERE c_id = '$id'
					)l
					LEFT JOIN
					(
						SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment WHERE c_id = '$id'
					)t
					ON l.c_id = t.c_id");

$rows = mysql_fetch_array($res);
$Dew = 	$rows['amt'] - ($rows['pay'] + $rows['dic']);

if($Dew <= '0.99'){
	$pay = 'Alrady Paid';
	$colllllor = "style='color: green;'";
}else{
	$pay = $Dew;
	$colllllor = "style='color: red;'";
}
}

$resultsfsf = mysql_query("SELECT c_id, c_name, cell, address, con_sts, b_date, payment_deadline, breseller, agent_id, count_commission, com_percent FROM clients WHERE c_id = '$id'");
$rowsfsf = mysql_fetch_array($resultsfsf);	

$agentt_id = $rowsfsf['agent_id'];
$count_commission = $rowsfsf['count_commission'];
$client_com_percent = $rowsfsf['com_percent'];

 if($agentt_id != '0'){
 $sqlf = mysql_query("SELECT e_id, e_name, com_percent, e_cont_per FROM agent WHERE sts = '0' AND e_id = '$agentt_id'");

$rowaa = mysql_fetch_assoc($sqlf);
		$agent_id= $rowaa['e_id'];
		$agent_name= $rowaa['e_name'];
		$com_percent= $rowaa['com_percent'];
		$e_cont_per= $rowaa['e_cont_per'];
		
		if($count_commission == '1'){
			if($client_com_percent != '0.00'){
				$comission = ($pay/100)*$client_com_percent;
			}
			else{
				$comission = ($pay/100)*$com_percent;
			}
		}
		else{
			$comission = '0.00';
		}
 }
 else{}
$query233 = mysql_query("SELECT id FROM payment ORDER BY id DESC LIMIT 1");
$row233 = mysql_fetch_assoc($query233);
$payment_idz = $row233['id'];

$resultsms = mysql_query("SELECT username AS smsgo FROM sms_setup WHERE status = '0' AND z_id = ''");
}else{
	
$resss = mysql_query("SELECT c_id FROM payment_mac_client WHERE c_id = '$id'");
$rowsss = mysql_fetch_array($resss);
$c_idd = $rowsss['c_id'];

if($c_idd == '')
{
	$res = mysql_query("SELECT c_id, SUM(bill_amount) AS amt FROM billing_mac_client WHERE c_id = '$id'");
	$rows = mysql_fetch_array($res);
	$pay = $rows['amt'];
	$Dew = $rows['amt'];
}

else{
$res = mysql_query("SELECT l.amt, t.dic, t.pay FROM
					(
						SELECT c_id, SUM(bill_amount) AS amt FROM billing_mac_client WHERE c_id = '$id'
					)l
					LEFT JOIN
					(
						SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment_mac_client WHERE c_id = '$id'
					)t
					ON l.c_id = t.c_id");

$rows = mysql_fetch_array($res);
$Dew = 	$rows['amt'] - ($rows['pay'] + $rows['dic']);

if($Dew <= '0'){
	$pay = 'Alrady Paid';
	$colllllor = "style='color: green;'";
}else{
	$pay = $Dew;
	$colllllor = "style='color: red;'";
}
}
$query233 = mysql_query("SELECT id FROM payment_mac_client ORDER BY id DESC LIMIT 1");
$row233 = mysql_fetch_assoc($query233);
$payment_idz = $row233['id'];

$resultsms = mysql_query("SELECT username AS smsgo FROM sms_setup WHERE z_id = '$client_z'");
}
$rowss = mysql_fetch_array($resultsms);	

if($user_type == 'admin' || $user_type == 'superadmin'){
	$Bank = mysql_query("SELECT b.id, b.bank_name FROM bank AS b LEFT JOIN payment_mathod AS p ON p.bank = b.id WHERE p.online IS NULL AND b.sts = '0' ORDER BY b.id ASC");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
}							
	
if($client_com_percent != '0.00'){ ?>
<script type="text/javascript">
function updatesum() {
document.form1.commission_amount.value = ((document.form1.payment.value -0)/100)*<?php echo $client_com_percent;?>;
}
</script>
<?php } else{?>
<script type="text/javascript">
function updatesum() {
document.form1.commission_amount.value = ((document.form1.payment.value -0)/100)*<?php echo $com_percent;?>;
}
</script>
<?php } ?>
	
	
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header" style="padding: 0 0 0 10px;">
					<h5>Add Payment</h5>
				</div>
				<form id="" name="form1" class="stdform" method="post" action="<?php if($row['mac_user'] == '0'){ ?>PaymentSave<?php } else{ ?>PaymentMacSave<?php } ?>" enctype="multipart/form-data" onsubmit='disableButton()'>
				<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="pay_ent_by" />
				<input type="hidden" value="<?php echo $payment_idz; ?>" name="last_payment_idz" />
				<input type="hidden" value="<?php echo date('Y-m-d', time());?>" name="pay_ent_date" />
				<input type="hidden" name="cell" value="<?php echo $row['cell'];?>" />
				<input type="hidden" name="send_by" value="<?php echo $e_id;?>" />
				<input type="hidden" name="con_sts" value="<?php echo $row['con_sts']; ?>" />
				<input type="hidden" name="pay_mtd" value="CASH" />
				<input type="hidden" name="breseller" value="<?php echo $row['breseller']; ?>" />
				<input type="hidden" name="send_date" value="<?php echo date('Y-m-d', time());?>" />
				<input type="hidden" name="send_time" value="<?php echo date('H:i:s', time());?>" />
				<input type="hidden" name="pay_date" value="<?php echo date('Y-m-d');?>" />
				<input type ="hidden" name="c_id" value="<?php echo $row['c_id']; ?>">
				<input type="hidden" name="dew" value="<?php echo $Dew;?>" readonly />
					<div class="modal-body" style="min-height: 180px;padding: 1px;">
					<div class="span6">
                        <table class="table table-bordered table-invoice">
								<tr>
									<td colspan="2" style="font-size: 14px;font-weight: bold;text-align: center;"><?php echo $row['c_id'];?></td>
								</tr>
								<tr>
									<td colspan="2" style="font-size: 12px;text-align: center;"><?php echo $row['c_name'];?> - <?php echo $row['cell'];?><br><?php echo $row['address'];?></td>
								</tr>
								<tr>
									<td colspan="2" style="font-size: 13px;font-weight: bold;text-align: center;"><a <?php echo $collin;?>>Status: <?php echo $row['con_sts'];?></a>   ||   <a <?php echo $colllllor;?>>Due: <?php $intotaldue=$Dew; echo number_format($intotaldue,2);?>৳</a></td>
								</tr>
								<?php if($agentt_id != '0' && $user_type != 'mreseller'){ ?>
								<input type ="hidden" name="agent_id" value="<?php echo $agentt_id; ?>">
								<input type ="hidden" name="com_percent" value="<?php if($client_com_percent != '0.00'){echo $client_com_percent;} else{echo $com_percent;} ?>">
								<tr>
									<td colspan="2" style="font-size: 14px;font-weight: bold;text-align: center;"><a><?php echo $agent_name.' | '.$e_cont_per.' | '.$com_percent.'%';?></a></td>
								</tr>
								<tr>
									<td class="width40" style="font-weight: bold;font-size: 12px;text-align: right;padding: 15px 10px 0px 60px;">Commission</td>
									<td class="width40" style="font-weight: bold;"><?php if($agentt_id != '0'){ if($count_commission == '1'){?><input type ="hidden" name="commission_sts" value="1"><input type="text" name="commission_amount" style="width:45%;font-weight: bold;text-align: center;font-size: 14px;" readonly value="<?php echo $comission; ?>" onChange="updatesum()"/><input type="text" name="" id="" style="width:30%;font-weight: bold;text-align: center;font-size: 14px; color:red;border-left: 0px solid;" value='<?php if($client_com_percent != '0.00'){ echo $client_com_percent; } else{echo $com_percent;}?>%' readonly /><?php } else{ ?><input type ="hidden" name="commission_sts" value="0"><?php }} ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td class="width40" style="font-weight: bold;font-size: 12px;text-align: right;padding: 13px 10px;">Payment Amount</td>
									<td class="width40" style="font-weight: bold;"><input type="text" name="payment" value="<?php echo $pay;?>" style="width:90%;font-weight: bold;text-align: center;font-size: 14px" required="" onChange="updatesum()">&nbsp; ৳</td>
								</tr>
								<tr>
									<td class="width40" style="font-weight: bold;font-size: 12px;text-align: right;padding: 13px 10px;">Discount</td>
								<?php if($user_type == 'mreseller'){?>
									<td class="width40" style="font-weight: bold;"><input type="text" name="bill_disc" value="0.00" style="width:90%;font-weight: bold;text-align: center;font-size: 14px">&nbsp; ৳</td>
								<?php } else{ if(in_array(217, $access_arry)){?>
									<td class="width40" style="font-weight: bold;"><input type="text" name="bill_disc" value="0.00" style="width:90%;font-weight: bold;text-align: center;font-size: 14px">&nbsp; ৳</td>
								<?php } else{ ?>
									<td class="width40" style="font-weight: bold;"><input type="text" name="bill_disc" readonly value="0.00" style="width:90%;font-weight: bold;text-align: center;font-size: 14px">&nbsp; ৳</td>
								<?php }} ?>
								</tr>
							
								<?php if($row['mac_user'] == '1'){ ?>
								<input type="hidden" name="macz_id" value="<?php echo $macz_id; ?>" />
								<tr>
									<td colspan="2" style="font-weight: bold;text-align: center">
										<select data-placeholder="Choose a pay_mode" class="chzn-select" style="width:100%;text-align: center;" name="pay_mode" required="" />
											<option value="CASH">Cash</option>
											<option value="bKash">bKash</option>
											<option value="Rocket">Rocket</option>
											<option value="iPay">iPay</option>
											<option value="Card">Card</option>
											<option value="Bank">Bank</option>
											<option value="Corporate">Corporate</option>
										</select>
									</td>
								</tr>
								<?php } else{ ?>
								<tr>
									<td colspan="2" style="font-weight: bold;text-align: center">
										<select data-placeholder="Choose a bank" class="chzn-select" style="width:100%;text-align: center;" name="bank" required="" />
													<option value=""></option>
												<?php while ($rowBank=mysql_fetch_array($Bank)) { ?>
													<option value="<?php echo $rowBank['id'];?>"<?php if($rowBank['emp_id'] == $e_id) {echo 'selected="selected"';}?>><?php echo $rowBank['bank_name'];?></option>
												<?php } ?>
										</select>
									</td>
								</tr>
								<?php } ?>
							<tr>
								<td class="width40" style="font-weight: bold;font-size: 12px;text-align: right;padding: 13px 10px 0px 0px;">Money Receipt No</td>
								<td class="width40" style="font-weight: bold;"><input type="text" name="moneyreceiptno" placeholder="Optional" style="width:97%;font-weight: bold;text-align: center;font-size: 12px"/></td>
							</tr>
							<tr>
								<td class="width40" style="font-weight: bold;font-size: 12px;text-align: right;padding: 10px 10px 0px 0px;">Send Invoice SMS</td>
								<td class="width40" style="padding: 0px 0px 0px 8px;"><?php if($rowss['smsgo'] != ''){ ?><div class="" style="font-weight: bold;font-size: 12px;"><input type="radio" name="sentsms" checked="checked" value="Yes"> Yes &nbsp; &nbsp;<input type="radio" name="sentsms" value="No"> No &nbsp; &nbsp;</div><?php } else { ?><span class="" style="font-size: 15px;font-weight: bold;padding: 6px 0 6px 0;display: block;color:red;">[ SMS API NOT ACTIVE ]</span><?php } ?></td>
                            </tr>
							<tr>
								<td class="width40" style="font-weight: bold;font-size: 12px;text-align: right;padding: 10px 10px 0px 0px;">Auto Activation</td>
								<td class="width40" style="padding: 0px 0px 0px 8px;"><div class="" style="font-weight: bold;font-size: 12px;"><?php if($row['con_sts']== 'Inactive'){ ?><input type="radio" name="auto_bill_check" value="Yes" checked="checked"> Yes &nbsp; &nbsp;<input type="radio" name="auto_bill_check" value="No"> No &nbsp; &nbsp;<?php } else{ ?><input type="radio" name="auto_bill_check" value="No" checked="checked"> No &nbsp; &nbsp;<?php } ?></div></td>
                            </tr>
							<tr>
								<td colspan="2" style="font-size: 12px;font-weight: bold;text-align: center;bold;"><textarea type="text" name="pay_dsc" style="width: 97%;" placeholder="Note"/></textarea></td>
							</tr>
                        </table>
                    </div><!--span6-->
					</div>
					<div class="modal-footer">
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
<style>
#uniform-undefined{display: inline-block;margin-top: 10px;}
</style>
<script type="text/javascript">
function disableButton() {
        var btn = document.getElementById('submitdisabl');
        btn.disabled = true;
        btn.innerText = 'Posting...'
}
</script>