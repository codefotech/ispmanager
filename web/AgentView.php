<?php
$titel = "Agent";
$Agent = 'active';
include('include/hader.php');
include("conn/connection.php") ;
$agentid = $_GET['id'];
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
if($user_type != 'agent'){
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Agent' AND $user_type = '1'");
}
else{
$access = mysql_query("SELECT * FROM module WHERE module_name = 'AgentView' AND $user_type = '1'");
}
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($user_type == 'agent'){
	$agentid = $e_id;
}

$crrntmonth = date('M-Y', time());

if($bill_month == ''){
$todaydate = date('Y-m-d', time());
$thismonth = date('M-Y', time());
}
else{
$todaydate = $bill_month;
$yrdata= strtotime($bill_month);
$thismonth = date('M-Y', $yrdata);
}

if($way == 'delete'){
	$querydf ="UPDATE agent_commission SET sts = '1' WHERE id = '$ids'";
	$resulthhh = mysql_query($querydf) or die("inser_query failed: " . mysql_error() . "<br />");
}

if($way == 'addcom' && $amount != ''){
	$queryfd="insert into agent_commission (agent_id, amount, bill_date, bill_time, purpose, note, entry_by)
					VALUES ('$agentid', '$amount', '$bill_date', '$bill_time', '$purpose', '$note', '$entry_by')";

	$resultgh = mysql_query($queryfd) or die("inser_query failed: " . mysql_error() . "<br />");
}


