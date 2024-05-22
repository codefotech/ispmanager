<?php
include("../web/conn/connection.php");
include("../web/company_info.php");
include("mk_api.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
session_start();
$API = new routeros_api();
$API->debug = false;

if($client_onlineclient_sts == '1'){
$items = array();
$sql34 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0'");
while ($roww = mysql_fetch_assoc($sql34)) {

		$ServerIP1 = $roww['ServerIP'];
		$Username1 = $roww['Username'];
		$Pass1= openssl_decrypt($roww['Pass'], $roww['e_Md'], $roww['secret_h']);
		$Port1 = $roww['Port'];
		if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)){
				$arrID = $API->comm('/ppp/active/getall');
				foreach($arrID as $x => $x_value) {
						$items[] = $x_value['name'];
				}
		 $API->disconnect();
		}
    $items = array_merge($items, $roww);
}
$total_active_connection = key(array_slice($items, -1, 1, true))+1;
$padddding = 'style="padding: 5px 0px;"';
}
else{
$padddding = 'style="padding: 15px 0px;"';
}

      $comid     = strip_tags(isset($_POST['com_id']) ? $_POST['com_id'] : '');
      $cid     = strip_tags(isset($_POST['c_id']) ? $_POST['c_id'] : '');
      $cname     = strip_tags(isset($_POST['c_name']) ? $_POST['c_name'] : '');
	  $cell     = strip_tags(isset($_POST['cell']) ? $_POST['cell'] : '');
	  $address     = strip_tags(isset($_POST['address']) ? $_POST['address'] : '');

     if($comid != ''){
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.com_id = '$comid' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND address = '$comid' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND address = '$comid' AND con_sts = 'Inactive'");
	}
	 if($cid != ''){
		$ccid = '%'.$cid.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.c_id LIKE '$ccid' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND c_id LIKE '$ccid' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND c_id LIKE '$ccid' AND con_sts = 'Inactive'");
	 }
	 
	  if($cname != ''){
		$ccname = '%'.$cname.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.c_name LIKE '$ccname' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND c_name LIKE '$ccname' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND c_name LIKE '$ccname' AND con_sts = 'Inactive'");
	 }
	 
	 if($cell != ''){
		 $phone = '%'.$cell.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.cell != '' AND c.cell LIKE '$phone' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND cell != '' AND mac_user !='1' AND cell LIKE '$phone' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND cell != '' AND mac_user !='1' AND cell LIKE '$phone' AND con_sts = 'Inactive'");
	 }
	 
	 if($address != ''){
		$aaa = '%'.$address.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.address != '' AND c.address LIKE '$aaa' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND address != '' AND mac_user !='1' AND address LIKE '$aaa' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND address != '' AND mac_user !='1' AND address LIKE '$aaa' AND con_sts = 'Inactive'");
	 }

	$total_count = mysql_num_rows($sql);
	
	$row22222 = mysql_fetch_assoc($query2266);
	$active_count = $row22222['active_count'];
	
	$row666 = mysql_fetch_assoc($query66);
	$inactive_count = $row666['inactive_count'];
	  
	  if($total_count == '0')
	  {
		  echo "<span style='color:brown;font-weight: bold;font-size: 18px;'>No Result Found</span>";
	  }
	  else
	  {

?>

<table id="dyntable" class="table table-bordered responsive" style="margin-top: 5px;width: 100%;">
                    <colgroup>
						<col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
                            <th class="head0" style="font-size: 10px;padding: 5px;text-align: center;">Client ID</th>
							<th class="head1" style="font-size: 10px;padding: 5px;text-align: center;">Mobile</th>
							<th class="head1" style="font-size: 10px;padding: 5px;text-align: center;">STS</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
								$x = 1;				
								 
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($client_onlineclient_sts == '1'){
									if(in_array($row['c_id'], $items) && $row['breseller'] != '1'){
										$clientactive = "<button style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 1px solid #0866c6;color: #0866c6;margin-top: 1px;' class='btn '>Online</button>";
									}
									else{
										$clientactive = "<button style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 1px solid red;color: red;margin-top: 1px;' class='btn inact'>Offline</button>";
									}
								}
								else{
									$clientactive = "";
								}
									if($row['con_sts'] == 'Active'){
										$clss = 'act';
										$dd = 'Inactive';
										$ee = 'Active';
										$colo = 'border: 1px solid green; font-size: 10px;';
									}
									if($row['con_sts'] == 'Inactive'){
										$clss = 'inact';
										$dd = 'Active';
										$ee = 'Inactive';
										$colo = 'border: 1px solid red; font-size: 8.5px;';	
									}
									if($row['log_sts'] == '0'){
										$aa = 'btn col2';
										$bb = "<i class='iconfa-unlock'></i>";
										$cc = 'Lock';
									}else{
										$aa = 'btn col3';
										$bb = "<i class='iconfa-lock pad4'></i>";
										$cc = 'Unlock';
									}
									if($row['breseller'] == '1'){
										$hhhh = 'D: '.$row['raw_download'] .' + U: '.$row['raw_upload'].' + Y: '.$row['youtube_bandwidth'].' = '.$row['total_bandwidth'].'mb <br> Rate: '.$row['total_price'];
									}
									else{
										$hhhh = $row['p_name'].'<br> ('.$row['bandwith'].')';
									}
									
									if($row['nid_back'] != ''){
										$nid_back = "<a href='{$row['nid_back']}' target='_blank' /><img src='/{$row['nid_back']}' width='20' height='12' style='border: 1px solid gray;'/></a>";
									}
									else{
										$nid_back = "";
									}
									if($row['nid_fond'] != ''){
										$nid_fond = "<a href='{$row['nid_fond']}' target='_blank' /><img src='/{$row['nid_fond']}' width='20' height='12' style='border: 1px solid gray;margin-right: 2px;'/></a>";
									}
									else{
										$nid_fond = "";
									}
									if($row['image'] != ''){
										$imgeeeee = "<a href='{$row['image']}' target='_blank' /><img src='/{$row['image']}' width='60' height='60' style='border: 1px solid gray;margin-bottom: 3px;'/></a>";
									}
									else{
										$imgeeeee = "";
									}
									echo
										"<tr class='gradeX'>
											<td class='center'>
												<ul class='tooltipsample' style='margin-bottom: 0px !important;'>
													<li style='font-size: 10px;padding: 0 5px 0 0;'><a href='ClientView?id={$row['c_id']}'>{$row['c_id']}</a><br/>{$row['c_name']}</li>
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample' style='margin-bottom: 0px !important;'>
													<li style='font-size: 10px;padding: 0 5px 0 0;'><a href='tel:{$row['cell']}'>{$row['cell']}</a><br/>{$row['z_name']}</li>
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample' style='margin-bottom: 0px !important;'>
													<li><a data-placement='top' data-rel='tooltip' style='padding: 3px 5px 3px 5px;font-weight: bold;{$colo}' href='#' data-original-title='{$dd}' class='btn {$clss}'>{$ee}</a><br><div style='margin-top: 2px;'>{$clientactive}</div></li>
												</ul>
											</td>
										</tr>\n ";
								}?>
					</tbody>
</table>
	  <?php  } ?>
