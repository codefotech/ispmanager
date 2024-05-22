<?php
date_default_timezone_set('Etc/GMT-6');
$dateTime = date('Y-m-01', time());
$now_date = date('Y-m-d', time());
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$way = isset($_GET['way']) ? $_GET['way'] : '';
$z_id = isset($_GET['z_id']) ? $_GET['z_id'] : 'all';
$box_id = isset($_GET['box_id']) ? $_GET['box_id'] : 'all';
$search_way = isset($_GET['search_way']) ? $_GET['search_way'] : 'all';
$f_date = isset($_GET['f_date']) ? $_GET['f_date'] : $dateTime;
$t_date = isset($_GET['t_date']) ? $_GET['t_date'] : $now_date;
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'all';
$dataway = isset($_GET['dataway']) ? $_GET['dataway'] : '';


if($way == 'traffic_search'){
	if($search_way == 'client_wise'){
	$sqlss = "SELECT COUNT(c.c_id) AS totalcounttt, (sum(t.intotal_tx_rxx)) AS intotal_tx_rxx, sum(t.tx_bytee) AS tx_bytee, sum(t.rx_bytee) AS rx_bytee, sum(t.session_countt) AS session_countt FROM
				(SELECT c_id FROM clients WHERE sts = '0'";
				
				if ($z_id != 'all') {
					$sqlss .= " AND z_id = '{$z_id}'";
				}
				if ($box_id != 'all') {
					$sqlss .= " AND box_id = '{$box_id}'";
				}
					$sqlss .= ") AS c
							LEFT JOIN
							(
							SELECT c_id, ((sum(tx_byte)/1000000000) + (sum(rx_byte)/1000000000)) AS intotal_tx_rxx, (sum(tx_byte)/1000000000) AS tx_bytee, (sum(rx_byte)/1000000000) AS rx_bytee, COUNT(session_id) AS session_countt FROM client_bandwidth
							WHERE session_date BETWEEN '$f_date' AND '$t_date' GROUP BY c_id
							) AS t
							ON c.c_id = t.c_id
							WHERE t.intotal_tx_rxx IS NOT null"; 

	$sqlssw = "SELECT t.id, c.com_id, c.address, c.c_id, c.c_name, c.cell, p.p_name, p.p_price, p.bandwith, z.z_name, c.payment_deadline, c.b_date, c.con_sts, ((sum(t.tx_byte)/1000000000) + (sum(t.rx_byte)/1000000000)) AS intotal_tx_rx, t.session_date, DATE_FORMAT(t.date_time,'%Y, %m, %d, %H') AS dat2ss, (sum(t.tx_byte)/1000000000) AS tx_byte, (sum(t.rx_byte)/1000000000) AS rx_byte, COUNT(t.session_id) AS session_count FROM client_bandwidth AS t
				LEFT JOIN clients AS c ON c.c_id = t.c_id
				LEFT JOIN zone AS z ON z.z_id = c.z_id
				LEFT JOIN box AS b ON b.box_id = c.box_id
				LEFT JOIN package AS p ON p.p_id = c.p_id
				
				WHERE c.sts = '0' AND t.session_date BETWEEN '$f_date' AND '$t_date'";  	
				
									if ($z_id != 'all') {
										$sqlssw .= " AND c.z_id = '{$z_id}'";
									}
									if ($box_id != 'all') {
										$sqlssw .= " AND c.box_id = '{$box_id}'";
									}
									
										$sqlssw .= " GROUP BY t.c_id ORDER BY ((sum(t.tx_byte)/1000000000) + (sum(t.rx_byte)/1000000000)) DESC";
	}
	if($search_way == 'zone_wise'){
	$sqlss = "SELECT count(q.z_id) AS totalcounttt, (sum(s.intotal_tx_rxx)) AS intotal_tx_rxx, sum(s.tx_bytee) AS tx_bytee, sum(s.rx_bytee) AS rx_bytee, sum(s.session_countt) AS session_countt FROM
				(SELECT z_id FROM zone WHERE status = '0'";
				
				if ($z_id != 'all') {
					$sqlss .= " AND z_id = '{$z_id}'";
				}
					$sqlss .= ") AS q
							LEFT JOIN
							(
							SELECT z.z_id, ((sum(t.tx_byte)/1000000000) + (sum(t.rx_byte)/1000000000)) AS intotal_tx_rxx, (sum(t.tx_byte)/1000000000) AS tx_bytee, (sum(t.rx_byte)/1000000000) AS rx_bytee, COUNT(t.session_id) AS session_countt FROM client_bandwidth AS t
							LEFT JOIN clients AS c ON c.c_id = t.c_id
							LEFT JOIN zone AS z ON z.z_id = c.z_id
							WHERE t.session_date BETWEEN '$f_date' AND '$t_date' GROUP BY z.z_id
							) AS s
							ON q.z_id = s.z_id
							WHERE s.intotal_tx_rxx IS NOT null"; 

	$sqlssw = "SELECT t.id, z.z_id, z.e_id as resellrid, z.z_name, z.z_bn_name, ((sum(t.tx_byte)/1000000000) + (sum(t.rx_byte)/1000000000)) AS intotal_tx_rx, t.session_date, DATE_FORMAT(t.date_time,'%Y, %m, %d, %H') AS dat2ss, (sum(t.tx_byte)/1000000000) AS tx_byte, (sum(t.rx_byte)/1000000000) AS rx_byte, COUNT(t.session_id) AS session_count FROM client_bandwidth AS t
				LEFT JOIN clients AS c ON c.c_id = t.c_id
				LEFT JOIN zone AS z ON z.z_id = c.z_id
				LEFT JOIN box AS b ON b.box_id = c.box_id
				LEFT JOIN package AS p ON p.p_id = c.p_id
				
				WHERE c.sts = '0' AND t.session_date BETWEEN '$f_date' AND '$t_date'";  	
				
									if ($z_id != 'all') {
										$sqlssw .= " AND c.z_id = '{$z_id}'";
									}
									if ($box_id != 'all') {
										$sqlssw .= " AND c.box_id = '{$box_id}'";
									}
									
										$sqlssw .= " GROUP BY z.z_id ORDER BY ((sum(t.tx_byte)/1000000000) + (sum(t.rx_byte)/1000000000)) DESC";
	}
}

$sqlddry = mysql_query($sqlssw);
$sqlsdftry = mysql_query($sqlss);
$rowsmt = mysql_fetch_assoc($sqlsdftry);

if($rowsmt['tx_bytee'] >= 1024){
	$tx_bitss1 = $rowsmt['tx_bytee'] / 1000;
	$tx_bitss = number_format($tx_bitss1,2).'TB';
}
else{
	$tx_bitss = number_format($rowsmt['tx_bytee'],2).'GB';
}

if($rowsmt['rx_bytee'] >= 1024){
	$rx_bitss1 = $rowsmt['rx_bytee'] / 1000;
	$rx_bitss = number_format($rx_bitss1,2).'TB';
}
else{
	$rx_bitss = number_format($rowsmt['rx_bytee'],2).'GB';
}

if($rowsmt['intotal_tx_rxx'] >= 1024){
	$intotal_tx_rxx1 = $rowsmt['intotal_tx_rxx'] / 1000;
	$intotal_tx_rxxx = number_format($intotal_tx_rxx1,2).'TB';
}
else{
	$intotal_tx_rxxx = number_format($rowsmt['intotal_tx_rxx'],2).'GB';
}

if($rowsmt['totalcounttt'] > '0'){
	if($sort_by == 'hour'){
		$sqlsswt = "SELECT a.dat2ss, SUM(a.tx_byte) AS tx_byte, SUM(a.rx_byte) AS rx_byte, SUM(a.session_count) AS session_count FROM 
					(SELECT t.session_date, DATE_FORMAT(t.date_time,'%Y, %m, %d, %H') AS dat2ss, (sum(t.tx_byte)/1000000000) AS tx_byte, (sum(t.rx_byte)/1000000000) AS rx_byte, COUNT(t.session_id) AS session_count FROM `client_bandwidth` AS t
					 LEFT JOIN clients AS c ON c.c_id = t.c_id
					 WHERE c.sts = '0'";  	
				
									if ($z_id != 'all') {
										$sqlsswt .= " AND c.z_id = '{$z_id}'";
									}
									if ($box_id != 'all') {
										$sqlsswt .= " AND c.box_id = '{$box_id}'";
									}
									
										$sqlsswt .= " GROUP BY t.session_time,t.session_date ORDER BY DATE_FORMAT(t.date_time,'%Y, %m, %d, %H') ASC) AS a WHERE a.session_date BETWEEN '$f_date' AND '$t_date' GROUP BY a.dat2ss ORDER BY a.dat2ss ASC";
	}
	if($sort_by == 'day'){
		$sqlsswt = "SELECT a.dat2ss, SUM(a.tx_byte) AS tx_byte, SUM(a.rx_byte) AS rx_byte, SUM(a.session_count) AS session_count FROM 
					(SELECT t.session_date, DATE_FORMAT(t.date_time,'%Y, %m, %d') AS dat2ss, (sum(t.tx_byte)/1000000000) AS tx_byte, (sum(t.rx_byte)/1000000000) AS rx_byte, COUNT(t.session_id) AS session_count FROM `client_bandwidth` AS t
					 LEFT JOIN clients AS c ON c.c_id = t.c_id
					 WHERE c.sts = '0'";  	
				
									if ($z_id != 'all') {
										$sqlsswt .= " AND c.z_id = '{$z_id}'";
									}
									if ($box_id != 'all') {
										$sqlsswt .= " AND c.box_id = '{$box_id}'";
									}
									
										$sqlsswt .= " GROUP BY t.session_time,t.session_date ORDER BY DATE_FORMAT(t.date_time,'%Y, %m, %d') ASC) AS a WHERE a.session_date BETWEEN '$f_date' AND '$t_date' GROUP BY a.dat2ss ORDER BY a.dat2ss ASC";
	}
$sqlddrddfy = mysql_query($sqlsswt);
while($r30=mysql_fetch_assoc($sqlddrddfy)){
	$myurl30[]="[new Date(".$r30['dat2ss']."), ".$r30['tx_byte'].", ".$r30['rx_byte']."]";
}
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
<script type="text/javascript">
google.charts.load('current', {'packages':['annotationchart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Download(GB)');
        data.addColumn('number', 'Upload(GB)');
        data.addRows([
		<?php echo(implode(",",$myurl30));?>
		]);
        var chart = new google.visualization.AnnotationChart(document.getElementById('chart_div38'));
        var options = {
          displayAnnotations: true,
		  chart: {
            vAxis: {
              direction: 1
            }
          },
          range: {
            ui: {
              chartOptions: {
              vAxis: { direction: 1 }
              }
            }
          },
          displayAnnotationsFilter: true,
          thickness: 2,
          max: 10,
          min: 0
        };
        chart.draw(data, options);
      }
</script>
		<div id="chart_div38" style="width: 100%; height: 300px;"></div>
	<div class="box box-primary">
		<div class="box-header">
			<h5 style="font-size: 16px;font-weight: bold;margin: 5px 0 0px 10px;">[Total Records: <a style="font-weight: bold;font-size: 16px;color:red;"><?php echo $rowsmt['totalcounttt'];?></a>] | [Total TX: <a style="font-weight: bold;font-size: 16px;color:#36c;"><?php echo $tx_bitss;?></a>] | [Total RX: <a style="font-weight: bold;font-size: 16px;color:green;"><?php echo $rx_bitss;?></a>] | [Total (TX+RX): <a style="font-weight: bold;font-size: 16px;color:red;"><?php echo $intotal_tx_rxxx;?></a>]</h5>
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
						<?php if($search_way == 'client_wise'){ ?>
							<th class="head0 center">ComID</th>
							<th class="head1">ID/Name/Cell</th>
							<th class="head0">Zone/Address</th>
							<th class="head1 center">Status</th>
							<th class="head0">Package</th>
							<th class="head1 center">PD | BD</th>
							<th class="head0 center">Total Download</th>
							<th class="head1 center">Total Upload</th>
							<th class="head0 center">In Total (TX+RX)</th>
							<th class="head1 center">GB/TB</th>
							<th class="head0 center"></th>
						<?php } if($search_way == 'zone_wise'){ ?>
							<th class="head0 center">Zone ID</th>
							<th class="head1">Zone Name</th>
							<th class="head0 center">Total Download</th>
							<th class="head1 center">Total Upload</th>
							<th class="head0 center">In Total (TX+RX)</th>
							<th class="head1 center">GB/TB</th>
							<th class="head0 center"></th>
						<?php } ?>
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
										
										if($row['tx_byte'] >= 1024){
											$tx_byte1 = $row['tx_byte'] / 1000;
											$total_tx_byte = number_format($tx_byte1,2).'TB';
										}
										else{
											$total_tx_byte = number_format($row['tx_byte'],2).'GB';
										}
										
										if($row['rx_byte'] >= 1024){
											$rx_byte1 = $row['rx_byte'] / 1000;
											$total_rx_byte = number_format($rx_byte1,2).'TB';
										}
										else{
											$total_rx_byte = number_format($row['rx_byte'],2).'GB';
										}
										
										if($row['intotal_tx_rx'] >= 1024){
											$intotal_tx_rx1 = $row['intotal_tx_rx'] / 1000;
											$intotal = number_format($intotal_tx_rx1,2);
											$cazzzz = 'TB';
										}
										else{
											$intotal = number_format($row['intotal_tx_rx'],2);
											$cazzzz = 'GB';
										}
										
										if($search_way == 'client_wise'){ 
										echo
											"<tr class='gradeX'>
												<td class='center' style='vertical-align: middle;font-size: 17px;font-weight: bold;'>{$row['com_id']}</td>
												<td style='vertical-align: middle;'><b>{$row['c_id']}</b><br>{$row['c_name']}</b><br>{$row['cell']}</td>
												<td style='vertical-align: middle;width: 20%;'>{$row['z_name']}<br>{$row['address']}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 15px;text-transform: uppercase;{$collr}'>{$row['con_sts']}</td>
												<td style='vertical-align: middle;'>{$row['p_name']}<br>{$row['bandwith']} - {$row['p_price']}tk</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 14px;'>{$row['payment_deadline']} | {$row['b_date']}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 16px;color: #36c;'>{$total_tx_byte}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 16px;color: green;'>{$total_rx_byte}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 16px;color: red;'>{$intotal}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 16px;'>{$cazzzz}</td>
												<td class='center' style='vertical-align: middle;'>
													<ul class='tooltipsample'>
														<li><form action='ClientView' method='post' target='_blank' data-placement='top' data-rel='tooltip' title='View Profile'><input type='hidden' name='ids' value='{$row['c_id']}' /><button class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></button></form></li>
													</ul>
												</td>												
												
											</tr>\n";	
										}
										if($search_way == 'zone_wise'){
											if($row['z_bn_name'] != '')
											{
												$zbangla = ' ('.$row['z_bn_name'].')';
											}
											else{
												$zbangla = '';
											}
											if($row['resellrid'] != ''){
												$zoneclient = 'Clients?id=macclient&';
											}
											else{
												$zoneclient = 'Clients?id=all&';
											}
											$queryaaaa = mysql_query("SELECT COUNT(id) AS activeclient FROM clients WHERE con_sts = 'Active' AND z_id = '{$row['z_id']}' AND sts = '0'");
											$rowaaaa = mysql_fetch_assoc($queryaaaa);

											$activeclient = $rowaaaa['activeclient'];
											
											$queryiiiii = mysql_query("SELECT COUNT(id) AS inactiveclient FROM clients WHERE con_sts = 'Inactive' AND z_id = '{$row['z_id']}' AND sts = '0'");
											$rowiii = mysql_fetch_assoc($queryiiiii);

											$inactiveclient = $rowiii['inactiveclient'];
											
											$totalclients = $activeclient + $inactiveclient;
										echo
											"<tr class='gradeX'>
												<td class='center' style='vertical-align: middle;font-size: 17px;font-weight: bold;'>{$row['z_id']}</td>
												<td style='vertical-align: middle;font-weight: bold;'><b style='font-weight: bold;font-size: 18px;'>{$row['z_name']} {$zbangla}</b><br><b style='color: #00a65a;font-weight: bold;'>Active:</b> {$activeclient}<br><b style='color: #b94a48;font-weight: bold;'>Inactive:</b> {$inactiveclient}<br><b style='font-weight: bold;'>Total:</b> {$totalclients}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 22px;color: #36c;'>{$total_tx_byte}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 22px;color: green;'>{$total_rx_byte}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 22px;color: red;'>{$intotal}</td>
												<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 22px;'>{$cazzzz}</td>
												<td class='center' style='vertical-align: middle;'>
													<ul class='tooltipsample'>
														<li><a href='{$zoneclient}zid={$row['z_id']}' target='_blank' class='btn ownbtn2' title='Check All Clients' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></a></li>
													</ul>
												</td>
											</tr>\n";	
										}
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
			"aaSorting": [[<?php if($search_way == 'client_wise'){echo '9';} if($search_way == 'zone_wise'){echo '5';}?>,'desc']],
            "sScrollY": "1100px"
        });
    });
</script>
<style>
#dyntable_length{display: none;}
.dataTables_filter{margin: -42px 0 10px 80%;}
</style>
<?php }
?>
