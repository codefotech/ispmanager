<?php
$titel = "Mac Reseller Bill History";
$MacReseller = 'active';
include('include/hader.php');
include("conn/connection.php");

if($userr_typ == 'mreseller'){
	$idz = $macz_id;
}
else{
$idz = $_GET['id'];
}
extract($_POST);

ini_alter('date.timezone','Asia/Almaty');
$todayyyy = date('Y-m-d', time());

if($bill_month == ''){
$todaydate = date('Y-m-d', time());
$thismonth = date('M-Y', time());
}
else{
$todaydate = $bill_month;
$yrdata= strtotime($bill_month);
$thismonth = date('M-Y', $yrdata);
}

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'MacReseller' OR 'MacResellerBillHistory' AND $user_type = '1'");
if($user_type == 'mreseller'){
	$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '40' AND $user_type = '1' or $user_type = '2'");
}
else{
	$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '39' AND $user_type = '1'");
}
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

$sql1 = mysql_query("SELECT b.c_id, c.com_id, c.c_name, c.z_id, c.join_date, c.termination_date, c.con_sts, c.cell, b.start_date, b.end_date, p.p_name, p.p_price, p.bandwith, b.p_price, sum(b.bill_amount) as bill_amount, sum(b.days) as days FROM billing_mac AS b
					LEFT JOIN clients AS c ON c.c_id = b.c_id
					LEFT JOIN package AS p ON p.p_id = b.p_id
					WHERE MONTH(b.entry_date) = MONTH('$todaydate') AND YEAR(b.entry_date) = YEAR('$todaydate') AND b.bill_amount != '0.00' AND b.sts = '0' AND c.z_id = '$idz' GROUP BY c.c_id ORDER BY c.id");
					
					
$sql1zz1 = mysql_query("SELECT SUM(b.bill_amount) AS totalbill FROM billing_mac AS b
					LEFT JOIN clients AS c ON c.c_id = b.c_id
					WHERE MONTH(b.entry_date) = MONTH('$todaydate') AND YEAR(b.entry_date) = YEAR('$todaydate') AND b.bill_amount != '0.00' AND b.sts = '0' AND c.z_id = '$idz'");
$rowwzz = mysql_fetch_array($sql1zz1);

$result = mysql_query("SELECT z.z_id, z.z_name, z.e_id as reseller_id, COUNT(c.c_id) AS totalclients, e.e_name, e.e_cont_per, e.pre_address, e.terminate FROM zone AS z
						LEFT JOIN emp_info AS e
						ON e.e_id = z.e_id
						LEFT JOIN clients AS c
						ON c.z_id = z.z_id
						WHERE z.z_id = '$idz' AND c.sts = '0'");
$row = mysql_fetch_array($result);	



$sql1q = mysql_query("SELECT c_id, SUM(bill_amount) AS totbill FROM billing_mac WHERE z_id = '$idz'");
$rowq = mysql_fetch_array($sql1q);


$sql1z1 = mysql_query("SELECT p.id, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p
						WHERE p.z_id = '$idz' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);

$aaaa = $rowwz['retotalpayments']-$rowq['totbill'];

//$Dew = $rowww['totaldue'];

if($aaaa < 0){
	$color = 'style="color:red;"';					
} else{
	$color = 'style="color:#000;"';
}

$sql1z11111 = mysql_query("SELECT COUNT(id) totalzoneclients FROM clients WHERE z_id = '$idz' AND sts = '0' AND con_sts = 'Active' AND mac_user = '1'");
$rowwz1111 = mysql_fetch_array($sql1z11111);

$totalzoneclients = $rowwz1111['totalzoneclients'];

$sql1z1111122 = mysql_query("SELECT COUNT(id) totalzoneclientsdetar FROM clients WHERE z_id = '$idz' AND sts = '0' AND con_sts = 'Inactive' AND mac_user = '1' AND c_terminate = '1'");
$rowwz111122 = mysql_fetch_array($sql1z1111122);

$totalzoneclientsdetar = $rowwz111122['totalzoneclientsdetar'];

	?>
	
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal11">
	<form id="form2" class="stdform" method="post" action="MacResellerTerminate">
	<input type="hidden" name="wayy" value="Terminate"/>
	<input type="hidden" name="eidddd" value="<?php echo $e_id;?>"/>
	<input type="hidden" name="z_id" value="<?php echo $idz;?>"/>
	<input type="hidden" name="totalzoneclients" value="<?php echo $totalzoneclients;?>"/>
	<input type="hidden" name="reseller_no" value="<?php echo $row['e_cont_per']; ?>"/>
	<input type="hidden" name="reseller_name" value="<?php echo $row['e_name']; ?>"/>
	<input type="hidden" name="reseller_id" value="<?php echo $row['reseller_id']; ?>"/>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Terminate Reseller clients</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div style="text-align: center;font-size: 25px;">Total active client: <?php echo $totalzoneclients; ?></div>
						</div>
						<div class="popdiv">
							<div style="text-align: center;font-size: 17px;color: red;">Are you sure to Terminate/Inactive all Clients?</div>
						</div>
						<div class="popdiv">
							<div class="col-1"></div>
							<div class="col-2"> <input type="radio" name="sentsms" value="Yes" checked="checked"> SMS to Reseller &nbsp; &nbsp;<input type="radio" name="sentsms" value="No"> SMS not Needed</div>
						</div>
					</div>
				</div>
			<div class="modal-footer">
				<button class="btn ownbtn2" type="submit">Proceed</button>
			</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal112">
	<form id="form2" class="stdform" method="post" action="MacResellerTerminate">
	<input type="hidden" name="wayy" value="Determinate"/>
	<input type="hidden" name="eidddd" value="<?php echo $e_id;?>"/>
	<input type="hidden" name="z_id" value="<?php echo $idz;?>"/>
	<input type="hidden" name="totalzoneclientsdetar" value="<?php echo $totalzoneclientsdetar;?>"/>
	<input type="hidden" name="reseller_no" value="<?php echo $row['e_cont_per']; ?>"/>
	<input type="hidden" name="reseller_name" value="<?php echo $row['e_name']; ?>"/>
	<input type="hidden" name="reseller_id" value="<?php echo $row['reseller_id']; ?>"/>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Determinate Reseller clients</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div style="text-align: center;font-size: 25px;">Total Inactive client: <?php echo $totalzoneclientsdetar; ?></div>
						</div>
						<div class="popdiv">
							<div style="text-align: center;font-size: 17px;color: red;">Are you sure to Determinate/Active all Clients?</div>
						</div>
						<div class="popdiv">
							<div class="col-1"></div>
							<div class="col-2"> <input type="radio" name="sentsms" value="Yes" checked="checked"> SMS to Reseller &nbsp; &nbsp;<input type="radio" name="sentsms" value="No"> SMS not Needed</div>
						</div>
					</div>
				</div>
			<div class="modal-footer">
				<button class="btn ownbtn2" type="submit">Proceed</button>
			</div>
			</div>
		</div>	
	</form>	
	</div><!--#myModal-->
<link rel="stylesheet" href="css/reset-fonts-grids.css" type="text/css" />
<link rel="stylesheet" href="css/resume.css" type="text/css" />
	<script language="javascript">
		function PrintMe(DivID) {
		var disp_setting="toolbar=yes,location=no,";
		disp_setting+="directories=yes,menubar=yes,";
		disp_setting+="scrollbars=yes,width=1050, height=800, left=50, top=25";
		   var content_vlue = document.getElementById(DivID).innerHTML;
		   var docprint=window.open("","",disp_setting);
		   docprint.document.open();
		   docprint.document.write('<link rel="stylesheet" href="css/resume_print.css" type="text/css" />');
		   docprint.document.write('<link rel="stylesheet" href="css/reset-fonts-grids_print.css" type="text/css" />');
		   docprint.document.write('<head><title>Reseller Clients History</title>');
		   docprint.document.write('<style type="text/css">body{ margin:0px;');
		   docprint.document.write('font-family:verdana,Arial;color:#000;');
		   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
		   docprint.document.write('a{color:#000;text-decoration:none;} </style>');
		   docprint.document.write('</head><body onLoad="self.print()"><center>');
		   docprint.document.write(content_vlue);
		   docprint.document.write('</center></body></html>');
		   docprint.document.close();
		   docprint.focus();
		}
	</script>
	
	<div class="pageheader">
        <div class="searchbar">
			<div class="margillll ">
			<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
				<select name="bill_month" class="" style="height: 30px;" onchange="submit();">
                    <option value="<?php echo date("Y-m-01") ?>"><?php echo date("M-Y") ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?></option>
                    <option value="<?php echo date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?></option>
                </select>
			</form>
			</div> 
			<?php
			if($userr_typ == 'mreseller'){?>
			<!--<a class="btn ownbtn2" href="MacResellerActiveClients"> Live Status</a>-->
			<a class="btn ownbtn3" href="MacResellerPayment"> Full History</a>
		<?php } else{ if(in_array(149, $access_arry)){?>
			<!--<a class="btn ownbtn2" href="MacResellerActiveClients?id=<?php echo $idz; ?>"> Live Status</a>-->
		<?php }} if(in_array(144, $access_arry)){ ?>
			<a class="btn ownbtn3" href="MacResellerPayment?id=<?php echo $idz; ?>"> Full History & Payment</a> 
		<?php } if(in_array(150, $access_arry)){ if($row['terminate'] == '0'){?>
			<a class="btn ownbtn4" href="#myModal11" data-toggle="modal"><i class="iconfa-thumbs-down"></i> Terminate</a>
		<?php }	else{?>
				<a class="btn ownbtn1" href="#myModal112" data-toggle="modal"><i class="icon-thumbs-up icon-white"></i> Determinate</a>
		<?php }} ?>
			<button class="btn ownbtn5" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')"><i class="iconfa-print"></i> Print</button>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Mac Reseller Bills (<?php echo $thismonth; ?>)</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
		<div id="divid">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:right">MAC Area &nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['z_name']; ?></td>
								
						<th style="text-align:right">Reseller Name&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['e_name']; ?></td>
							
						<th style="text-align:right">Cell No&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['e_cont_per']; ?></td>
							
						<th style="text-align:right">Total Clients&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['totalclients']; ?></td>
						
						<th style="text-align:right">Balance &nbsp;:&nbsp; </th>
						<td <?php echo $color; ?>> &nbsp; <?php $intotaldue=$aaaa; echo number_format($intotaldue,2); ?></td>
					</tr>	
				</table>
<br>
			<div id="hd">
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
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
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center">ComID</th>
							<th class="head1">ID/Name/Cell</th>
							<th class="head0 center">Status</th>
							<th class="head1 center">Termination Date</th>
							<th class="head1">Package/Bandwith</th>
							<th class="head1 center">Amount</th>
							<th class="head0 center">Remaining_Days</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
						$x = 1;	
								while( $row1 = mysql_fetch_assoc($sql1) )
								{
									
									
									$yrdata= strtotime($row1['start_date']);
									$startdate = date('d F, Y', $yrdata);
									
									$yrdata1= strtotime($row1['termination_date']);
									$enddate = date('d F, Y', $yrdata1);
									
									$diff = abs(strtotime($row1['termination_date']) - strtotime($todayyyy))/86400;
									if($row1['termination_date'] < $todayyyy){ $diff = '0';}
									if($diff == '0'){
										$colorr11 = "style='color: red;font-size: 20px;font-weight: bold;'";
									}
									else{
										$colorr11 = "style='font-size: 20px;font-weight: bold;'";
									}
									if($row1['con_sts'] == 'Active'){
										$colorrrr = 'style="color:green; font-size: 14px;font-weight: bold;padding-top: 15px;"';
									}
									else{
										$colorrrr = 'style="color:red; font-size: 14px;font-weight: bold;padding-top: 15px;"';
									}
									echo
										"<tr class='gradeX'>
											<td class='center'><b style='font-weight: bold;font-size: 12px;'>{$row1['com_id']}</b></td>
											<td><b style='font-weight: bold;font-size: 13px;'>{$row1['c_id']}</b><br>{$row1['c_name']}<br>{$row1['cell']}</td>
											<td class='center' $colorrrr>{$row1['con_sts']}</td>
											<td style='text-align: center;'><b style='color: red;font-size: 12px;'>{$enddate}</b></td>
											<td>{$row1['p_name']} <br> {$row1['bandwith']} - {$row1['p_price']}tk</td>
											<td class='center'><b style='color: #5e490a;'>{$row1['bill_amount']} tk</b><br>-------------<br><b><a>{$row1['days']} Days</a></b></td>
											<td class='center' $colorr11>{$diff}</td>\n ";
										$x++; ?>
										
											<td class='center'>
												<ul class='tooltipsample'>
												<?php if(in_array(151, $access_arry) || in_array(152, $access_arry)){?>
													<li><form action='MacResellerClientBillHistory' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row1['c_id'];?>' /><button class='btn ownbtn2' style='padding: 6px 9px;' title='View'><i class='fa iconfa-eye-open'></i></button></form></li>
												<?php } ?>
												</ul>
											</td>
										</tr>
								<?php } ?>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td style="text-align: right;"><b>TOTAL:</b></td>
							<td><b><?php echo $rowwzz['totalbill'];?></b></td>
							<td></td>
							<td></td>
					</tbody>
				</table>
			</div>
		</div></div>
		<div class="modal-footer">
			<button class="btn ownbtn5" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')"><i class="iconfa-print"></i> Print</button>
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
			"iDisplayLength": 1000,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<style>
#dyntable_length{display: none;}
</style>