<?php
$titel = "Payment";
$Billing = 'active';
include('include/hader.php');
extract($_POST); 
$id = isset($_POST['c_id']) ? $_POST['c_id'] : '';
ini_alter('date.timezone','Asia/Almaty');

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Billing' AND $user_type = '1'"); 
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '11' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(128, $access_arry) && $id != ''){
//---------- Permission -----------
							
$result = mysql_query("SELECT c_id, z_id, c_name, cell, address, con_sts, b_date, payment_deadline, breseller, mac_user, agent_id, count_commission, com_percent FROM clients WHERE c_id = '$id'");
$row = mysql_fetch_array($result);	

if($row['con_sts'] == 'Active'){
	$collllor = "Green";
	$dhdhfh = "";
}
else{
	$collllor = "Red";
	$dhdhfh = "style='float: left;'";
}

$client_z = $row['z_id'];

if($row['mac_user'] == '0'){
	if($row['breseller'] == '2'){
		$res = mysql_query("SELECT IFNULL((b.bill - p.paid), '0.00') AS total_due FROM clients AS c 
							LEFT JOIN
							(SELECT IFNULL(c_id, '$id') AS c_id, IFNULL(SUM(total_price), '0.00') AS bill FROM billing_invoice WHERE sts = '0' AND c_id = '$id')b
							ON b.c_id = c.c_id
							LEFT JOIN
							(SELECT IFNULL(c_id, '$id') AS c_id, IFNULL((SUM(pay_amount)+SUM(bill_discount)), '0.00') AS paid FROM payment WHERE sts = '0' AND c_id = '$id')p
							ON p.c_id = c.c_id
							WHERE c.breseller = '2' AND c.c_id = '$id'");

		$rows = mysql_fetch_array($res);
		$Dew = 	$rows['total_due'];
		$pay = $rows['total_due'];
		$invoice_mr = mysql_query("SELECT b.invoid, (IFNULL(b.bill, '0.00') - IFNULL(p.pay_amount, '0.00')) AS invoicedue FROM
								(SELECT invoice_id AS invoid, IFNULL(SUM(total_price), '0.00') AS bill FROM billing_invoice 
								WHERE sts = '0' AND c_id = '$id' GROUP BY invoice_id)b
								LEFT JOIN
								(SELECT moneyreceiptno AS invoid, IFNULL((SUM(pay_amount)+SUM(bill_discount)), '0.00') AS pay_amount FROM payment 
								WHERE sts = '0' AND c_id = '$id' GROUP BY moneyreceiptno)p
								ON p.invoid = b.invoid
								WHERE (IFNULL(b.bill, '0.00') - IFNULL(p.pay_amount, '0.00')) > '0' ORDER BY (IFNULL(b.bill, '0.00') - IFNULL(p.pay_amount, '0.00')) DESC");
	}
	else{
		$resss = mysql_query("SELECT c_id FROM payment WHERE c_id = '$id'");
		$rowsss = mysql_fetch_array($resss);
		$c_idd = $rowsss['c_id'];

		if($c_idd == ''){
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
		}
	}
	
	$query233 = mysql_query("SELECT id FROM payment ORDER BY id DESC LIMIT 1");
	$row233 = mysql_fetch_assoc($query233);
	$payment_idz = $row233['id'];
	
	$agentt_id = $row['agent_id'];
	$count_commission = $row['count_commission'];
	$client_com_percent = $row['com_percent'];

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
	
$resultsms = mysql_query("SELECT username AS smsgo FROM sms_setup WHERE status = '0' AND z_id = ''");
}
else{
	$resss = mysql_query("SELECT c_id FROM payment_mac_client WHERE c_id = '$id'");
	$rowsss = mysql_fetch_array($resss);
	$c_idd = $rowsss['c_id'];

	if($c_idd == ''){
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
	}

	$query233 = mysql_query("SELECT id FROM payment_mac_client ORDER BY id DESC LIMIT 1");
	$row233 = mysql_fetch_assoc($query233);
	$payment_idz = $row233['id'];
	
$resultsms = mysql_query("SELECT username AS smsgo FROM sms_setup WHERE z_id = '$client_z'");
}
$rowss = mysql_fetch_array($resultsms);	

if($Dew <= 0){
	$pay = 'Paid';
}else{
	$pay = $Dew;
}

if($user_type == 'admin' || $user_type == 'superadmin'){
	$Bank = mysql_query("SELECT b.id, b.bank_name, emp_id FROM bank AS b LEFT JOIN payment_mathod AS p ON p.bank = b.id WHERE p.online IS NULL AND b.sts = '0' ORDER BY b.id asc");
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
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Cash Payment</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Cash Payment</h5>
				</div>
				<form id="" name="form1" class="stdform" method="post" action="<?php if($row['mac_user'] == '0'){ ?>PaymentSave<?php } else{ ?>PaymentMacSave<?php } ?>" onsubmit='disableButton()'>
				<input type="hidden" value="<?php echo $e_id; ?>" name="pay_ent_by" />
				<input type="hidden" value="<?php echo $payment_idz; ?>" name="last_payment_idz" />
				<input type="hidden" value="<?php echo date('Y-m-d', time());?>" name="pay_ent_date" />
				<input type="hidden" name="cell" value="<?php echo $row['cell'];?>" />
				<input type="hidden" name="send_by" value="<?php echo $e_id;?>" />
				<?php if($row['mac_user'] == '1'){ ?>
					<input type="hidden" name="userr_typ" value="<?php echo $user_type;?>" />
					<input type="hidden" name="macz_id" value="<?php echo $macz_id;?>" />
				<?php } ?>
				<input type="hidden" name="con_sts" value="<?php echo $row['con_sts']; ?>" />
				<input type="hidden" name="pay_mtd" value="CASH" />
				<input type="hidden" name="breseller" value="<?php echo $row['breseller']; ?>" />
				<input type="hidden" name="send_date" value="<?php echo date('Y-m-d', time());?>" />
				<input type="hidden" name="send_time" value="<?php echo date('H:i:s', time());?>" />
				<input type="hidden" readonly name="pay_date" id="" class="input-xlarge" value="<?php echo date('Y-m-d');?>" />
					<div class="modal-body">
						<p>	
							<label style="font-weight: bold;">INFO:</label>
							<input type ="hidden" name="c_id" value="<?php echo $row['c_id']; ?>">
							<span class="field" style="font-size: 20px;padding: 5px 0 0px 0px;color: #555555de;">
								<b><?php echo $row['c_id'];?> | <?php echo $row['c_name'];?></b>
							</span>
							<span class="field" style="font-size: 15px;padding: 5px 0 5px 0px;color: #317eac;">
								<b><?php echo $row['address'];?> | <?php echo $row['cell'];?></b>
							</span>
							<span class="field" style="font-size: 15px;padding: 0px 0 10px 0px;text-transform: uppercase; color: <?php echo $collllor;?>;">
								<b>[ <?php echo $row['con_sts'];?> ]</b>
							</span>
						</p>
						<input type="hidden" name="dew" value="<?php echo $Dew;?>" readonly />
						<p>
							<label style="font-weight: bold;">TOTAL DUE:</label>
							<span class="field" style="font-size: 25px;font-weight: bold;padding: 5px 0 10px 0;color: crimson;">
								<?php $intotaldue=$Dew; echo number_format($intotaldue,2);?>৳ 
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">PAYMENT AMOUNT:</label>
							<span class="field">
								<div id="result" <?php echo $dhdhfh;?>>
								<?php if($wayyyy == 'client'){ ?>
									<input type="text" name="payment" id="" style="width:80px;height: 25px;font-size: 20px;font-weight: bold;color: brown;" value="<?php echo $amount;?>" readonly required="" onInput="updatesum()" onmouseover="updatesum()" onChange="updatesum()"/><input type="text" name="" id="" style="width:17px;height: 25px; color:brown; font-weight: bold;font-size: 20px;border-left: none;" value='৳' readonly />
								<?php } else{ ?>
									<input type="text" name="payment" id="" style="width:80px;height: 25px;font-size: 20px;font-weight: bold;color: brown;" value="<?php echo $pay;?>" required="" onInput="updatesum()" onmouseover="updatesum()" onChange="updatesum()"/><input type="text" name="" id="" style="width:17px;height: 25px; color:brown; font-weight: bold;font-size: 20px;border-left: none;" value='৳' readonly />
								<?php }  ?>
								</div>
								<?php if($row['con_sts'] == 'Inactive'){ ?>
									<div class="input-prepend">
										<span class="add-on" style="border-radius: 0 5px 5px 0;font-weight: bold;font-size: 15px;border-left: 0px solid transparent;padding: 5px 0px 6px 10px;color: <?php echo $collllor;?>;">
											<input type="checkbox" name="auto_bill_check" id="prependedInput" class="span2" checked="checked" value="Yes"/>AUTO ACTIVE  &nbsp;
										</span>
									</div>
								<?php } ?>
							</span>
						</p>
						<?php if($agentt_id != '0' && $row['mac_user'] == '0'){ ?>
						<p>
							<label>Commission Amount</label>
							<?php if($count_commission == '1'){?><input type="hidden" name="commission_sts" value="1"><input type="text" name="commission_amount" id="commission_amount" style="width:5%;" readonly value="<?php echo $comission;?>" onChange="updatesum()" onmouseover="updatesum()"/><input type="text" name="client_com_percent" id="client_com_percent" style="width:5%; color:red;border-left: 0px solid;" value='<?php if($client_com_percent != '0.00'){ echo $client_com_percent; } else{echo $com_percent;}?>%' readonly /><?php } else{ ?><input type ="hidden" name="commission_sts" value="0"><?php } ?></span>
						</p>
						<?php } if($user_type == 'mreseller'){?>
						<p>
							<label style="font-weight: bold;">DISCOUNT:</label>
							<span class="field">
								<input type="text" name="bill_disc" id="" style="width:80px;height: 25px;font-size: 20px;font-weight: bold;color: #6b6b6b;" value="0.00"/><input type="text" name="" id="" style="width:17px;height: 25px; color:#6b6b6b; font-weight: bold;font-size: 20px;border-left: none;" value='৳' readonly />
							</span>
						</p>
						<?php } else{ if(in_array(217, $access_arry)){?>
						<p>
							<label style="font-weight: bold;">DISCOUNT:</label>
							<span class="field">
								<input type="text" name="bill_disc" id="" style="width:80px;height: 25px;font-size: 20px;font-weight: bold;color: #6b6b6b;" value="0.00"/><input type="text" name="" id="" style="width:17px;height: 25px; color:#6b6b6b; font-weight: bold;font-size: 20px;border-left: none;" value='৳' readonly />
							</span>
						</p>
						<?php } else{ ?>
							<input type="hidden" name="bill_disc" readonly value="0.00"/>
						<?php }} ?>
						<?php if($row['mac_user'] == '1'){ ?>
						<input type="hidden" name="macz_id" value="<?php echo $macz_id; ?>" />
						<p>	
							<label style="font-weight: bold;">Payment Method</label>
							<select data-placeholder="Payment Method" name="pay_mtd" style="width:280px;" class="chzn-select">
								<option value="CASH" <?php if ($pay_mode == 'CASH') echo 'selected="selected"';?>>Cash</option>
								<option value="bKash" <?php if ($pay_mode == 'bKash' || $pay_mode == 'bKashT') echo 'selected="selected"';?>>bKash</option>
								<option value="Rocket" <?php if ($pay_mode == 'Rocket') echo 'selected="selected"';?>>Rocket</option>
								<option value="iPay" <?php if ($pay_mode == 'iPay') echo 'selected="selected"';?>>iPay</option>
								<option value="Card" <?php if ($pay_mode == 'Card') echo 'selected="selected"';?>>Card</option>
								<option value="Bank" <?php if ($pay_mode == 'Bank') echo 'selected="selected"';?>>Bank</option>
								<option value="Corporate" <?php if ($pay_mode == 'Corporate') echo 'selected="selected"';?>>Corporate</option>
							</select>
						</p>
						<?php if($wayyyy == 'client'){ ?>
						<p>
							<label>Sender No</label>
							<span class="field"><input type="text" name="sender_no" readonly value="<?php echo $sender_no;?>" id="" class="input-xlarge" placeholder="Sender No"/></span>
						</p>
						<p>
							<label>TrxID</label>
							<span class="field"><input type="text" name="trxID" readonly value="<?php echo $trxID;?>" id="" class="input-xlarge" placeholder="trxID"/></span>
						</p>
						
						<?php } else{ ?>
						<p>
							<label>Money Receipt No</label>
							<span class="field"><input type="text" name="moneyreceiptno" id="" class="input-xlarge" placeholder="MR NO"/></span>
						</p>
						<?php } ?>
						<?php } else{ if($agentt_id != '0'){ ?>
						<p>	
							<label style="font-weight: bold;">Agent Info</label>
							<span class="field">
								<input type ="hidden" name="agent_id" value="<?php echo $agentt_id; ?>">
								<input type ="hidden" name="com_percent" value="<?php if($client_com_percent != '0.00'){echo $client_com_percent;} else{echo $com_percent;} ?>">
								<input type="text" name="" id="" class="input-xlarge" value="<?php echo $agent_name.' | '.$e_cont_per.' | '.$com_percent.'%';?>" readonly />
							</span>
						</p>
						<?php } ?>
						<p>	
							<label style="font-weight: bold;">BANK:</label>
							<select data-placeholder="Select a Bank" name="bank" required="" class="chzn-select" style="width:160px;float:left;">
								<option></option>
								<?php while ($rowBank=mysql_fetch_array($Bank)) { ?>
									<option value="<?php echo $rowBank['id'];?>"<?php if($rowBank['emp_id'] == $e_id) {echo 'selected="selected"';}?>><?php echo $rowBank['bank_name'];?></option>
								<?php } ?>
							</select>
							<input type="text" name="moneyreceiptno" style="vertical-align: top;height: 24px;width:85px;font-size: 16px;font-weight: bold;" placeholder="MR NO"/>
						</p>
						<?php if($row['breseller'] == '2'){ ?>
						<p>	
							<label style="font-weight: bold;">INVOICE</label>
							<select data-placeholder="Select a Invoice" name="dueinvoid" required="" class="chzn-select" style="width:10%;" onselect="updatesum()">
								<option></option>
								<?php while ($rowinvoice_mr=mysql_fetch_array($invoice_mr)) { ?>
									<option value="<?php echo $rowinvoice_mr['invoid'];?>"><?php echo $rowinvoice_mr['invoid'];?> - <?php echo $rowinvoice_mr['invoicedue'];?></option>
								<?php } ?>
							</select>
						</p>
						<?php }} if($rowss['smsgo'] != ''){ ?>
						<p>
                            <label style="font-weight: bold;">CONFIRMATION SMS:</label>
							<span class="" style="font-size: 15px;font-weight: bold;padding: 0px 0 10px 0;display: block;line-height: 30px;">
								<input type="radio" name="sentsms" value="Yes" checked="checked"> YES &nbsp; &nbsp;
								<input type="radio" name="sentsms" value="No"> NO &nbsp; &nbsp;
                            </span>
                        </p>
						<?php } else{ ?>
						<input type ="hidden" name="sentsms" value="No">
						<p>
							<label style="font-weight: bold;">CONFIRMATION SMS:</label>
							<span class="" style="font-size: 15px;font-weight: bold;padding: 0px 0 10px 0;display: block;line-height: 30px;color:red;">
								[ SMS API NOT ACTIVE ]
                            </span>
						</p>
						<?php } ?>
						<p>
							<label style="font-weight: bold;">NOTE:</label>
							<span class="field"><textarea type="text" name="pay_dsc" id="" placeholder="Payment Note (Optional)" class="input-xlarge" /></textarea></span>
						</p>
						<br>
						<p style="color: #0866c6;">
                            <label style="font-weight: bold;">AFTER SUBMIT:</label>
							<span class="" style="font-size: 14px;font-weight: bold;padding: 0px 0 10px 0;display: block;line-height: 30px;">
								<input type="radio" name="after_submit" value="closetab" checked="checked"> CLOSE TAB &nbsp; &nbsp; &nbsp;
								<input type="radio" name="after_submit" value="printmr"> PRINT MR
                            </span>
                        </p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11" style="float: left;">Reset</button>
						<button class="btn ownbtn2" style="float: left;" type="submit" id="submitdisabl" <?php if($agentt_id != '0'){ ?> onmouseover="updatesum()" <?php } ?>>Submit</button>
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
jQuery('select[name="dueinvoid"]').on('change',function(){
			var p_id = jQuery(this).val(); 
				$.ajax({
				type : 'POST',
				url  : 'payment-dueinvoid-search.php',
				data : jQuery(this),
				success : function(data)
					{
						$("#result").html(data);
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