<?php
$titel = "SMS Template Settings";
$SMSSettings = 'active';
include('include/hader.php');
extract($_POST); 

$user_type = $_SESSION['SESS_USER_TYPE'];
$menuactive = 'class="ui-tabs-active ui-state-active"';

if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'mreseller'){
if($user_type == 'mreseller'){
$sqlqss = mysql_query("SELECT id FROM sms_msg WHERE z_id = '$macz_id'");
$countsms = mysql_num_rows($sqlqss);

if($countsms == '0'){
$query222 = "INSERT INTO sms_msg (from_page, sms_msg, variable, variable_means, from_sub, sms_type, z_id) VALUES ('Add Client', '..::WELLCOME::..\r\nTo \r\n{{company_name}}\r\n\r\nYour ID: {{user_id}}\r\nPassword: {{password}}\r\nPackage: {{package}}\r\nTermination date: {{termination_date}}\r\n\r\nThanks\r\n{{reseller_name}}\r\n{{reseller_cell}}', '{{user_id}}\r\n{{password}}\r\n{{package}}\r\n{{termination_date}}\r\n\r\n{{company_name}}\r\n{{company_cell}}\r\n{{reseller_name}}\r\n{{reseller_cell}}', 'Client PPPoE ID\r\nClient PPPoE Password\r\nPackage Name\r\nTermination Date [10th March, 2022]\r\n\r\n$CompanyName\r\n$CompanyPhone\r\n$reseller_fullname\r\n$reseller_cell', 'Welcome SMS', 'Yes/No', '$macz_id')";
					if (!mysql_query($query222))
							{
							die('Error: ' . mysql_error());
							}
							
$query222e = "INSERT INTO sms_msg (from_page, sms_msg, variable, variable_means, from_sub, sms_type, z_id) VALUES ('Recharge', 'Dear {{c_name}},\r\nYour account has been recharged for {{days}} days till {{new_termination_date}}\r\nTotal Cost: {{total_cost}} TK\r\n\r\nThanks\r\n{{reseller_name}}\r\n{{reseller_cell}}', '{{c_id}}\r\n{{c_name}}\r\n{{days}}\r\n{{total_cost}}\r\n{{new_termination_date}}\r\n\r\n{{company_name}}\r\n{{company_cell}}\r\n{{reseller_name}}\r\n{{reseller_cell}}', 'Client PPPoE ID\r\nClient Name [Mr. James Bond]\r\nRecharged Days\r\nCost Amount\r\nTermination Date [10th March, 2022]\r\n\r\n$CompanyName\r\n$CompanyPhone\r\n$reseller_fullname\r\n$reseller_cell', 'When recharge new days', 'Yes/No', '$macz_id')";
					if (!mysql_query($query222e))
							{
							die('Error: ' . mysql_error());
							}

$query222ed = "INSERT INTO sms_msg (from_page, sms_msg, variable, variable_means, from_sub, sms_type, z_id) VALUES ('Due Bill', 'Dear {{c_name}},\r\nToday is the last day of internet connection bill payment.\r\nYour due bill: {{total_due}}Tk.\r\nAvoid auto inactive, Please pay your bill as soon as possible.\r\n\r\nThanks\r\n{{reseller_name}}\r\n{{reseller_cell}}', '{{c_id}}\r\n{{c_name}}\r\n{{termination_date}}\r\n{{total_due}}\r\n{{this_month}}\r\n\r\n{{company_name}}\r\n{{company_cell}}\r\n{{reseller_name}}\r\n{{reseller_cell}}', 'Client PPPoE ID\r\nClient Name [Mr. James Bond]\r\nTermination Date [10th March, 2022]\r\nTotal Due Amount\r\nThis Month Short Name [Jan]\r\n\r\n$CompanyName\r\n$CompanyPhone\r\n$reseller_fullname\r\n$reseller_cell', 'When Use Due Bill from SMS', 'Yes/No', '$macz_id')";
					if (!mysql_query($query222ed))
							{
							die('Error: ' . mysql_error());
							}
$query222edd = "INSERT INTO sms_msg (from_page, sms_msg, variable, variable_means, from_sub, sms_type, z_id) VALUES ('Bill Payment', 'Dear {{c_name}},\r\nReceive Amount: {{PaymentAmount}}Tk by {{PaymentMethod}}\r\nMR No/TrxID: {{TrxId}}{{MoneyreceiptNo}}\r\nTotal Due: {{TotalDue}}Tk\r\n\r\nThanks\r\n{{reseller_name}}\r\n{{reseller_cell}}', '{{c_id}}\r\n{{c_name}}\r\n{{PaymentAmount}}\r\n{{PaymentDiscount}}\r\n{{PaymentMethod}}\r\n{{TotalDue}}\r\n{{MoneyreceiptNo}}\r\n{{TrxId}}\r\n\r\n{{company_name}}\r\n{{company_cell}}\r\n{{reseller_name}}\r\n{{reseller_cell}}', 'Client PPPoE ID\r\nClient Name [Mr. James Bond]\r\nPaid Amount\r\nDiscount Amount\r\nDue Amount\r\nPayment Method\r\nMoney receipt No\r\nTransaction ID\r\n\r\n$CompanyName\r\n$CompanyPhone\r\n$reseller_fullname\r\n$reseller_cell', 'Cash & Online', 'Yes/No', '$macz_id')";
					if (!mysql_query($query222edd))
							{
							die('Error: ' . mysql_error());
							}
$query22r1 = "INSERT INTO sms_msg (from_page, sms_msg, variable, variable_means, from_sub, sms_type, z_id, day, send_sts) VALUES ('1st Remainder', 'Dear {{c_name}},\r\nYou have last 3 days to payment or at {{termination_date}} your account will terminate.\r\n\r\nThanks\r\n{{reseller_name}}\r\n{{reseller_cell}}', '{{c_id}}\r\n{{c_name}}\r\n{{termination_date}}\r\n{{package_price}}\r\n\r\n{{company_name}}\r\n{{company_cell}}\r\n{{reseller_name}}\r\n{{reseller_cell}}', 'Client PPPoE ID\r\nClient Name [Mr. James Bond]\r\nTermination Date [10th March, 2022]\r\nPackage Price [500]\r\n\r\n$CompanyName\r\n$CompanyPhone\r\n$reseller_fullname\r\n$reseller_cell', '', 'Auto', '$macz_id', '3', '1')";
					if (!mysql_query($query22r1))
							{
							die('Error: ' . mysql_error());
							}
							
$query22r2 = "INSERT INTO sms_msg (from_page, sms_msg, variable, variable_means, from_sub, sms_type, z_id, day, send_sts) VALUES ('2nd Remainder', 'Dear {{c_name}},\r\nYou have last 1 days to payment or at {{termination_date}} your account will terminate.\r\n\r\nThanks\r\n{{reseller_name}}\r\n{{reseller_cell}}', '{{c_id}}\r\n{{c_name}}\r\n{{termination_date}}\r\n{{package_price}}\r\n\r\n{{company_name}}\r\n{{company_cell}}\r\n{{reseller_name}}\r\n{{reseller_cell}}', 'Client PPPoE ID\r\nClient Name [Mr. James Bond]\r\nTermination Date [10th March, 2022]\r\nPackage Price [500]\r\n\r\n$CompanyName\r\n$CompanyPhone\r\n$reseller_fullname\r\n$reseller_cell', '', 'Auto', '$macz_id', '1', '1')";
					if (!mysql_query($query22r2))
							{
							die('Error: ' . mysql_error());
							}
							
$qry22r2 = "INSERT INTO sms_msg (from_page, sms_msg, variable, variable_means, from_sub, sms_type, z_id, day, send_sts) VALUES ('Generate Bill', 'Dear {{c_name}},\r\nMonthly Bill : {{MonthBillAmount}}TK\r\nTotal Due : {{TotalDue}}TK.\r\n\r\nPlease Pay Before : 05 {{ThisMonth}}, 2022\r\n\r\nThanks\r\n{{reseller_name}}\r\n{{reseller_cell}}', '{{c_id}}\r\n{{c_name}}\r\n{{TotalDue}}\r\n{{ThisMonth}}\r\n{{MonthBillAmount}}\r\n{{MonthDiscountAmount}}\r\n{{termination_date}}\r\n\r\n{{company_name}}\r\n{{company_cell}}\r\n{{reseller_name}}\r\n{{reseller_cell}}', 'Client PPPoE ID\r\nClient Name [Mr. James Bond]\r\nTotal Due Amount\r\nThis Month Short Name [Jan]\r\nGenerated Bill Amount\r\nDiscount Amount\r\nTermination Date [10th March, 2022]\r\n\r\n$CompanyName\r\n$CompanyPhone\r\n$reseller_fullname\r\n$reseller_cell', '', 'Auto', '$macz_id', '0', '1')";
					if (!mysql_query($qry22r2))
							{
							die('Error: ' . mysql_error());
							}
}
}
if($user_type == 'admin' || $user_type == 'superadmin'){
$sqlset="SELECT id, name, owner_name, last_id, email, address, postal_code, com_email, fax, phone, copmaly_boss_cell, website, currency, logo, app_logo, tis_id, user_limit, bill_amount FROM app_config ";
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
$last_id=$rowset['last_id'];
$owner_name=$rowset['owner_name'];
$copmaly_boss_cell=$rowset['copmaly_boss_cell'];
$com_email=$rowset['com_email'];
$tis_id=$rowset['tis_id'];
$user_limit=$rowset['user_limit'];
$bill_amount=$rowset['bill_amount'];

$sqlsdf = mysql_query("SELECT id, sms_msg, from_page, variable FROM sms_msg WHERE id= '1'");
$rowsm = mysql_fetch_assoc($sqlsdf);

$sqlsdfq = mysql_query("SELECT id, sms_msg, from_page, accpt_amount, variable, send_sts FROM sms_msg WHERE id= '2'");
$rowsmq = mysql_fetch_assoc($sqlsdfq);

$sqlsdfee = mysql_query("SELECT id, sms_msg, from_page, variable FROM sms_msg WHERE id= '4'");
$rowsme = mysql_fetch_assoc($sqlsdfee);

$sqlsdfp = mysql_query("SELECT id, sms_msg, from_page, variable FROM sms_msg WHERE id= '5'");
$rowsmep = mysql_fetch_assoc($sqlsdfp);

$sqlcln = mysql_query("SELECT id, sms_msg, from_page, variable FROM sms_msg WHERE id= '6'");
$rowcln = mysql_fetch_assoc($sqlcln);

$sqlext = mysql_query("SELECT id, sms_msg, from_page, variable FROM sms_msg WHERE id= '7'");
$rowext = mysql_fetch_assoc($sqlext);

$sqlsup = mysql_query("SELECT id, sms_msg, from_page, variable FROM sms_msg WHERE id= '8'");
$rowsup = mysql_fetch_assoc($sqlsup);

$sqlass = mysql_query("SELECT id, sms_msg, from_page, variable FROM sms_msg WHERE id= '9'");
$rowass = mysql_fetch_assoc($sqlass);

$sqlress = mysql_query("SELECT id, sms_msg, from_page, variable FROM sms_msg WHERE id= '10'");
$rowress = mysql_fetch_assoc($sqlress);

$sqlgnb = mysql_query("SELECT id, sms_msg, from_page, variable, send_sts FROM sms_msg WHERE id= '11'");
$rowgnb = mysql_fetch_assoc($sqlgnb);

$sqls1std = mysql_query("SELECT id, sms_msg, from_page, variable, send_sts, day FROM sms_msg WHERE id= '12'");
$rows1st = mysql_fetch_assoc($sqls1std);

$sqlsdfdd = mysql_query("SELECT id, sms_msg, from_page, variable, send_sts, day FROM sms_msg WHERE id= '13'");
$rowsmdd = mysql_fetch_assoc($sqlsdfdd);

$sqlsdfdddd = mysql_query("SELECT id, sms_msg, from_page, variable, send_sts, day FROM sms_msg WHERE id= '14'");
$rowsmdddd = mysql_fetch_assoc($sqlsdfdddd);

$sreess = mysql_query("SELECT id, sms_msg, from_page, variable FROM sms_msg WHERE id= '15'");
$roress = mysql_fetch_assoc($sreess);
}
?>

<div class="mainwrapper">
        <div class="pageheader2">
			<?php if($user_type == 'admin' || $user_type == 'superadmin'){?>
            <div class="searchbar">
				<a class="btn ownbtn1" style="" href="AppSettings">Application Settings</a>
				<a class="btn ownbtn2" style="" href="UserAccess">User Menu Access</a>
				<a class="btn ownbtn3" style="" href="UserAccessPage">User Advance Access</a>
			</div>
			<?php } ?>
            <div class="pageicon"><span class="iconfa-comment"></span></div>
            <div class="pagetitle">
                <h1>SMS Template Settings</h1>
            </div>
        </div><!--pageheader-->
<?php if($way != '') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $way;?> Successfully Edited in Your System.
			</div><!--alert-->
<?php } else {}?>

	<div class="box box-primary">
		<div class="box-header">
				<div class="tabbedwidget">
                            <ul>
							<?php if($user_type == 'admin' || $user_type == 'superadmin'){?>
                                <li <?php if($way == 'Add Client'){ echo $menuactive;}?>><b><a href="#tabs-2" style="padding: 10px 10px;">Welcome SMS</a></b></li>
                                <li <?php if($way == 'Auto Inactive SMS'){ echo $menuactive;}?>><b><a href="#tabs-3" style="padding: 10px 10px;">Auto Inactive</a></b></li>
                                <li <?php if($way == 'Due Bill SMS'){ echo $menuactive;}?>><b><a href="#tabs-4" style="padding: 10px 10px;">Due Bill</a></b></li>
                                <li <?php if($way == 'Bill Payment SMS'){ echo $menuactive;}?>><b><a href="#tabs-5" style="padding: 10px 10px;">Bill Payment</a></b></li>
                                <li <?php if($way == 'Others Collection SMS'){ echo $menuactive;}?>><b><a href="#tabs-6" style="padding: 10px 10px;">Others Collection</a></b></li>
                                <li <?php if($way == 'Support SMS'){ echo $menuactive;}?>><b><a href="#tabs-7" style="padding: 10px 10px;">Support</a></b></li>
                                <li <?php if($way == 'Reseller Payment SMS'){ echo $menuactive;}?>><b><a href="#tabs-8" style="padding: 10px 10px;">Reseller Payment</a></b></li>
                                <li <?php if($way == 'Generate Bill SMS'){ echo $menuactive;}?>><b><a href="#tabs-9" style="padding: 10px 10px;">Generate Bill</a></b></li>
                                <li <?php if($way == 'Bill Rimainder SMS'){ echo $menuactive;}?>><b><a href="#tabs-10" style="padding: 10px 10px;">Bill Remainder</a></b></li>
                           <?php } if($user_type == 'mreseller'){
							   	$sqlsdfq = mysql_query("SELECT id, from_page, sms_msg, variable, variable_means FROM sms_msg WHERE z_id = '$macz_id'");
								while( $resrow = mysql_fetch_assoc($sqlsdfq) )
								{ ?>
									<li <?php if($way == $resrow['from_page']){ echo $menuactive;}?>><b><a href="#tabs-<?php echo $resrow['id'];?>" style="padding: 10px 10px;"><?php echo $resrow['from_page'];?></a></b></li>
							<?php }} ?>
						   </ul>
						   
						<?php if($user_type == 'mreseller'){
								$sqlsdfqss = mysql_query("SELECT id, from_page, sms_msg, variable, variable_means, from_sub, sms_type, day, send_sts FROM sms_msg WHERE z_id = '$macz_id'");
								while( $resrowss = mysql_fetch_assoc($sqlsdfqss) ){
							?>
						   <div id="tabs-<?php echo $resrowss['id'];?>" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="<?php echo $resrowss['from_page'];?>"/>
									<input type="hidden" name="sms_id" value="<?php echo $resrowss['id'];?>"/>
									<input type="hidden" name="z_id" value="<?php echo $macz_id;?>"/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">From<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i><?php echo $resrowss['from_sub'];?></i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $resrowss['from_page'];?></h4>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i></i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $resrowss['sms_type'];?></h4>
										</p>
										<?php if($resrowss['day'] != '' && $resrowss['from_page'] == '1st Remainder'){?>
										<br>
										<p>
											<label style="font-weight: bold;">When Run?</label>
											<span class="field"><input type="text" readonly id="" style="width: 15px;" required="" value="<?php echo $resrowss['day'];?>"/> Day Before Termination Date.</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Send SMS?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i></i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="send_sts" value="0" <?php if('0' == $resrowss['send_sts']) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="send_sts" value="1" <?php if('1' == $resrowss['send_sts']) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<?php } if($resrowss['day'] != '' && $resrowss['from_page'] == '2nd Remainder'){?>
										<br>
										<p>
											<label style="font-weight: bold;">When Run?</label>
											<span class="field"><input type="text" readonly id="" style="width: 15px;" required="" value="<?php echo $resrowss['day'];?>"/> Day Before Termination Date.</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Send SMS?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i></i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="send_sts" value="0" <?php if('0' == $resrowss['send_sts']) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="send_sts" value="1" <?php if('1' == $resrowss['send_sts']) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<?php } if($resrowss['from_page'] == 'Generate Bill'){?>
										<br>
										<p>
											<label style="font-weight: bold;">Send SMS?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i></i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="send_sts" value="0" <?php if('0' == $resrowss['send_sts']) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="send_sts" value="1" <?php if('1' == $resrowss['send_sts']) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										<?php } ?>
										 <table style="width: 100%;border-bottom: 1px solid #ddd;">
											 <tr>
												<th style="width: 40%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg" style="width:100%;height: 300px;" required="" id="" placeholder="" class="input-large" /><?php echo $resrowss['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 3%;border-right: 1px solid #ddd;"></th>
												<th style="width: 2%;"></th>
												<th style="width: 40%;text-align: left;">
													<textarea type="text" style="width:175px;height:300px;font-family: Consolas,monospace;font-weight: bold;" class="input-large" /><?php echo $resrowss['variable'];?></textarea>
													<textarea type="text" style="width:45%;height:300px;font-family: Consolas,monospace;font-weight: bold;" class="input-large" /><?php echo $resrowss['variable_means'];?></textarea>
												</th>
											</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn ownbtn11">Reset</button>
										<button class="btn ownbtn2" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
						<?php }} ?>
						<?php if($user_type == 'admin' || $user_type == 'superadmin'){?>
                            <div id="tabs-2" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="<?php echo $rowsm['from_page'];?>"/>
									<input type="hidden" name="sms_id" value="<?php echo $rowsm['id'];?>"/>
									<input type="hidden" name="z_id" value=""/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">From</label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rowsm['from_page'];?></h4>
										</p>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Choose by User</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Yes/No</h4>
										</p>
										<br>
										 <table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowsm['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowsm['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn ownbtn11">Reset</button>
										<button class="btn ownbtn2" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							
							<div id="tabs-3" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="Auto_Inactive"/>
									<input type="hidden" name="sms_id" value="<?php echo $rowsmq['id'];?>"/>
									<input type="hidden" name="z_id" value=""/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">From</label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rowsmq['from_page'];?></h4>
										</p>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>When Inactive by Deadline.</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Auto</h4>
										</p><br>
										<p>
											<label style="font-weight: bold;">Minimum Due Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>When Due Amount Larger Than <?php echo $rowsmq['accpt_amount'].'TK';?></i></a></label>
											<span class="field"><input type="text" name="accpt_amount" id="" style="width: 50px;" required="" value="<?php echo $rowsmq['accpt_amount'];?>"/>TK</span>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Send SMS?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i></i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="send_sts" value="0" <?php if('0' == $rowsmq['send_sts']) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="send_sts" value="1" <?php if('1' == $rowsmq['send_sts']) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										 <table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowsmq['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowsmq['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn ownbtn11">Reset</button>
										<button class="btn ownbtn2" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							
							<div id="tabs-4" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="Due Bill"/>
									<input type="hidden" name="sms_id" value="<?php echo $rowsme['id'];?>"/>
									<input type="hidden" name="z_id" value=""/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">From</label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rowsme['from_page'];?></h4>
										</p>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>When Use Due Bill from SMS.</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">When Use</h4>
										</p>
										<br>
										 <table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowsme['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowsme['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn ownbtn11">Reset</button>
										<button class="btn ownbtn2" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							
							<div id="tabs-5" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="Bill Payment"/>
									<input type="hidden" name="sms_id" value="<?php echo $rowsmep['id'];?>"/>
									<input type="hidden" name="sms_id1" value="<?php echo $rowsmdddd['id'];?>"/>
									<input type="hidden" name="z_id" value=""/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">From<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Cash & Online</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rowsmep['from_page'];?></h4>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Choose by User</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Yes/No</h4>
										</p>
										<br>
										 <table style="width: 100%;border-bottom: 1px solid #ddd;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowsmep['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowsmep['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
											</tr>
										</table>
										<br/><br/><br/>
										<p>
											<label style="font-weight: bold;">From<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Online Webhook</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rowsmdddd['from_page'];?></h4>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>When payment by Webhook</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Auto</h4>
										</p>
										<br>
										 <table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg1" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowsmdddd['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowsmdddd['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn ownbtn11">Reset</button>
										<button class="btn ownbtn2" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							
							<div id="tabs-6" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="Others Collection"/>
									<input type="hidden" name="z_id" value=""/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">From</a></label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rowcln['from_page'];?> Collection</h4>
										</p>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Choose by User</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Yes/No</h4>
										</p>
										<br>
										<table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>For Client</i></a></label>
														<input type="hidden" name="sms_cid" value="<?php echo $rowcln['id'];?>"/>
														<span class="field"><textarea type="text" name="sms_msg_client" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowcln['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowcln['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
										<br>
										<table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>For Extra Income</i></a></label>
														<input type="hidden" name="sms_ext" value="<?php echo $rowext['id'];?>"/>
														<span class="field"><textarea type="text" name="sms_msg_extra" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowext['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowext['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn ownbtn11">Reset</button>
										<button class="btn ownbtn2" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							
							<div id="tabs-7" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="Support"/>
									<input type="hidden" name="z_id" value=""/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">From</a></label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rowsup['from_page'];?></h4>
										</p>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Choose by User</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Yes/No</h4>
										</p>
										<br>
										<table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>For Client</i></a></label>
														<input type="hidden" name="sms_cid" value="<?php echo $rowsup['id'];?>"/>
														<span class="field"><textarea type="text" name="sms_msg_client" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowsup['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowsup['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
										<br>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Auto</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">[Yes] When Assign Employee</h4>
										</p>
										<table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>For Extra Income</i></a></label>
														<input type="hidden" name="sms_ext" value="<?php echo $rowass['id'];?>"/>
														<span class="field"><textarea type="text" name="sms_msg_assign" style="width:100%;height: 210px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowass['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowass['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn ownbtn11">Reset</button>
										<button class="btn ownbtn2" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							
							<div id="tabs-8" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="Reseller Payment"/>
									<input type="hidden" name="sms_id" value="<?php echo $rowress['id'];?>"/>
									<input type="hidden" name="sms_id1" value="<?php echo $roress['id'];?>"/>
									<input type="hidden" name="z_id" value=""/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">From<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Cash & Online</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rowress['from_page'];?></h4>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Choose by User</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Yes/No</h4>
										</p>
										<br>
										 <table style="width: 100%;border-bottom: 1px solid #ddd;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowress['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowress['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
										<br>
										<br>
										<p>
											<label style="font-weight: bold;">From<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Online Webhook</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $roress['from_page'];?></h4>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>When Recharge by Webhook</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Auto</h4>
										</p>
										<br>
										 <table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg1" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $roress['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $roress['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn ownbtn11">Reset</button>
										<button class="btn ownbtn2" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							
							<div id="tabs-9" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="Generate Bill"/>
									<input type="hidden" name="sms_id" value="<?php echo $rowgnb['id'];?>"/>
									<input type="hidden" name="z_id" value=""/>
									<div class="modal-body">
										<p>
											<label style="font-weight: bold;">From</label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rowgnb['from_page'];?></h4>
										</p>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>1st Day of Month.</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Auto</h4>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">Send SMS?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i></i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="send_sts" value="0" <?php if('0' == $rowgnb['send_sts']) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="send_sts" value="1" <?php if('1' == $rowgnb['send_sts']) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										 <table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowgnb['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowgnb['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn ownbtn11">Reset</button>
										<button class="btn ownbtn2" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							
							<div id="tabs-10" style="min-height: 500px;">
								<div class="modal-content">
									<form id="" name="form1" class="stdform" method="post" action="AppSettingsQuery">
									<input type="hidden" name="way" value="Bill Rimainder"/>
									<input type="hidden" name="z_id" value=""/>
									<div class="modal-body">
										<input type="hidden" name="sms_id_1" value="<?php echo $rows1st['id'];?>"/>
										<p>
											<label style="font-weight: bold;">From</label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rows1st['from_page'];?></h4>
										</p>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i><?php echo $rows1st['day'];?>-Day Before Payment Deadline.</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Auto</h4>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">When?</label>
											<span class="field"><input type="text" name="day_1" id="" style="width: 15px;" required="" value="<?php echo $rows1st['day'];?>"/> Day Before Payment Deadline.</span>
										</p>
										<p>
											<label style="font-weight: bold;">Send SMS?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i></i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="send_sts_1" value="0" <?php if('0' == $rows1st['send_sts']) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="send_sts_1" value="1" <?php if('1' == $rows1st['send_sts']) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										 <table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg_1" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rows1st['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rows1st['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
									</div>
									
									
									<div class="modal-body">
									<input type="hidden" name="sms_id_2" value="<?php echo $rowsmdd['id'];?>"/>
										<p>
											<label style="font-weight: bold;">From</label>
											<h4 style="padding-top: 8px;font-weight: bold;"><?php echo $rowsmdd['from_page'];?></h4>
										</p>
										<p>
											<label style="font-weight: bold;">SMS Type<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i><?php echo $rowsmdd['day'];?>-Day Before Payment Deadline.</i></a></label>
											<h4 style="padding-top: 8px;font-weight: bold;">Auto</h4>
										</p>
										<br>
										<p>
											<label style="font-weight: bold;">When?</label>
											<span class="field"><input type="text" name="day_2" id="" style="width: 15px;" required="" value="<?php echo $rowsmdd['day'];?>"/> Day Before Payment Deadline.</span>
										</p>
										<p>
											<label style="font-weight: bold;">Send SMS?<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i></i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="send_sts_2" value="0" <?php if('0' == $rowsmdd['send_sts']) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="send_sts_2" value="1" <?php if('1' == $rowsmdd['send_sts']) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
										</p>
										 <table style="width: 100%;">
											 <tr>
												<th style="width: 60%;">
													<p>
														<label style="font-weight: bold;">SMS Massege*<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Type Text Here</i></a></label>
														<span class="field"><textarea type="text" name="sms_msg_2" style="width:100%;height: 200px;" required="" id="" placeholder="" class="input-large" /><?php echo $rowsmdd['sms_msg'];?></textarea></span>
													</p>
												</th>
												<th style="width: 5%;border-right: 1px solid #ddd;"></th>
												<th style="width: 5%;"></th>
												<th style="width: 20%;text-align: left;">
													<textarea type="text" style="width:100%;height: 200px;font-family: Consolas,monospace;" class="input-large" /><?php echo $rowsmdd['variable'];?></textarea>
												</th>
												<th style="width: 5%;"></th>
												</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="reset" class="btn ownbtn11">Reset</button>
										<button class="btn ownbtn2" type="submit">Submit</button>
									</div>
									</form>
								</div>
                            </div>
							<?php } ?>
                </div>
		</div>
	</div>
</div>

<?php
}
else{echo 'You are not authorized.';}

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