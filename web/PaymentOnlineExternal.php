<?php
session_start();
include("conn/connection.php");
include('company_info.php');

if($external_online_link == '1'){
$clientid = isset($_GET['clientid']) ? $_GET['clientid'] : '';
$gateway = isset($_GET['gateway']) ? $_GET['gateway'] : '';
$dewamount = isset($_GET['dewamount']) ? $_GET['dewamount'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
$sts = isset($_GET['sts']) ? $_GET['sts'] : '';

$ext_acc = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS ex_access FROM external_access WHERE sts = '0' AND show_sts = '1'"));
$ext_access = explode(',',$ext_acc['ex_access']);
extract($_POST);

ini_alter('date.timezone','Asia/Almaty');
$y = date("Y");
$m = date("m");
$ss = date('s', time());
$dat = $y.$m.$ss;

if($gateway == 'bKash' && in_array(1, $online_getway)){
//---bKash
$bkkk=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`, `app_key`,`app_secret`,`username`,`password`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts` FROM payment_online_setup WHERE id = '1'");
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

if($bkcharge_sts == '1'){
	$ext_charge = $bkcharge;
}
else{
	$ext_charge = '0.00';
}

$paygrant = 'ok';
$shortcode = 'BK-';
}

elseif($gateway == 'bKashT' && in_array(6, $online_getway)){
//---bKash
$zsfgg = "https://".$_SERVER['SERVER_NAME']."/tagreeexpayment.php";
$zsfgg1 = "https://".$_SERVER['SERVER_NAME']."/texecutepayment.php";
$error = $_GET['error'];
$bkkk=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`, `app_key`,`app_secret`,`username`,`password`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts` FROM payment_online_setup WHERE id = '6'");
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

if($bkcharge_sts == '1'){
	$ext_charge = $bkcharge;
}
else{
	$ext_charge = '0.00';
}

$paygrant = 'ok';
$shortcode = 'BK-';
}

elseif($gateway == 'iPay' && in_array(2, $online_getway)){
//---iPay
$ipayyy=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`app_key`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts` FROM payment_online_setup WHERE id = '2'");
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

if($ipaycharge_sts == '1'){
	$ext_charge = $ipaycharge;
}
else{
	$ext_charge = '0.00';
}

$paygrant = 'ok';
$shortcode = 'IPAY-';
}

elseif($gateway == 'SSLCommerz' && in_array(3, $online_getway)){
//---SSLCommerz
$sslll=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`password`,`store_id`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts` FROM payment_online_setup WHERE id = '3'");
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

if($sslcharge_sts == '1'){
	$ext_charge = $sslcharge;
}
else{
	$ext_charge = '0.00';
}

$paygrant = 'ok';
$shortcode = 'SSL-';
}

elseif($gateway == 'Rocket' && in_array(4, $online_getway)){
//---Rocket
$rocketll=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`password`,`store_id`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts` FROM payment_online_setup WHERE id = '4'");
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

if($rocketcharge_sts == '1'){
	$ext_charge = $rocketcharge;
}
else{
	$ext_charge = '0.00';
}

$paygrant = 'ok';
$shortcode = 'RKT-';
}

elseif($gateway == 'Nagad' && in_array(5, $online_getway)){
//---Nagad
$nagadll=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`password`,`store_id`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts` FROM payment_online_setup WHERE id = '5'");
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

if($nagadcharge_sts == '1'){
	$ext_charge = $nagadcharge;
}
else{
	$ext_charge = '0.00';
}

$paygrant = 'ok';
$shortcode = 'NGD-';
}
else{
$paygrant = 'no';
$shortcode = '';
}

if($clientid != ''){
	$sqlf = mysql_query("SELECT c.c_name, c.c_id, c.com_id, l.id, c.z_id, b.b_name, c.edit_sts, c.terms, l.nid_fond, l.nid_back, c.father_name, c.bill_man, c.old_address, z.z_name, c.technician, c.termination_date,c.box_id, c.raw_download, c.calculation, c.breseller, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, 
	l.e_id AS userid, l.pw, c.b_date, c.mk_id, m.Name AS mk_name, m.ServerIP, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.mac_user, payment_deadline, c.occupation, c.email, p.p_price_reseller, c.extra_bill,
	p_m, c.address, c.thana, c.join_date, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.opening_balance, c.con_type, c.connectivity_type, c.ip, c.mac, c.cable_sts, c.discount, c.con_sts, c.req_cable, c.cable_type, 
	c.nid, c.p_id, p.p_name, p.p_price, p.bandwith, c.signup_fee, c.note, c.agreementID, c.customerMsisdn FROM clients AS c
		LEFT JOIN zone AS z ON z.z_id = c.z_id
		LEFT JOIN box AS b ON b.box_id = c.box_id
		LEFT JOIN package AS p ON p.p_id = c.p_id 
		LEFT JOIN mk_con AS m ON m.id = c.mk_id
		LEFT JOIN login AS l ON l.e_id = c.c_id
		WHERE c.c_id ='$clientid' ");
		
$rowsdfs = mysql_fetch_assoc($sqlf);
		$c_id= $rowsdfs['c_id'];
		$com_id= $rowsdfs['com_id'];
		$c_name= $rowsdfs['c_name'];
		$z_id= $rowsdfs['z_id'];
		$z_name = $rowsdfs['z_name'];
		$b_name = $rowsdfs['b_name'];
		$father_name = $rowsdfs['father_name'];
		$occupation = $rowsdfs['occupation'];
		$cell= $rowsdfs['cell'];
		$cell1= $rowsdfs['cell1'];
		$cell2= $rowsdfs['cell2'];
		$cell3= $rowsdfs['cell3'];
		$cell4= $rowsdfs['cell4'];
		$opening_balance = $rowsdfs['opening_balance'];
		$email= $rowsdfs['email'];
		$address= $rowsdfs['address'];
		$old_address= $rowsdfs['old_address'];
		$thana= $rowsdfs['thana'];
		$previous_isp= $rowsdfs['previous_isp'];
		$join_date= $rowsdfs['joinn'];
		$con_type= $rowsdfs['con_type'];
		$mac_user = $rowsdfs['mac_user'];
		$connectivity_type= $rowsdfs['connectivity_type'];
		$ip= $rowsdfs['ip'];
		$mac= $rowsdfs['mac'];
		$cable_sts= $rowsdfs['cable_sts'];
		$con_sts= $rowsdfs['con_sts'];
		$req_cable= $rowsdfs['req_cable'];
		$cable_type= $rowsdfs['cable_type'];
		$nid= $rowsdfs['nid'];
		$p_id= $rowsdfs['p_id'];
		$signup_fee= $rowsdfs['signup_fee'];
		$note= $rowsdfs['note'];
		$discount = $rowsdfs['discount'];
		$p_m = $rowsdfs['p_m'];
		$p_name = $rowsdfs['p_name'];
		if($mac_user == '1'){
			$p_price = ($rowsdfs['p_price_reseller']-$rowsdfs['discount'])+$rowsdfs['extra_bill'];
		}
		else{
			$p_price = ($rowsdfs['p_price']-$rowsdfs['discount'])+$rowsdfs['extra_bill'];
		}
//		$p_price = $rowsdfs['p_price'];
		$bandwith = $rowsdfs['bandwith'];
		$mk_name = $rowsdfs['mk_name'];
		$ServerIP = $rowsdfs['ServerIP'];
		$payment_deadline = $rowsdfs['payment_deadline'];
		$b_date = $rowsdfs['b_date'];
		$pw = $rowsdfs['pw'];
		$mk_id = $rowsdfs['mk_id'];
		$lid = $rowsdfs['id'];
		$raw_download = $rowsdfs['raw_download'];
		$youtube_bandwidth = $rowsdfs['youtube_bandwidth'];
		$raw_upload = $rowsdfs['raw_upload'];
		$total_bandwidth = $rowsdfs['total_bandwidth'];
		$bandwidth_price = $rowsdfs['bandwidth_price'];
		$youtube_price = $rowsdfs['youtube_price'];
		$total_price = $rowsdfs['total_price'];
		$breseller = $rowsdfs['breseller'];
		$box_id = $rowsdfs['box_id'];
		$technician = $rowsdfs['technician'];
		$bill_man = $rowsdfs['bill_man'];
		$termination_date = $rowsdfs['termination_date'];
		$edit_sts = $rowsdfs['edit_sts'];
		$terms = $rowsdfs['terms'];
		$agreementID = $rowsdfs['agreementID'];
		$customerMsisdn = $rowsdfs['customerMsisdn'];
}

if($breseller == '2'){
	$res = mysql_query("SELECT IFNULL((b.bill - p.paid), '0.00') AS total_due FROM clients AS c 
							LEFT JOIN
							(SELECT IFNULL(c_id, '$clientid') AS c_id, IFNULL(SUM(total_price), '0.00') AS bill FROM billing_invoice WHERE sts = '0' AND c_id = '$clientid')b
							ON b.c_id = c.c_id
							LEFT JOIN
							(SELECT IFNULL(c_id, '$clientid') AS c_id, IFNULL((SUM(pay_amount)+SUM(bill_discount)), '0.00') AS paid FROM payment WHERE sts = '0' AND c_id = '$clientid')p
							ON p.c_id = c.c_id
							WHERE c.breseller = '2' AND c.c_id = '$clientid'");

		$rows = mysql_fetch_array($res);
		$Dew = 	$rows['total_due'];
		$pay = $rows['total_due'];
}
else{
		if($mac_user == '0'){
				$resss = mysql_query("SELECT c_id FROM payment WHERE c_id = '$clientid'");
				$rowsss = mysql_fetch_array($resss);
				$c_idd = $rowsss['c_id'];
				if($c_idd == ''){
					$res = mysql_query("SELECT c_id, SUM(bill_amount) AS amt FROM billing WHERE c_id = '$clientid'");
					$rows = mysql_fetch_array($res);
					$Dew = $rows['amt'];
				}
				else{
					$res = mysql_query("SELECT (l.amt - (IFNULL(t.pay,0) + IFNULL(t.dic,0))) AS Dew FROM
										(
											SELECT c_id, SUM(bill_amount) AS amt FROM billing WHERE c_id = '$clientid'
										)l
										LEFT JOIN
										(
											SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment WHERE c_id = '$clientid'
										)t
										ON l.c_id = t.c_id");

					$rows = mysql_fetch_array($res);
					$Dew = 	$rows['Dew'];
				}
			}
			else{
				if($external_online_link_mac == '1'){
				$resss = mysql_query("SELECT c_id FROM payment_mac_client WHERE c_id = '$clientid'");
				$rowsss = mysql_fetch_array($resss);
				$c_idd = $rowsss['c_id'];
				if($c_idd == ''){
					$res = mysql_query("SELECT c_id, SUM(bill_amount) AS amt FROM billing_mac_client WHERE c_id = '$clientid'");
					$rows = mysql_fetch_array($res);
					$Dew = $rows['amt'];
				}
				else{
					$res = mysql_query("SELECT (l.amt - (IFNULL(t.pay,0) + IFNULL(t.dic,0))) AS Dew FROM
										(
											SELECT c_id, SUM(bill_amount) AS amt FROM billing_mac_client WHERE c_id = '$clientid'
										)l
										LEFT JOIN
										(
											SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment_mac_client WHERE c_id = '$clientid'
										)t
										ON l.c_id = t.c_id");

					$rows = mysql_fetch_array($res);
					$Dew = 	$rows['Dew'];
				}
				}
				else{
					$Dew = 	'0';
				}
			}
}


	if($Dew <= 0){
		$pay = 'Alrady Paid';
		$color1 = 'style="color:#555555;font-size: 18px;"';
	}else{
		$pay = $Dew;
		$color1 = 'style="color:red;font-size: 18px;"';					
	}

$pytk = ($Dew*$ext_charge)/100;

$payment_amount = $Dew + $pytk;

$respy = mysql_query("SELECT `id` FROM `payment` ORDER BY id DESC LIMIT 1");
$rowspy = mysql_fetch_array($respy);
	if($rowspy['id'] == ''){
			$invo_no = $shortcode.$y.$m.'1';
		}
		else{
			$new = $rowspy['id'] + 1;
			$invo_no = $shortcode.$y.$m.$new;
		}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>External Online Payment | <?php echo $comp_name;?></title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="icon" type="images/png" href="images/favicon.png"/>

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="js/jquery.autogrow-textarea.js"></script>
<script type="text/javascript" src="js/charCount.js"></script>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script type="text/javascript" src="js/ui.spinner.min.js"></script>
<script type="text/javascript" src="js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/dy_add_input.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/responsive-tables.js"></script>
</head>
<?php if($gateway == 'bKash' && in_array(1, $online_getway)){ ?>
	<script src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
    <meta name="viewport" content="width=device-width" , initial-scale=1.0/>
<?php } else {} ?>
<body class="login-page" style="">
<div class="login-logo">
	<a href="<?php echo $mainlink;?>"><img src="<?php echo $company_main_logo;?>" height="40px" width="175px" /></a>
</div>
<div class="maincontent">
  <div class="maincontentinner">
	<div class="box box-primary">
		<div class="box-header">
			<div class="row-fluid" style="min-height: 650px;">
			<?php if ($c_id != ''){ ?>
                <div class="span4 profile-left" style="margin-bottom: 10px;">
                        <div class="widgetbox tags">
                                <div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 15px;font-weight: bold;background: none;border: 1px solid rgba(0, 0, 0, 0.2);border-bottom: 0px;">
									<div class="pagetitle" style="margin: 0px 0px 2px 0;">
										<center><h4>Welcome To <?php echo $comp_name;?></h4> <center>
									</div>
								</div>
                                    <ul class="taglist">
                                        <table class="table table-bordered table-invoice">
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #2e3e4e;border-top: 1px solid white;border-right: 1px solid white;font-size: 13px;" class="btn-rounded">Total Due</td>
											<td style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;font-weight: bold;'><a <?php echo $color1; ?>><?php echo number_format($Dew,2).'৳'; ?></a></td>
										</tr>
										<?php if(in_array(1, $ext_access)){ ?>
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #337ab7;border-top: 1px solid white;border-right: 1px solid white;" class="btn-rounded">Client ID</td>
											<td style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;font-weight: bold;'><?php echo $c_id;?></td>
										</tr>
										<?php } if(in_array(2, $ext_access)){?>
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #337ab7;border-top: 1px solid white;border-right: 1px solid white;" class="btn-rounded">Com ID</td>
											<td style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;font-weight: bold;'><?php echo $com_id;?></td>
										</tr>
										<?php } if(in_array(3, $ext_access)){?>
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #337ab7;border-top: 1px solid white;border-right: 1px solid white;" class="btn-rounded">Name</td>
											<td style='font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;font-weight: bold;'><?php echo $c_name;?></td>
										</tr>
										<?php } if(in_array(4, $ext_access)){?>
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #337ab7;border-top: 1px solid white;border-right: 1px solid white;" class="btn-rounded">Cell No</td>
											<td><?php echo $cell;?></td>
										</tr>
										<?php } if(in_array(5, $ext_access)){?>
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #337ab7;border-top: 1px solid white;border-right: 1px solid white;" class="btn-rounded">Zone</td>
											<td class="width70" style="font-family: gorgia;"><?php echo $z_name.' ('.$b_name.')'; ?></td>
										</tr>
										<?php } if($breseller != '2'){ if(in_array(6, $ext_access)){?>
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #337ab7;border-top: 1px solid white;border-right: 1px solid white;" class="btn-rounded">Package</td>
											<td><?php echo $p_name;?>-<?php echo $bandwith;?> (<?php echo $p_price;?>TK)</td>
										</tr>
										<?php } if(in_array(7, $ext_access)){?>
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #337ab7;border-top: 1px solid white;border-right: 1px solid white;" class="btn-rounded">User Type</td>
											<td><?php echo $con_type;?> (<?php echo $connectivity_type;?>)</td>
										</tr>
										<?php } if(in_array(8, $ext_access)){?>
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #337ab7;border-top: 1px solid white;border-right: 1px solid white;" class="btn-rounded">Connectivity</td>
											<td><?php echo $connectivity_type;?></td>
										</tr>
										<?php } } if(in_array(9, $ext_access)){ ?>
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #337ab7;border-top: 1px solid white;border-right: 1px solid white;" class="btn-rounded">Joining Date</td>
											<td><?php echo $join_date;?></td>
										</tr>
										<?php } if(in_array(10, $ext_access)){?>
										<tr>
											<td style="border-left: 1px solid #ddd;border-bottom: 1px solid white;font-weight: bold;text-align: right;color: #337ab7;border-top: 1px solid white;border-right: 1px solid white;" class="btn-rounded">Line Status</td>
											<?php if($con_sts = 'Active'){?>
											<td style="color: green;font-weight: bold;">Active</td>
											<?php } else{ ?>
											<td style="color: red;font-weight: bold;">Inactive</td>
											<?php } ?>
										</tr>
										<?php } ?>
									</table>
                                    </ul>
                        </div>
                </div>
                <div class="span8">
	<?php if($error != '' && $gateway != '') {?>
		<div class="alert alert-error">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Payment Unsuccessful!!</strong> <?php echo $error;?>.
		</div><!--alert-->
	<?php } if($sts == 'faild'){?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Payment has been Faild!!</strong> Please try again.
			</div><!--alert-->
	<?php } if($sts == 'canceled' && $gateway != 'SSLCommerz'){?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Payment has been canceled!!</strong>.
			</div><!--alert-->
	<?php } if($sts == 'success'){?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Payment Successful!!</strong> Thanks for your payment.
			</div><!--alert-->
	<?php } if($sts == 'done'){?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $payment; ?> TK Successfully paid by <?php echo $mode; ?>.
			</div><!--alert-->
	<?php } ?>
						<div class="modal-content">
						<?php if($gateway == 'bKash' && in_array(1, $online_getway)){ ?>
							<div class="modal-footer">
							<?php if($Dew > '2'){if(in_array(4, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=Rocket"><img src="imgs/rocket_s.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
							<?php } if(in_array(5, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=Nagad"><img src="imgs/nagad_s.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
							<?php } if(in_array(2, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=iPay"><img src="imgs/ip_rbttn.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;"></a>
							<?php } if(in_array(3, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=SSLCommerz"><img src="imgs/ssl.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
							<?php }} ?>
							</div>
							<table class="table table-bordered table-invoice" style="width: 100%;font-family: gorgia;">
										
										<tr>
											<td class="width30" style="font-size: 15px;font-weight: bold;text-align: right;border-left: none;">Invoice No</td>
											<td class="width70" style="border-right: none;"><strong style="font-size: 15px;font-weight: bold;font-family: gorgia;"><?php echo $invo_no;?></strong></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Method</td>
											<td style="font-size: 13px;font-weight: bold;border-right: none;"><?php echo $gateway;?></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Due Amount</td>
											<td style="font-size: 13px;font-weight: bold;border-right: none;">৳ <?php echo number_format($Dew,2); ?></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Service Charge</td>
											<td style="font-size: 13px;font-weight: bold;border-right: none;">৳ <?php echo number_format($pytk,2); ?></td>
										</tr>
										<tr>
											<td style="font-size: 17px;font-weight: bold;text-align: right;border-left: none;">Payable Amount</td>
											<td style="font-size: 22px;font-weight: bold;color: firebrick;border-right: none;color:red;">৳ <?php echo number_format($payment_amount,2); ?></td>
										</tr>
							</table>
							<div class="modal-footer">
							<?php if($Dew < '2'){?> <h3>You have not any due.</h3> <?php } else{ ?>
								<input type="image" id="bKash_button" name="submit" src="imgs/bk_btn.png" border="0" alt="Submit" style="width: 200px;" />
							<?php } ?>
							</div>
						<?php } elseif($gateway == 'bKashT' && in_array(6, $online_getway)){ include('ttoken.php');?>
							<div class="modal-footer">
							<?php if($Dew > '2'){if(in_array(4, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=Rocket"><img src="imgs/rocket_s.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
							<?php } if(in_array(5, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=Nagad"><img src="imgs/nagad_s.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
							<?php } if(in_array(2, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=iPay"><img src="imgs/ip_rbttn.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;"></a>
							<?php } if(in_array(3, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=SSLCommerz"><img src="imgs/ssl.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
							<?php }} ?>
							</div>
							<table class="table table-bordered table-invoice" style="width: 100%;font-family: gorgia;">
										
										<tr>
											<td class="width30" style="font-size: 15px;font-weight: bold;text-align: right;border-left: none;">Invoice No</td>
											<td class="width70" style="border-right: none;"><strong style="font-size: 15px;font-weight: bold;font-family: gorgia;"><?php echo $invo_no;?></strong></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Method</td>
											<td style="font-size: 13px;font-weight: bold;border-right: none;"><?php echo $gateway;?></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Due Amount</td>
											<td style="font-size: 13px;font-weight: bold;border-right: none;">৳ <?php echo number_format($Dew,2); ?></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Service Charge</td>
											<td style="font-size: 13px;font-weight: bold;border-right: none;">৳ <?php echo number_format($pytk,2); ?></td>
										</tr>
										<tr>
											<td style="font-size: 17px;font-weight: bold;text-align: right;border-left: none;">Payable Amount</td>
											<td style="font-size: 22px;font-weight: bold;color: firebrick;border-right: none;color:red;">৳ <?php echo number_format($payment_amount,2); ?></td>
										</tr>
							</table>
							<div class="modal-footer">
							<?php if($Dew < '2'){ ?> <h3>You have not any due.</h3> <?php } else{ 
								session_regenerate_id();
									$_SESSION['invo_no'] = $invo_no;
									$_SESSION['payment_amount'] = number_format($payment_amount,2, '.', '');
									$_SESSION['dewamount'] = number_format($Dew,2, '.', '');
									$_SESSION['wayyy'] = 'client';
									$_SESSION['gateway'] = $gateway;
									$_SESSION['payfrom'] = 'external';
									$_SESSION['external_clientid'] = $c_id;
								session_write_close();
								?>
								<form name="form" method="post" action="tcreateagree.php" enctype="multipart/form-data" style="float: right;">
									<input type="hidden" name="payerReference" value="<?php echo $c_id;?>">
									<input type="hidden" name="callbackURL" value="<?php echo $zsfgg;?>">
									<button class="btn ownbtn2" type="submit">Pay With New bKash</button>
								</form>
								<?php if($agreementID != ''){?>
								<form name="form" method="post" action="tcreatepayment.php" enctype="multipart/form-data" style="float: right;margin-right: 5px;">
									<input type="hidden" name="payerReference" value="<?php echo $c_id;?>">
									<input type="hidden" name="agreementID" value="<?php echo $agreementID;?>">
									<input type="hidden" name="invo_no" value="<?php echo $invo_no;?>">
									<input type="hidden" name="payment_amount" value="<?php echo number_format($payment_amount,2, '.', '');?>">
									<input type="hidden" name="callbackURL" value="<?php echo $zsfgg1;?>">
									
									<button class="btn ownbtn4" type="submit">Pay by (<?php echo $customerMsisdn;?>)</button>
								</form>
							<?php }} ?>
							</div>
						<?php } elseif($gateway == 'iPay' && in_array(2, $online_getway)){ ?>
							<div class="modal-footer">
									<?php if($Dew > '2'){if(in_array(1, $online_getway)){?>
										<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=bKash"><img src="imgs/bk_rbttn.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
									<?php } if(in_array(4, $online_getway)){?>
										<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=Rocket"><img src="imgs/rocket_s.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
									<?php } if(in_array(5, $online_getway)){?>
										<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=Nagad"><img src="imgs/nagad_s.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
									<?php } if(in_array(3, $online_getway)){?>
										<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=SSLCommerz"><img src="imgs/ssl.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
									<?php }} ?>
							</div>
							<form name="form1" class="stdform" method="post" action="PaymentOnlineQuery?gateway=<?php echo $gateway;?>&payfrom=external" enctype="multipart/form-data">
								<input type="hidden" name="invoice" value="<?php if($sts=='faild' || $sts=='canceled'){echo $invo_no.$ss;} else{echo $invo_no;}?>">
								<input type="hidden" name="wayyy" value="client">
								<input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
								<input type="hidden" name="description" value="Internet Bill Pay">
								<input type="hidden" name="payment_amount" value="<?php echo $payment_amount;?>">
								<input type="hidden" name="dewamount" value="<?php echo '&dewamount='.$Dew.'&amount='.$payment_amount;?>">
								<table class="table table-bordered table-invoice" style="width: 100%;font-family: gorgia;">
										<tr>
											<td class="width30" style="font-size: 15px;font-weight: bold;text-align: right;border-left: none;">Invoice No</td>
											<td class="width70" style="border-right: none;"><strong style="font-size: 15px;font-weight: bold;font-family: gorgia;"><?php echo $invo_no;?></strong></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Method</td>
											<td style="font-size: 13px;font-weight: bold;border-right: none;"><?php echo $gateway;?></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Due Amount</td>
											<td style="font-size: 13px;font-weight: bold;border-right: none;">৳ <?php echo number_format($Dew,2); ?></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Service Charge</td>
											<td style="font-size: 13px;font-weight: bold;border-right: none;">৳ <?php echo number_format($pytk,2); ?></td>
										</tr>
										<tr>
											<td style="font-size: 17px;font-weight: bold;text-align: right;border-left: none;">Payable Amount</td>
											<td style="font-size: 22px;font-weight: bold;color: firebrick;border-right: none;color:red;">৳ <?php echo number_format($payment_amount,2); ?></td>
										</tr>
								</table>
							<div class="modal-footer">
							<?php if($Dew < '2'){?> <h3>You hant any due.</h3> <?php } else{ ?>
								<button class="btn ownbtn2" type="submit">Pay With iPay</button>
							<?php } ?>
							</div>
							</form>
						<?php } elseif($gateway == 'SSLCommerz' && in_array(3, $online_getway)){ ?>
							<div class="modal-footer">
									<?php if($Dew > '2'){if(in_array(1, $online_getway)){?>
										<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=bKash"><img src="imgs/bk_rbttn.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
									<?php } if(in_array(4, $online_getway)){?>
										<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=Rocket"><img src="imgs/rocket_s.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
									<?php } if(in_array(5, $online_getway)){?>
										<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=Nagad"><img src="imgs/nagad_s.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
									<?php } if(in_array(2, $online_getway)){?>
										<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=iPay"><img src="imgs/ip_rbttn.png" style="margin-right: 10px;width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
									<?php }} ?>
							</div>
							<form name="form1" class="stdform" method="post" action="PaymentOnlineQuery?gateway=<?php echo $gateway;?>&payfrom=external" enctype="multipart/form-data">
							<input type="hidden" name="invoice" value="<?php echo $invo_no;?>">
							<input type="hidden" name="wayyy" value="client">
							<input type="hidden" name="c_id" value="<?php echo $c_id;?>">
							<input type="hidden" name="cell" value="<?php echo $cell;?>">
							<input type="hidden" name="address" value="<?php echo $address; ?>">
							<input type="hidden" name="description" value="Internet Bill Pay">
							<input type="hidden" name="payment_amount" value="<?php echo $payment_amount;?>">
							<input type="hidden" name="dewamount" value="<?php echo $Dew;?>">
							<input type="hidden" name="amount" value="<?php echo $payment_amount;?>">
								<table class="table table-bordered table-invoice" style="width: 100%;font-family: gorgia;">
									<tr>
										<td class="width30" style="font-size: 15px;font-weight: bold;text-align: right;border-left: none;">Invoice No</td>
										<td class="width70" style="border-right: none;"><strong style="font-size: 15px;font-weight: bold;font-family: gorgia;"><?php echo $invo_no;?></strong></td>
									</tr>
									<tr>
										<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Method</td>
										<td style="font-size: 13px;font-weight: bold;border-right: none;"><?php echo $gateway;?></td>
									</tr>
									<tr>
										<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Due Amount</td>
										<td style="font-size: 13px;font-weight: bold;border-right: none;">৳ <?php echo number_format($Dew,2); ?></td>
									</tr>
									<tr>
										<td style="font-size: 13px;font-weight: bold;text-align: right;border-left: none;">Service Charge</td>
										<td style="font-size: 13px;font-weight: bold;border-right: none;">৳ <?php echo number_format($pytk,2); ?></td>
									</tr>
									<tr>
										<td style="font-size: 17px;font-weight: bold;text-align: right;border-left: none;">Payable Amount</td>
										<td style="font-size: 22px;font-weight: bold;color: firebrick;border-right: none;color:red;">৳ <?php echo number_format($payment_amount,2); ?></td>
									</tr>
								</table>
							<div class="modal-footer">
								<?php if($Dew < '2'){?> <h3>You have not any due.</h3> <?php } else{ ?>
								<button class="btn ownbtn2" type="submit">Pay With SSLCommerz</button>
								<?php } ?>
							</div>
							</form>
						<?php } else{ ?>
							<div class="modal-header">
								<h5>Please Choose Payment Method</h5>
							</div>
							<div class="modal-body" style="text-align: center;">
							<?php if($Dew > '2'){
								if(in_array(1, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=bKash"><img src="imgs/bk_rbttn.png" style="margin-right: 10px;width: 80px;padding: 0px;margin-top: -3px;"></a>
								<?php } if(in_array(6, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=bKashT"><img src="imgs/bk_rbttn.png" style="margin-right: 10px;width: 80px;padding: 0px;margin-top: -3px;"></a>
								<?php } if(in_array(4, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=Rocket"><img src="imgs/rocket_s.png" style="margin-right: 10px;width: 80px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
								<?php } if(in_array(5, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=Nagad"><img src="imgs/nagad_s.png" style="margin-right: 10px;width: 80px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
								<?php } if(in_array(2, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=iPay"><img src="imgs/ip_rbttn.png" style="margin-right: 10px;width: 80px;padding: 0px;margin-top: -3px;"></a>
								<?php } if(in_array(3, $online_getway)){?>
								<a href="PaymentOnlineExternal?clientid=<?php echo $clientid;?>&gateway=SSLCommerz"><img src="imgs/ssl_big.png" style="width: 250px;padding: 5px 0 0 0px;border-radius: 10px;height: 70px;"></a>
							<?php }} ?>
							</div>
					<?php } ?>
						</div>
                </div><!--span8-->
			<?php } else{ ?>
				<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: red;padding: 5px 0px 4px 15px;font-weight: bold;background: none;">
					<div class="pagetitle" style="margin: 0px 0px 2px 0;">
						<center><h3>Invalid Details.</h3> <center>
					</div>
				</div>
			<?php } ?>
            </div><!--row-fluid-->
		</div>
	</div>

		<div class="login-footer" style="bottom: 0;font-family: helvetica;left: 0;padding: 0.1% 0 0.2% 0.7%;position: fixed;right: 0;width: 100%;">
			<?php echo $footer; ?>
		</div>
</div>		
</div>
</body>
</html>
<?php if($gateway == 'bKash' && in_array(1, $online_getway)){ ?>
<code class="language-javascript">
<script type="text/javascript">
    $(document).ready(function () {
            //Token
            $.ajax({
                        url: 'token.php',
                        type: 'POST',
                        contentType: 'application/json',
                        success: function (data) {
                            console.log('got data from token  ..');
                        }
                    });

            var paymentConfig;
			paymentConfig = { createCheckoutURL: 'createpayment.php', executeCheckoutURL: 'executepayment.php' };


            var paymentRequest;
            paymentRequest = { amount: <?php echo number_format($payment_amount, 2, '.', ''); ?>, intent: 'bill' };

            bKash.init({

                paymentMode: 'checkout',

                paymentRequest: paymentRequest,


                createRequest: function (request) {

                    console.log('=> createRequest (request) :: ');
                    console.log(request);


                    $.ajax({
                        url: paymentConfig.createCheckoutURL+"?amount="+paymentRequest.amount,
                        type: 'GET',
                        contentType: 'application/json',
                        success: function (data) {
                            console.log('got data from create  ..');
                            console.log('data ::=>');
                            console.log(JSON.parse(data).paymentID);
                            data = JSON.parse(data);
                            if (data && data.paymentID != null) {
                                paymentID = data.paymentID;
                                bKash.create().onSuccess(data);      
                            } else {
                                bKash.create().onError();
                            }
                        },
                        error: function () {
                            bKash.create().onError();

                        }
                    });
                },
                executeRequestOnAuthorization: function () {

                    console.log('=> executeRequestOnAuthorization');
                    $.ajax({
                        url: paymentConfig.executeCheckoutURL+"?paymentID="+paymentID,
                        type: 'POST',
                        contentType: 'application/json',
                        success: function (data) {
                            console.log('got data from execute  ..');
                            console.log('data ::=>');
                            console.log(JSON.stringify(data));
                            data = JSON.parse(data);
                             if (data && data.paymentID != null) {
								window.location.href = "PaymentOnlineQuery.php?paymentID="+data.paymentID+"&trxID="+data.trxID+"&createTime="+data.createTime+"&updateTime="+data.updateTime+"&transactionStatus="+data.transactionStatus+"&intent="+data.intent+"&merchantInvoiceNumber="+data.merchantInvoiceNumber+"&amount="+data.amount+"&gateway=bKash&wayyy=client&e_id=<?php echo $c_id;?>&payfrom=external&dewamount="+<?php echo $Dew;?>;
                            } else {
//								alert(data.errorMessage);
                                window.location.href = "PaymentOnlineExternal?clientid=<?php echo $c_id;?>&gateway=bKash&error="+data.errorMessage;
                            }
                        },
                        error: function () {
							alert(data.errorMessage);
                        }
                    });
                },
				onClose: function(){
					window.location.href='PaymentOnlineExternal?clientid=<?php echo $c_id;?>&gateway=bKash';  // Your redirect route when cancel payment
				}
            });
//			$('#bKash_button').removeAttr('disabled');
        });
</script>
</code>
	<?php } ?>
<style>
  .rhdhyher {
	  border: 1px solid white;
	  font-weight: bold;
	  text-align: right;
	  color: #337ab7;
  }
</style>
<?php } else{echo 'File not found.';}?>