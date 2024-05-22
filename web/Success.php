<?php
$titel = "Success!!";
$Clients = 'active';
include('include/hader.php');
include("conn/connection.php");
include('include/smsapi.php');
include('include/telegramapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

$SQLSECS = mysql_query("SELECT c.c_id, c.c_name, c.z_id, c.com_id, z.z_name, c.address, c.cell, c.con_type, l.user_id, l.password, p.p_name, c.payment_deadline, c.termination_date, c.mac_user, e.e_name FROM clients AS c
						LEFT JOIN login AS l
						ON l.e_id = c.c_id
						LEFT JOIN zone AS z
						ON z.z_id = c.z_id
						LEFT JOIN package AS p
						ON p.p_id = c.p_id
                        LEFT JOIN emp_info AS e
						ON e.e_id = c.entry_by
						WHERE c_id = '$new_id'");

$ROWSECS = mysql_fetch_assoc($SQLSECS);

$c_idd = $ROWSECS['c_id'];
$com_id = $ROWSECS['com_id'];
$c_name = $ROWSECS['c_name'];
$z_name = $ROWSECS['z_name'];
$address = $ROWSECS['address'];
$cell = $ROWSECS['cell'];
$con_type = $ROWSECS['con_type'];
$user_id = $ROWSECS['user_id'];
$p_name = $ROWSECS['p_name'];
$payment_deadline = $ROWSECS['payment_deadline'];
$termination_date = $ROWSECS['termination_date'];
$mac_user = $ROWSECS['mac_user'];
$ename = $ROWSECS['e_name'];
$z_id = $ROWSECS['z_id'];

if ($SQLSECS){

//TELEGRAM Start....
if($tele_sts == '0' && $tele_add_user_sts == '0'){
$telete_way = 'user_add';
$msg_body='..::[New Client Added]::..

Name: '.$c_name.' 
ID: '.$c_idd.'
Zone: '.$z_name.'
Package: '.$p_name.'

By: '.$ename.'
'.$tele_footer.'';

include('include/telegramapicore.php');
}
//TELEGRAM END....

//SMS Start....
if($sentsms=='Yes'){
if($mac_user=='1'){
$from_page = 'Add MAC Client';

$sss1mtt = mysql_query("SELECT e_name AS reseller_fullnamee, e_cont_per AS reseller_celll FROM emp_info WHERE z_id = '$z_id'");
$sssw1mss = mysql_fetch_assoc($sss1mtt);
$reseller_fullnamee = $sssw1mss['reseller_fullnamee'];
$reseller_celll = $sssw1mss['reseller_celll'];

$sqlsdf = mysql_query("SELECT sms_msg FROM sms_msg WHERE from_page = 'Add Client' AND z_id = '$z_id'");
$rowsm = mysql_fetch_assoc($sqlsdf);
}
else{ 
$from_page = 'Add Client'; 
$reseller_fullnamee = '';
$reseller_celll = '';

$sqlsdf = mysql_query("SELECT sms_msg FROM sms_msg WHERE id= '1'");
$rowsm = mysql_fetch_assoc($sqlsdf);
}

$sms_msg= $rowsm['sms_msg'];

$replacements = array(
	'user_id' => $user_id,
	'c_id' => $user_id,
	'com_id' => $com_id,
	'password' => $passid,
	'package' => $p_name,
	'termination_date' => $termination_date,
	'deadline' => $payment_deadline,
	'reseller_name' => $reseller_fullnamee,
	'reseller_cell' => $reseller_celll,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);

$sms_body = bind_to_template($replacements, $sms_msg);

$send_by = $_SESSION['SESS_EMP_ID'];
include('include/smsapicore.php');
}

//SMS END....

?>
	<div class="pageheader">
        <div class="searchbar">
			<a href="Clients" class="btn btn-rounded"><i class="iconsweets-create"></i> Update</a>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Done!!</h1>
        </div>
    </div><!--pageheader-->
		
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="alert alert-success succs">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
					<center><h2>Success!!</h2><br />
					New Client has been <strong>Successfully</strong> added in <strong><?php echo $CompanyName; ?></strong> Client List <br />
					Add in your Mikrotik &nbsp; <a class="succ"><?php echo $mk_name; ?></a> 
					Client id is &nbsp; <a class="succ"><?php echo $c_idd; ?></a> &nbsp; In &nbsp; <a class="terr"><?php echo $z_name; ?></a>.</center>
				</div>
				<div class="alert alert-success succs">
					<button data-dismiss="alert" class="close" type="button">&times;</button>
					<center>
						Client Name : <strong><?php echo $c_name; ?></strong><br />
						Connection Type : <strong><?php echo $con_type; ?></strong> & <strong><?php echo $p_name; ?></strong><br />
						Address : <strong><?php echo $address; ?></strong><br />
						Contact No : <strong><?php echo $cell; ?></strong><br />
						Loging Username : <strong><?php echo $user_id; ?></strong><br />
						Loging Password : <strong><?php echo $passid; ?></strong><br />
						<?php if($sentsms=='Yes'){?>
						Login information Successfully Send to <strong><?php echo $cell; ?></strong><br />
						<?php } ?><br />
						
					</center>
				</div>
			</div>
		</div>
	</div>

<?php
	}
else
	{
		echo "Error: " . $query . "<br>" . mysql_error($con);
	}
include('include/footer.php');
?>
<script language="JavaScript" type="text/javascript">

</script>