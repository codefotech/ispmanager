<?php
$titel = "Estimate Income";
$AgentView = 'active';

include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Agent' or module_name = 'AgentView' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($user_type == 'agent'){
	$agent_id = $e_id;
}

if($bill_month == ''){
$todaydate = date('Y-m-d', time());
$thismonth = date('M-Y', time());
}
else{
$todaydate = $bill_month;
$yrdata= strtotime($bill_month);
$thismonth = date('M-Y', $yrdata);
}


$sql1 = mysql_query("SELECT t1.c_id, t1.con_sts, DATE_FORMAT(t1.join_date, '%D-%M, %y') AS joindate, t1.cell, t1.c_name, t1.z_name, t1.p_name, t1.bandwith, t1.p_price, t1.address, t1.agent_per, t1.client_par, t1.count_commission, (t2.bill-IFNULL(t3.paid,0.00)) AS due, IFNULL(t3.paid,0), t2.bill, t1.qq,
CASE WHEN t1.count_commission = 1 THEN t1.qq*(t2.bill-t3.paid)/100 END AS tttt

FROM
(SELECT CASE WHEN c.com_percent = 0 THEN a.com_percent WHEN c.com_percent != 0 THEN c.com_percent END AS qq, a.com_percent AS agent_per, p.p_name, p.bandwith, p.p_price, c.c_id, c.com_percent AS client_par, c.count_commission, c.con_sts, c.join_date, c.cell, c.c_name, z.z_name, c.address FROM agent AS a
LEFT JOIN clients AS c ON c.agent_id = a.e_id
LEFT JOIN zone AS z ON z.z_id = c.z_id
LEFT JOIN package AS p ON p.p_id = c.p_id
WHERE a.e_id = '$agent_id' ORDER BY c.c_id ASC)t1
LEFT JOIN
(SELECT c_id, SUM(bill_amount) AS bill FROM billing GROUP BY c_id)t2
ON t2.c_id = t1.c_id
LEFT JOIN
(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment GROUP BY c_id)t3
ON t3.c_id = t1.c_id");

$loccc = mysql_num_rows($sql1);

$sql11 = mysql_query("SELECT p.c_id, SUM(p.pay_amount), SUM(p.commission_amount) AS commissionamount, q.p_name, q.bandwith, q.p_price, c.c_id, c.com_percent AS client_par, c.count_commission, c.con_sts, c.join_date, c.cell, c.c_name, z.z_name, c.address FROM payment AS p 
LEFT JOIN clients AS c ON c.c_id = p.c_id
LEFT JOIN zone AS z ON z.z_id = c.z_id
LEFT JOIN package AS q ON q.p_id = c.p_id
WHERE p.agent_id = '$agent_id' AND c.agent_id != '$agent_id' GROUP BY p.c_id");

$sql1zz1 = mysql_query("SELECT * FROM agent WHERE e_id = '$agent_id'");
$rowwzz = mysql_fetch_array($sql1zz1);

$resultaa = mysql_query("SELECT COUNT(c.c_id) AS totalclients FROM clients AS c
						WHERE c.agent_id = '$agent_id'");
$rowaa = mysql_fetch_array($resultaa);	

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
	
	<div class="pageheader">
        <div class="searchbar">
		<?php if($user_type == 'agent'){?>
		<div class="margillll ">
			<a href='AgentView' class='btn ownbtn5'><i class="iconfa-arrow-left"></i> Back to History</a>
        </div>
		<div class="margillll ">
			<form action='welcome' method='post'><button class='btn ownbtn2'>Ledger</button></form>
		</div>
		<?php } else{ ?>
		<div class="margillll ">
			<a href='AgentView?id=<?php echo $agent_id; ?>' class='btn ownbtn5'><i class="iconfa-arrow-left"></i> Back to History</a>
        </div>
		<div class="margillll ">
			<form action='ReportAgentLedger' method='post'><input type='hidden' name="agent_id" value="<?php echo $agent_id;?>" /><button class='btn ownbtn2'>Ledger</button></form>
		</div>
		<?php } ?>
		<div class="margillll ">
			<button class="btn ownbtn4" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')"><i class="iconfa-print"></i> Print</button>
        </div>
        </div>
        <div class="pageicon"><i class="iconfa-trophy"></i></div>
        <div class="pagetitle">
            <h1>Estimate Income (<?php echo $rowwzz['e_name'];?>)</h1>
        </div>
    </div><!--pageheader-->
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
						<td>&nbsp; <?php echo $rowaa['totalclients']; ?></td>
					</tr>	
				</table>
<br>		<?php if($loccc > '2'){ ?>
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
							<th class="head1">Client ID/Name/Cell</th>							
							<th class="head0">Zone/Address</th>	
							<th class="head1">Package/Bandwith</th>
							<th class="head0">Client Due</th>
							<th class="head1 center">Commission(TK)</th>
							<th class="head1 center">Commission(%)</th>
							<th class="head1 center">Amount (TK)</th>
                            <th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
						$x = 1;	
						
							while( $row1 = mysql_fetch_assoc($sql1) )
								{
									$ciddd = $row1['c_id'];
									$sql2r =mysql_query("SELECT COUNT(id) AS totalmonth FROM `billing` WHERE `c_id` = '$ciddd' AND p_price != '0.00' AND bill_amount != '0.00'");
									$rowrrd = mysql_fetch_assoc($sql2r);
									$totalmonth = $rowrrd['totalmonth'];
									
									$sql2re =mysql_query("SELECT SUM(amount) AS totalcomcount FROM `agent_commission` WHERE `c_id` = '$ciddd'");
									$rowrrde = mysql_fetch_assoc($sql2re);
									$totalcomcount = $rowrrde['totalcomcount'];
										
									if($row1['con_sts'] == 'Inactive'){
										$colorrrr = 'style="color: red;font-weight: bold;font-size: 12px;"';
										$colorr = 'style="color: red;font-weight: bold;font-size: 17px;text-align: center;"';
										$colorr33 = 'style="color: red;font-weight: bold;text-align: center;"';
										$colorr31 = 'style="color: green;font-weight: bold;text-align: center;"';
										$bodrcolor = 'style="border-top: 3px solid #ff6c6c;border-bottom: 3px solid #ff6c6c;"';
										
										$sql2oo ="SELECT DATE_FORMAT(update_date, '%D-%M, %y') AS update_date,DATE_FORMAT(update_time, '%h:%i%p') AS update_time FROM `con_sts_log` WHERE c_id = '$ciddd' ORDER BY id DESC LIMIT 1";
										$query2oo = mysql_query($sql2oo);
										$row2ff = mysql_fetch_assoc($query2oo);
										$updatedatee = ' & Inactive Since '.$row2ff['update_date'].' '.$row2ff['update_time'];
									}
									else{
										$colorrrr = 'style="color: green;font-weight: bold;font-size: 12px;"';
										$colorr = 'style="color: green;font-weight: bold;font-size: 17px;text-align: center;"';
										$colorr31 = 'style="color: green;font-weight: bold;text-align: center;"';
										$colorr33 = '';
										$bodrcolor = '';
										$updatedatee = '';
									}
									
									
									if($row1['due'] < 0){
										$dew = '0.00';
									}
									else{
										$dew = $row1['due'];
									}
									
									$amountcount = number_format($row1['tttt'],2);
									
									if($amountcount < 0){
										$amountcountt = '0.00';
									}
									else{
										$amountcountt = $amountcount;
									}
									
									$yrdata= strtotime($row1['bill_date']);
									$month = date('d M, Y', $yrdata);
									echo
										"<tr class='gradeX'>
											<td $bodrcolor>$x</td>
											<td $bodrcolor><b style='font-weight: bold;font-size: 13px;'>{$row1['c_id']}</b><br>{$row1['c_name']}<br>{$row1['cell']}<br><b $colorrrr>[{$row1['con_sts']}]</td>		
											<td $bodrcolor>{$row1['z_name']}<br>{$row1['address']}<br><b style='color: #317eac;font-weight: bold;text-align: center;'>Month Count: {$totalmonth}</b><br><b $colorr31>Joining Date: {$row1['joindate']}</b><b $colorr33>{$updatedatee}</b></td>	
											<td $bodrcolor>{$row1['p_name']}<br>[{$row1['bandwith']} - {$row1['p_price']}]</td>
											<td class='center' $bodrcolor><b $colorr>{$dew}</b></td>
											<td $bodrcolor class='center'><b style='font-size: 17px;color: #2e3192;'>{$totalcomcount}</b></td>
											<td $bodrcolor class='center'><b $colorr>{$row1['qq']}%</b></td>
											<td $bodrcolor class='center'><b style='font-size: 17px;color: #2e3192;'>{$amountcountt}</b></td>
											<td class='center' $bodrcolor>
												<ul class='tooltipsample'>
													<li><form action='ClientView' method='post' target='_blank'><input type='hidden' name='ids' value='{$row1['c_id']}' /><button class='btn col1'><i class='fa iconfa-eye-open'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
								$gggggg += $amountcountt;
								$totalcom += $totalcomcount;
										$x++;	
								}   
							?>
											<td><?php echo $x;?></td>
											<td></td>
											<td style="color: #044a8e;font-weight: bold;font-size: 17px;text-align: center;">[<?php echo $rowwzz['e_name'];?>] Estimate Income</td>
											<td></td>
											<td style="font-weight: bold;font-size: 17px;text-align: right;"><b>TOTAL</b></td>
											<td style="color: #044a9f;font-weight: bold;font-size: 17px;text-align: center;"><?php echo number_format($totalcom,2);?></td>
											<td style="font-weight: bold;font-size: 17px;text-align: right;"><b>TOTAL</b></td>
											<td style="color: #044a9f;font-weight: bold;font-size: 17px;text-align: center;"><?php echo number_format($gggggg,2);?></td>
											<td></td>
					</tbody>
				</table>
			</div>
			<?php } ?>
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
			"iDisplayLength": 1000,
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