<?php
$titel = "My Bill";
$ClientsBill = 'active';
include('include/hader.php');
extract($_POST); 
$id = $_SESSION['SESS_EMP_ID'];
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'ClientsBill' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
$resultgg = mysql_query("SELECT c_id, c_name, cell, address, con_sts, b_date, payment_deadline, breseller, mac_user FROM clients WHERE c_id = '$id'");
$row = mysql_fetch_array($resultgg);

if($row['breseller'] == '2'){
$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.invoice_id, a.paydate, a.bill_date AS date, a.bill_amount, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
					(
					SELECT b.c_id, b.invoice_date AS bill_date, b.invoice_id, '' AS paydate, SUM(b.total_price) AS bill_amount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS sender_no, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.date_time AS pay_date_time
															FROM billing_invoice AS b
															LEFT JOIN clients AS c ON c.c_id = b.c_id
															WHERE b.c_id = '$id' AND b.sts = '0' GROUP BY b.invoice_id
											UNION
					SELECT p.c_id, p.pay_date AS bill_date, '' AS invoice_id, pay_date AS paydate, '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.sender_no, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment AS p
												LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by
												WHERE p.c_id = '$id' GROUP BY p.pay_date_time
					) AS a
					ORDER BY a.pay_date_time");

$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(total_price) AS bill FROM billing_invoice WHERE sts = '0' GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment WHERE sts = '0' GROUP BY c_id)p
						ON p.c_id = c.c_id
						WHERE c.c_id = '$id'");
}
else{
		if($row['mac_user'] == '0'){
		$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.p_name, a.p_price, a.raw_download, a.raw_upload, a.total_price, a.p_discount, a.bill_amount, a.extra_bill, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.pay_mode, a.pay_idd, a.entrybyname FROM
					(SELECT b.c_id, b.bill_date, p.p_name, p.p_price, c.raw_download, c.raw_upload, c.total_price, b.bill_amount, b.extra_bill AS extra_bill, b.discount AS p_discount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.bill_date_time AS pay_date_time
										FROM billing AS b
										LEFT JOIN package AS p ON p.p_id = b.p_id
										LEFT JOIN clients AS c ON c.c_id = b.c_id
										WHERE b.bill_amount != '0' AND b.c_id = '$id'
						UNION
							SELECT p.c_id, p.pay_date AS bill_date, '', '', '', '', '', '', '', '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment AS p
							LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by
							WHERE p.c_id = '$id' GROUP BY p.pay_date_time
					) AS a
					ORDER BY a.pay_date_time");
					
		$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$id'");
		}
		else{
$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.paydate, a.c_id, a.bill_date AS date, a.p_name, a.p_price, a.p_discount, a.bill_amount, a.extra_bill, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
					(SELECT b.c_id, b.bill_date, '' AS paydate, p.p_name, p.p_price_reseller AS p_price, b.bill_amount, b.extra_bill AS extra_bill, b.discount AS p_discount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS sender_no, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.bill_date_time AS pay_date_time
										FROM billing_mac_client AS b
										LEFT JOIN package AS p ON p.p_id = b.p_id
										LEFT JOIN clients AS c ON c.c_id = b.c_id
										WHERE b.bill_amount != '0' AND b.c_id = '$id'
						UNION
							SELECT p.c_id, p.pay_date AS bill_date, pay_date AS paydate, '', '', '', '', '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.sender_no, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment_mac_client AS p
							LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by
							WHERE p.c_id = '$id' GROUP BY p.pay_date_time
					) AS a
					ORDER BY a.bill_date");
	
$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing_mac_client GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment_mac_client GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$id'");
		}
	}
$rows = mysql_fetch_array($sql2);
$Dew = $rows['due'];

