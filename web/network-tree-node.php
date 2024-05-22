<?php
date_default_timezone_set('Etc/GMT-6');
$dateTime = date('Y-m-01', time());
$now_date = date('Y-m-d', time());
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$node1 = isset($_GET['node1']) ? $_GET['node1'] : 'all';

if($node1 == 'all'){
$sql360 = mysql_query("SELECT d.id as idee, COUNT(n.device_type) AS devi, d.icon, d.d_name AS devicename FROM network_tree AS n
LEFT JOIN device AS d ON d.id = n.device_type
LEFT JOIN network_tree AS s ON s.tree_id = n.parent_id
GROUP BY n.device_type
order by COUNT(n.device_type) DESC");
}
else{
$sql360 = mysql_query("SELECT d.id as idee, COUNT(n.device_type) AS devi, d.icon, d.d_name AS devicename FROM network_tree AS n
LEFT JOIN device AS d ON d.id = n.device_type
LEFT JOIN network_tree AS s ON s.tree_id = n.parent_id
WHERE s.parent_id = '$node1' OR s.tree_id = '$node1' GROUP BY n.device_type
order by COUNT(n.device_type) DESC");
}
?>
			<table id="dyntable2" class="table table-bordered responsive" style="width: 100%;">
                    <colgroup>
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center" style="width: 3%;">ID</th>
							<th class="head0">Device Type</th>
							<th class="head1 center">ICON</th>
							<th class="head0">Total Count</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $rowwqq = mysql_fetch_assoc($sql360) )
								{
									echo
										"<tr class='gradeX'>
											<td class='center' style='font-size: 17px;font-weight: bold;color: darkred;'>{$rowwqq['idee']}</td>
											<td style='font-size: 17px;font-weight: bold;color: darkred;'>{$rowwqq['devicename']}</td>
											<td class='center'><img src='/{$rowwqq['icon']}' width='25' height='30' alt='' /></td>
											<td style='font-size: 17px;font-weight: bold;color: green;'>{$rowwqq['devi']}</td>
											<td class='center' style='width: 100px !important;'>
												<ul class='tooltipsample'>
													<li><form action='NetworkDeviceOnMap' method='post' target='_blank'><input type='hidden' name='d_type' value='{$rowwqq['id']}' /><button class='btn' style='border-radius: 3px;border: 1px solid #0866c6;color: #0866c6;padding: 6px 9px;' title='View Device On Map'><i class='iconfa-eye-open'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
			</table>
