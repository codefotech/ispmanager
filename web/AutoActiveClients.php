<table id="dyntable" class="table table-bordered responsive">
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
							<th class="head0">ID/Name/Cell</th>
							<th class="head1">Zone/Address</th>
							<th class="head0">Package</th>
							<th class="head0">Deadline</th>
							<th class="head1">Mac Address</th>
                            <th class="head0">IP</th>
							<th class="head1">Uptime</th>
							<th class="head0 center">MissMatch</th>
							<th class="head0 center">Status</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
		include("conn/connection.php");
		include("mk_api.php");	
		$mk_id = $_GET['id'];
		$sqlmk1 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk1 = mysql_fetch_assoc($sqlmk1);
		
		$ServerIP1 = $rowmk1['ServerIP'];
		$Username1 = $rowmk1['Username'];
		$Pass1= openssl_decrypt($rowmk1['Pass'], $rowmk1['e_Md'], $rowmk1['secret_h']);
		$Port1 = $rowmk1['Port'];
		$API = new routeros_api();
		$API->debug = false;
						if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)) {
								$arrID = $API->comm('/ppp/active/getall');
								echo "<div class='' id='responsecontainer'></div>";
								foreach($arrID as $x => $x_value) {
									
									$aaaaa = $x_value['name'];
									$ppp_mac = $x_value['caller-id'];
									$sql44 = mysql_query("SELECT c.c_name, c.mk_id, c.c_id, c.payment_deadline, m.Name, c.p_id, c.mac, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												WHERE c.c_id = '$aaaaa' ORDER BY c.id DESC");
									$rows1 = mysql_fetch_assoc($sql44);
									
									$sqlcon = mysql_query("SELECT s.c_id, s.con_sts, DATE_FORMAT(s.update_date, '%D %M %Y') AS update_date, s.update_time, s.update_by, e.e_name FROM con_sts_log AS s 
									LEFT JOIN emp_info AS e ON e.e_id = s.update_by
									WHERE s.c_id = '$aaaaa' AND s.con_sts = 'inactive' ORDER BY s.id DESC LIMIT 1");
									$rowcon = mysql_fetch_assoc($sqlcon);
									
									if($rows1['mk_id'] != $mk_id){
										$querysdfsd ="UPDATE clients SET mk_id = '$mk_id' WHERE c_id = '$aaaaa'";
										$resultsdgsd = mysql_query($querysdfsd) or die("inser_query failed: " . mysql_error() . "<br />");
									}
									
									if($rows1['c_name'] == ''){
										$colorrrr = 'style="color: red;"'; 
										$qqqqq = 'ID Not Matched'; 
										$bbbbb = '';
										$wwww = 'Not found in application databse';
										$dddd = "";
										} 
										else{
											if($rows1['mac'] == ''){
												$bindmac = 'Yes';
												$colllmac = 'col2';
											}
											else{
												$bindmac = 'No';
												$colllmac = 'col5';
											}
												$colorrrr = '';
												$qqqqq = "<form action='ClientView' method='post' target='_blank' data-placement='top' data-rel='tooltip' title='View Profile'><input type='hidden' name='ids' value=".$rows1['c_id']." /><button class='btn col1'><i class='iconfa-eye-open'></i></button></form>";
												if($rows1['con_sts'] == 'Active'){
													$clss = 'act';
													$ee = 'Active';
													$wwww = '-';
													$colorrrr = '';
													$bbbbb = "<a data-placement='top' data-rel='tooltip' class='btn {$clss}'>{$ee}</a>";
													$dddd = "";
												}
												if($rows1['con_sts'] == 'Inactive'){
													$clss = 'inact';
													$ee = 'Inactive';
													$colorrrr = 'style="color: red;"'; 
													if($rowcon['update_by'] == 'Auto'){$empname = 'Auto';} else{$empname = $rowcon['e_name'];}
													$wwww = $ee.' in application but Active in Mikrotik Since '.$rowcon['update_date'].' by '.$empname;
													$bbbbb = "<a data-placement='top' data-rel='tooltip' href='NetworkActiveTOInactive?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts1()'>Inactive him in Mikrotik</a>";
													$dddd = "OR<br><a data-placement='top' data-rel='tooltip' style='color: green;' href='ClientStatus?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts()'>Active him in Application</a>";
												}
												if($rows1['mac'] != $ppp_mac){
													$colorrrrr = 'style="font-size: 11px;font-weight: bold;"'; 
													$macccc = "
													<form action='MkToTisMacBind' method='post' enctype='multipart/form-data'>
														<input type='hidden' name='bind' value='{$bindmac}'/> 
														<input type='hidden' name='mk_id' value='{$mk_id}'/> 
														<input type='hidden' name='mkc_id' value='{$aaaaa}'/> 
														<input type='hidden' name='wayyy' value='act'/>
														<input type='hidden' name='mkmac' value='{$ppp_mac}'/>
														<input type='hidden' name='c_id' value='{$rows1['c_id']}'/>
														<button><i class='iconfa-signin' style='color: #044a8e;'></i></button>
													</form>"; 
													$macnot = 'MK: '.$ppp_mac.'<br> AP: '.$rows1['mac'];
													$massmac = '<br>MAC Address are not same.';
												}
												else{
													$colorrrrr = 'style="font-size: 11px;font-weight: bold;"'; 
													$macccc = "
													<form action='MkToTisMacBind' method='post' enctype='multipart/form-data'>
														<input type='hidden' name='bind' value='{$bindmac}'/> 
														<input type='hidden' name='mk_id' value='{$mk_id}'/> 
														<input type='hidden' name='mkc_id' value='{$aaaaa}'/> 
														<input type='hidden' name='mkmac' value=''/>
														<input type='hidden' name='wayyy' value='act'/>
														<input type='hidden' name='c_id' value='{$rows1['c_id']}'/>
														<button><i class='iconfa-trash' style='color: red;'></i></button>
													</form>"; 
													$macnot = 'MK: '.$ppp_mac.'<br> AP: '.$rows1['mac'];
													$massmac = '';
												}
											}
												
												$ppp_mac_replace = str_replace(":","-",$ppp_mac);
												$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);
												$macsearch = mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'");
												$macsearchaa = mysql_fetch_assoc($macsearch);
												$mac_device = $macsearchaa['info'];
									
									echo "<tr class='gradeX'>
											<td $colorrrr><b>" . $aaaaa . "</b><br>". $rows1['c_name'] ."<br> ". $rows1['cell'] ."</td>
											<td>" . $rows1['z_name'] ." <br> ". $rows1['address'] ."</td>
											<td>" . $rows1['p_name'] ." <br> ". $rows1['bandwith'] ."</td>
											<td>" . $rows1['payment_deadline'] ."</td>
											<td $colorrrrr>".$macnot."<br>".$mac_device." ".$macccc."</td>
											<td $colorrrr><form href='#myModal345345' data-toggle='modal' data-placement='top' data-rel='tooltip' title='Click for Ping'><button type='submit' value=".$x_value['address'].'&mk_id='.$mk_id." class='btn' onClick='getRoutePoint(this.value)'>".$x_value['address']."</button></form></td>
											<td $colorrrr id='responsecontainer'><b>" . $x_value['uptime'] ."</b></td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr><b>".$wwww."</b></li>
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr><b>".$bbbbb."<br>".$dddd."</b></li>
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr><b>".$qqqqq."</b></li>
												</ul>
											</td>
										</tr>";
									
								}
								 $API->disconnect();

						}
						else{echo 'Selected Network are not Connected.';}
?>
</tbody>
</table>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
			"aaSortingFixed": [[6,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
	<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	
	function getRoutePoint(afdId) {		
		
		var strURL="ip-ping-check2.php?ip="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>