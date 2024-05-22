<?php
$titel = "SMS";
$SMS = 'active';
include('include/hader.php');
include("conn/connection.php");
$zone_id = isset($_GET['zid']) ? $_GET['zid'] : '';
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'SMS' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
ini_alter('date.timezone','Asia/Almaty');
$today55 = date('Y-m-d', time());


if($userr_typ == 'mreseller'){
	$sql88tt = ("SELECT s.id, s.link, s.username, s.password, s.status, e.e_cont_per FROM sms_setup AS s LEFT JOIN emp_info AS e ON e.z_id = s.z_id WHERE s.status = '0' AND s.z_id = '$macz_id'");
	
	$querytt = mysql_query($sql88tt);
	$smsclients = mysql_num_rows($querytt);
	$rowtt = mysql_fetch_assoc($querytt);
			$link= $rowtt['link'];
			$username= $rowtt['username'];
			$password= $rowtt['password'];
			$status= $rowtt['status'];
}
else{
	if($zone_id == 'all' || $zone_id == ''){
		$sql88tt = ("SELECT id, link, username, password, status FROM sms_setup WHERE status = '0' AND z_id = ''");
		
		$querytt = mysql_query($sql88tt);
		$smsclients = mysql_num_rows($querytt);
		$rowtt = mysql_fetch_assoc($querytt);
				$link= $rowtt['link'];
				$username= $rowtt['username'];
				$password= $rowtt['password'];
				$status= $rowtt['status'];
	}
	else{
		$username= 'not_empty';
		$password = $zone_id;
	}
}

$full_link= 'http://smpp.ajuratech.com/sms/smsConfiguration/smsClientBalance.jsp?client='.$password;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $full_link); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable 
curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
$balance = curl_exec($ch);
$smsapi = json_decode($balance, true);
$balance = $smsapi['Balance'];


