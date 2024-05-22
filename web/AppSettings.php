<?php
$titel = "Application Settings";
$AppSettings = 'active';
if($_GET['wayyy'] == 'SMS API' || $_POST['way'] == 'SMS API'){
	$SMSSettings = 'active';
}
include('include/hader.php');
$way = isset($_GET['wayyy']) ? $_GET['wayyy'] : '';
extract($_POST); 

$user_type = $_SESSION['SESS_USER_TYPE'];
$user_name = $_SESSION['SESS_FIRST_NAME'];
if($user_type == 'admin' || $user_type == 'superadmin'){
	
$sqllimi = mysql_query("SELECT id FROM clients WHERE sts = '0' AND con_sts = 'Active'");
$total_clients = mysql_num_rows($sqllimi);

$sqlset="SELECT id, name, owner_name, last_id, edit_last_id, tree_sts, use_diagram_client, tis_api, invoice_note1, invoice_note2, invoice_note3, online_off, invoice_note4, invoice_note5, invoice_logo_size, clients_per_del, delete_clients_till, reseller_downgrade, onlineclient_sts, onlineclient_search_sts, search_with_reseller, client_terminate, latitude, longitude, email, address, address2, postal_code, com_email, location_service, fax, phone, copmaly_boss_cell, website, currency, logo, app_logo, minimize_load, tis_id, user_limit, bill_amount, ppoe_comment, active_queue, reseller_per_del, delete_reseller_till, inactive_way, realtime_graph, cpu, cpu_interval, reseller_client_login, reseller_client_online_payment_sts, division_id, district_id, upazila_id, union_id, chat_access FROM app_config ";
$resultset=mysql_query($sqlset);
$rowset=mysql_fetch_array($resultset);
$id=$rowset['id'];
$name=$rowset['name'];
$email=$rowset['email'];
$postal_code=$rowset['postal_code'];
$fax=$rowset['fax'];
$phone=$rowset['phone'];
$website=$rowset['website'];
$currency=$rowset['currency'];
$logo=$rowset['logo'];
$app_logo=$rowset['app_logo'];
$address=$rowset['address'];
$address2=$rowset['address2'];
$last_id=$rowset['last_id'];
$edit_last_id=$rowset['edit_last_id'];
$owner_name=$rowset['owner_name'];
$copmaly_boss_cell=$rowset['copmaly_boss_cell'];
$com_email=$rowset['com_email'];
$tis_id=$rowset['tis_id'];
$onlineclient_sts=$rowset['onlineclient_sts'];
$onlineclient_search_sts=$rowset['onlineclient_search_sts'];
$search_with_reseller_clients=$rowset['search_with_reseller'];
$user_limit=$rowset['user_limit'];
$bill_amount=$rowset['bill_amount'];
$active_queue=$rowset['active_queue'];
$ppoe_comment=$rowset['ppoe_comment'];
$online_btns_off=$rowset['online_off'];
$location_service=$rowset['location_service'];
$reseller_downgrade=$rowset['reseller_downgrade'];
$copmaly_seting_latitude = $rowset['latitude'];
$copmaly_seting_longitude = $rowset['longitude'];
$copmaly_client_terminate = $rowset['client_terminate'];
$copmaly_use_diagram_client = $rowset['use_diagram_client'];
$tree_sts_copmaly = $rowset['tree_sts'];
$inactive_way = $rowset['inactive_way'];
$realtime_graph = $rowset['realtime_graph'];
$cpu_load = $rowset['cpu'];
$cpu_interval = $rowset['cpu_interval'];
$clients_per_deletee = $rowset['clients_per_del'];
$delete_clients_tilll = $rowset['delete_clients_till'];
$reseller_per_deletee = $rowset['reseller_per_del'];
$delete_reseller_tilll = $rowset['delete_reseller_till'];
$minimize_loaddd = $rowset['minimize_load'];
$tis_api = $rowset['tis_api'];
$invoice_notee1 = $rowset['invoice_note1'];
$invoice_notee2 = $rowset['invoice_note2'];
$invoice_notee3 = $rowset['invoice_note3'];
$invoice_notee4 = $rowset['invoice_note4'];
$invoice_notee5 = $rowset['invoice_note5'];
$invoice_logo_sizee = $rowset['invoice_logo_size'];
$reseller_client_loginn = $rowset['reseller_client_login'];
$reseller_client_online_payment_stss = $rowset['reseller_client_online_payment_sts'];
$division_id = $rowset['division_id'];
$district_id = $rowset['district_id'];
$upazila_id = $rowset['upazila_id'];
$union_id = $rowset['union_id'];
$user_chat_access = explode(',', $rowset['chat_access']);

$sqlss2k = mysql_query("SELECT u_des, u_type FROM user_typ WHERE sts = '0'");
$resufltdt = mysql_query("SELECT * FROM divisions");

if($division_id != ''){
	$sqlss1 = mysql_query("SELECT id AS dis_id, name AS dis_name, bn_name AS dis_bn_name, lat, lon, url FROM `districts` WHERE `division_id` = '$division_id'");  
	
	if($district_id != ''){
		$sqlss2 = mysql_query("SELECT id AS upz_id, name AS upz_name, bn_name AS upz_bn_name, url FROM `upazilas` WHERE `district_id` =  '$district_id'");  
		
		if($upazila_id != ''){
			$sqlss3 = mysql_query("SELECT id AS uni_id, name AS uni_name, bn_name AS uni_bn_name, url FROM `unions` WHERE `upazilla_id` =  '$upazila_id'");
		}
	}
}

$bkmathodsss = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");
$bkmathodssst = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");
$ipaymathodsss = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");
$sslmathodsss = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");
$rocketmathodsss = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");
$nagadmathodsss = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");

//---bKash
$bkkk=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`, `app_key`,`app_secret`,`username`,`password`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '1'");
$rowbk=mysql_fetch_array($bkkk);
$bkid=$rowbk['id'];
$bkgetway_name=$rowbk['getway_name'];
$bkgetway_name_details=$rowbk['getway_name_details'];
$bkmerchant_number=$rowbk['merchant_number'];
$bkapp_key=$rowbk['app_key'];
$bkapp_secret=$rowbk['app_secret'];
$bkusername=$rowbk['username'];
$bkpassword=$rowbk['password'];
$bkbank=$rowbk['bank'];
$bkcharge=$rowbk['charge'];
$bkcharge_sts=$rowbk['charge_sts'];
$bkshow_sts=$rowbk['show_sts'];
$bksts=$rowbk['sts'];
$bkwebhook_sts=$rowbk['webhook_sts'];

//---bKashT
$bkkkt=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`, `app_key`,`app_secret`,`username`,`password`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts` FROM payment_online_setup WHERE id = '6'");
$rowbkt=mysql_fetch_array($bkkkt);
$bkidt=$rowbkt['id'];
$bkgetway_namet=$rowbkt['getway_name'];
$bkgetway_name_detailst=$rowbkt['getway_name_details'];
$bkmerchant_numbert=$rowbkt['merchant_number'];
$bkapp_keyt=$rowbkt['app_key'];
$bkapp_secrett=$rowbkt['app_secret'];
$bkusernamet=$rowbkt['username'];
$bkpasswordt=$rowbkt['password'];
$bkbankt=$rowbkt['bank'];
$bkcharget=$rowbkt['charge'];
$bkcharge_stst=$rowbkt['charge_sts'];
$bkshow_stst=$rowbkt['show_sts'];
$bkstst=$rowbkt['sts'];

//---iPay
$ipayyy=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`app_key`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '2'");
$rowipay=mysql_fetch_array($ipayyy);
$ipayid=$rowipay['id'];
$ipaygetway_name=$rowipay['getway_name'];
$ipaygetway_getway_name_details=$rowipay['getway_name_details'];
$ipaymerchant_number=$rowipay['merchant_number'];
$ipayapp_key=$rowipay['app_key'];
$ipaybank=$rowipay['bank'];
$ipaycharge=$rowipay['charge'];
$ipaycharge_sts=$rowipay['charge_sts'];
$ipayshow_sts=$rowipay['show_sts'];
$ipaysts=$rowipay['sts'];
$ipaywebhook_sts=$rowipay['webhook_sts'];

//---SSLCommerz
$sslll=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`password`,`store_id`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '3'");
$rowssl=mysql_fetch_array($sslll);
$sslid=$rowssl['id'];
$sslgetway_name=$rowssl['getway_name'];
$sslgetway_name_details=$rowssl['getway_name_details'];
$sslmerchant_number=$rowssl['merchant_number'];
$sslstore_id=$rowssl['store_id'];
$sslpassword=$rowssl['password'];
$sslbank=$rowssl['bank'];
$sslcharge=$rowssl['charge'];
$sslcharge_sts=$rowssl['charge_sts'];
$sslshow_sts=$rowssl['show_sts'];
$sslsts=$rowssl['sts'];
$sslwebhook_sts=$rowssl['webhook_sts'];

//---Rocket
$rocketll=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`password`,`store_id`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '4'");
$rowrocket=mysql_fetch_array($rocketll);
$rocketid=$rowrocket['id'];
$rocketgetway_name=$rowrocket['getway_name'];
$rocketgetway_name_details=$rowrocket['getway_name_details'];
$rocketmerchant_number=$rowrocket['merchant_number'];
$rocketstore_id=$rowrocket['store_id'];
$rocketpassword=$rowrocket['password'];
$rocketbank=$rowrocket['bank'];
$rocketcharge=$rowrocket['charge'];
$rocketcharge_sts=$rowrocket['charge_sts'];
$rocketshow_sts=$rowrocket['show_sts'];
$rocketsts=$rowrocket['sts'];
$rockewebhook_sts=$rowrocket['webhook_sts'];

//---Nagad
$nagadll=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`password`,`store_id`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '5'");
$rownagad=mysql_fetch_array($nagadll);
$nagadid=$rownagad['id'];
$nagadgetway_name=$rownagad['getway_name'];
$nagadgetway_name_details=$rownagad['getway_name_details'];
$nagadmerchant_number=$rownagad['merchant_number'];
$nagadstore_id=$rownagad['store_id'];
$nagadpassword=$rownagad['password'];
$nagadbank=$rownagad['bank'];
$nagadcharge=$rownagad['charge'];
$nagadcharge_sts=$rownagad['charge_sts'];
$nagadshow_sts=$rownagad['show_sts'];
$nagadsts=$rownagad['sts'];
$nagadwebhook_sts=$rownagad['webhook_sts'];

$teleset=mysql_query("SELECT id, t_link, bot_id, chat_id, sts, add_user, add_user_chat_id, add_payment, add_payment_chat_id, webhook_client_payment, webhook_client_payment_chat_id, webhook_reseller_recharge, webhook_reseller_recharge_chat_id, client_status, client_status_chat_id, expense_sts, expense_sts_chat_id, client_recharge, client_recharge_chat_id, instruments_in_sts, instruments_in_chat_id, instruments_out_sts, instruments_out_chat_id, onu_ping_check, onu_ping_check_chat_id, fund_transfer_sts, fund_transfer_chat_id FROM telegram_setup");
$rowtele=mysql_fetch_array($teleset);
$teleid=$rowtele['id'];
$t_link=$rowtele['t_link'];
$bot_id=$rowtele['bot_id'];
$chat_id=$rowtele['chat_id'];
$sts=$rowtele['sts'];
$add_user=$rowtele['add_user'];
$add_user_chat_id=$rowtele['add_user_chat_id'];
$add_payment=$rowtele['add_payment'];
$add_payment_chat_id=$rowtele['add_payment_chat_id'];
$webhook_client_payment=$rowtele['webhook_client_payment'];
$webhook_client_payment_chat_id=$rowtele['webhook_client_payment_chat_id'];
$webhook_reseller_recharge=$rowtele['webhook_reseller_recharge'];
$webhook_reseller_recharge_chat_id=$rowtele['webhook_reseller_recharge_chat_id'];
$client_status=$rowtele['client_status'];
$client_status_chat_id=$rowtele['client_status_chat_id'];
$expense_sts=$rowtele['expense_sts'];
$expense_sts_chat_id=$rowtele['expense_sts_chat_id'];
$client_recharge=$rowtele['client_recharge'];
$client_recharge_chat_id=$rowtele['client_recharge_chat_id'];
$instruments_in_sts=$rowtele['instruments_in_sts'];
$instruments_in_chat_id=$rowtele['instruments_in_chat_id'];
$instruments_out_sts=$rowtele['instruments_out_sts'];
$instruments_out_chat_id=$rowtele['instruments_out_chat_id'];
$onu_ping_check=$rowtele['onu_ping_check'];
$onu_ping_check_chat_id=$rowtele['onu_ping_check_chat_id'];
$fund_transfer_sts=$rowtele['fund_transfer_sts'];
$fund_transfer_chat_id=$rowtele['fund_transfer_chat_id'];

$sql88 = ("SELECT id, link, username, password, status FROM sms_setup WHERE status = '0' AND z_id = ''");

$query88 = mysql_query($sql88);
$row88 = mysql_fetch_assoc($query88);
$link= $row88['link'];
$username= $row88['username'];
$password= $row88['password'];
$status= $row88['status'];

$menuactive = 'class="ui-tabs-active ui-state-active"';

$extrnal_link=mysql_query("SELECT id, ex_name, show_sts FROM external_access WHERE sts = '0' ORDER BY id ASC");

//--------------------------------------------------------------------------------------------------------------
mysql_close($con);
$serverrr = "localhost";
$conyy = @mysql_connect($serverrr, 'billing', 'billing3322');
if (!$conyy) {
    die('Could not connect: ' . mysql_error());
}
$qqqtt = mysql_select_db('asthatecnet_tis', $conyy);

$sqldfdf = mysql_query("SELECT a.bill_date AS date, a.p_name, a.p_price, a.p_discount, a.bill_amount, a.discount, a.extra_bill, a.payment, a.note, a.pay_idd, a.moneyreceiptno, a.pay_date_time, a.type, a.pay_mode FROM
					(SELECT b.c_id, b.bill_date, p.p_name, p.p_price, b.bill_amount, b.discount AS P_Discount, b.extra_bill, '-' AS Discount, '-' AS Payment, '-' AS note, '#' AS pay_idd, '' AS moneyreceiptno, bill_date_time AS pay_date_time, 'Monthly' AS type, '-' AS pay_mode 
										FROM billing AS b
										LEFT JOIN package AS p ON p.p_id = b.p_id
										LEFT JOIN clients AS c ON c.c_id = b.c_id
										WHERE b.bill_amount != '0' AND b.c_id = '$tis_id'
						UNION
							SELECT c_id, pay_date,'-', '-', '-', '-', '-', SUM(bill_discount) AS bill_discount, SUM(pay_amount) AS pay_amount, pay_desc AS note, id AS pay_idd, moneyreceiptno, pay_date_time, '-' AS type, pay_mode FROM payment
							WHERE c_id = '$tis_id' GROUP BY pay_date
						UNION
							SELECT b.c_id, b.pay_date,'-', '-', SUM(b.amount) AS bill_amount, '-', '-', '-', '-', b.bill_dsc AS note, '#' AS pay_idd, '-', b.pay_date_time AS pay_date_time, t.type, '-' AS pay_mode  FROM bill_signup AS b
							LEFT JOIN bills_type AS t ON t.bill_type = b.bill_type
							WHERE b.c_id = '$tis_id' GROUP BY b.pay_date_time
					) AS a
					ORDER BY a.pay_date_time");
					
$sql2 = mysql_query("SELECT c.c_id, ((b.bill+IFNULL(q.othersbill,0))-IFNULL(p.paid,0)) AS due, (b.bill+IFNULL(q.othersbill,0)) AS total_bill, IFNULL(p.paid,0) AS total_paid FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment GROUP BY c_id)p
						ON p.c_id = c.c_id
						LEFT JOIN
						(
						SELECT c_id, SUM(amount) AS othersbill FROM bill_signup GROUP BY c_id
						)q
						ON q.c_id = c.c_id
						WHERE c.c_id = '$tis_id'");
$rows = mysql_fetch_array($sql2);
$Dew = $rows['due'];
			
if($Dew > 1){
	$color = 'style="color:red;"';				
} else{
	$color = 'style="color:#666;"';
}

//--------------------------------------------------------------------------------------------------------------
?>
  <script type="text/javascript">
     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(90)
                        .height(28);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
        <div class="pageheader">
            <div class="searchbar">
				<a class="btn ownbtn9" href="UserType">User Type</a>
				<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;" href="UserAccess">User Menu Access</a>
				<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: green;border: 1px solid green;font-size: 14px;" href="UserAccessPage">User Advance Access</a>
				<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #a0f;border: 1px solid #a0f;font-size: 14px;" href="SMSSettings">SMS Templates</a>
			</div>
            <div class="pageicon"><span class="iconfa-cogs"></span></div>
            <div class="pagetitle">
                <h1>Application Settings</h1>
            </div>
        </div><!--pageheader-->
<?php if($_POST['way'] != '') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $way;?> Successfully Edited in Your System.
			</div><!--alert-->
<?php } else {}?>

	<div class="box box-primary">
		<div class="box-header">
				<div class="tabbedwidget">
                            <ul>
                                <li <?php if($way == 'Balance'){ echo $menuactive;}?>><b><a href="#tabs-1" <?php echo $color;?>>Balance [<?php echo number_format($Dew,2);?>৳]</a></b></li>
                                <li <?php if($way == 'Basic Informations'){ echo $menuactive;}?>><b><a href="#tabs-2">Basic</a></b></li>
                                <li <?php if($way == 'Owner Informations'){ echo $menuactive;}?>><b><a href="#tabs-3">Onwer</a></b></li>
                                <li <?php if($way == 'Backup Informations'){ echo $menuactive;}?>><b><a href="#tabs-4">Backup</a></b></li>
                                <li <?php if($way == 'Gateway'){ echo $menuactive;}?>><b><a href="#tabs-5">Online Payment</a></b></li>
                                <li <?php if($way == 'SMS API'){ echo $menuactive;}?>><b><a href="#tabs-6">SMS</a></b></li>
                                <li <?php if($way == 'Telegram API'){ echo $menuactive;}?>><b><a href="#tabs-7">Telegram</a></b></li>
                                <li <?php if($way == 'Others Settings'){ echo $menuactive;}?>><b><a href="#tabs-8">Others</a></b></li>
							<?php if($userr_typ == 'superadmin'){ ?>
                                <li <?php if($way == 'admin'){ echo $menuactive;}?>><b><a href="#tabs-9">Admin</a></b></li>
							<?php } ?>
                            </ul>
							
							<div id="tabs-1" style="min-height: 500px;">
									<table id="dyntable" class="table table-bordered responsive" >
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
												<th class="head1">Date</th>
												<th class="head0">Rent</th>
												<th class="head1">Extra</th>
												<th class="head0">Bill</th>
												<th class="head1">Discount</th>
												<th class="head0">Payment</th>
												<th class="head1">Mathod</th>
												<th class="head0">Bill Type</th>
											</tr>
										</thead>
										<tbody>
											<?php		
													while( $row = mysql_fetch_assoc($sqldfdf) )
													{
														
														$yrdata= strtotime($row['pay_date_time']);
														$month = date('d F, Y g:ia', $yrdata);
														if($row['pay_idd'] != '#'){
															$ss = "<li><a data-placement='top' data-rel='tooltip' href='PaymentDeleteClient?pid={$row['pay_idd']}' data-original-title='Delete Payment' class='btn col5' onclick='return checkDelete()'><i class='iconfa-remove'></i></a></li>";
															$ee = "<li><form action='fpdf/MRPrint' method='post' target='_blank' enctype='multipart/form-data'><input type='hidden' name='mrno' value='{$row['pay_idd']}'/> <button class='btn col1'><i class='iconfa-print'></i></button></form></li>"; 									}
														else{
															$ss = '';										
															$ee = '';
														}
													
														echo
															"<tr class='gradeX'>
																<td>{$month}</td>
																<td>{$row['p_price']}</td>
																<td>{$row['extra_bill']}</td>
																<td>{$row['bill_amount']}</td>
																<td>{$row['discount']}</td>
																<td>{$row['payment']}</td>
																<td>{$row['pay_mode']}</td>
																<td>{$row['type']}</td>
															</tr>\n ";
													
													}
													
												?>
										</tbody>
									</table><br><br>
										<table class="invoice-table" style="float: left;margin-bottom: 25px;">
										<tbody>
											  <tr>
												<th class="width40 right" style="float: left;" colspan="2">
													<div class="totamm">
															<h2 <?php echo $color;?>><span>Total Due</span>৳ <?php echo number_format($Dew,2); ?></h2>
													</div><br><br>
												</th>
											  </tr>
											
												</tbody>
										</table><br><br>
                            </div><br><br>
							
                            <div id="tabs-2" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="basic"/>
									<input type="hidden" name="tis_id" value="<?php echo $tis_id;?>"/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">Application ID</label>
											<h3 style="color: #317eac;"><?php echo $tis_id ;?></h3>
										</p>
										<p>
											<label style="font-weight: bold;">Clients Limit<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Only Active clients will count</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;"><a style="color: #0000ffba;"><?php echo $total_clients;?></a> / <a style="color: red;font-weight: bold;"><?php echo $user_limit;?></a></h4><h5 style="color: green;font-weight: bold;"><?php echo $bill_amount;?>৳ <a style="font-size: 10px;color: #669;">[Per Month]</a></h5>
										</p>
										<p>
											<label style="font-weight: bold;">Company Name*</label>
											<span class="field"><input type="text" name="name" id="" class="input-xlarge" required="" value="<?php echo $name ;?>" placeholder="Company Name" /></span>
										</p>
										<p>
											<label style="font-weight: bold;">Company Address 1*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Company Address 1</i></a></label>
											<span class="field"><textarea type="text" name="address" id="address" style="width:30%;" required="" placeholder="Company Full Address" class="input-large" /><?php echo $address ;?></textarea></span>
										</p>
										<p>
											<label style="font-weight: bold;">Company Address 2<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Company Address 2</i></a></label>
											<span class="field"><textarea type="text" name="address2" id="address2" style="width:30%;" placeholder="Company Full Address" class="input-large" /><?php echo $address2 ;?></textarea></span>
										</p>
										<p style="font-weight: bold;">
											<label style="font-weight: bold;">Division*</label>
											<select name="division_id" id="division_id" data-placeholder="Choose Division" class="chzn-select" style="font-weight: bold;width: 360px;text-align: center;" required="">
												<option></option>
												<?php while ($rdowdt = mysql_fetch_array($resufltdt)) { ?>
													<option value="<?php echo $rdowdt['id'];?>" <?php if($rdowdt['id'] == $division_id){echo 'selected="selected"';}?>><?php echo $rdowdt['name'];?> (<?php echo $rdowdt['bn_name'];?>)</option>		
												<?php } ?>
											</select>
										</p>
										
											<div id="resultpack" style="font-weight: bold;">
											<?php if($division_id != ''){ ?>
											<p>
												<label style="font-weight: bold;"></label>
												<select name="district_id" id="district_id" data-placeholder="District" class="chzn-select" style="font-weight: bold;width: 360px;">
													<option></option>
													<?php while ($rdowdst1 = mysql_fetch_array($sqlss1)) { ?>
														<option value="<?php echo $rdowdst1['dis_id'];?>" <?php if ($rdowdst1['dis_id'] == $district_id) echo 'selected="selected"';?>><?php echo $rdowdst1['dis_name'];?> (<?php echo $rdowdst1['dis_bn_name'];?>)</option>		
													<?php } ?>
												</select>
											</p>

											<?php if($district_id != '' && $division_id != ''){ ?>
											<p>
												<label style="font-weight: bold;"></label>
												<select name="upazila_id" id="upazila_id" data-placeholder="Upazila/Thana" class="chzn-select" style="font-weight: bold;width: 178px;">
													<option></option>
													<?php while ($rdowdst2 = mysql_fetch_array($sqlss2)) { ?>
														<option value="<?php echo $rdowdst2['upz_id'];?>" <?php if ($rdowdst2['upz_id'] == $upazila_id) echo 'selected="selected"';?>><?php echo $rdowdst2['upz_name'];?> (<?php echo $rdowdst2['upz_bn_name'];?>)</option>		
													<?php } ?>
												</select>

											<?php if($upazila_id != '' && $district_id != '' && $division_id != ''){ ?>
												<select name="union_id" id="union_id" data-placeholder="Union" class="chzn-select" style="font-weight: bold;width: 178px;">
													<option></option>
													<?php while ($rdowdst3 = mysql_fetch_array($sqlss3)) { ?>
														<option value="<?php echo $rdowdst3['uni_id'];?>" <?php if ($rdowdst3['uni_id'] == $union_id) echo 'selected="selected"';?>><?php echo $rdowdst3['uni_name'];?> (<?php echo $rdowdst3['uni_bn_name'];?>)</option>		
													<?php } ?>
												</select>
											<?php }}} ?>
											</p>
										</div>
										
										<p>
											<label>G.Location</label>
											<span class="field" style="margin-left: 0px;">
												<div class="input-append">
													<input type="text" name="latitude" id="latitude" placeholder="Map Latitude" value="<?php echo $copmaly_seting_latitude;?>" class="span2" style="margin-right: 2px;">
													<input type="text" name="longitude" id="longitude" placeholder="Map Longitude" value="<?php echo $copmaly_seting_longitude;?>" class="span2">
												</div>
											</span>
										</p>
										<p>
											<label>Postal Code</label>
											<span class="field"><input type="text" name="postal_code" id="" style="width: 10%;" value="<?php echo $postal_code ;?>" placeholder="Postal Code" /></span>
										</p>
										<p>
											<label>Web Address</label>
											<span class="field"><input type="text" name="website" id="" class="input-large" value="<?php echo $website ;?>" placeholder="http://www.company.com" /></span>
										</p>
										<p>
											<label style="font-weight: bold;">Support Phone No*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Customer care phone no</i></a></label>
											<span class="field"><input type="text" name="phone" id="" class="input-large" required="" value="<?php echo $phone ;?>" placeholder="Support Phone No" /></span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Company Logo*</label>
											<span class="field"><img src="<?php echo $logo; ?>" alt="" class="img-polaroid" height="60px" width="140px" /></span>
										</p>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: gray;border: 1px solid gray;font-size: 14px;">Reset</button>
										<button class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
                            <div id="tabs-3" style="min-height: 500px;">
                                <div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="owner"/>
									<input type="hidden" name="tis_id" value="<?php echo $tis_id;?>"/>
									<div class="modal-body" style="min-height: 400px;">
										<p>
											<label style="font-weight: bold;">Onwer Name*</label>
											<span class="field"><input type="text" name="owner_name" id="" class="input-xlarge" required="" value="<?php echo $owner_name ;?>" placeholder="Company Owner Name" /></span>
										</p>
										<p>
											<label style="font-weight: bold;">Onwer's Cell No*</label>
											<span class="field"><input type="text" name="copmaly_boss_cell" id="" class="input-large" required="" value="<?php echo $copmaly_boss_cell ;?>" placeholder="Company Owner Cell No" /></span>
										</p>
										<p>
											<label style="font-weight: bold;">Onwer's E-mail*</label>
											<span class="field"><input type="text" name="com_email" id="" class="input-large" required="" value="<?php echo $com_email ;?>" placeholder="Company Owner E-mail Address" /></span>
										</p>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: gray;border: 1px solid gray;font-size: 14px;">Reset</button>
										<button class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							 <div id="tabs-4" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="backup"/>
									<input type="hidden" name="tis_id" value="<?php echo $tis_id;?>"/>
									<div class="modal-body" style="min-height: 400px;">
										<p>
											<label style="font-weight: bold;">Backup E-mail*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Auto backup one/two email</i></a></label>
											<span class="field"><input type="text" name="email" id="" class="input-xxlarge" required="" value="<?php echo $email;?>" placeholder="test@gmail.com,test2@gmail.com" /></span>
										</p><br/>
										<p>
											<span class="field" id="backupgen1"><a class="btn ownbtn1" href="backup_db">Send On Mail</a><a class="btn ownbtn2" id="backupgen" style="margin-left: 10px;">Generate & Download</a></span>
										</p>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: gray;border: 1px solid gray;font-size: 14px;">Reset</button>
										<button class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							<div id="tabs-5" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="Gateway"/>
									<input type="hidden" name="bkid" value="<?php echo $bkid;?>"/>
									<input type="hidden" name="bkidt" value="<?php echo $bkidt;?>"/>
									<input type="hidden" name="ipayid" value="<?php echo $ipayid;?>"/>
									<input type="hidden" name="sslid" value="<?php echo $sslid;?>"/>
									<input type="hidden" name="rocketid" value="<?php echo $rocketid;?>"/>
									<input type="hidden" name="nagadid" value="<?php echo $nagadid;?>"/>
									<div class="modal-body" style="min-height: 400px;">
										<div class="" style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 15px;padding: 10px 0px 8px 20px;font-weight: bold;background: none;border: 1px solid rgba(0, 0, 0, 0.2);"><div style="float: left;padding: 3px 0;"><img src="imgs/bk_rbttn.png" style="width: 35px;padding: 0px;margin: -3px 20px 0 0;"></div>
										<div style="float: left;padding: 7px 0;">[ bKash ]</div>
										<span class=""  style="margin-left: 130px;text-transform: uppercase;text-align: center;">
											<select class="chzn-select" name="bksts" style="width:10%;" required="" onChange="getRoutePoint1(this.value)">
												<option value="0"<?php if($bksts == '0') echo 'selected="selected"';?>>Active</option>
												<option value="1"<?php if($bksts == '1') echo 'selected="selected"';?>>Inactive</option>
											</select>
										</span>
										</div>
										<div id="Pointdiv1">
										<?php if('0' == $bksts){?>
											<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
											<br/>
												<p>
													<label style="font-weight: bold;">Merchant Number*</label>
													<span class="field"><input type="text" name="bkmerchant_number" id="" required="" style="width: 110px;" value="<?php echo $bkmerchant_number;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">App Key*</label>
													<span class="field"><input type="text" name="bkapp_key" id="" required="" class="input-large" value="<?php echo $bkapp_key;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">App Secret*</label>
													<span class="field"><input type="text" name="bkapp_secret" id="" required="" class="input-large" value="<?php echo $bkapp_secret;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">Username*</label>
													<span class="field"><input type="text" name="bkusername" id="" required="" class="input-large" value="<?php echo $bkusername;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">Password*</label>
													<span class="field"><input type="password" name="bkpassword" id="" required="" class="input-large" value="<?php echo $bkpassword;?>" placeholder="" /></span>
												</p>
												<p>	
													<label style="font-weight: bold;">Bank*</label>
													<select data-placeholder="Must Choose a Bank" name="bkbank" style="width:220px;" class="chzn-select" required="" />
														<option></option>
														<?php 
														while ($rowmathdddd=mysql_fetch_array($bkmathodsss)) { ?>
															<option value="<?php echo $rowmathdddd['id'];?>"<?php if($rowmathdddd['id'] == $bkbank) {echo 'selected="selected"';}?>><?php echo $rowmathdddd['id'];?>. <?php echo $rowmathdddd['bank_name'];?></option>
														<?php } ?>
													</select>
												</p>
												<p>
													<label>Active Charge?</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="bkcharge_sts" value="1" <?php if('1' == $bkcharge_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
														<input type="radio" name="bkcharge_sts" value="0" <?php if('0' == $bkcharge_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
													</span>
												</p>
												<p>
													<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
													<span class="field"><input type="text" name="bkcharge" id="" style="width:7%;" value="<?php echo $bkcharge;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
												</p><br>
												<p>
													<label>Webhook</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="bkwebhook_sts" value="0" <?php if('0' == $bkwebhook_sts) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
														<input type="radio" name="bkwebhook_sts" value="1" <?php if('1' == $bkwebhook_sts) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
													</span>
												</p>
												<br>
												<br>
											</div>
										<?php } ?>
										</div>
										
										
										<div class="" style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 15px;padding: 10px 0px 8px 20px;font-weight: bold;background: none;border: 1px solid rgba(0, 0, 0, 0.2);"><div style="float: left;padding: 3px 0;"><img src="imgs/bk_rbttn.png" style="width: 35px;padding: 0px;margin: -3px 20px 0 0;"></div>
										<div style="float: left;padding: 7px 0;">[ bKash - Tokenize ]</div>
										<span class=""  style="margin-left: 51px;text-transform: uppercase;text-align: center;">
											<select class="chzn-select" name="bkstst" style="width:10%;" required="" onChange="getRoutePoint1t(this.value)">
												<option value="0"<?php if($bkstst == '0') echo 'selected="selected"';?>>Active</option>
												<option value="1"<?php if($bkstst == '1') echo 'selected="selected"';?>>Inactive</option>
											</select>
										</span>
										</div>
										<div id="Pointdiv1t">
										<?php if('0' == $bkstst){?>
											<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
											<br/>
												<p>
													<label style="font-weight: bold;">Merchant Number*</label>
													<span class="field"><input type="text" name="bkmerchant_numbert" id="" required="" style="width: 110px;" value="<?php echo $bkmerchant_numbert;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">App Key*</label>
													<span class="field"><input type="text" name="bkapp_keyt" id="" required="" class="input-large" value="<?php echo $bkapp_keyt;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">App Secret*</label>
													<span class="field"><input type="text" name="bkapp_secrett" id="" required="" class="input-large" value="<?php echo $bkapp_secrett;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">Username*</label>
													<span class="field"><input type="text" name="bkusernamet" id="" required="" class="input-large" value="<?php echo $bkusernamet;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">Password*</label>
													<span class="field"><input type="password" name="bkpasswordt" id="" required="" class="input-large" value="<?php echo $bkpasswordt;?>" placeholder="" /></span>
												</p>
												<p>	
													<label style="font-weight: bold;">Bank*</label>
													<select data-placeholder="Must Choose a Bank" name="bkbankt" style="width:220px;" class="chzn-select" required="" />
														<option></option>
														<?php 
														while ($rowmathddddt=mysql_fetch_array($bkmathodssst)) { ?>
															<option value="<?php echo $rowmathddddt['id'];?>"<?php if($rowmathddddt['id'] == $bkbankt) {echo 'selected="selected"';}?>><?php echo $rowmathddddt['id'];?>. <?php echo $rowmathddddt['bank_name'];?></option>
														<?php } ?>
													</select>
												</p>
												<p>
													<label>Active Charge?</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="bkcharge_stst" value="1" <?php if('1' == $bkcharge_stst) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
														<input type="radio" name="bkcharge_stst" value="0" <?php if('0' == $bkcharge_stst) echo 'checked="checked"';?>> No &nbsp; &nbsp;
													</span>
												</p>
												<p>
													<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
													<span class="field"><input type="text" name="bkcharget" id="" style="width:7%;" value="<?php echo $bkcharget;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
												</p>
												<br>
												<br>
											</div>
										<?php } ?>
										</div>
										
										
										
										<div class="" style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 15px;padding: 10px 0px 8px 20px;font-weight: bold;background: none;border: 1px solid rgba(0, 0, 0, 0.2);"><div style="float: left;padding: 3px 0;"><img src="imgs/rocket_s.png" style="width: 35px;padding: 0px;margin: -3px 20px 0 0;"></div>
										<div style="float: left;padding: 7px 0;">[ Rocket ]</div>
										<span class=""  style="margin-left: 125px;text-transform: uppercase;text-align: center;">
											<select class="chzn-select" name="rocketsts" style="width:10%;" required="" onChange="getRoutePoint2(this.value)">
												<option value="0"<?php if($rocketsts == '0') echo 'selected="selected"';?>>Active</option>
												<option value="1"<?php if($rocketsts == '1') echo 'selected="selected"';?>>Inactive</option>
											</select>
										</span>
										</div>
										
									<div id="Pointdiv2">
										<?php if('0' == $rocketsts){?>
											<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
											<br/>
												<p>
													<label style="font-weight: bold;">Merchant Number*</label>
													<span class="field"><input type="text" name="rocketmerchant_number" id="" required="" style="width: 110px;" value="<?php echo $rocketmerchant_number;?>" placeholder="" /></span>
												</p>
												<p>	
													<label style="font-weight: bold;">Bank*</label>
													<select data-placeholder="Must Choose a Bank" name="rocketbank" style="width:220px;" class="chzn-select" required="" />
														<option></option>
														<?php 
														while ($rodfss=mysql_fetch_array($rocketmathodsss)) { ?>
															<option value="<?php echo $rodfss['id'];?>"<?php if($rodfss['id'] == $rocketbank) {echo 'selected="selected"';}?>><?php echo $rodfss['id'];?>. <?php echo $rodfss['bank_name'];?></option>
														<?php } ?>
													</select>
												</p>
												<p>
													<label>Active Charge?</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="rocketcharge_sts" value="1" <?php if('1' == $rocketcharge_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
														<input type="radio" name="rocketcharge_sts" value="0" <?php if('0' == $rocketcharge_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
													</span>
												</p>
												<p>
													<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
													<span class="field"><input type="text" name="rocketcharge" id="" style="width:7%;" value="<?php echo $rocketcharge;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
												</p><br>
												<p>
													<label>Webhook</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="rockewebhook_sts" value="0" <?php if('0' == $rockewebhook_sts) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
														<input type="radio" name="rockewebhook_sts" value="1" <?php if('1' == $rockewebhook_sts) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
													</span>
												</p>
												<br>
												<br>
											</div>
										<?php } ?>
									</div>
										
										<div class="" style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 15px;padding: 10px 0px 8px 20px;font-weight: bold;background: none;border: 1px solid rgba(0, 0, 0, 0.2);"><div style="float: left;padding: 3px 0;"><img src="imgs/nagad_s.png" style="width: 35px;padding: 0px;margin: -3px 20px 0 0;"></div>
										<div style="float: left;padding: 7px 0;">[ Nagad ]</div>
										<span class=""  style="margin-left: 128px;text-transform: uppercase;text-align: center;">
											<select class="chzn-select" name="nagadsts" style="width:10%;" required="" onChange="getRoutePoint3(this.value)">
												<option value="0"<?php if($nagadsts == '0') echo 'selected="selected"';?>>Active</option>
												<option value="1"<?php if($nagadsts == '1') echo 'selected="selected"';?>>Inactive</option>
											</select>
										</span>
										</div>
										
									<div id="Pointdiv3">
										<?php if('0' == $nagadsts){?>
											<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
												<br/>
												<p>
													<label style="font-weight: bold;">Merchant Number*</label>
													<span class="field"><input type="text" name="nagadmerchant_number" id="" required="" style="width: 110px;" value="<?php echo $nagadmerchant_number;?>" placeholder="" /></span>
												</p>
												<p>	
													<label style="font-weight: bold;">Bank*</label>
													<select data-placeholder="Must Choose a Bank" name="nagadbank" style="width:220px;" class="chzn-select" required="" />
														<option></option>
														<?php 
														while ($rodfssdd=mysql_fetch_array($nagadmathodsss)) { ?>
															<option value="<?php echo $rodfssdd['id'];?>"<?php if($rodfssdd['id'] == $nagadbank) {echo 'selected="selected"';}?>><?php echo $rodfssdd['id'];?>. <?php echo $rodfssdd['bank_name'];?></option>
														<?php } ?>
													</select>
												</p>
												<p>
													<label>Active Charge?</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="nagadcharge_sts" value="1" <?php if('1' == $nagadcharge_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
														<input type="radio" name="nagadcharge_sts" value="0" <?php if('0' == $nagadcharge_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
													</span>
												</p>
												<p>
													<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
													<span class="field"><input type="text" name="nagadcharge" id="" style="width:7%;" value="<?php echo $nagadcharge;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
												</p><br>
												<p>
													<label>Webhook</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="nagadwebhook_sts" value="0" <?php if('0' == $nagadwebhook_sts) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
														<input type="radio" name="nagadwebhook_sts" value="1" <?php if('1' == $nagadwebhook_sts) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
													</span>
												</p>
												<br>
												<br>
											</div>
										<?php } ?>
									</div>
										
										<div class="" style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 15px;padding: 10px 0px 8px 20px;font-weight: bold;background: none;border: 1px solid rgba(0, 0, 0, 0.2);"><div style="float: left;padding: 3px 0;"><img src="imgs/ip_rbttn.png" style="width: 35px;padding: 0px;margin: -3px 20px 0 0;"></div>
										<div style="float: left;padding: 7px 0;">[ iPay ]</div>
										<span class="" style="margin-left: 144px;text-transform: uppercase;text-align: center;">
											<select class="chzn-select" name="ipaysts" style="width:10%;" required="" onChange="getRoutePoint4(this.value)">
												<option value="0"<?php if($ipaysts == '0') echo 'selected="selected"';?>>Active</option>
												<option value="1"<?php if($ipaysts == '1') echo 'selected="selected"';?>>Inactive</option>
											</select>
										</span>
										</div>
									<div id="Pointdiv4">
										<?php if('0' == $ipaysts){?>
											<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
												<br/>
												<p>
													<label style="font-weight: bold;">Merchant Number*</label>
													<span class="field"><input type="text" name="ipaymerchant_number" id="" required="" style="width: 110px;" value="<?php echo $ipaymerchant_number;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">App Key*</label>
													<span class="field"><input type="password" name="ipayapp_key" id="" required="" class="input-large" value="<?php echo $ipayapp_key;?>" placeholder="" /></span>
												</p>
												<p>	
													<label style="font-weight: bold;">Bank*</label>
													<select data-placeholder="Must Choose a Bank" name="ipaybank" style="width:220px;" class="chzn-select" required="" />
														<option></option>
														<?php 
														while ($rodddd=mysql_fetch_array($ipaymathodsss)) { ?>
															<option value="<?php echo $rodddd['id'];?>"<?php if($rodddd['id'] == $ipaybank) {echo 'selected="selected"';}?>><?php echo $rodddd['id'];?>. <?php echo $rodddd['bank_name'];?></option>
														<?php } ?>
													</select>
												</p>
												<p>
													<label>Active Charge?</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="ipaycharge_sts" value="1" <?php if('1' == $ipaycharge_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
														<input type="radio" name="ipaycharge_sts" value="0" <?php if('0' == $ipaycharge_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
													</span>
												</p>
												<p>
													<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
													<span class="field"><input type="text" name="ipaycharge" id="" style="width:7%;" value="<?php echo $ipaycharge;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
												</p><br>
												<p>
													<label>Webhook</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="ipaywebhook_sts" value="0" <?php if('0' == $ipaywebhook_sts) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
														<input type="radio" name="ipaywebhook_sts" value="1" <?php if('1' == $ipaywebhook_sts) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
													</span>
												</p>
												<br><br>
											</div>
										<?php } ?>
									</div>
										
										<div class="" style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 15px;padding: 10px 0px 8px 20px;font-weight: bold;background: none;border: 1px solid rgba(0, 0, 0, 0.2);"><div style="float: left;padding: 3px 0;"><img src="imgs/ssl.png" style="width: 35px;padding: 0px;margin: -3px 20px 0 0;border-radius: 8px;"></div>
										<div style="float: left;padding: 7px 0;">[ SSLCommerz ]</div>
										<span class="" style="margin-left: 80px;text-transform: uppercase;text-align: center;">
											<select class="chzn-select" name="sslsts" style="width:10%;" required="" onChange="getRoutePoint5(this.value)">
												<option value="0"<?php if($sslsts == '0') echo 'selected="selected"';?>>Active</option>
												<option value="1"<?php if($sslsts == '1') echo 'selected="selected"';?>>Inactive</option>
											</select>
										</span>
										</div>
										<div id="Pointdiv5">
										<?php if('0' == $sslsts){?>
											<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
												<br/>
												<p>
													<label style="font-weight: bold;">Merchant Number*</label>
													<span class="field"><input type="text" name="sslmerchant_number" id="" required="" style="width: 110px;" value="<?php echo $sslmerchant_number;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">Store id*</label>
													<span class="field"><input type="text" name="sslstore_id" id="" required="" class="input-large" value="<?php echo $sslstore_id;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">Store Password*</label>
													<span class="field"><input type="password" name="sslpassword" id="" required="" class="input-large" value="<?php echo $sslpassword;?>" placeholder="" /></span>
												</p>
												<p>	
													<label style="font-weight: bold;">Bank*</label>
													<select data-placeholder="Must Choose a Bank" name="sslbank" style="width:220px;" class="chzn-select" required="" />
														<option></option>
														<?php 
														while ($rodf=mysql_fetch_array($sslmathodsss)) { ?>
															<option value="<?php echo $rodf['id'];?>"<?php if($rodf['id'] == $sslbank) {echo 'selected="selected"';}?>><?php echo $rodf['id'];?>. <?php echo $rodf['bank_name'];?></option>
														<?php } ?>
													</select>
												</p>
												<p>
													<label>Active Charge?</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="sslcharge_sts" value="1" <?php if('1' == $sslcharge_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
														<input type="radio" name="sslcharge_sts" value="0" <?php if('0' == $sslcharge_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
													</span>
												</p>
												<p>
													<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
													<span class="field"><input type="text" name="sslcharge" id="" style="width:7%;" value="<?php echo $sslcharge;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
												</p><br>
												<p>
													<label>Webhook</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="sslwebhook_sts" value="0" <?php if('0' == $sslwebhook_sts) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
														<input type="radio" name="sslwebhook_sts" value="1" <?php if('1' == $sslwebhook_sts) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
													</span>
												</p>
												<br><br>
											</div>
										<?php } ?>
										</div>
										<br>
										<?php if(in_array(1, $online_getway) || in_array(2, $online_getway) || in_array(3, $online_getway) || in_array(4, $online_getway) || in_array(5, $online_getway) || in_array(6, $online_getway)){ ?>
										<br>
										<br>
										<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 15px;padding: 5px 0px 4px 45px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">External Online Payment</div>
											<p>
												<label style="font-weight: bold;margin-left: 50px;">External Payment Link</a></label>
												<span class="formwrapper"  style="margin-left: 0px;">
													<input type="radio" name="external_online_link_sts" value="1" <?php if('1' == $external_online_link) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
													<input type="radio" name="external_online_link_sts" value="0" <?php if('0' == $external_online_link) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
												</span>
											</p>
											<?php if($reseller_client_online_payment_stss == '1'){?>
											<p>
												<label style="font-weight: bold;margin-left: 50px;">For Mac Reseller Clients</a></label>
												<span class="formwrapper"  style="margin-left: 0px;">
													<input type="radio" name="external_online_link_mac_sts" value="1" <?php if('1' == $external_online_link_mac) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
													<input type="radio" name="external_online_link_mac_sts" value="0" <?php if('0' == $external_online_link_mac) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
												</span>
											</p>
											<?php } else{ ?>
													<input type="hidden" name="external_online_link_mac_sts" value="0">
											<?php } $rrr = 101; while ($rowdsffsdf=mysql_fetch_array($extrnal_link)) { ?>
											<p>
												<label style="font-weight: bold;margin-left: 50px;"><?php echo $rowdsffsdf['ex_name'];?></a></label>
												<span class="formwrapper" style="margin-left: 0px;">
													<input type="radio" name="<?php echo 'a'.$rrr;?>" value="1" <?php if('1' == $rowdsffsdf['show_sts']) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
													<input type="radio" name="<?php echo 'a'.$rrr;?>" value="0" <?php if('0' == $rowdsffsdf['show_sts']) echo 'checked="checked"';?>> No &nbsp; &nbsp;
												</span>
											</p>
										<?php $rrr++;} ?>
										<br>
										<br>
											<p>
												<label style="font-weight: bold;margin-left: 50px;">External Link For SMS Templates:</a></label>
												<span class="field"><input type="text" style="width: 270px;" readonly value="<?php echo $weblink.'exp?cid={{c_id}}';?>" />&nbsp;&nbsp;<b>OR</b>&nbsp;&nbsp;<input type="text" style="width: 400px;" readonly value="<?php echo $weblink.'PaymentOnlineExternal?clientid={{c_id}}';?>" /></span>
											</p>
										<?php } else{ ?><input type="hidden" name="external_online_link_sts" value="0" /><?php } ?>
									</div>
							
									<div class="modal-footer">
										<button type="reset" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: gray;border: 1px solid gray;font-size: 14px;">Reset</button>
										<button class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							<div id="tabs-6" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="">
									<input type="hidden" name="way" value="sms"/>
									<div class="modal-body" style="min-height: 400px;">
										<p>
											<label style="font-weight: bold;">API Link*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>[Provided by SMS Company]</i></a></label>
											<span class="field"><input type="text" name="link" required="" id="" class="input-xlarge" value="<?php echo $link;?>" placeholder="" /></span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Username*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>[Provided by SMS Company]</i></a></label>
											<span class="field"><input type="text" name="username" required="" id="" class="input-large" value="<?php if($link == 'http://217.172.190.215/') {echo $password;} else{echo $username;}?>" placeholder="" /></span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Password*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>[Provided by SMS Company]</i></a></label>
											<span class="field"><input type="text" name="password" required="" id="" class="input-large" value="<?php echo $password;?>" placeholder="" /></span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Set Templates</a></label>
											<span class="field"><a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #a0f;border: 1px solid #a0f;font-size: 14px;" href="SMSSettings">SMS Templates</a></span>
										</p>
									<?php if($link == 'http://217.172.190.215/'){?>
										<p>
											<label style="font-weight: bold;"></a></label>
											<span class="field"><a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: green;border: 1px solid green;font-size: 14px;" href="http://sms.asthatec.com/login/" target='_blank'>LOGIN TO SMS PANEL</a></span>
										</p>
									<?php } ?>
									</div>
									<!---<div class="modal-footer">
										<button type="reset" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: gray;border: 1px solid gray;font-size: 14px;">Reset</button>
										<button class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;" type="submit">Submit</button>
									</div>--->
									</form>
								</div>
                            </div>
							<div id="tabs-7" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="telegram"/>
									<div class="modal-body" style="min-height: 400px;">
										<p>
											<label style="font-weight: bold;">Active Telegram?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>If Yes, You require below info</i></a></label>
											<span class="formwrapper" style="text-transform: uppercase;">
											<select class="chzn-select" name="sts" style="width:15%;" required="" onChange="getRoutePoint10(this.value)">
												<option value="0"<?php if($sts == '0') echo 'selected="selected"';?>>Active</option>
												<option value="1"<?php if($sts == '1') echo 'selected="selected"';?>>Inactive</option>
											</select>
										</span>
										</p>
									<div id="Pointdiv10">
									<?php if($sts == '0'){?>
										<br>
										<?php if($userr_typ == 'superadmin'){ ?>
										<p>
											<label style="font-weight: bold;">API Link</label>
											<span class="field"><input type="text" name="t_link" required="" id="" readonly class="input-large" value="https://api.telegram.org/bot" placeholder="" /></span>
										</p>
										
										<p>
											<label style="font-weight: bold;">Bot ID<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Telegram bot id</i></a></label>
											<span class="field"><input type="text" name="bot_id" id="" required="" class="input-xxlarge" value="<?php echo $bot_id ;?>" placeholder="" /></span>
										</p>
										<br>
										<?php } else{ ?>
											<input type="hidden" name="t_link" value="https://api.telegram.org/bot"/>
											<input type="hidden" name="bot_id" value="<?php echo $bot_id ;?>"/>
										<?php } ?>
										<p>
											<label style="font-weight: bold;">Default Chat ID<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Chat/Group chat id</i></a></label>
											<span class="field"><input type="text" name="chat_id" id="" required="" class="input-large" value="<?php echo $chat_id ;?>" placeholder="" /></span>
										</p>
										<br>
										
										<p>
											<label style="font-weight: bold;">Client Creation<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when Add Client?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="add_user" value="0" <?php if('0' == $add_user) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="add_user" value="1" <?php if('1' == $add_user) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
											<span class="field"><input type="text" name="add_user_chat_id" id="" style="width: 10%;" value="<?php echo $add_user_chat_id ;?>" placeholder="Chat ID" /></span>
										</p>
										<p>
											<label style="font-weight: bold;">Make Payment<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when Add Payment?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="add_payment" value="0" <?php if('0' == $add_payment) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="add_payment" value="1" <?php if('1' == $add_payment) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="add_payment_chat_id" id="" style="width: 10%;" value="<?php echo $add_payment_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Webhook Client Payment<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when client paid by Webhook?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="webhook_client_payment" value="0" <?php if('0' == $webhook_client_payment) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="webhook_client_payment" value="1" <?php if('1' == $webhook_client_payment) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="webhook_client_payment_chat_id" id="" style="width: 10%;" value="<?php echo $webhook_client_payment_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Webhook Reseller Recharge<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when reseller recharge by Webhook?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="webhook_reseller_recharge" value="0" <?php if('0' == $webhook_reseller_recharge) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="webhook_reseller_recharge" value="1" <?php if('1' == $webhook_reseller_recharge) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="webhook_reseller_recharge_chat_id" id="" style="width: 10%;" value="<?php echo $webhook_reseller_recharge_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Client Status<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when Active/Inactive?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="client_status" value="0" <?php if('0' == $client_status) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="client_status" value="1" <?php if('1' == $client_status) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="client_status_chat_id" id="" style="width: 10%;" value="<?php echo $client_status_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Expense<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when expense add/approved/rejected?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="expense_sts" value="0" <?php if('0' == $expense_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="expense_sts" value="1" <?php if('1' == $expense_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="expense_sts_chat_id" id="" style="width: 10%;" value="<?php echo $expense_sts_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Reseller Client Recharge<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when reseller recharge days?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="client_recharge" value="0" <?php if('0' == $client_recharge) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="client_recharge" value="1" <?php if('1' == $client_recharge) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="client_recharge_chat_id" id="" style="width: 10%;" value="<?php echo $client_recharge_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Store Instruments In<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when instruments in or delete?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="instruments_in_sts" value="0" <?php if('0' == $instruments_in_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="instruments_in_sts" value="1" <?php if('1' == $instruments_in_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="instruments_in_chat_id" id="" style="width: 10%;" value="<?php echo $instruments_in_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Store Instruments Out<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when instruments out or delete?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="instruments_out_sts" value="0" <?php if('0' == $instruments_out_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="instruments_out_sts" value="1" <?php if('1' == $instruments_out_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="instruments_out_chat_id" id="" style="width: 10%;" value="<?php echo $instruments_out_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Fund Transfer<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when anyone transfer fund or edit fund transfer?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="fund_transfer_sts" value="0" <?php if('0' == $fund_transfer_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="fund_transfer_sts" value="1" <?php if('1' == $fund_transfer_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="fund_transfer_chat_id" id="" style="width: 10%;" value="<?php echo $fund_transfer_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">ONU Ping Check<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification When Diagram ONU Ping Loss/Down?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="onu_ping_check" value="0" <?php if('0' == $onu_ping_check) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="onu_ping_check" value="1" <?php if('1' == $onu_ping_check) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="onu_ping_check_chat_id" id="" style="width: 10%;" value="<?php echo $onu_ping_check_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<?php } ?>
									</div>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: gray;border: 1px solid gray;font-size: 14px;">Reset</button>
										<button class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							<div id="tabs-8" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="others"/>
									<input type="hidden" name="tis_id" value="<?php echo $tis_id;?>"/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">Last Client ID<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Clients Serial No</i></a></label>
											<span class="field"><input type="text" name="last_id" id="" class="input-large" value="<?php echo $last_id;?>" placeholder="" /></span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Can Edit Company ID?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Can Edit Last Client ID.</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="edit_last_id" value="1" <?php if('1' == $edit_last_id) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="edit_last_id" value="0" <?php if('0' == $edit_last_id) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Reseller Downgrade Package?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Reseller Can Downgrade Clients Package.</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="reseller_downgrade" value="1" <?php if('1' == $reseller_downgrade) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="reseller_downgrade" value="0" <?php if('0' == $reseller_downgrade) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Active Queues?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Queues On Network.</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="active_queue" value="1" <?php if('1' == $active_queue) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="active_queue" value="0" <?php if('0' == $active_queue) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<?php if($tree_sts_copmaly == '0'){?>
										<br>
										<p>
											<label style="font-weight: bold;">Location Service<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Store Location While Longin.<br>[User Permission Needed]</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="location_service" value="1" <?php if('1' == $location_service) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="location_service" value="0" <?php if('0' == $location_service) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Add Clients On Diagram<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>ONU will Add on Network Diagram.<br>[Diagram Must be Up to Date]</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="use_diagram_client" value="1" <?php if('1' == $copmaly_use_diagram_client) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="use_diagram_client" value="0" <?php if('0' == $copmaly_use_diagram_client) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<?php } ?>
										<br>
										<p>
											<label style="font-weight: bold;">Active Terminate Option<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Active Client Terminate Option.</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="client_terminate" value="1" <?php if('1' == $copmaly_client_terminate) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="client_terminate" value="0" <?php if('0' == $copmaly_client_terminate) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Show Online Clients<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>TIS Will Slow if Any of Your Network Get Disconnected</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="onlineclient_sts" value="1" <?php if('1' == $onlineclient_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="onlineclient_sts" value="0" <?php if('0' == $onlineclient_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Reseller Clients Search<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>If yes, Reseller Clients Will Show When Search From Clients Module</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="search_with_reseller" value="1" <?php if('1' == $search_with_reseller_clients) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="search_with_reseller" value="0" <?php if('0' == $search_with_reseller_clients) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Active Comment?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>If Yes, Comment will add in mikrotik when add/edit PPPoE Client.</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="ppoe_comment" value="0" <?php if('0' == $ppoe_comment) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="ppoe_comment" value="1" <?php if('1' == $ppoe_comment) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Comment Format</label>
											<span class="field"><input type="text" name="" id="" class="input-xxlarge" value="Client_Name-Cell_No-Address-Box_Name-Joining_Date-Package_Price" readonly /></span>
										</p>
										<p>
											<label style="font-weight: bold;">Invoice Logo Size</label>
											<span class="field"><input type="text" name="invoice_logo_sizee" placeholder="" style="width: 30px;" value="<?php echo $invoice_logo_sizee;?>" /></span>
										</p>
										<p>
											<label style="font-weight: bold;">Invoice NOTE / TERMS</label>
											<span class="field"><input type="text" name="invoice_notee1" placeholder="Invoice NOTE 1" class="input-xxlarge" value="<?php echo $invoice_notee1;?>" /></span>
											<?php if($invoice_notee1 != ''){?>
											<span class="field"><input type="text" name="invoice_notee2" placeholder="Invoice NOTE 2" class="input-xxlarge" value="<?php echo $invoice_notee2;?>" /></span>
											<?php } if($invoice_notee1 != '' && $invoice_notee2 != ''){?>
											<span class="field"><input type="text" name="invoice_notee3" placeholder="Invoice NOTE 3" class="input-xxlarge" value="<?php echo $invoice_notee3;?>" /></span>
											<?php } if($invoice_notee1 != '' && $invoice_notee2 != '' && $invoice_notee3 != ''){?>
											<span class="field"><input type="text" name="invoice_notee4" placeholder="Invoice NOTE 4" class="input-xxlarge" value="<?php echo $invoice_notee4;?>" /></span>
											<?php } if($invoice_notee1 != '' && $invoice_notee2 != '' && $invoice_notee3 != '' && $invoice_notee4 != ''){?>
											<span class="field"><input type="text" name="invoice_notee5" placeholder="Invoice NOTE 5" class="input-xxlarge" value="<?php echo $invoice_notee5;?>" /></span>
											<?php } ?>
										</p>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: gray;border: 1px solid gray;font-size: 14px;">Reset</button>
										<button class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							<?php if($userr_typ == 'superadmin'){ ?>
							<div id="tabs-9" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="admin"/>
									<input type="hidden" name="tis_id" value="<?php echo $tis_id;?>"/>
									<div class="modal-body">
										<br>
										<p>
											<label style="font-weight: bold;">Google Map?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Can Use Google Map on Diagram.</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="tree_sts_copmaly" value="0" <?php if('0' == $tree_sts_copmaly) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="tree_sts_copmaly" value="1" <?php if('1' == $tree_sts_copmaly) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
											</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Inactive Policy</label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="inactive_way" value="0" <?php if('0' == $inactive_way) echo 'checked="checked"';?>> Disable PPPoE &nbsp; &nbsp;
												<input type="radio" name="inactive_way" value="1" <?php if('1' == $inactive_way) echo 'checked="checked"';?>> Package "Inactive" &nbsp; &nbsp;
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Realtime Bandwidth Graph</label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="realtime_graph" value="1" <?php if('1' == $realtime_graph) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="realtime_graph" value="0" <?php if('0' == $realtime_graph) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Show Status on Search</label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="onlineclient_search_sts" value="1" <?php if('1' == $onlineclient_search_sts) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="onlineclient_search_sts" value="0" <?php if('0' == $onlineclient_search_sts) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">TIS API</label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="tis_api" value="1" <?php if('1' == $tis_api) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="tis_api" value="0" <?php if('0' == $tis_api) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Minimize Data Load</label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="minimize_loaddd" value="1" <?php if('1' == $minimize_loaddd) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="minimize_loaddd" value="0" <?php if('0' == $minimize_loaddd) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Show Online/Offline</label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="online_btns_off" value="0" <?php if('0' == $online_btns_off) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="online_btns_off" value="1" <?php if('1' == $online_btns_off) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Reseller Client Login</label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="reseller_client_loginn" value="1" <?php if('1' == $reseller_client_loginn) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="reseller_client_loginn" value="0" <?php if('0' == $reseller_client_loginn) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Reseller Client Payment</label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="reseller_client_online_payment_stss" value="1" <?php if('1' == $reseller_client_online_payment_stss) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="reseller_client_online_payment_stss" value="0" <?php if('0' == $reseller_client_online_payment_stss) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Chat Access For</label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<select data-placeholder="Multiple User Type" name="chat_access[]" class="chzn-select" style="width: 360px;text-align:center;height: 25px;" multiple="multiple" tabindex="5">
													<?php if($rowset['chat_access'] != ''){
															while ($rowd1ss=mysql_fetch_array($sqlss2k)) { ?>			
														<option style="text-align:center;" value="<?php echo $rowd1ss['u_type'];?>"<?php if(in_array($rowd1ss['u_type'], $user_chat_access)){echo 'selected="selected"';}?>><?php echo $rowd1ss['u_des'];?></option>
													<?php }} ?>
														<option style="text-align:center;" value="superadmin" selected="selected">Superadmin</option>
												</select>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">CPU Loading Bar</label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="cpu_load" value="0" <?php if('0' == $cpu_load) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="cpu_load" value="1" <?php if('1' == $cpu_load) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
												<input type="text" name="cpu_interval" placeholder="Interval" style="width: 4%;" value="<?php echo $cpu_interval;?>"/> SEC
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Clients Delete Button<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Clients Permanent Delete.</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="clients_per_deletee" value="1" <?php if('1' == $clients_per_deletee) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="clients_per_deletee" value="0" <?php if('0' == $clients_per_deletee) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
												<div class="input-append">
													<input type="text" style="width:50%;margin-right: 5px;" readonly value="<?php echo $delete_clients_tilll;?>" />&nbsp; &nbsp;
													<input type="text" name="delete_clients_till" style="width:50%;" class="" value="<?php echo date("Y-m-d H:i:s");?>" />
												</div>
											</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Reseller Delete Button<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Reseller Permanent Delete.</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="reseller_per_deletee" value="1" <?php if('1' == $reseller_per_deletee) echo 'checked="checked"';?>> Enable &nbsp; &nbsp;
												<input type="radio" name="reseller_per_deletee" value="0" <?php if('0' == $reseller_per_deletee) echo 'checked="checked"';?>> Disable &nbsp; &nbsp;
												<div class="input-append">
													<input type="text" style="width:50%;margin-right: 5px;" readonly value="<?php echo $delete_reseller_tilll;?>" />&nbsp; &nbsp;
													<input type="text" name="delete_reseller_till" style="width:50%;" class="" value="<?php echo date("Y-m-d H:i:s");?>" />
												</div>
											</span>
										</p>
										
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: gray;border: 1px solid gray;font-size: 14px;">Reset</button>
										<button class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							<?php } ?>
                        </div>
		</div>
	</div>

<?php
}
else{
	header("Location:/index");
	}
include('include/footer.php');
?>
<style>
.tabco{font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;font-weight: bold;}
.subto{
	border-bottom: 1px solid #ddd;
	display: block;
	font-family: 'RobotoBold', 'Helvetica Neue', Helvetica, sans-serif;
	font-size: 13px;
	padding: 7px 20px 8px 20px;
}
.subto2{
	display: block;
	font-family: 'RobotoBold', 'Helvetica Neue', Helvetica, sans-serif;
	font-size: 13px;
	padding: 7px 20px 8px 20px;
}
.totamm {width: 40%;float: right;}
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
	font-weight: bold;
}
</style>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;key=<?php echo $gapikey;?>&amp;libraries=places"></script>
<script>
google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
var input = document.getElementById('address');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.addListener('place_changed', function () {
var place = autocomplete.getPlace();
// place variable will have all the information you are looking for.
 
  document.getElementById("latitude").value = place.geometry['location'].lat();
  document.getElementById("longitude").value = place.geometry['location'].lng();
});
}
</script>
<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	

	function getRoutePoint1(afdId) {		
		
		var strURL="payment-info-check.php?bksts="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}

	function getRoutePoint1t(afdId) {		
		
		var strURL="payment-info-check.php?bkstst="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1t').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getRoutePoint2(afdId) {		
		
		var strURL="payment-info-check.php?rocketsts="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv2').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	function getRoutePoint3(afdId) {		
		
		var strURL="payment-info-check.php?nagadsts="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv3').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	function getRoutePoint4(afdId) {		
		
		var strURL="payment-info-check.php?ipaysts="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv4').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	function getRoutePoint5(afdId) {		
		
		var strURL="payment-info-check.php?sslsts="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv5').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	function getRoutePoint10(afdId) {		
		
		var strURL="payment-info-check.php?sts="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv10').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}


$(document).ready(function(){  
	$("#backupgen").on('click',function(){
		var user_name = $('<?php echo $user_name;?>').val();
		$('#backupgen1').html('<img src="images/loaddd.gif" alt="">');
		$.ajax({  
				type: 'POST',
				url: "backup_db_download.php",
				data:{user_name:user_name},
				success:function(data){
					data = JSON.parse(data);
					$('#backupgen1').html("<a class='btn ownbtn4' style='margin-left: 100px;margin-top: 60px;' href="+data.file+">DOWNLOAD NOW</a>");
				}
		});
		return false;
	});  
});
</script>
<script type="text/javascript">
jQuery(document).ready(function(){  
    jQuery('#division_id, #district_id, #upazila_id, #resultpack, #union_id').on('change',function(){ 
        var division_id = jQuery('#division_id').val();
        var district_id = jQuery('#district_id').val();
        var upazila_id = jQuery('#upazila_id').val();
        var union_id = jQuery('#union_id').val();
		
		jQuery('#resultpack').html('<img src="images/loaddd.gif" alt="">');
        jQuery.ajax({  
				type: 'POST',
                url: "division_district_upazila.php",
                data:{division_id:division_id,district_id:district_id,upazila_id:upazila_id,union_id:union_id},
                success:function(data){
                    jQuery('#resultpack').html(data);
                }
				
        });  
    });  
});
</script>