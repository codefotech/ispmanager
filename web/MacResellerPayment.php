<?php
$titel = "Mac Reseller Bill History";
$MacReseller = 'active';
include('include/hader.php');
include("conn/connection.php");
extract($_POST);
date_default_timezone_set('Etc/GMT-6');
$todayyy = date('m-Y', time());

if($userr_typ == 'mreseller'){
	$zz_id = $macz_id;
}
else{
	if($id != '' && $wayyyy == 'reseller'){
		$zz_id = $id;
	}
else{
$zz_id = $_GET['id'];
}
}
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'MacReseller' OR 'MacResellerBillHistory' AND $user_type = '1'");
if($user_type == 'mreseller'){
	$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '40' AND $user_type = '1' or $user_type = '2'");
}
else{
	$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '39' AND $user_type = '1' or $user_type = '2'");
}
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

$query222 =mysql_query("SELECT z.z_id, z.z_name, z.e_id, COUNT(c.c_id) AS totalclients, e.e_name, e.e_cont_per, e.mk_id, e.pre_address, e.agent_id, e.count_commission, e.com_percent FROM zone AS z
						LEFT JOIN emp_info AS e
						ON e.e_id = z.e_id
						LEFT JOIN clients AS c
						ON c.z_id = z.z_id
						WHERE z.z_id = '$zz_id'");
$row22 = mysql_fetch_assoc($query222);

$agentt_id = $row22['agent_id'];
$count_commission = $row22['count_commission'];
$client_com_percent = $row22['com_percent'];

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


$query2223 =mysql_query("SELECT p.id, p.z_id, p.pay_date, p.pay_mode, p.note, p.pay_amount, p.discount, q.e_name, (p.pay_amount + p.discount) AS totalpayments FROM `payment_macreseller` AS p
							LEFT JOIN emp_info AS q
							ON q.e_id = p.entry_by
							WHERE p.z_id = '$zz_id' AND p.sts = '0' ORDER BY p.id DESC");
							

$sql7q7 = mysql_query("SELECT a.bill_date, a.totalclients, a.totaldays, a.pay_time, a.totalbill, a.opening_balance, a.pay_amount, a.pay_mode, a.discount, a.closing_balance, a.pay_idd, a.commission_sts, a.note FROM
						(SELECT COUNT(b.c_id) AS totalclients, sum(b.days) AS totaldays, b.entry_date AS bill_date, FORMAT(SUM(b.bill_amount), 2) AS totalbill, '-' AS pay_time, '-' AS pay_mode, '-' AS discount, '-' AS opening_balance, '-' AS closing_balance, '-' AS pay_amount, '#' AS pay_idd, '' AS commission_sts, '' AS note FROM billing_mac AS b
						LEFT JOIN clients AS c ON c.c_id = b.c_id
						WHERE c.mac_user = '1' AND b.z_id = '$zz_id' GROUP BY MONTH(b.entry_date), YEAR(b.entry_date), DATE(b.entry_date)
						UNION
						SELECT '' AS totalclients, '' AS totaldays, p.pay_date, '-', p.pay_time, p.pay_mode, p.discount, p.opening_balance, p.closing_balance, FORMAT(p.pay_amount, 2) AS pay_amount, p.id AS pay_idd, p.commission_sts, p.note FROM payment_macreseller AS p
						WHERE p.z_id = '$zz_id' AND p.sts = '0' GROUP BY p.pay_date, p.pay_time) AS a
						ORDER BY a.bill_date, a.pay_time ASC");
						
$sql2 ="SELECT COUNT(c_id) AS activeclients FROM clients WHERE z_id = '$zz_id' AND con_sts = 'Active'";
$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);

$sql111 = mysql_query("SELECT SUM(b.bill_amount) AS totbill FROM billing_mac AS b
						WHERE b.z_id = '$zz_id'");

$rowww = mysql_fetch_array($sql111);

$sql1z1 = mysql_query("SELECT p.id, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p
						WHERE p.z_id = '$zz_id' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);

if($wayyyy == 'reseller'){
	$Bankdghf = mysql_query("SELECT getway_name AS bank_name, bank AS id FROM payment_online_setup WHERE  getway_name = '$pay_mode'");
	$Bankfgdg = mysql_fetch_array($Bankdghf);
	$Bankfgdgrfty = $Bankfgdg['id'];
	
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND id = '$Bankfgdgrfty' ORDER BY bank_name");
}
else{
if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'accounts'){
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
}
}

$query233 = mysql_query("SELECT id FROM payment_macreseller ORDER BY id DESC LIMIT 1");
$row233 = mysql_fetch_assoc($query233);
$payment_idz = $row233['id'];

if($client_com_percent != '0.00'){ ?>
<script type="text/javascript">
function updatesum() {
document.form.commission_amount.value = ((document.form.pay_amount.value -0)/100)*<?php echo $client_com_percent;?>;
}
</script>
<?php } else{?>
<script type="text/javascript">
function updatesum() {
document.form.commission_amount.value = ((document.form.pay_amount.value -0)/100)*<?php echo $com_percent;?>;
}
</script>
<?php } ?>

	<div class="pageheader">
        <div class="searchbar">
		<?php if($user_type == 'admin' || $user_type == 'superadmin'){ if($limit_accs == 'Yes'){?>
			<!--<a class="btn ownbtn3" style="float: right;" href="NetworkImportClients?id=<?php //echo $row22['mk_id'].'&input=reseller&zid='.$row22['z_id'];?>">Mass Import</a>--->
			<form action='NetworkImportClientsOnebyOne' method='post' style="float: right;margin-right: 5px;">
				<input type='hidden' name='mk_id' value='<?php echo $row22['mk_id'];?>' />
				<input type='hidden' name='z_id' value='<?php echo $row22['z_id'];?>' />
				<input type='hidden' name='input' value='reseller' />
				<button class='btn ownbtn5'>One by One Import</button>
			</form>
		<?php } else{  ?>
									<div style='font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;font-size: 30px;text-align: center;'>[User Limit Exceeded]</div>

		<?php }}  ?>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>MAC Reseller Payments & History</h1>
        </div>
    </div><!--pageheader-->					

	<?php  if('add' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
	<div class="alert alert-success">
	<button data-dismiss="alert" class="close" type="button">&times;</button>
	<strong>Success!!</strong> Reseller Paymnet Successfully Added in Your System.</div><!--alert-->
	<?php } if('error' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-error">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Error!!</strong> This Payment Already Added.
		</div>
	<?php } if('input' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-error">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> Clients Added Successfully in Your System.
		</div>
	<?php } if((isset($_POST['sts']) ? $_POST['sts'] : '') == 'faild'){?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Payment has been Faild!!</strong> Please try again.
			</div><!--alert-->
	<?php } if((isset($_POST['sts']) ? $_POST['sts'] : '') == 'done'){?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $online_pay_amount; ?> TK Successfully paid by <?php echo $mode; ?>.
			</div><!--alert-->
	<?php } ?>
	
	<div class="box box-primary">
			<div class="box-body">			
					<div class="row">
						<div style="width: 100%;">
							<table class="table table-bordered table-invoice" style="width: 48%; float: left;margin-left: 15px;">
								<tr>
									<td class="width30">MAC Owner</td>
									<td class="width70"><strong><?php echo $row22['e_name']; ?></strong></td>
								</tr>
								<tr>
									<td>Contact No</td>
									<td><?php echo $row22['e_cont_per']; ?></td>
								</tr>
								<tr>
									<td>Address</td>
									<td><?php echo $row22['pre_address']; ?></td>
								</tr>
							</table>
							<table class="table table-bordered table-invoice" style="width: 48%; float: right;margin-right: 15px;">
								<tr>
									<td class="width30">MAC Area</td>
									<td class="width70"><strong><?php echo $row22['z_name']; ?></strong></td>
								</tr>
								<tr>
									<td>Total Clients</td>
									<td><?php echo $row22['totalclients']; ?></td>
								</tr>
								<tr>
									<td>Active Clients</td>
									<td><?php echo $row2['activeclients']; ?></td>
								</tr>
							</table>
						</div><!--col-md-6-->
					</div>

            <br />
		<div style="width: 100%;">
			<div style="width: 100%;">
				<table style="width:100%;background: #fdfdfd;font-size: 16px;height: 30px;margin-bottom: 3px;border: 2px solid #bbcadd;">
					<tr>
						<th style="text-align:left;padding: 5px 0px 2px 15px;color: #317eac;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;">Reseller Bills & Payments</th>
						<th style="text-align:right;padding: 0px 5px 1px 0px;color: #317eac;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;">	
						
						<a data-placement='top' data-rel='tooltip'  href='fpdf/ReportMacResellerLedger?id=<?php echo $zz_id; ?>' class='btn' target="_blank"><i class='iconfa-print'></i>Print</a></th>
					</tr>	
				</table>
				<table id="dyntable2" class="table table-bordered responsive">
                    <colgroup>
						<col class="con1" />
						<col class="con0" />
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1">Bill/Payment Date</th>
							<th class="head0">Time</th>
							<th class="head1 center">Clients</th>
							<th class="head0 center">Days</th>
							<th class="head1 center">Recharged</th>
							<th class="head0">Payments</th>
							<th class="head1">Pay Mood</th>
							<th class="head0">Discount</th>
							<th class="head1">Note</th>
							<th class="head0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
						$x = 1;	
								while( $row7 = mysql_fetch_assoc($sql7q7) )
								{
									$yrdatas= strtotime($row7['bill_date']);
									$months = date('d F, Y', $yrdatas);
									if($row7['pay_idd'] != '#'){
										if(date('m-Y', $yrdatas) == $todayyy){
											$ss = "<li><form action='PaymentDeleteMac' method='post' enctype='multipart/form-data' onclick='return checkDelete()'><input type='hidden' name='py_id' value='{$row7['pay_idd']}' /><input type='hidden' name='commission_sts' value='{$row7['commission_sts']}' /> <button class='btn ownbtn4'><i class='iconfa-remove'></i></button></form></li>";
											$aa = "";
										}
										else{
											$ss = "";
											$aa = "";
										}
									}
									
									else{
										$ss = "";
										$aa = "<li><form action='MacResellerClientRechargeHistory' method='post'><input type='hidden' name='z_id' value='{$zz_id}' /><input type='hidden' name='add_date' value='{$row7['bill_date']}' /> <button class='btn ownbtn2'><i class='fa iconfa-eye-open'></i></button></form></li>";
									}
									if($user_type == 'admin' || $user_type == 'superadmin'){
									echo
										"<tr class='gradeX'>
											<td style='vertical-align: middle;font-weight: bold;'>{$months}</td>
											<td style='vertical-align: middle;'>{$row7['pay_time']}</td>
											<td class='center' style='vertical-align: middle;'>{$row7['totalclients']}</td>
											<td class='center' style='vertical-align: middle;'>{$row7['totaldays']}</td>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;color:purple;'>{$row7['totalbill']}</td>
											<td style='vertical-align: middle;font-size: 15px;color:#0088cc;font-weight: bold;'>{$row7['pay_amount']}</td>
											<td style='vertical-align: middle;'>{$row7['pay_mode']}</td>
											<td style='vertical-align: middle;font-size: 15px;color:#0088cc;font-weight: bold;'>{$row7['discount']}</td>
											<td style='vertical-align: middle;'>{$row7['note']}</td>
											<td class='center' style='width: 20px !important;'>
												<ul class='tooltipsample'>
													{$ss}{$aa}
												</ul>
											</td>
										</tr>\n ";
									}
									else{
										echo
										"<tr class='gradeX'>
											<td style='vertical-align: middle;font-weight: bold;'>{$months}</td>
											<td style='vertical-align: middle;'>{$row7['pay_time']}</td>
											<td class='center' style='vertical-align: middle;'>{$row7['totalclients']}</td>
											<td class='center' style='vertical-align: middle;'>{$row7['totaldays']}</td>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;color:purple;'>{$row7['totalbill']}</td>
											<td style='vertical-align: middle;font-size: 15px;color:#0088cc;font-weight: bold;'>{$row7['pay_amount']}</td>
											<td style='vertical-align: middle;'>{$row7['pay_mode']}</td>
											<td style='vertical-align: middle;font-size: 15px;color:#0088cc;font-weight: bold;'>{$row7['discount']}</td>
											<td style='vertical-align: middle;'>{$row7['note']}</td>
											<td class='center' style='width: 20px !important;'>
												<ul class='tooltipsample'>
													{$aa}
												</ul>
											</td>
										</tr>\n ";
									}
								}  
							?>
					</tbody>
				</table>
			</div>	
			
		<br />
		<div style="width: 100%;margin-top: 10px;margin-bottom: 10px;"><center>
				<table style="width:85%;border-bottom: 1px solid #bbcadd;">
					<tr>
						<th></th>
					</tr>	
				</table></center>
		</div>	
		<br />
				
                <table class="invoice-table" style="width: 100%;">
                    <tbody>
                        <tr>
                        	<td class="width65 msg-invoice">
          						
                            </td>
                            <td class="width20 right numlist">
                            	<div class="subto">Area Total Bill</div>
								<div class="subto2">Cash Payment + Discount</div>
                            </td>
                            <td class="width20 right numlist">
                                <div class="subto">৳ <?php echo number_format($rowww['totbill'],2); ?></div>
								<div class="subto2">৳ <?php echo number_format($rowwz['retotalpayments'],2); ?></div>
                            </td>
                        </tr>
                    </tbody>
				</table>
		</div>

		<div class="row" style="padding-left: 15px; width: 100%;">
		<?php if($userr_typ == 'mreseller' && in_array(1, $online_getway) || $userr_typ == 'mreseller' && in_array(6, $online_getway) || $userr_typ == 'mreseller' && in_array(4, $online_getway) || $userr_typ == 'mreseller' && in_array(2, $online_getway) || $userr_typ == 'mreseller' && in_array(5, $online_getway) || $userr_typ == 'mreseller' && in_array(3, $online_getway)){?>
			<form id="form" class="stdform" method="post" action="form">
				<input type="hidden" name="wayyy" value="reseller" />
				<table style="width:45%;font-size: 16px;height: 30px;margin-bottom: 3px;border-bottom: 2px solid #bbcadd;">
					<tr>
						<th style="text-align:left;padding: 5px 0px 2px 15px;color: #317eac;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;">Recharge Balance by Online Payment</th>
					</tr>	
				</table>
				<table class="table table-bordered table-invoice" style="width: 45%; float: left;">
					<tr>
						<td class="width30" style="text-align: right;font-size: 13px;padding-top: 14px;font-weight: bold;">Amount</td>
						<td class="width70"><input type="text" name="dewamount" required="" style="width: 20%;" /><input type="text" name="" readonly value="৳" style="width: 5%;font-size: 17px;font-weight: bold;" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php if(in_array(1, $online_getway)){?>
							<input class="btn ownbtn2" type="submit" value="bKash" onclick="javascript: form.action='PaymentOnline?gateway=bKash';"/>
						<?php } if(in_array(6, $online_getway)){?>
							<input class="btn ownbtn2" type="submit" value="bKashT" onclick="javascript: form.action='PaymentOnline?gateway=bKashT';"/>
						<?php } if(in_array(4, $online_getway)){?>
							<input class="btn ownbtn2" type="submit" value="Rocket" onclick="javascript: form.action='PaymentOnline?gateway=Rocket';"/>
						<?php } if(in_array(2, $online_getway)){?>
							<input class="btn ownbtn2" type="submit" value="iPay" onclick="javascript: form.action='PaymentOnline?gateway=iPay';"/>
						<?php } if(in_array(5, $online_getway)){?>
							<input class="btn ownbtn2" type="submit" value="Nagad" onclick="javascript: form.action='PaymentOnline?gateway=Nagad';"/>
						<?php } if(in_array(3, $online_getway)){?>
							<input class="btn ownbtn2" type="submit" value="SSLCommerz" onclick="javascript: form.action='PaymentOnline?gateway=SSLCommerz';"/>
						<?php } ?>
						</td>
					</tr>
				</table>
			</form>
		<?php } else{ if(in_array(153, $access_arry)){?>
							<table style="width:49%;font-size: 16px;height: 30px;margin-bottom: 3px;border-bottom: 2px solid <?php if($wayyyy == 'reseller'){?>red<?php } else{?>#bbcadd;<?php } ?>">
								<tr>
									<th style="text-align:left;padding: 5px 0px 2px 15px;color: #317eac;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;">Receive Payment from <?php echo $row22['e_name']; ?></th>
								</tr>	
							</table>
						<section id="paymentt">
						<form class="stdform" method="post" action="MacResellerPaymnetQuery" name="form" enctype="multipart/form-data" onsubmit='disableButton()'>
							<input type="hidden" name="opening_balance" value="<?php $intotaldue=$rowwz['retotalpayments']-$rowww['totbill']; echo $intotaldue;?>" />
							<input type="hidden" name="z_id" value="<?php echo $zz_id;?>" />
							<input type="hidden" name="old_payment_idz" value="<?php echo $payment_idz;?>" />
							<input type="hidden" name="entry_by" value="<?php echo $e_id;?>" />
							<input type="hidden" name="pay_date" value="<?php echo date("Y-m-d");?>" />
							<input type="hidden" name="pay_time" value="<?php echo date("H:i:s");?>" />
							<input type="hidden" name="date_time" value="<?php echo date("Y-m-d H:i:s");?>" />
							<input type="hidden" name="e_id" value="<?php echo $row22['e_id'];?>" />
							<input type="hidden" name="cell" value="<?php echo $row22['e_cont_per'];?>" />
							<input type="hidden" name="e_name" value="<?php echo $row22['e_name'];?>" />
						
							<table class="table table-bordered table-invoice" style="width: 49%; float: left;">
								
							<?php if($agentt_id != '0'){ ?>
								<tr>
									<td class="width30" style="text-align: right;font-size: 13px;padding-top: 14px;font-weight: bold;">Cash Amount</td>
									<td class="width70">
										<strong><input type="text" name="pay_amount" <?php if($wayyyy == 'reseller'){?> readonly value="<?php echo $amount;?>"<?php } ?> required="" style="width: 47%;" onChange="updatesum()"/><input type="text" name="" id="" style="width:4%; color:#2e3e4e; font-weight: bold;font-size: 15px;margin-right: 5px;border-left: 0px solid;" value='৳' readonly /></strong>
										<?php if($agentt_id != '0'){ if($count_commission == '1'){?><input type ="hidden" name="commission_sts" value="1"><input type="text" name="commission_amount" style="width:15%;" readonly value="<?php echo $comission; ?>" onChange="updatesum()"/><input type="text" name="" id="" style="width:15%; color:red;border-left: 0px solid;" value='<?php if($client_com_percent != '0.00'){ echo $client_com_percent; } else{echo $com_percent;}?>%' readonly /><?php } else{ ?><input type ="hidden" name="commission_sts" value="0"><?php }} ?></span>
									</td>
								</tr>
								<tr>
									<td style="text-align: right;font-size: 13px;padding-top: 14px;font-weight: bold;">Agent Info</td>
									<td class="width70"><strong>
										<input type ="hidden" name="agent_id" value="<?php echo $agentt_id; ?>">
										<input type ="hidden" name="com_percent" value="<?php if($client_com_percent != '0.00'){echo $client_com_percent;} else{echo $com_percent;} ?>">
										<input type="text" name="" id="" style="width: 90%;" value="<?php echo $agent_name.' | '.$e_cont_per.' | '.$com_percent.'%';?>" readonly /></strong>
									</td>
								</tr>
							<?php } else{?>
								<tr>
									<td class="width30" style="text-align: right;font-size: 13px;padding-top: 14px;font-weight: bold;">Cash Amount</td>
									<td class="width70"><strong><input type="text" name="pay_amount" <?php if($wayyyy == 'reseller'){?> readonly value="<?php echo $amount;?>"<?php } ?> required="" style="width: 90%;" />&nbsp; ৳</strong></td>
								</tr>
							<?php } ?>
								<tr>
									<td style="text-align: right;font-size: 13px;padding-top: 14px;font-weight: bold;">Discount Amount</td>
									<td class="width70"><strong><input type="text" name="discount" style="width: 85%;" <?php if($wayyyy == 'reseller'){?> readonly value="0.00"<?php } ?> /><input type="text" name="" id="" style="width:4%; color:#2e3e4e; font-weight: bold;font-size: 15px;margin-right: 5px;border-left: 0px solid;" value='৳' readonly /></strong></td>
								</tr>
								<tr>
									<td style="text-align: right;font-size: 13px;padding-top: 14px;font-weight: bold;">Bank</td>
									<td>
										<select data-placeholder="Select a Bank" name="bank" class="chzn-select"  required="" style="width: 100%;" required="">
											<option value=""></option>
											<?php while ($rowBank=mysql_fetch_array($Bank)) { ?>
												<option value="<?php echo $rowBank['id'];?>"<?php if ($Bankfgdgrfty == $rowBank['id']) echo 'selected="selected"';?>><?php echo $rowBank['bank_name']?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<tr>
									<td style="text-align: right;font-size: 13px;padding-top: 14px;font-weight: bold;">Payment Method</td>
									<td>
									<?php if($wayyyy == 'reseller'){?>
										<input type='hidden' name='wayyyy' value='reseller'/>
										<input type='hidden' name='paymentid' value='<?php echo $paymentid;?>'/>
										<input type="text" name="pay_mode" readonly value="<?php echo $pay_mode;?>">
										<input type="hidden" name="trxid" value="<?php echo $trxID;?>">
									<?php } else{ ?>
										<select class="chzn-select" name="pay_mode" style="width: 100%;" required="" >
												<option value="Cash">CASH</option>
												<option value="bKash">bKash</option>
												<option value="CHQ">CHQ</option>
												<option value="Credit Card">Credit Card</option>
												<option value="Deposit">Deposit</option>
										</select>
									<?php } ?>
									</td>
								</tr>
								<tr>
									<td style="text-align: right;font-size: 13px;padding-top: 32px;font-weight: bold;">Note</td>
									<td class="width70"><strong><textarea type="text" name="note" style="width: 97%;" /></textarea></strong></td>
								</tr>
								<tr>
									<td style="text-align: right;font-size: 13px;padding-top: 14px;font-weight: bold;">Send Invoice SMS</td>
									<td class="width70"><strong><input type="radio" name="sentsms" value="Yes"> Yes &nbsp; &nbsp;<input type="radio" name="sentsms" value="No" checked="checked"> No &nbsp; &nbsp;<strong></td>
								</tr>
								<tr>
									<td></td>
									<td class="width70" style="text-align:right;"><button type="reset" class="btn ownbtn11"> Reset </button>&nbsp; <button type="submit" class="btn ownbtn2" id="submitdisabl"> Submit </button></td>
								</tr>
							
							</table>
						</form>
							</section>
							<br />
		<?php } }
		$aaaa = $rowwz['retotalpayments']-$rowww['totbill'];
		?>
							<div class="totamm">
								<h2><span>Balance</span>৳ <?php $intotaldue=$aaaa; echo number_format($intotaldue,2); ?></h2> <br />
							</div>
		</div>

	</div>			</div>	

<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 20,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 20,
			"aaSorting": [[0,'desc']],
            "sScrollY": "700px"
        });
    });
</script>

<style>
#dyntable_length{display: none;}
#dyntable2_length{display: none;}
.dataTables_filter{display: none;}
.tabco{font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;font-weight: bold;}
.subto{
	border-bottom: 1px solid #ddd;
	display: block;
	font-family: 'RobotoBold', 'Helvetica Neue', Helvetica, sans-serif;
	font-size: 13px;
	padding: 7px 20px 8px 0px;
}
.subto2{
	display: block;
	font-family: 'RobotoBold', 'Helvetica Neue', Helvetica, sans-serif;
	font-size: 13px;
	padding: 7px 20px 8px 0px;
}
.totamm {text-align: right;width: 24%;float: right; margin: 0px 80px 0px 0px;;}
.totamm h2{
text-align: center;
line-height: normal;
border: 1px solid #ccc;
background: #fcfcfc;
padding: 10px 30px;
width: 250px;}
.totamm h2 span{
	    display: block;
    font-size: 12px;
    text-transform: uppercase;
    color: #666;
}
</style>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}

function disableButton() {
        var btn = document.getElementById('submitdisabl');
        btn.disabled = true;
        btn.innerText = 'Posting...'
}
</script>