$resultsdfg=mysql_query("SELECT IFNULL(s.z_id,'main') AS z_id, s.password, IFNULL(e.e_name,s.password) AS resellername, IFNULL(z.z_name,'Main SMS') AS z_name FROM sms_setup AS s
LEFT JOIN zone AS z ON z.z_id = s.z_id
LEFT JOIN emp_info AS e ON z.z_id = e.z_id
ORDER BY s.z_id ASC");

if($userr_typ == 'mreseller'){
$query22="SELECT box_id, b_name, location FROM box WHERE z_id = '$macz_id' AND sts = '0' order by b_name";
$sql8u8 = mysql_query("SELECT * FROM sms_setup WHERE z_id = '$macz_id'");
$resellersms = mysql_num_rows($sql8u8);
}
else{
$query22="SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id = '' order by z.z_name";
}
$result22=mysql_query($query22);

$query202="SELECT c_id, c_name FROM clients WHERE sts = '0' AND mac_user = '0' order by c_name";
$result220=mysql_query($query202);

$result20=mysql_query("SELECT * FROM emp_info WHERE dept_id != '0' AND status = '0' order by e_name");

$sqllimi = mysql_query("SELECT cell FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
								WHERE c.sts = '0' AND t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.mac_user = '0' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.cell REGEXP '^-?[0-9]+$'");
$total_clients = mysql_num_rows($sqllimi);

$querysms = "DELETE FROM sms_send WHERE id <= ( SELECT id FROM ( SELECT id FROM sms_send ORDER BY id DESC LIMIT 1 OFFSET 1500 ) foo )";
if(!mysql_query($querysms)){die('Error: ' . mysql_error());}

$querysms11 = "DELETE FROM log_info WHERE id <= ( SELECT id FROM ( SELECT id FROM log_info ORDER BY id DESC LIMIT 1 OFFSET 1500 ) foo )";
if(!mysql_query($querysms11)){die('Error: ' . mysql_error());}

$querysms111 = "DELETE FROM realtime_speed WHERE id <= ( SELECT id FROM ( SELECT id FROM realtime_speed ORDER BY id DESC LIMIT 1 OFFSET 1000 ) foo )";
if(!mysql_query($querysms111)){die('Error: ' . mysql_error());}

$querysmsss = "DELETE FROM emp_log WHERE id <= ( SELECT id FROM ( SELECT id FROM emp_log ORDER BY id DESC LIMIT 1 OFFSET 500 ) foo )";
if(!mysql_query($querysmsss)){die('Error: ' . mysql_error());}

$querysmsssdd = "DELETE FROM app_search WHERE id <= ( SELECT id FROM ( SELECT id FROM app_search ORDER BY id DESC LIMIT 1 OFFSET 100 ) foo )";
if(!mysql_query($querysmsssdd)){die('Error: ' . mysql_error());}

$querysmsssddd = "DELETE FROM con_sts_log WHERE id <= ( SELECT id FROM ( SELECT id FROM con_sts_log ORDER BY id DESC LIMIT 1 OFFSET 10000 ) foo )";
if(!mysql_query($querysmsssddd)){die('Error: ' . mysql_error());}

$querysmsssdddd = "DELETE FROM network_sync_log WHERE id <= ( SELECT id FROM ( SELECT id FROM network_sync_log ORDER BY id DESC LIMIT 1 OFFSET 1000 ) foo )";
if(!mysql_query($querysmsssdddd)){die('Error: ' . mysql_error());}

$querysmsssdddds = "DELETE FROM login_cookie WHERE id <= ( SELECT id FROM ( SELECT id FROM login_cookie WHERE sts = '1' ORDER BY id DESC LIMIT 1 OFFSET 500 ) foo )";
if(!mysql_query($querysmsssdddds)){die('Error: ' . mysql_error());}

$quedddds = "DELETE FROM mk_active_count WHERE date_time < DATE_SUB(CURDATE(), INTERVAL 3 DAY)";
if(!mysql_query($quedddds)){die('Error: ' . mysql_error());}


if($userr_typ == 'mreseller'){
	$sqlsdf = mysql_query("SELECT sms_msg, from_page, variable FROM sms_msg WHERE from_page = 'Due Bill' AND z_id = '$macz_id'");
	
	$sqlqqmm = mysql_query("SELECT e_name AS reseller_fullnamee, e_cont_per AS reseller_celll FROM emp_info WHERE z_id = '$macz_id'");
	$row22m = mysql_fetch_assoc($sqlqqmm);
	$reseller_fullnamee = $row22m['reseller_fullnamee'];
	$reseller_celll = $row22m['reseller_celll'];
}
else{
	$sqlsdf = mysql_query("SELECT sms_msg, from_page, variable FROM sms_msg WHERE id= '4'");
}
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];
$variable= $rowsm['variable'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2266">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div id='Pointdiv1'></div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="SMSDueBillSave">
	<input type="hidden" name="send_by" value="<?php echo $e_id;?>" />
	<input type="hidden" name="from_page" value="<?php echo $from_page;?>" />
	<input type="hidden" name="userr_typ" value="<?php echo $user_type;?>" />
	<input type="hidden" name="way" value="all" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5" style="margin: 0;">Send SMS to Due Bill Clients</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-2" style="margin-bottom: 15px;width: 100%;">
							<?php if($userr_typ == 'mreseller'){ ?>
										<select data-placeholder="Choose a Zone" name="box_id" id="box_id" class="chzn-select"  style="width:340px;">
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result22)) { ?>
											<option value="<?php echo $row['box_id']?>"><?php echo $row['b_name']; ?> (<?php echo $row['b_name'];?>)</option>
												<?php } ?>
										</select>
										<input type="hidden" name="z_id" value="<?php echo $macz_id;?>" />
										<input type="hidden" name="reseller_fullnamee" value="<?php echo $reseller_fullnamee;?>" />
										<input type="hidden" name="reseller_celll" value="<?php echo $reseller_celll;?>" />
									<?php } else{ ?>
										<select data-placeholder="Choose a Zone" name="z_id" id="z_id" class="chzn-select" style="width:340px;" required="">
											<?php if($total_clients < '500'){?><option value="all"> All Zone </option><?php } else{?><option> Choose a Zone </option><?php } ?>
												<?php while ($row=mysql_fetch_array($result22)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?></option>
												<?php } ?>
										</select>
									<?php } ?>
							<div style="float: right;"><i class="iconfa-phone" style="font-size: 24px;float: left;"></i><div id="resultpack" style="font-weight: bold;font-size: 25px;padding: 0px 20px 0px 8px;float: left;color: red;"></div></div>
						</div>
						
						<div class="col-2" style="margin-bottom: 15px;width: 100%;">
							<input type="radio" name="con_sts" id="con_sts" value="Active" checked="checked"> Active &nbsp; &nbsp;
							<input type="radio" name="con_sts" id="con_sts" value="Inactive"> Inactive &nbsp; &nbsp;
							<input type="radio" name="con_sts" id="con_sts" value="all"> Both &nbsp; &nbsp;
						</div>
						<br>
						<div class="col-2" style="width: 100%;">
							<div style="width: 65%;float: left;">
								<textarea type="text" name="sms_msg" style="width:100%;height: 225px;" required="" id="sms_msg" placeholder="" class="input-large" /><?php echo $sms_msg;?></textarea>
							</div>
							<div style="width: 30%;float: right;">
								<?php echo $variable;?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal10">
	<form id="form2" class="stdform" method="post" action="SMSDueBillClientSave">
	<input type="hidden" name="send_by" value="<?php echo $e_id;?>" />
	<input type="hidden" name="way" value="all" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Send SMS to Due Bill Clients</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Client</div>
						<div class="col-2">
							<select data-placeholder="Choose a Client" name="c_id" class="chzn-select"  style="width:345px;">
								<option selected> Choose a Client </option>
									<?php while ($row=mysql_fetch_array($result220)) { ?>
								<option value="<?php echo $row['c_id']?>"><?php echo $row['c_id']?> - <?php echo $row['c_name']; ?></option>
									<?php } ?>
							</select>
						</div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal11">
	<form id="form2" class="stdform" method="post" action="SMSDueBillSave">
	<input type="hidden" name="way" value="billman" />
	<input type="hidden" name="e_id" value="<?php echo $e_id;?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Send SMS to Billman Wise Due Clients</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Choose Bill Man</div>
						<div class="col-2">
							<select data-placeholder="Choose a Bill Man" name="bill_man" class="chzn-select"  style="width:345px;">
								<option selected> Choose a Bill Man </option>
									<?php while ($row=mysql_fetch_array($result20)) { ?>
								<option value="<?php echo $row['e_id']?>"><?php echo $row['e_name']; ?> (<?php echo $row['e_id']; ?>)</option>
									<?php } ?>
							</select>
						</div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal112">
	<form id="form2" class="stdform" method="post" action="SMSFaildResend">
	<input type="hidden" name="send_by" value="<?php echo $e_id;?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Re-Send All Faild SMS (Date Wise)</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;font-size: 15px;">Choose Date</div>
						<div class="col-2">
							<input type="text" name="send_date" id="" class="input-large" value="<?php echo $today55;?>" required=""/>
							<div style="color: red;font-weight: bold;">YYYY-MM-DD</div>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1"></div>
						<div class="col-2" style="color: red;font-weight: bold;">This date all faild SMS will Re-Send</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
		<?php if($userr_typ == 'mreseller'){if($resellersms > 0){?>
			<a class="btn ownbtn2" href="SMSDueBillWrite" data-toggle="modal1"> SMS Due Bill</a>
			<a class="btn ownbtn3" href="#myModal" data-toggle="modal"> Due Bill</a>
			<a class="btn ownbtn9" href="SMSMultiAdd?id=ZoneWiseSMS"> Zone Wise SMS</a>
			<a class="btn ownbtn5" href="SMSMultiAdd?id=PackageWiseSMS"> Package Wise SMS</a>
			<a class="btn ownbtn7" href="SMSAdd"> Send SMS</a>
			<a class="btn" style="border-radius: 3px;border: 1px solid #a0f;color: #a0f;padding: 6px 9px;" href="SMSSettings" title='SMS Settings & Templates'><i class="iconfa-cogs"></i></a>
		<?php }} else{ if($userr_typ == 'admin' || $userr_typ == 'superadmin'){?>
						<form method="GET" action="SMS" style="float: left;margin-right: 4px;">
							<select name="zid" style="border: 1px solid #317eac;color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;border-radius: 3px;" onchange="submit();">
									<option value="all" style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;">All SMS</option>
									<?php while ($row345=mysql_fetch_array($resultsdfg)) { ?>
											<option style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;" value="<?php echo $row345['password']?>"<?php if ($row345['password'] == $zone_id) echo 'selected="selected"';?>><?php echo $row345['z_name']; ?> - <?php echo $row345['resellername'];?></option>
									<?php } ?>
							</select>
						</form>
			<?php } ?>
				<div class="input-append">
					<div class="btn-group">
						<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid green;color: green;font-size: 14px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;">SMS To Due Clients <span class="caret" style="border-top: 4px solid green;"></span></button>
						<ul class="dropdown-menu">
							<li><a style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #3A8EE1;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Write SMS for Due Clients" href="SMSDueBillWrite">Write SMS</a></li>
							<li><a style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: brown;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Sent Due Bill SMS" data-toggle="modal" href="#myModal"> Due Bill</a></li>
							<li><a style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: seagreen;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" href="#myModal10" data-toggle="modal" title="Due Bill SMS to One Client"> Client Due Bill</a></li>
							<li><a style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #8b008bc4;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" href="#myModal11" data-toggle="modal" title="Billman Wise Due Bill SMS"> Billman Wise</a></li>
						</ul>
					</div>
				</div>
				<div class="input-append">
					<div class="btn-group">
						<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid #0000ffbf;color: #0000ffbf;font-size: 14px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;">Multi SMS <span class="caret" style="border-top: 4px solid #0000ffbf;"></span></button>
						<ul class="dropdown-menu">
							<li><a style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #0000ffbf;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Send SMS to Zone All Clients" href="SMSMultiAdd?id=ZoneWiseSMS">Zone Wise</a></li>
							<li><a style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: green;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Send SMS to Package All Clients" href="SMSMultiAdd?id=PackageWiseSMS">Package Wise</a></li>
							<li><a style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #a0f;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Send Welcome SMS" href="SMSMultiAdd?id=Welcome">Welcome</a></li>
						</ul>
					</div>
				</div>
			<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: red;border: 1px solid red;font-size: 14px;" href="#myModal112" data-toggle="modal" title="Re-Send Date Wise All Faild SMS"> Faild Re-Send</a>
			<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: green;border: 1px solid green;font-size: 14px;" href="SMSSavedTemplates" title="Saved Templates"> Saved Templates</a>
			<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: blue;border: 1px solid blue;font-size: 14px;" href="SMSAdd" title="Send SMS to Any Number"> Send SMS</a>
			<a class="btn" style="border-radius: 3px;border: 1px solid green;color: green;padding: 5px 8px;font-size: 17px;" href="sms_deliverey_report?api_id=checkall" target='_blank' title='Update Delevery Report'><i class="iconfa-check"></i></a>
			<a class="btn" style="border-radius: 3px;border: 1px solid #a0f;color: #a0f;padding: 5px 8px;font-size: 17px;" href="SMSSettings" title='SMS Settings & Templates'><i class="iconfa-cogs"></i></a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-comment"></i></div>
        <div class="pagetitle">
            <h1>SMS</h1>
        </div>
    </div><!--pageheader-->
	<?php if ($sts == 'smssent'){?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			 <strong>Successfully!!</strong> Your SMS successfully Send.
		</div>
	<?php } if ($sts == 'smsresent'){?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			 <strong>Successfully!!</strong> Your SMS successfully Re-Send.
		</div>
	<?php } if ($sts == 'multismsresent'){?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			 <strong>Successfully!!</strong> Your SMS successfully Re-Send.
		</div>
	<?php } ?>
		<div class="box box-primary">
			<div class="box-header">
				<a style="font-size: 20px;"><b><?php if($username == ''){echo 'API Not Active';} else{ echo 'Balance: '.number_format($balance,2).' TK';}?></b></a>
			</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
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
							<th class="head1">ID</th>
							<th class="head0">Client</th>
							<th class="head1">Cell No</th>
							<th class="head0">SMS Text</th>
							<th class="head1">From</th>
							<th class="head0">Sender</th>
							<th class="head1 center">Time</th>
							<th class="head1 center">Status</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						if($userr_typ == 'mreseller'){
							if($resellersms > 0){
							$sql = mysql_query("SELECT s.id, s.c_id, s.c_cell, s.sms_body, s.from_page, l.user_name, DATE_FORMAT(s.send_date_time, '%D %M %Y %h:%i%p') AS send_date_time, s.api_id, s.delivery_report FROM sms_send AS s 
													LEFT JOIN login AS l
													ON l.e_id = s.send_by
													WHERE s.status = '0' AND s.username = '$password' ORDER BY s.id desc LIMIT 1500");
							}
						}
						else{
							if($zone_id == 'all' || $zone_id == ''){
								$sql = mysql_query("SELECT s.id, s.c_id, s.c_cell, s.sms_body, s.from_page, l.user_name, DATE_FORMAT(s.send_date_time, '%D %M %Y %h:%i%p') AS send_date_time, s.api_id, s.delivery_report FROM sms_send AS s 
													LEFT JOIN login AS l
													ON l.e_id = s.send_by
													WHERE s.status = '0' ORDER BY s.id desc LIMIT 1500");								
							}
							else{
								$sql = mysql_query("SELECT s.id, s.c_id, s.c_cell, s.sms_body, s.from_page, l.user_name, DATE_FORMAT(s.send_date_time, '%D %M %Y %h:%i%p') AS send_date_time, s.api_id, s.delivery_report FROM sms_send AS s 
													LEFT JOIN login AS l
													ON l.e_id = s.send_by
													WHERE s.status = '0' AND s.username = '$zone_id' ORDER BY s.id desc LIMIT 1500");								
							}
						}
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['api_id'] != '' && $row['delivery_report'] != '')
									{
										$delivery = "<button href='#myModal2266' style='padding: 6px 9px;' data-toggle='modal' data-placement='top' data-rel='tooltip' title='Deliverey Report' type='submit' value='{$row['api_id']}' class='btn ownbtn3' onClick='getRoutePoint(this.value)'>{$row['api_id']}</button>";
										if($row['delivery_report'] == 'DELIVRD'){
											$report = "<span class='label label-success' style='font-weight: bold;margin-top: 5px;border-radius: 3px;width: 70px;display: inline-block;'>{$row['delivery_report']}</span>";
										}
										elseif($row['delivery_report'] == 'SENT'){
											$report = "<span class='label label-info' style='font-weight: bold;margin-top: 5px;border-radius: 3px;width: 70px;display: inline-block;'>{$row['delivery_report']}</span>";
										}
										elseif($row['delivery_report'] == 'REJECTD'){
											$report = "<span class='label label-important' style='font-weight: bold;margin-top: 5px;border-radius: 3px;width: 70px;display: inline-block;'>{$row['delivery_report']}</span>";
										}
										else{
											$report = "<span class='label label-inverse' style='font-weight: bold;margin-top: 5px;border-radius: 3px;width: 70px;display: inline-block;'>{$row['delivery_report']}</span>";
										}
										$colorr = 'style="color: blue;font-weight: bold;"';
									}
									else{
										$delivery = "<button href='#myModal2266' style='padding: 6px 9px;' data-toggle='modal' data-placement='top' data-rel='tooltip' title='Deliverey Report' type='submit' value='{$row['api_id']}' class='btn ownbtn3' onClick='getRoutePoint(this.value)'>{$row['api_id']}</button>";
										$report = "";
										$colorr = 'style="color: red;font-weight: bold;;"';
									}
									echo
										"<tr class='gradeX'>
											<td>{$row['id']}</td>
											<td>{$row['c_id']}</td>
											<td>{$row['c_cell']}</td>
											<td>{$row['sms_body']}</td>
											<td>{$row['from_page']}</td>
											<td>{$row['user_name']}</td>
											<td>{$row['send_date_time']}</td>
											<td class='center' $colorr>{$delivery}<br>{$report}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li style='padding: 0;'><form action='SMSResend' method='post' onclick='return ReSend()'><input type='hidden' name='from_page' value='{$row['from_page']}' /><input type='hidden' name='sms_id' value='{$row['id']}' /><input type='hidden' name='e_id' value='{$e_id}' /><button class='btn ownbtn2' style='padding: 6px 9px;' title='Re-Send'><i class='iconfa-refresh'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>
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
<?php if($user_type == 'mreseller'){ ?>
<script type="text/javascript">
jQuery(document).ready(function(){
    $("#resultpack").load("client-sms-cellno-count.php?way=mresellerduebill&z_id=<?php echo $macz_id;?>&box_id=all&con_sts=Active");
    jQuery('#box_id, #con_sts').on('change',function(){ 
        var box_id = jQuery('#box_id').val();
        var con_sts = jQuery('input[name=con_sts]:checked').val();
        jQuery.ajax({  
				type: 'GET',
                url: "client-sms-cellno-count.php?way=mresellerduebill&z_id=<?php echo $macz_id;?>",
                data:{box_id:box_id,con_sts:con_sts},
                success:function(data){
                    jQuery('#resultpack').html(data);
                }
        });  
    });  
});
</script>
<?php } else{ ?>
<script type="text/javascript">
jQuery(document).ready(function(){  
    $("#resultpack").load("client-sms-cellno-count.php?way=duebill&z_id=all&con_sts=Active");
    jQuery('#z_id, #con_sts').on('change',function(){ 
        var z_id = jQuery('#z_id').val();
        var con_sts = jQuery('input[name=con_sts]:checked').val();
        jQuery.ajax({  
				type: 'GET',
                url: "client-sms-cellno-count.php?way=duebill",
                data:{z_id:z_id,con_sts:con_sts},
                success:function(data){
                    jQuery('#resultpack').html(data);
                }
        });  
    });  
});
</script>
<?php } ?>
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
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}
function ReSend(){
    return confirm('Re-Send SMS!!  Are you sure?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>
<script language="javascript" type="text/javascript">
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
	
	function getRoutePoint(afdId) {		
		
		var strURL="sms_deliverey_report.php?api_id="+afdId;
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
</script>
  <script type="text/javascript">
let currentInput = $('#sms_msg');
$(document).on('focus', 'textarea', function() {
	currentInput = $(this);
})

$( 'button[type=button]' ).on('click', function(){
  let cursorPos = currentInput.prop('selectionStart');
  let v = currentInput.val();
  let textBefore = v.substring(0,  cursorPos );
  let textAfter  = v.substring( cursorPos, v.length );
  currentInput.val( textBefore+ $(this).val() +textAfter );
});
  </script>