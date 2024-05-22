<?php
date_default_timezone_set('Etc/GMT-6');
$dateTime = date('Y-m-01', time());

include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
$way = isset($_GET['way']) ? $_GET['way'] : '';
$z_id = isset($_GET['z_id']) ? $_GET['z_id'] : 'all';
$p_id = isset($_GET['p_id']) ? $_GET['p_id'] : 'all';
$box_id = isset($_GET['box_id']) ? $_GET['box_id'] : 'all';
$p_m = isset($_GET['p_m']) ? $_GET['p_m'] : 'all';
$con_sts = isset($_GET['con_sts']) ? $_GET['con_sts'] : 'all';
$p_id = isset($_GET['p_id']) ? $_GET['p_id'] : 'all';
$dt_date = isset($_GET['dt_date']) ? $_GET['dt_date'] : 'all';
$df_date = isset($_GET['df_date']) ? $_GET['df_date'] : 'all';
$partial = isset($_GET['partial']) ? $_GET['partial'] : 'all';
$old_payment_deadline = isset($_GET['old_payment_deadline']) ? $_GET['old_payment_deadline'] : 'all';
$old_b_date = isset($_GET['old_b_date']) ? $_GET['old_b_date'] : 'all';
$only_due = isset($_GET['only_due']) ? $_GET['only_due'] : 'no';
$old_con_sts = isset($_GET['old_con_sts']) ? $_GET['old_con_sts'] : 'all';
$dataway = isset($_GET['dataway']) ? $_GET['dataway'] : '';