if($Dew > 0){
	$color = 'style="color:red;font-size: 12px;"';					
	$colordd = 'style="color:red;font-size: 15px;float: right;padding-right:10px;"';					
} else{
	$color = 'style="color:#000;font-size: 12px;"';
	$colordd = 'style="color:#000;font-size: 15px;float: right;padding-right:10px;"';
}

	?>
	<?php if($sts == 'done') {?>
			<div class="alert alert-success" style="padding: 5px;">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $payment; ?> TK Successfully paid by <?php echo $mode; ?>.
			</div><!--alert-->
	<?php } ?>
	<div class="box box-primary">
			<div class="box-body" style="padding: 0px 10px 0 10px;">
			<div class="pageheader" style="padding: 0px 10px 0 10px;">
        <div class="pagetitle">
			<?php if($Dew > '9'){ ?>
			<div class="box-header" style="padding-top: 5px;text-align:center;">
				<?php if($row['mac_user'] == '1'){ if($external_online_link_mac == '1'){ if(in_array(1, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>&gateway=bKash"><img src="<?php echo $weblink;?>imgs/bk_rbttn.png" title="bKash" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(6, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>&gateway=bKashT"><img src="<?php echo $weblink;?>imgs/bk_rbttn.png" title="bKash" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(4, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>gateway=Rocket"><img src="<?php echo $weblink;?>imgs/rocket_s.png" title="Rocket" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
						<?php } if(in_array(5, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>gateway=Nagad"><img src="<?php echo $weblink;?>imgs/nagad_s.png" title="Nagad" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
						<?php } if(in_array(2, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>gateway=iPay"><img src="<?php echo $weblink;?>imgs/ip_rbttn.png" title="iPay" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(3, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>gateway=SSLCommerz"><img src="<?php echo $weblink;?>imgs/ssl.png" title="SSLCommerz" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
				<?php }} else {}} else{ ?>
						<?php if(in_array(1, $online_getway)){?>
							<a href="PaymentOnline?gateway=bKash"><img src="<?php echo $weblink;?>imgs/bk_rbttn.png" title="bKash" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(6, $online_getway)){?>
							<a href="PaymentOnline?gateway=bKashT"><img src="<?php echo $weblink;?>imgs/bk_rbttn.png" title="bKash" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(4, $online_getway)){?>
							<a href="PaymentOnline?gateway=Rocket"><img src="<?php echo $weblink;?>imgs/rocket_s.png" title="Rocket" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
						<?php } if(in_array(5, $online_getway)){?>
							<a href="PaymentOnline?gateway=Nagad"><img src="<?php echo $weblink;?>imgs/nagad_s.png" title="Nagad" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
						<?php } if(in_array(2, $online_getway)){?>
							<a href="PaymentOnline?gateway=iPay"><img src="<?php echo $weblink;?>imgs/ip_rbttn.png" title="iPay" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(3, $online_getway)){?>
							<a href="PaymentOnline?gateway=SSLCommerz"><img src="<?php echo $weblink;?>imgs/ssl.png" title="SSLCommerz" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
						<?php }} ?>
			</div>
			<?php } ?>
			<div class="row">
					<table style="width:100%;background: #eeeeee;font-size: 10px;">
						<tr>
							<th style="font-size: 13px;float:left;padding-left: 10px;"><b>Billing Information</b></th>
							<td <?php echo $colordd;?>> <b>Total Due: &nbsp; &nbsp; <?php echo number_format($Dew,2).'tk'; ?></b></td>
						</tr>	
					</table>
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						<col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0" style="font-size: 9px;padding: 4px 0px 0px 4px;vertical-align: middle;">Date</th>
							<th class="head1 center" style="font-size: 9px;padding: 4px 0px 0px 0px;vertical-align: middle;">Pkg/Rate/ETC</th>
							<th class="head0 center" style="font-size: 9px;padding: 4px 0px 0px 0px;vertical-align: middle;">Bill</th>
							<th class="head1 center" style="font-size: 9px;padding: 4px 0px 0px 0px;vertical-align: middle;">Dis</th>
							<th class="head0 center" style="font-size: 9px;padding: 4px 0px 0px 0px;vertical-align: middle;">Paid</th>
							<th class="head1 center" style="font-size: 9px;padding: 4px 0px 0px 0px;vertical-align: middle;">MR</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $rown = mysql_fetch_assoc($sql) )
								{
									if($row['breseller'] == '0'){
										$packprice = $rown['p_price'];
									}
									else{
										$packprice = $rown['total_price'];
									}
									
									if($rown['pay_idd'] != '#'){
										$ee = "<li><form action='fpdf/MRPrint' method='post' target='_blank' enctype='multipart/form-data'><input type='hidden' name='mrno' value='{$rown['pay_idd']}'/> <input type='hidden' name='c_id' value='{$ids}'/> <button class='btn ownbtn2' title='Print Money Receipt' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>"; 
									}
									else{
										$ee = '';
									}
									
									if($row['breseller'] == '0'){
										$packageeee = $rown['p_name'];
									}
									else{
										if($rown['pay_idd'] == '#'){
											$packageeee = $rown['raw_download'].'mbps/'.$rown['raw_upload'].'mbps';
										}
										else{
											$packageeee = '';
										}
									}
									
									if($packageeee == ''){
										if($rown['sender_no'] != '' && $rown['trxid'] != ''){
											$onlineinfo = '<br>'.$rown['sender_no'].'<br>'.$rown['trxid'];
										}
										$packageeee = $rown['pay_mode'].$onlineinfo;
									}
									echo
										"<tr class='gradeX'>
											<td style='font-size: 9px;font-weight: bold;vertical-align: middle;'>{$rown['dateee']}</td>
											<td style='font-size: 9px;font-weight: bold;vertical-align: middle;' class='center'>{$packageeee}<br>{$packprice}</td>
											<td style='font-size: 15px;font-weight: bold;color: red;vertical-align: middle;' class='center'>{$rown['bill_amount']}</td>
											<td style='font-size: 9px;font-weight: bold;vertical-align: middle;' class='center'>{$rown['discount']}</td>
											<td style='font-size: 9px;font-weight: bold;vertical-align: middle;' class='center'><b style='font-size: 15px;color: green;'>{$rown['payment']}</b></td>
											<td class='center' style='font-size: 9px;font-weight: bold;vertical-align: middle;'>
												<ul class='tooltipsample' style='margin: 0px;'>
													{$ee}
												</ul>
											</td>
										</tr>\n";
								}  
							?>
					</tbody>
					</table>
			</div>
		</div>
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