$sql1 = mysql_query("SELECT r.id, r.payment_id, r.c_id, c.c_name, c.cell, c.address, r.reseller_id, e.e_cont_per, e.e_pr_div, e.e_name AS resellername, r.purpose, r.z_id, z.z_name, r.com_percent, r.payment_amount, r.amount, r.bill_date, r.bill_time, r.note, f.e_name AS entryby FROM `agent_commission` AS r
LEFT JOIN emp_info AS e ON e.e_id = r.reseller_id
LEFT JOIN zone AS z ON z.z_id = r.z_id
LEFT JOIN emp_info AS f ON f.e_id = r.entry_by
LEFT JOIN clients AS c ON c.c_id = r.c_id
WHERE MONTH(r.bill_date) = MONTH('$todaydate') AND YEAR(r.bill_date) = YEAR('$todaydate') AND r.agent_id = '$agentid' AND r.sts = '0' ORDER BY r.id DESC");

$sql1zz1 = mysql_query("SELECT * FROM agent WHERE e_id = '$agentid'");
$rowwzz = mysql_fetch_array($sql1zz1);

$resultaa = mysql_query("SELECT COUNT(c.c_id) AS totalclients FROM clients AS c
						WHERE c.agent_id = '$agentid'");
$rowaa = mysql_fetch_array($resultaa);	

$resultaa1 = mysql_query("SELECT COUNT(e.e_id) AS totalclients FROM emp_info AS e
						WHERE e.agent_id = '$agentid'");
$rowaa1 = mysql_fetch_array($resultaa1);	

	?>
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
		   docprint.document.write('<head><title>Agent_Comission</title>');
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
	<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
	<input type="hidden" name="entry_by" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>"/>
	<input type="hidden" value="<?php echo date('Y-m-d');?>" name="bill_date" />
	<input type="hidden" value="<?php echo date('H:i:s');?>" name="bill_time" />
	<input type="hidden" value="<?php echo $agentid;?>" name="agentid" />
	<input type="hidden" value="addcom" name="way" />
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Add Extra Commission for <?php echo $rowwzz['e_name'];?></h5>
				</div>
				<div class="modal-body">
					<div class="popdiv">
						<div class="col-1">Agent Info</div>
						<div class="col-2"><input id="" type="text" readonly name="" class="input-xlarge" value="<?php echo $rowwzz['e_name'];?> || <?php echo $rowwzz['e_cont_per'];?> || <?php echo $rowwzz['com_percent'];?>%"></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Commission For</div>
						<div class="col-2"><input type="text" name="purpose" id="" placeholder="Purpose of Commission" class="input-xlarge" required="" /></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Amount</div>
						<div class="col-2"><input type="text" name="amount" id="" style="width:40%;" required="" placeholder=" Amount Of TK" /><input type="text" name="" id="" style="width:10%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly /></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Note</div>
						<div class="col-2"><input type="text" name="note" id="" placeholder="Expanse Note (If Any)" class="input-xlarge"/></div>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
			<div class="margillll ">
				<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
					<select name="bill_month" class="" style="height: 30px;padding: 6px 3px;font-weight: bold;border-radius: 3px;text-align: center;border-color: #918e8e;" onchange="submit();">
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
			 <?php if($user_type == 'admin' || $user_type == 'superadmin'){?>
			 <div class="margillll ">
				<a class="btn ownbtn5" href="#myModal" data-toggle="modal">Add Commission</a>
			 </div>
			  <?php } ?>
			 <div class="margillll ">
			 <?php if($user_type == 'agent'){?>
				<form action='welcome' method='post'><button class='btn ownbtn6'>Ledger</button></form>
			 <?php } else{ ?>
			 	<form action='ReportAgentLedger' method='post'><input type='hidden' name="agent_id" value="<?php echo $agentid; ?>" /><button class='btn ownbtn6'>Ledger</button></form>
			  <?php } ?>
			 </div>
			<div class="margillll">
				<form action="AgentEstimateIncome" method='post'><input type='hidden' name="agent_id" value="<?php echo $agentid; ?>" /><button class='btn ownbtn2'>Estimate Income</button></form>
			</div>
			<div class="margillll ">
				<button class="btn ownbtn4" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')"><i class="iconfa-print"></i> Print</button>
			</div>
        </div>
        <div class="pageicon"><i class="iconfa-user-md"></i></div>
        <div class="pagetitle">
            <h1>Agent Commission (<?php echo $thismonth; ?>)</h1>
        </div>
    </div><!--pageheader-->
	<?php if($way == 'addcom') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Commission Successfully Add in Your System.
			</div><!--alert-->
		<?php }?>
	<div class="box box-primary">
		<div class="box-header">
		<div id="divid">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:right">Agent Name &nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $rowwzz['e_name'];?></td>
								
						<th style="text-align:right">Cell&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $rowwzz['e_cont_per'];?></td>
						
						<th style="text-align:right">Address&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $rowwzz['pre_address'];?></td>
							
						<th style="text-align:right">Default&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $rowwzz['com_percent'];?>%</td>
							
						<th style="text-align:right">Current Clients&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $rowaa['totalclients']+$rowaa1['totalclients']; ?></td>
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">S/L</th>
							<th class="head1">Name/ID/Cell</th>							
							<th class="head0">Zone/Address</th>	
							<th class="head0">Purpose</th>
							<th class="head1">note</th>
							<th class="head0">Date</th>
							<th class="head1 center">Payment</th>
							<th class="head0 center">Commission(%)</th>
							<th class="head1 center">Amount (TK)</th>
                            <th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
						$x = 1;	
								while( $row1 = mysql_fetch_assoc($sql1) )
								{
									if($row1['con_sts'] == 'Inactive'){
										$colorrrr = 'style="color: red;font-weight: bold;font-size: 12px;"';
									}
									else{
										$colorrrr = 'style="color: green;font-weight: bold;font-size: 12px;"';
									}
									
									$yrdatadfd= strtotime($row1['bill_date']);
									$dfgdgd = date('M-Y', $yrdatadfd);
									
									if($row1['payment_id'] == '0'){
										if($crrntmonth == $dfgdgd){
											$delete = "<li><form action='AgentView?id={$agentid}' method='post'><input type='hidden' name='ids' value='{$row1['id']}'/><input type='hidden' name='way' value='delete'/><button class='btn ownbtn4' onclick='return checkDelete()'><i class='iconfa-trash'></i></button></form></li>";
										}
									}
									else{
										$delete = "";
									}
									$yrdata= strtotime($row1['bill_date']);
									$month = date('d M, Y', $yrdata);
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td><b style='font-weight: bold;font-size: 13px;'>{$row1['resellername']}{$row1['c_name']}</b><br>{$row1['reseller_id']}{$row1['c_id']}<br>{$row1['e_cont_per']}{$row1['cell']}</td>		
											<td>{$row1['z_name']}<br>{$row1['e_pr_div']}{$row1['address']}</td>	
											<td>{$row1['purpose']}</td>
											<td>{$row1['note']}</td>
											<td class='center'><b>{$month}</b><br>{$row1['bill_time']} <br> BY <br><b>[{$row1['entryby']}]</b></td>
											<td style='color: #2e3e4e;font-weight: bold;font-size: 15px;text-align: center;'>{$row1['payment_amount']}</td>
											<td style='color: #2e3e4e;font-weight: bold;font-size: 15px;text-align: center;'>{$row1['com_percent']}%</td>
											<td style='color: green;font-weight: bold;font-size: 17px;text-align: center;'>{$row1['amount']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
														{$delete}
												</ul>
											</td>
										</tr>\n ";
								$gggggg += $row1['amount'];
										$x++;	
								}  
							?>
											<td><?php echo $x;?></td>
											<td></td>
											<td style="color: #044a8e;font-weight: bold;font-size: 17px;text-align: center;"><?php echo $thismonth;?> Commission History</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td style="font-weight: bold;font-size: 17px;text-align: right;"><b>TOTAL</b></td>
											<td style="color: #044a9f;font-weight: bold;font-size: 17px;text-align: center;"><?php echo number_format($gggggg,2);?></td>
											<td></td>
					</tbody>
				</table>
			</div>
		</div></div>
		<div class="modal-footer">
				<button class="btn ownbtn4" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')"><i class="iconfa-print"></i> Print</button>
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
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<style>
#dyntable_length{display: none;}
</style>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}

function checksts(){
    return confirm('Change connection status!!  Are you sure?');
}

function checkLock(){
    return confirm('Are you sure?  Do u know what are you doing?');
}
</script>