<?php
$titel = "Zone Active Clients";
$Zone = 'active';
include('include/hader.php');
include("conn/connection.php");
include("mk_api.php");

$idz = $_GET['z_id'];
extract($_POST); 
ini_alter('date.timezone','Asia/Almaty');
$todaydate = date('Y-m-d', time());
$thismonth = date('M-Y', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Zone' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql1z1 = mysql_query("SELECT z_name FROM zone WHERE z_id = '$idz'");
$rowwz = mysql_fetch_array($sql1z1);
$znamee = $rowwz['z_name'];

							$sql = mysql_query("SELECT c.c_name, c.com_id, c.termination_date, c.onu_mac, c.mk_id, c.c_id, c.b_date, c.payment_deadline, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												WHERE c.sts = '0' AND z.z_id = '$idz' ORDER BY c.id DESC");
							
							$tot = mysql_num_rows($sql);
							
							$tit = "<div class='box-header'>
										<div class='hil'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
									</div>";

$API = new routeros_api();
$API->debug = false;
	?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" style="padding: 0px 4px 8px 4px;">
				<div class="row">
					<div class="popdiv">
						<div id='Pointdiv1'></div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
			<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
				<select name="user_status" style="font-weight: bold;font-size: 15px;width:185px;" onchange="submit();">
					<option value=""<?php if($user_status == '') echo 'selected="selected"';?>>All Clients</option>
					<option value="Online"<?php if($user_status == 'Online') echo 'selected="selected"';?> style="color: green;">Online Clients</option>
					<option value="Offline"<?php if($user_status == 'Offline') echo 'selected="selected"';?> style="color: red;">Offline Clients</option>
				</select>
			</form>        
		</div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Zone Clients Status</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header" style="font-size: 20px;padding: 15px 0px 2px 15px;">
		<h4>Showing All <?php echo $user_status;?> Clients On <?php echo $znamee;?></h4>
		</div>
		<div class="box-body">
		<div id="divid">
			<div id="hd">
				<table id="dyntable" class="table table-bordered responsive">
					<colgroup>
                        <col class="con1" />
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
							<th class="head1 center">S/L</th>
							<th class="head0">ID/Name/Cell</th>
							<th class="head1">Zone/Address</th>
							<th class="head0">Package</th>
							<th class="head1">Realtime Info</th>
							<th class="head0">Deadline</th>
							<th class="head1">Auto_Note</th>
							<th class="head0">Note</th>
							<th class="head0 center">Status</th>
                            <th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								$x = 0;				
								$onlinecounter = 0;				
								while( $row = mysql_fetch_assoc($sql) )
								{
											$mk_id = $row['mk_id'];
											$c_id = $row['c_id'];
											$sqlmk1 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h, graph, web_port FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
											$rowmk1 = mysql_fetch_assoc($sqlmk1);
											
											$ServerIP = $rowmk1['ServerIP'];
											$Username = $rowmk1['Username'];
											$Pass= openssl_decrypt($rowmk1['Pass'], $rowmk1['e_Md'], $rowmk1['secret_h']);
											$Port = $rowmk1['Port'];
											$graph = $rowmk1['graph'];
											$web_port = $rowmk1['web_port'];
													
											$interid = 'pppoe-'.$c_id;

										if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
											$API->write('/ppp/active/print', false);
											$API->write('?name='.$c_id);
											$res=$API->read(true);

											$ppp_name = $res[0]['name'];
											$ppp_mac = $res[0]['caller-id'];
											$ppp_ip = $res[0]['address'];
											$ppp_uptime = $res[0]['uptime'];
										if($ppp_mac == ''){
											$API->write('/ppp/secret/print', false);
											$API->write('?name='.$c_id);
											$ress=$API->read(true);
											
											$ppp_lastloggedout = $ress[0]['last-logged-out'];
										}
										else{}
											$API->disconnect();
										}
										else{
											echo 'Selected Network are not Connected';
										}
										if($ppp_mac != ''){
											$constsss = "<a style='color: green;font-weight: bold;margin-top: 10px;' class='btn'>Online</a>";
											$ppp_mac_replace = str_replace(":","-",$ppp_mac);
											$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);
											$macsearch = mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'");
											$macsearchaa = mysql_fetch_assoc($macsearch);
											$response = $macsearchaa['info'];
											$lastloggedout = '';
											$ppp_mac1 = $ppp_mac;
											$ppp_ip1 = $ppp_ip;
											$ppp_uptime1 = $ppp_uptime;
											$onlinecount = true;
											$ippingcheck = "<button href='#myModal' data-toggle='modal' data-placement='top' data-rel='tooltip' title='Click for Ping' type='submit' value='{$ppp_ip1}&mk_id={$mk_id}' class='btn' onClick='getRoutePoint(this.value)'>{$ppp_ip1}</button><br>";
										}
										else{
											$constsss = "<a style='color: red;font-weight: bold;margin-top: 10px;' class='btn'>Offline</a>";
											$response = '';
											$lastloggedout = $ppp_lastloggedout;
											$ppp_mac1 = '';
											$ppp_ip1 = '';
											$ppp_uptime1 = '';
											$onlinecount = false;
											$ippingcheck = "";
										}
										if($onlinecount == true){
											$onlinecounter++;
										}
									if($user_status == 'Online'){
										if($ppp_uptime != ''){
											$hideeeee = '';
										}
										else{
											$hideeeee = "style='display: none;'";
										}
									}
									if($user_status == 'Offline'){
										if($ppp_uptime == ''){
											$hideeeee = '';
										}
										else{
											$hideeeee = "style='display: none;'";
										}
									}
									if($row['con_sts'] == 'Active'){
										$clss = 'act';
										$dd = 'Inactive';
										$ee = 'Active';
									}
									if($row['con_sts'] == 'Inactive'){
										$clss = 'inact';
										$dd = 'Active';
										$ee = 'Inactive';
									}
									
									if($row['breseller'] == '1'){
										$hhhh = 'D: '.$row['raw_download'] .' + U: '.$row['raw_upload'].' + Y: '.$row['youtube_bandwidth'].' = '.$row['total_bandwidth'].'mb <br> Rate: '.$row['total_price'];
									}
									else{
										$hhhh = $row['p_name'].'<br> ('.$row['bandwith'].')';
									}
									echo
										"<tr class='gradeX'>
											<td class='center' $hideeeee>{$row['com_id']}</td>
											<td $hideeeee><b>{$row['c_id']}</b><br>{$row['c_name']}<br>{$row['cell']}<br>{$row['onu_mac']}</td>
											<td $hideeeee>{$row['z_name']}<br>{$row['address']}<br><b>[{$row['Name']}]</b></td>
											<td $hideeeee>{$hhhh}</td>
											<td $hideeeee>{$ippingcheck}<b>{$ppp_uptime1}{$lastloggedout}</b><br>{$ppp_mac1}<br><b style='font-size: 8px;'>{$response}</b></td>
											<td $hideeeee><b>PD: {$row['payment_deadline']}<br>BD: {$row['b_date']}</b></td>
											<td $hideeeee>{$row['note_auto']}</td>
											<td $hideeeee>{$row['note']}</td>
											<td class='center' $hideeeee>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='#' data-original-title='{$dd}' class='btn {$clss}' onclick='return checksts()'><b>{$ee}</b></a><br>{$constsss}</li>
												</ul>
											</td>	
											<td class='center' $hideeeee>
												<ul class='tooltipsample'>
													<li><form action='ClientView' method='post' target='_blank' data-placement='top' data-rel='tooltip' title='View Profile'><input type='hidden' name='ids' value='{$row['c_id']}' /><button class='btn col1'><i class='iconfa-eye-open'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}
							?>
							<td class='center'></td>
							<td class='center'></td>
							<td class='center'></td>
							<td class='center'></td>
							<td class='center'><a style="color: red;font-weight: bold;margin-top: 10px;font-size: 15px;">Offline</a></td>
							<td class='center'><a style="color: red;font-weight: bold;margin-top: 10px;font-size: 20px;"><?php echo $x-$onlinecounter;?></a></td>
							<td class='center'><a style="color: green;font-weight: bold;margin-top: 10px;font-size: 15px;">Online</a></td>
							<td class='center'><a style="color: green;font-weight: bold;margin-top: 10px;font-size: 20px;"><?php echo $onlinecounter;?></a></td>
							<td class='center'></td>
							<td class='center'></td>
					</tbody>
				</table>
				</div>
			</div>
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