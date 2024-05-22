<?php
$titel = "Reports";
$Reports = 'active';
$ReportAgentLedger = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(174, $access_arry)){
//---------- Permission -----------
$userName = $_SESSION['SESS_FIRST_NAME'];
$Date = date('d/m/Y');

if($f_date == '' || $t_date == ''){
$f_date = date("Y-m-01");
$t_date = date("Y-m-d");}

?>
	<div class="pageheader">
        <div class="searchbar" style="right: 0px;">
		<form id="" name="form" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
			<input type="text" name="f_date" id="" style="width:30%;text-align: center;" placeholder="From Date" class="surch_emp datepicker" value="<?php echo $f_date; ?>"/>
			<input type="text" name="t_date" id="" style="width:30%;text-align: center;" placeholder="To Date" class="surch_emp datepicker" value="<?php echo $t_date; ?>"/>
			<input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>"/>
			<button class="btn col5" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
		</form>
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Agent Ledger</h1>
        </div>
    </div><!--pageheader-->
		<div class="box-header row-fluid" style="width: 98% !important;">
			<div class="span3 profile-left" style="">
				<div class="list-group">
					<?php require('include/Reports_menu.php'); ?>
				</div>
			</div>
			<div class="span9 rightside" style="width: 74% !important; margin-left: 15px !important;">
				<div class="box box-primary" style=" margin: 0px;">
					<div class="box-body" style="min-height: 440px;">
						<center>
					<?php if($agent_id !=''){
					$sqlop1 = mysql_query("SELECT SUM(amount) AS ISP FROM agent_commission WHERE sts = '0' AND agent_id = '$agent_id' AND bill_date < '$f_date'");

					$rowop1 = mysql_fetch_array($sqlop1);
					$fundReceivedOp = $rowop1['ISP'];
					
					$sqlopCr1 = mysql_query("SELECT SUM(amount) AS VPT FROM expanse WHERE agent_id = '$agent_id' AND status = '2' AND ex_date < '$f_date'");
					
					$rowop7 = mysql_fetch_array($sqlopCr1);
					$fundSendOp = $rowop7['VPT'];
					
					
					$openingRecived = $fundReceivedOp;
					$openingPayment = $fundSendOp;
					
					$openingBalance = $openingRecived - $openingPayment;
					
					$Bankkk = mysql_query("SELECT e_id, e_name, e_cont_per, email, com_percent, e_j_date AS join_date FROM agent WHERE e_id = '$agent_id'");
					$Bnkkk=mysql_fetch_array($Bankkk);
					$agentname = $Bnkkk['e_name'];
					$agentcell = $Bnkkk['e_cont_per'];
					$agentcom_percent = $Bnkkk['com_percent'];
					$agentemail = $Bnkkk['email'];
					$agentjoin_date = $Bnkkk['join_date'];
					?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="padding-top: 5px;">Name:</th>
						<td><?php echo $agentname.' ('.$agentcom_percent.'%)';?></td>
								
						<th style="padding-top: 5px;">Cell:</th>
						<td><?php echo $agentcell; ?></td>
						
						<th style="padding-top: 5px;">Email:</th>
						<td><?php echo $agentemail; ?></td>
						
						<th style="padding-top: 5px;">joining Date:</th>
						<td><?php echo $agentjoin_date; ?></td>
					</tr>	
				</table>
			</div>
					<table id="dyntable" class="table table-bordered responsive">
						<colgroup>
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
									<th class="head0">Date</th>
									<th class="head1">Particulars</th>
									<th class="head0">Commission</th>
									<th class="head1">Paid Amount</th>
									<th class="head0">Balance</th>
									<th class="head1">Note</th>
								</tr>
						</thead>
					<tbody>
					<tr class='gradeX'>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align: right;"><b>Opeaning Balance:</b></td>
					<td><b><?php echo $openingBalance; ?></b></td>
					<td></td>
					</tr>
					<?php			
					$x = 1;
					$TotBalanceTransferRcv = 0;	
					$TotalVendCr = 0;
					
		while (strtotime($f_date) <= strtotime($t_date)) {	
		//------------------------------------------------------------Received Amount---------------------------------------------------------------------------------	
			
			$sqlfgj = mysql_query("SELECT p.id AS vp_id, p.payment_amount, q.e_name AS resellername, p.purpose, q.e_id AS agentidddd, c.cell, c.c_name, p.c_id, p.com_percent AS compercent, DATE_FORMAT(p.bill_date, '%D %b-%y') AS bill_date, DATE_FORMAT(p.bill_time, '%h:%i%p') AS bill_time, p.agent_id, a.e_name AS agent_name, a.e_cont_per, a.com_percent, p.amount, p.entry_by, e.e_name, p.sts, p.note FROM `agent_commission` AS p
											LEFT JOIN agent AS a ON a.e_id = p.agent_id
											LEFT JOIN emp_info AS q ON q.e_id = p.reseller_id
											LEFT JOIN emp_info AS e ON e.e_id = p.entry_by
											LEFT JOIN clients AS c ON c.c_id = p.c_id
											WHERE p.sts = '0' AND p.agent_id = '$agent_id' AND p.bill_date = '$f_date' ORDER BY p.bill_date_time DESC");
			$InstumentPurchase = 0;
			while ($rowert = mysql_fetch_array($sqlfgj)) {?>
				<tr class='gradeX'>
					<td><b><?php echo $rowert['bill_date'];?></b><br><?php echo $rowert['bill_time']; ?></td>
				<?php if($rowert['c_id'] == '' && $rowert['agentidddd'] == ''){?>
					<td>Extra Commission Added for <?php echo $rowert['purpose'];?> [By <?php echo $rowert['e_name'];?>]</td>
				<?php } else{?>
					<td><b><?php echo $rowert['compercent'];?>%</b> Commission for <b><?php echo $rowert['c_name'];?><?php echo $rowert['resellername'];?> (<?php echo $rowert['c_id'];?><?php echo $rowert['agentidddd'];?>)</b> Payment <b><?php echo $rowert['payment_amount'];?>tk</b> [By <?php echo $rowert['e_name'];?>]</td>
				<?php } ?>
					<td><?php echo $rowert['amount'].'/='; ?></td>
					<td class='center'>-</td>
					<td></td>
					<td><?php echo $rowert['note'];?></td>
				</tr>
			<?php	$InstumentPurchase += $rowert['amount'];
			}
		

	//------------------------------------------------------------Paid Amount---------------------------------------------------------------------------------
	
			$sqlCr = mysql_query("SELECT e.voucher, x.ex_type, DATE_FORMAT(e.ex_date, '%D %b-%y') AS ex_date, e.`ex_by`, i.e_name AS ex_by, e.`type`, e.`amount`, e.`mathod`, e.`entry_by`, q.e_name AS entry_by, DATE_FORMAT(e.enty_date, '%h:%i%p') AS enty_date , e.`note`, e.`v_id`, b.bank_name FROM `expanse` AS e 
									LEFT JOIN expanse_type AS x ON x.id = e.type
									LEFT JOIN emp_info AS i ON i.e_id = e.ex_by
									LEFT JOIN emp_info AS q ON q.e_id = e.entry_by
									LEFT JOIN bank AS b ON b.id = e.bank
									WHERE e.agent_id = '$agent_id' AND e.`status` = '2' AND e.`ex_date` = '$f_date' ORDER BY e.ex_date DESC");
			$VendorPaymentAmountCr = 0;
			while ($rowCr = mysql_fetch_array($sqlCr)) {?>
				<tr class='gradeX'>
					<td><b><?php echo $rowCr['ex_date']; ?></b><br><?php echo $rowCr['enty_date']; ?></td>
					<td><?php echo $rowCr['ex_type']; ?> [Paid by <?php echo $rowCr['ex_by'];?> by <?php echo $rowCr['mathod'];?>] [Bank: <?php echo $rowCr['bank_name'];?>]</td>
					<td class="center">-</td>
					<td><?php echo $rowCr['amount'].'/='; ?></td>
					<td></td>
					<td><?php echo $rowCr['note']; ?></td>
				</tr>
			<?php	$VendorPaymentAmountCr += $rowCr['amount'];
			}
			

			$f_date = date ("Y-m-d", strtotime("+1 days", strtotime($f_date)));
			$x++;
			$TotBalanceTransferRcv += $InstumentPurchase;
			$TotalVendCr += $VendorPaymentAmountCr;
		}	

			$ReciveTotal = $TotBalanceTransferRcv;
			$PaidTotal = $TotalVendCr;?>
				<tr class='gradeX'>
					<td></td>
					<td style="text-align: right;"><b>TOTAL:</b></td>
					<td><b><?php echo number_format($ReciveTotal,2); ?></b></td>
					<td><b><?php echo number_format($PaidTotal,2); ?></b></td>
					<td><b><?php echo number_format((($ReciveTotal + $openingBalance) - $PaidTotal),2); ?></b></td>
					<td></td>
				</tr>
					</tbody>
						</table>
					<?php } if($agent_id ==''){ ?>
						<table id="dyntable" class="table table-bordered responsive">
							<colgroup>
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
									<th class="head0">SL</th>
									<th class="head1">Agent</th>
									<th class="head1">Opeaning Balance</th>
									<th class="head0">Bill Amount</th>
									<th class="head1">Paid Amount</th>
									<th class="head0">Balance</th>
									<th class="head1 center">Action</th>
								</tr>
							</thead>
							<tbody>
				<?php $sqlBank = mysql_query("SELECT e_id, e_name, e_cont_per AS cell, email, com_percent, e_j_date AS join_date FROM agent ORDER BY e_id ASC");
				$x = 1;
				$TotBalance = 0;
				$ReceivedAmountt = 0;
				$PaymentAmountt = 0;
				while ($rowBank = mysql_fetch_array($sqlBank)) {
					$VenId = $rowBank['e_id'];
					$VenName = $rowBank['e_name'];
					$VenCell = $rowBank['cell'];
					$VenEmail = $rowBank['email'];
					$VenLocation = $rowBank['com_percent'].'%';
					
					$sqlOp = mysql_query("SELECT * FROM 
										(
										SELECT e_id, e_name, e_cont_per AS cell FROM agent WHERE e_id = '$VenId'
										)a
										LEFT JOIN
										(
										SELECT agent_id, SUM(amount) AS insprice FROM agent_commission WHERE sts = '0' AND agent_id = '$VenId' AND bill_date < '$f_date'
										)b ON a.e_id = b.agent_id");
					$rowOp = mysql_fetch_array($sqlOp);		
					$ReceivedAmountOp = $rowOp['insprice'];
					
					$sqlOp1 = mysql_query("SELECT * FROM 
										(
										SELECT e_id, e_name, e_cont_per AS cell FROM agent WHERE e_id = '$VenId'
										)a
										LEFT JOIN
										(
										SELECT agent_id, IFNULL(SUM(amount), 0) AS vanpayamount FROM expanse WHERE agent_id = '$VenId' AND status = '2' AND ex_date < '$f_date'
										)b ON a.e_id = b.agent_id");
					$rowOp1 = mysql_fetch_array($sqlOp1);		
					$PaymentAmountOp = $rowOp1['vanpayamount'];
					$OpeningAmount = $ReceivedAmountOp - $PaymentAmountOp;
					
					$sql = mysql_query("SELECT * FROM 
										(
										SELECT e_id, e_name, e_cont_per AS cell FROM agent WHERE e_id = '$VenId'
										)a
										LEFT JOIN
										(
										SELECT agent_id, IFNULL(SUM(amount), 0) AS insprice FROM agent_commission WHERE sts = '0' AND agent_id = '$VenId' AND bill_date BETWEEN '$f_date' AND '$t_date'
										)b ON a.e_id = b.agent_id");
					$row = mysql_fetch_array($sql);		
					$ReceivedAmount = $row['insprice'] + $row['fibprice'];
					
					$sql1 = mysql_query("SELECT a.e_id, b.agent_id, IFNULL(b.vanpaya, 0) AS vanpayamount FROM 
										(
										SELECT e_id, e_name, e_cont_per AS cell FROM agent WHERE e_id = '$VenId'
										)a
										LEFT JOIN
										(
										SELECT agent_id, SUM(amount) AS vanpaya FROM expanse WHERE agent_id = '$VenId' AND status = '2' AND ex_date BETWEEN '$f_date' AND '$t_date'
										)b ON a.e_id = b.agent_id");
					$row1 = mysql_fetch_array($sql1);
					$PaymentAmount = $row1['vanpayamount'];
					$Balance = (($ReceivedAmount + $OpeningAmount) - $PaymentAmount);

					echo
												"<tr class='gradeX'>
													<td>{$x}</td>
													<td><b>{$VenName}</b><br>{$VenCell}<br>{$VenLocation}<br>{$VenEmail}</td>
													<td>{$OpeningAmount}</td>
													<td>{$ReceivedAmount}</td>
													<td>{$PaymentAmount}</td>
													<td><b>{$Balance}</b></td>
													<td class='center'>
														<ul class='tooltipsample'>
															<li><form action='ReportAgentLedger' method='post'><input type='hidden' name='agent_id' value='{$VenId}' /><button class='btn col1' onClick='submit();'><i class='fa iconfa-eye-open'></i></button></form></li>
															<li><a data-placement='top' data-rel='tooltip' href='#?id=",$id,"{$VenId}' data-original-title='Print' class='btn col5'><i class='iconfa-print'></i></a></li>
														</ul>
													</td>
												</tr>\n";
				
					$x++;
					$ReceivedAmountt += $ReceivedAmount;
					$PaymentAmountt += $PaymentAmount;
					$TotBalance += $Balance;
					
				}?>
												<td></td>
												<td></td>
												<td style="text-align: right;"><b>TOTAL:</b></td>
												<td><b><?php echo $ReceivedAmountt; ?></b></td>
												<td><b><?php echo $PaymentAmountt; ?></b></td>
												<td><b><?php echo $TotBalance; ?></b></td>
												<td></td>
							</tbody>
						</table>
					<?php } ?>
						</center>
					</div>
				</div>
			</div>
		</div>
<?php
}
else{
	session_unset();
	session_destroy();
}
include('include/footer.php');
?>