<?php
$titel = "Online Payments";
$OnlinePaymentMac = 'active';
include("conn/connection.php");
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'OnlinePaymentMac' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

	if($f_date == ''){$f_date = date('Y-m-01', time());} else{$f_date = $f_date;}
	if($t_date == ''){$t_date = date('Y-m-d', time());} else{$t_date = $t_date;}
	$f_date_ttime = $f_date.' 00:00:00';
	$t_date_ttime = $t_date.' 23:59:59';
	
	if($locksts_way == 'unlock') {
		$querydfh ="UPDATE payment_online_mac_client SET lock_sts = '1' WHERE id = '$paymentid'";
		$resultdf = mysql_query($querydfh) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	else{
		$querydfh ="UPDATE payment_online_mac_client SET lock_sts = '0' WHERE id = '$paymentid'";
		$resultdf = mysql_query($querydfh) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	
 if($wayyyy == ''){
	if($gateway == 'Webhook'){
	$sql = mysql_query("SELECT p.id, p.lock_sts, DATE_FORMAT(p.date_time, '%D %M %Y') AS paydate, DATE_FORMAT(p.date_time, '%T') AS paytime, p.c_id, c.c_name, c.com_id, c.z_id, z.z_name, c.cell, c.box_id, c.payment_deadline, c.b_date, c.p_id, p.sender_no, p.pay_mode, p.date_time, p.paymentID, p.createTime, p.updateTime, p.trxID, p.transactionStatus, p.amount, p.pay_amount, p.currency, (p.amount - p.pay_amount) AS chargeamount, p.intent, p.merchantInvoiceNumber, p.refundAmount, p.card_type, p.bank_gw, p.card_no, p.card_issuer, p.card_brand, p.ssl_amount, p.tran_id, p.alldata, p.webhook, p.dateTime, p.debitMSISDN, p.creditOrganizationName, p.creditShortCode, p.transactionType, p.transactionReference, p.webhook_all FROM payment_online_mac_client AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id 
						LEFT JOIN zone AS z ON z.z_id = c.z_id 
						WHERE p.sts = '0' AND p.date_time between '$f_date_ttime' AND '$t_date_ttime' AND p.webhook = '1' AND p.pay_mode = 'bKash' AND c.z_id = '$macz_id' ORDER BY p.id ASC");
	}
	if($gateway == 'bKash'){
	$sql = mysql_query("SELECT p.id, p.lock_sts, DATE_FORMAT(p.date_time, '%D %M %Y') AS paydate, DATE_FORMAT(p.date_time, '%T') AS paytime, p.c_id, c.c_name, c.com_id, c.z_id, z.z_name, c.cell, c.box_id, c.payment_deadline, c.b_date, c.p_id, p.sender_no, p.pay_mode, p.date_time, p.paymentID, p.createTime, p.updateTime, p.trxID, p.transactionStatus, p.amount, p.pay_amount, p.currency, (p.amount - p.pay_amount) AS chargeamount, p.intent, p.merchantInvoiceNumber, p.refundAmount, p.card_type, p.bank_gw, p.card_no, p.card_issuer, p.card_brand, p.ssl_amount, p.tran_id, p.alldata, p.webhook, p.dateTime, p.debitMSISDN, p.creditOrganizationName, p.creditShortCode, p.transactionType, p.transactionReference, p.webhook_all FROM payment_online_mac_client AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id 
						LEFT JOIN zone AS z ON z.z_id = c.z_id 
						WHERE p.sts = '0' AND p.date_time between '$f_date_ttime' AND '$t_date_ttime' AND p.webhook = '0' AND p.pay_mode = 'bKash' AND c.z_id = '$macz_id' ORDER BY p.id ASC");
	}
	if($gateway == 'bKashT'){
	$sql = mysql_query("SELECT p.id, p.lock_sts, DATE_FORMAT(p.date_time, '%D %M %Y') AS paydate, DATE_FORMAT(p.date_time, '%T') AS paytime, p.c_id, c.c_name, c.com_id, c.z_id, z.z_name, c.cell, c.box_id, c.payment_deadline, c.b_date, c.p_id, p.sender_no, p.pay_mode, p.date_time, p.paymentID, p.createTime, p.updateTime, p.trxID, p.transactionStatus, p.amount, p.pay_amount, p.currency, (p.amount - p.pay_amount) AS chargeamount, p.intent, p.merchantInvoiceNumber, p.refundAmount, p.card_type, p.bank_gw, p.card_no, p.card_issuer, p.card_brand, p.ssl_amount, p.tran_id, p.alldata, p.webhook, p.dateTime, p.debitMSISDN, p.creditOrganizationName, p.creditShortCode, p.transactionType, p.transactionReference, p.webhook_all FROM payment_online_mac_client AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id 
						LEFT JOIN zone AS z ON z.z_id = c.z_id 
						WHERE p.sts = '0' AND p.date_time between '$f_date_ttime' AND '$t_date_ttime' AND p.webhook = '0' AND p.pay_mode = 'bKashT' AND c.z_id = '$macz_id' ORDER BY p.id ASC");
	}
	if($gateway == 'all' || $gateway == ''){
	$sql = mysql_query("SELECT p.id, p.lock_sts, DATE_FORMAT(p.date_time, '%D %M %Y') AS paydate, DATE_FORMAT(p.date_time, '%T') AS paytime, p.c_id, c.c_name, c.com_id, c.z_id, z.z_name, c.cell, c.box_id, c.payment_deadline, c.b_date, c.p_id, p.sender_no, p.pay_mode, p.date_time, p.paymentID, p.createTime, p.updateTime, p.trxID, p.transactionStatus, p.amount, p.pay_amount, p.currency, (p.amount - p.pay_amount) AS chargeamount, p.intent, p.merchantInvoiceNumber, p.refundAmount, p.card_type, p.bank_gw, p.card_no, p.card_issuer, p.card_brand, p.ssl_amount, p.tran_id, p.alldata, p.webhook, p.dateTime, p.debitMSISDN, p.creditOrganizationName, p.creditShortCode, p.transactionType, p.transactionReference, p.webhook_all FROM payment_online_mac_client AS p 
						LEFT JOIN clients AS c ON c.c_id = p.c_id 
						LEFT JOIN zone AS z ON z.z_id = c.z_id 
						WHERE p.sts = '0' AND p.date_time between '$f_date_ttime' AND '$t_date_ttime' AND c.z_id = '$macz_id' ORDER BY p.id ASC");
	}


	$sql19 = mysql_query("SELECT IFNULL(SUM(p.amount), 0.00) AS paidamount, (IFNULL(SUM(p.amount), 0.00) - IFNULL(SUM(p.pay_amount), 0.00)) AS chargeamount, IFNULL(SUM(p.pay_amount), 0.00) AS pay_amount FROM payment_online_mac_client AS p WHERE p.date_time between '$f_date_ttime' AND '$t_date_ttime' AND z_id = '$macz_id'");
	$row19 = mysql_fetch_array($sql19);
	$tit = "<div class='box-header'>
				<div class='hil' style='font-weight: bold;'> Total Collection: <i style='color: blue'>{$row19['paidamount']} ৳</i></div> 
				<div class='hil' style='font-weight: bold;'> Total Charged: <i style='color: red'>{$row19['chargeamount']} ৳</i></div> 
				<div class='hil' style='font-weight: bold;'> Total Count: <i style='color: green'>{$row19['pay_amount']} ৳</i></div> 
			</div>";
	}

?>

	<div class="pageheader">
        <div class="searchbar">
		<form id="" name="form" class="stdform" style="margin-top: -8px;" method="post" action="<?php echo $PHP_SELF;?>">
			<div style="float: left;font-weight: bold;">
				<input type="text" name="f_date" id="" style="width:30%;text-align: center;" placeholder="From Date" class="surch_emp datepicker" value="<?php echo $f_date; ?>" required=""/>
				<input type="text" name="t_date" id="" style="width:30%;text-align: center;" placeholder="To Date" class="surch_emp datepicker" value="<?php echo $t_date; ?>" required=""/>
					<select data-placeholder="Choose a Method" name="gateway" style="width:30%;" class="" required="" />
						<option value="all" <?php if($gateway == 'all') echo 'selected="selected"';?>>All Gateway</option>
						<option value="bKash" <?php if($gateway == 'bKash') echo 'selected="selected"';?>>bKash</option>
						<option value="bKashT" <?php if($gateway == 'bKashT') echo 'selected="selected"';?>>bKash (T)</option>
						<option value="Rocket" <?php if($gateway == 'Rocket') echo 'selected="selected"';?>>Rocket</option>
						<option value="Nagad" <?php if($gateway == 'Nagad') echo 'selected="selected"';?>>Nagad</option>
						<option value="iPay" <?php if($gateway == 'iPay') echo 'selected="selected"';?>>iPay</option>
						<option value="SSLCommerz" <?php if($gateway == 'SSLCommerz') echo 'selected="selected"';?>>SSLCommerz</option>
						<option value="Webhook" <?php if($gateway == 'Webhook') echo 'selected="selected"';?>>Webhook</option>
					</select>
				<br>
				<input type="radio" name="radiofield" <?php if('collections' == $radiofield or $radiofield == ''){echo "checked='checked'";}?> value="matched" />Reference Matched &nbsp; &nbsp;
				<input type="radio" name="radiofield" <?php if('discounts' == $radiofield){echo "checked='checked'";}?>  value="discounts"/>Reference Not Matched &nbsp; &nbsp;
				<input type="radio" name="radiofield" <?php if('others_bank' == $radiofield){echo "checked='checked'";}?>  value="others_bank"/>Without Reference &nbsp; &nbsp;
			</div>
			<div style="float: left;">
				<button class="btn col1" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
			</div>
		</form>
        </div>
        <div class="pageicon"><i class="iconfa-shopping-cart"></i></div>
        <div class="pagetitle">
            <h1>Online Payments</h1>
        </div>
    </div><!--pageheader-->
	<?php if('add' == (isset($_POST['add']) ? $_POST['add'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully added.
			</div><!--alert-->
		<?php } ?>
	<div class="box box-primary">
	<?php if($wayyyy == ''){ ?>
		<div class="box-header">
			<h5><?php echo $tit;?></h5>
		</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
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
							<th class="head0 center">SL NO</th>
							<th class="head1">Date Time</th>
							<th class="head0">Auto Added</th>
							<th class="head1 center">Payment Details</th>
							<th class="head0 center">Force Added To</th>
							<th class="head1 center">Amount</th>
							<th class="head0 center">Charged</th>
							<th class="head1 center">Count Amount</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php

								$x = 1;				
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($user_type == 'admin' || $user_type == 'superadmin'){
										if($row['lock_sts'] == '0'){
											$aaa = "<li style='margin: 0px;'><form action='{$PHP_SELF}' method='post'><input type='hidden' name='paymentid' value='{$row['id']}'/><input type='hidden' name='locksts_way' value='unlock'/><button class='' style='padding: 10px 14px;border: 2px solid #0000003b;border-radius: 5px;' title='Force Add Unlocked'><i class='iconsweets-unlock'></i></button></form></li>";
										}
										else{
											$aaa = "<li style='margin: 0px;'><form action='{$PHP_SELF}' method='post'><input type='hidden' name='paymentid' value='{$row['id']}'/><input type='hidden' name='locksts_way' value='lock'/><button class='' style='padding: 10px 14px;border: 2px solid #ff000029;border-radius: 5px;' title='Force Add Locked'><i class='iconsweets-locked2'></i></button></form></li>";
										}
										$bbb = "<td rowspan='2' style='width: 20%;border-right: none;vertical-align: middle;'><ul class='tooltipsample' style='text-align: center;'>{$aaa}</ul></td>";
									}
									else{
										if($row['lock_sts'] == '0'){
											$aaa = "";
										}
										else{
											$aaa = "<li style='margin: 0px;'><button class='' style='padding: 10px 14px;border: 2px solid #ff000029;border-radius: 5px;' title='Force Add Locked'><i class='iconsweets-locked2'></i></button></li>";
										}
										$bbb = "";
									}
									
									$sql19ff = mysql_query("SELECT p.id, c.c_id, c.c_name, c.cell, p.pay_ent_by, DATE_FORMAT(p.pay_date_time, '%D-%b, %Y %T') AS add_date_time FROM payment_mac_client AS p LEFT JOIN clients AS c ON c.c_id = p.c_id WHERE p.trxid = '{$row['trxID']}'");
									$r19s = mysql_fetch_array($sql19ff);
																				
									if($r19s['c_id'] != ''){
										$changebttn = "<li><form action='BillPaymentView' method='post' target='_blank' data-placement='top' data-rel='tooltip' title='View Bill & Payment'><input type='hidden' name='id' value='{$r19s['c_id']}' /><button class='btn col1'><i class='iconfa-eye-open'></i></button></form></li>";
										$originally = "";
									}
									else{
										$originally = "<table style='width: 100%;'>
														<tbody>
															<tr>
																<td class='center' style='border-right: none;border-left: none;'>
																	<form id='form2' class='stdform' method='post' action='{$PHP_SELF}'>
																		<input type='hidden' name='paymentid' value='{$row['id']}'/>
																		<input type='hidden' name='wayyyy' value='client'/>
																		<input type='hidden' name='sender_no' value='{$row['sender_no']}'/>
																		<input type='hidden' name='amount' value='{$row['amount']}'/>
																		<input type='hidden' name='trxID' value='{$row['trxID']}'/>
																		<input type='hidden' name='pay_mode' value='{$row['pay_mode']}'/>
																		<input type='hidden' name='autoid' value='{$row['c_id']}'/>
																		<button class='btn btn-primary' type='submit' style='text-transform: uppercase;font-weight: bold;height: 35px;width: 100%;float: left;'>Client</button>
																	</form>
																</td>
															</tr>
														</tbody>
													</table>";												
										$changebttn = "";
									}
									
									
									echo
										"<tr class='gradeX'>
											<td class='center' style='vertical-align: middle;font-size: 18px;font-weight: bold;'>{$row['id']}</td>
											<td style='vertical-align: middle;'><b>{$row['paydate']}</b><br>{$row['paytime']}</td>
											<td><b>{$row['c_id']}{$row['reseller_id']}</b><br>{$row['c_name']}{$row['e_name']}<br>{$row['cell']}{$row['resellerzone']}</td>
											<td><b>{$row['pay_mode']}{$addweb}</b><br>{$row['sender_no']}<br>{$row['trxID']}<br><b style='color: red;'>Reff: {$row['transactionReference']}</b></td>
											<td style='vertical-align: middle;'>{$originally}</td>
											<td class='center' style='font-size: 14px;vertical-align: middle;'><b>{$row['amount']}</b></td>
											<td class='center' style='font-size: 14px;vertical-align: middle;'><b>{$row['chargeamount']}</b></td>
											<td class='center' style='font-size: 18px;vertical-align: middle;color: #044a8e;'><b>{$row['pay_amount']}</b></td>
											<td class='center' style='vertical-align: middle;'>
												<ul class='tooltipsample'>
													{$changebttn}
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>		
<?php } elseif($wayyyy == 'client'){
$queryr = mysql_query("SELECT c_id, com_id, c_name, cell FROM clients WHERE mac_user = '1' AND sts = '0' AND z_id = '$macz_id' ORDER BY c_id ASC");
?>
					<div class="box-header">
						<div class="modal-content">
							<div class="modal-header">
								<h5>Set <?php echo $pay_mode;?> Payment to</h5>
							</div>
								<form id="form" class="stdform" method="POST" name="form" action="PaymentAdd" enctype="multipart/form-data">
									<input type='hidden' name='paymentid' value='<?php echo $paymentid;?>'/>
									<input type='hidden' name='wayyyy' value='client'/>
									<input type='hidden' name='sender_no' value='<?php echo $sender_no;?>'/>
									<input type='hidden' name='amount' value='<?php echo $amount;?>'/>
									<input type='hidden' name='trxID' value='<?php echo $trxID;?>'/>
									<input type='hidden' name='pay_mode' value='<?php echo $pay_mode;?>'/>
										<div class="modal-body">
											<p>
												<label style="font-weight: bold;">Choose a Client</label>
												<span class="field">
													<select data-placeholder="Choose Client" name="c_id" class="chzn-select" required="" style="width:80%;" onchange="submit();">
														<option value=""></option>
														<?php while ($row2=mysql_fetch_array($queryr)) { ?>
														<option value="<?php echo $row2['c_id']?>"<?php if($row2['c_id'] == $autoid) echo 'selected="selected"';?>><?php echo $row2['com_id']; ?> | <?php echo $row2['c_id']; ?> | <?php echo $row2['c_name']; ?> | <?php echo $row2['cell']; ?></option>
														<?php } ?>
													</select>
												</span>	
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn btn-green" style="float: left;" onclick="history.back()"><i class="iconfa-arrow-left"></i>  BACK</button>
											<button class="btn btn-primary" type="submit">SUBMIT</button>
										</div>
								</form>		
						</div>
					</div>
		<?php } else{
$resultdgfhd=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_cont_per, e.e_id FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");
			?>		
					<div class="box-header">
						<div class="modal-content">
							<div class="modal-header">
								<h5>Set <?php echo $pay_mode;?> Payment to</h5>
							</div>
								<form id="form" class="stdform" method="POST" name="form" action="MacResellerPayment#paymentt" enctype="multipart/form-data">
									<input type='hidden' name='paymentid' value='<?php echo $paymentid;?>'/>
									<input type='hidden' name='wayyyy' value='reseller'/>
									<input type='hidden' name='sender_no' value='<?php echo $sender_no;?>'/>
									<input type='hidden' name='amount' value='<?php echo $amount;?>'/>
									<input type='hidden' name='trxID' value='<?php echo $trxID;?>'/>
									<input type='hidden' name='pay_mode' value='<?php echo $pay_mode;?>'/>
										<div class="modal-body">
											<p>
												<label style="font-weight: bold;">Choose a Reseller</label>
												<span class="field">
													<select data-placeholder="Choose Area" name="id" class="chzn-select" required="" style="width:80%;" onchange="submit();">
															<option value=""></option>
														<?php while ($row=mysql_fetch_array($resultdgfhd)) { ?>
																<option value="<?php echo $row['z_id']?>"<?php if($row['e_id'] == $autorid) echo 'selected="selected"';?>><?php echo $row['z_name'];?> | <?php echo $row['resellername'];?> | <?php echo $row['e_cont_per']; ?></option>
														<?php } ?>
													</select>
												</span>	
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn btn-green" style="float: left;" onclick="history.back()"><i class="iconfa-arrow-left"></i>  BACK</button>
											<button class="btn btn-primary" type="submit">SUBMIT</button>
										</div>
								</form>		
						</div>
					</div>
		<?php } ?>			
	</div>
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
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
                                    
        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
	if(jQuery('.tooltipsample').length > 0)
		jQuery('.tooltipsample').tooltip({selector: "a[rel=tooltip]"});
		
	jQuery('.popoversample').popover({selector: 'a[rel=popover]', trigger: 'hover'});
        
    });
</script>
<style>
#dyntable_length{display: none;}
</style>