if($way == 'ClientsDeadlineSet'){
	$sqlss = "SELECT count(t1.id) AS countcell FROM
												(
												SELECT c.id, c.c_id FROM clients AS c 
												LEFT JOIN zone AS z ON z.z_id = c.z_id
												WHERE c.mac_user = '0' AND c.sts = '0' AND c.breseller != '2'";  							
									if ($z_id != 'all') {
										$sqlss .= " AND c.z_id = '{$z_id}'";
									}
									if ($p_id != 'all') {
										$sqlss .= " AND c.p_id = '{$p_id}'";
									}
									if ($old_con_sts != 'all') {
										$sqlss .= " AND c.con_sts = '{$old_con_sts}'";
									}
									if ($old_payment_deadline != 'all'){
										$sqlss .= " AND c.payment_deadline = '{$old_payment_deadline}'";
									}
									else{
										$sqlss .= " AND c.payment_deadline = ''";
									}
									if ($old_b_date != 'all'){
										$sqlss .= " AND c.b_date = '{$old_b_date}'";
									}
									else{
										$sqlss .= " AND c.b_date = ''";
									}
										$sqlss .= ")t1
												LEFT JOIN
												(
												SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b
												GROUP BY b.c_id
												)t2
												ON t1.c_id = t2.c_id
												LEFT JOIN
												(
												SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p 											
												GROUP BY p.c_id
												)t3
												ON t1.c_id = t3.c_id"; 
									if ($only_due != 'no'){
										$sqlss .= " WHERE (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) > '0.99'";
									}
									
	$sqlssw = "SELECT t1.id, t1.com_id, t1.c_id, t1.c_name, t1.cell, t1.p_name, t1.address, t1.p_price, t1.bandwith, t1.con_sts, t1.z_name, t1.payment_deadline, t1.b_date, (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) AS dueamount FROM
												(
												SELECT c.id, c.com_id, c.address, c.c_id, c.c_name, c.cell, p.p_name, p.p_price, p.bandwith, z.z_name, c.payment_deadline, c.b_date, c.con_sts FROM clients AS c 
												LEFT JOIN zone AS z ON z.z_id = c.z_id
												LEFT JOIN package AS p ON p.p_id = c.p_id
												WHERE c.mac_user = '0' AND c.sts = '0' AND c.breseller != '2'";  							
									if ($z_id != 'all') {
										$sqlssw .= " AND c.z_id = '{$z_id}'";
									}
									if ($p_id != 'all') {
										$sqlssw .= " AND c.p_id = '{$p_id}'";
									}
									if ($old_con_sts != 'all') {
										$sqlssw .= " AND c.con_sts = '{$old_con_sts}'";
									}
									if ($old_payment_deadline != 'all'){
										$sqlssw .= " AND c.payment_deadline = '{$old_payment_deadline}'";
									}
									else{
										$sqlssw .= " AND c.payment_deadline = ''";
									}
									if ($old_b_date != 'all'){
										$sqlssw .= " AND c.b_date = '{$old_b_date}'";
									}
									else{
										$sqlssw .= " AND c.b_date = ''";
									}
										$sqlssw .= ")t1
												LEFT JOIN
												(
												SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b
												GROUP BY b.c_id
												)t2
												ON t1.c_id = t2.c_id
												LEFT JOIN
												(
												SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p 											
												GROUP BY p.c_id
												)t3
												ON t1.c_id = t3.c_id"; 
									if ($only_due != 'no'){
										$sqlssw .= " WHERE (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) > '0.99'";
									}
}

if($way == 'mresellerzonemulti'){
$sqlss = "SELECT COUNT(cell) AS countcell FROM clients WHERE sts = '0' AND cell !='0' AND cell !='88' AND cell !='' AND cell REGEXP '^-?[0-9]+$' AND mac_user = '1' AND z_id = '$z_id'";  							
		if($p_m != 'all'){
			$sqlss .= " AND p_m = '$p_m'";
		}
		if($box_id != 'all'){
			$sqlss .= " AND box_id = '$box_id'";
		}
		if($con_sts != 'all'){
			$sqlss .= " AND con_sts = '$con_sts'";
		}
}
if($way == 'zonemulti'){
$sqlss = "SELECT COUNT(cell) AS countcell FROM clients WHERE sts = '0' AND cell !='0' AND cell !='88' AND cell !='' AND cell REGEXP '^-?[0-9]+$' AND mac_user = '0'";  							
		if($z_id != 'all'){
			$sqlss .= " AND z_id = '$z_id'";
		}
		if($box_id != 'all'){
			$sqlss .= " AND box_id = '$box_id'";
		}
		if($p_m != 'all'){
			$sqlss .= " AND p_m = '$p_m'";
		}
		if($con_sts != 'all'){
			$sqlss .= " AND con_sts = '$con_sts'";
		}
}

if($way == 'mresellerpackmulti'){
$sqlss = "SELECT COUNT(cell) AS countcell FROM clients WHERE sts = '0' AND cell !='0' AND cell !='88' AND cell !='' AND cell REGEXP '^-?[0-9]+$' AND mac_user = '1' AND z_id = '$z_id'";  							
		if($p_id != 'all'){
			$sqlss .= " AND p_id = '$p_id'";
		}
		if($con_sts != 'all'){
			$sqlss .= " AND con_sts = '$con_sts'";
		}
}

if($way == 'packmulti'){
$sqlss = "SELECT COUNT(cell) AS countcell FROM clients WHERE sts = '0' AND cell !='0' AND cell !='88' AND cell !='' AND cell REGEXP '^-?[0-9]+$' AND mac_user = '0'";  							
		if($p_id != 'all'){
			$sqlss .= " AND p_id = '$p_id'";
		}
		if($con_sts != 'all'){
			$sqlss .= " AND con_sts = '$con_sts'";
		}
}

if($way == 'duebillwrite'){
$sqlss = "SELECT COUNT(cell) AS countcell FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
								LEFT JOIN (SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p WHERE MONTH(p.pay_date) = MONTH('$dateTime') AND YEAR(p.pay_date) = YEAR('$dateTime') GROUP BY p.c_id)p ON p.c_id = t.c_id
								WHERE c.sts = '0' AND t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.mac_user = '0' AND c.cell REGEXP '^-?[0-9]+$'";
		if($partial != 'all'){
			if($partial != '1') {
				$sqlss .= " AND p.totalpaymentamount is null";
			}
			else{
				$sqlss .= " AND p.totalpaymentamount != '0.00'";
			}
		}
		if ($df_date != 'all' && $dt_date != 'all'){
			$sqlss .= " AND c.payment_deadline BETWEEN '$df_date' AND '$dt_date'";
		}
		if ($df_date != 'all' && $dt_date == 'all'){
			$sqlss .= " AND c.payment_deadline = '$df_date'";
		}
		if ($df_date == 'all' && $dt_date != 'all'){
			$sqlss .= " AND c.payment_deadline BETWEEN '$dt_date' AND '$dt_date'";
		}
		if ($z_id != 'all'){
			$sqlss .= " AND c.z_id = '$z_id'";
		}
		if ($p_m != 'all'){
			$sqlss .= " AND c.p_m = '$p_m'";
		}
		if ($con_sts != 'all'){
			$sqlss .= " AND c.con_sts = '$con_sts'";
		}
}

if($way == 'mresellerduebillwrite'){
$sqlss = "SELECT COUNT(cell) AS countcell FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing_mac_client AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment_mac_client AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
								LEFT JOIN (SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment_mac_client AS p WHERE MONTH(p.pay_date) = MONTH('$dateTime') AND YEAR(p.pay_date) = YEAR('$dateTime') GROUP BY p.c_id)p ON p.c_id = t.c_id
								WHERE c.sts = '0' AND t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.z_id = '$z_id' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.mac_user = '1' AND c.cell REGEXP '^-?[0-9]+$'";  
		if($partial != 'all'){
			if($partial != '1') {
				$sqlss .= " AND p.totalpaymentamount is null";
			}
			else{
				$sqlss .= " AND p.totalpaymentamount != '0.00'";
			}
		}
		if ($box_id != 'all'){
			$sqlss .= " AND c.box_id = '$box_id'";
		}
		if ($p_m != 'all'){
			$sqlss .= " AND c.p_m = '$p_m'";
		}
		if ($con_sts != 'all'){
			$sqlss .= " AND c.con_sts = '$con_sts'";
		}
}


if($way == 'duebill'){
$sqlss = "SELECT COUNT(c.cell) AS countcell FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
								WHERE c.sts = '0' AND t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.mac_user = '0' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.cell REGEXP '^-?[0-9]+$'";  
		if ($z_id != 'all'){
			$sqlss .= " AND c.z_id = '$z_id'";
		}		
		if ($con_sts != 'all'){
			$sqlss .= " AND c.con_sts = '$con_sts'";
		}
}

if($way == 'mresellerduebill'){
$sqlss = "SELECT COUNT(c.cell) AS countcell FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing_mac_client AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment_mac_client AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
								WHERE c.sts = '0' AND t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.z_id = '$z_id' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.mac_user = '1' AND c.cell REGEXP '^-?[0-9]+$'";  
		if ($box_id != 'all'){
			$sqlss .= " AND c.box_id = '$box_id'";
		}
		if ($con_sts != 'all'){
			$sqlss .= " AND c.con_sts = '$con_sts'";
		}
}



if($dataway == 'info'){ 
$sqlddry = mysql_query($sqlssw);

$sqlsdftry = mysql_query($sqlss);
$rowsmt = mysql_fetch_assoc($sqlsdftry);
if($rowsmt['countcell'] > '0'){
?>
	<div class="box box-primary">
		<div class="box-header">
			<h5 style="font-size: 20px;font-weight: bold;margin: 5px 0 0px 10px;">SELECTED CLIENTS ARE [TOTAL FOUND: <a style="font-weight: bold;font-size: 20px;color:red;"><?php echo $rowsmt['countcell'];?></a>]</h5>
		</div>
			<div class="modal-content">
					<table id="dyntable2" class="table table-bordered responsive">
                    <colgroup>
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
							<th class="head1">Zone/Address</th>
							<th class="head0 center">Status</th>
							<th class="head0">Package</th>
							<th class="head1 center">Payment Deadline</th>
							<th class="head0 center">Billing Deadline</th>
							<th class="head1 center">Due</th>
                        </tr>
                    </thead>
						<tbody>
						<?php
									while( $row = mysql_fetch_assoc($sqlddry) )
									{
										if($row['con_sts'] == 'Active'){
											$collr = 'color: green;';
										}
										else{
											$collr = 'color: red;';
										}
										echo
											"<tr class='gradeX'>
												<td class='center' style='vertical-align: middle;font-size: 17px;font-weight: bold;'>{$row['com_id']}</td>
												<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b><br>{$row['cell']}</td>
												<td>{$row['z_name']}<br>{$row['address']}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 17px;text-transform: uppercase;{$collr}'>{$row['con_sts']}</td>
												<td>{$row['p_name']}<br>{$row['bandwith']} - {$row['p_price']}tk</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 20px;color: red;'>{$row['payment_deadline']}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 20px;color: red;'>{$row['b_date']}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 20px;color: red;'>{$row['dueamount']}</td>
											</tr>\n ";	
									}?>
						</tbody>
					</table>
			</div>
		
	</div>
<script type="text/javascript">
jQuery(document).ready(function(){
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
            "sScrollY": "1100px"
        });
    });
</script>
<style>
#dyntable_length{display: none;}
.dataTables_filter{margin: -42px 0 10px 80%;}
</style>
<?php }} else{
$sqlsdftry = mysql_query($sqlss);
$rowsmt = mysql_fetch_assoc($sqlsdftry);

echo $rowsmt['countcell'];
}
?>
