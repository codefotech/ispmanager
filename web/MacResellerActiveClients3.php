<?php
$titel = "Reseller Clients Current Status";
$Clients = 'active';
include('include/hader.php');
include("conn/connection.php");
include("mk_api.php");

if($userr_typ == 'mreseller'){
	$idz = $macz_id;
}
else{
$idz = $_GET['id'];
}

extract($_POST); 

ini_alter('date.timezone','Asia/Almaty');
$todaydate = date('Y-m-d', time());
$thismonth = date('M-Y', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql1z1 = mysql_query("SELECT e.mk_id, e.e_name AS reseller_name, z.z_name FROM `zone` AS z
						LEFT JOIN emp_info AS e ON e.e_id = z.e_id
						WHERE z.z_id = '$idz' AND z.status = '0' ");
$rowwz = mysql_fetch_array($sql1z1);

$mkid = $rowwz['mk_id'];
$reseller_name = $rowwz['reseller_name'];
$znamee = $rowwz['z_name'];

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
        <div class="pageicon"><i class="iconfa-globe"></i></div>
        <div class="pagetitle">
            <h1>Reseller Clients Status</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header" style="font-size: 20px;padding: 15px 0px 2px 15px;">
		<h4>Showing All <?php echo $user_status;?> Clients On <?php echo $znamee.' ('.$reseller_name.')';?></h4>
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1">S/L</th>
							<th class="head0">ID/Name/Cell</th>
							<th class="head1">Zone/Address</th>
							<th class="head0">Package</th>
							<th class="head1">Mac Address</th>
                            <th class="head0">IP</th>
							<th class="head1">Uptime/Last-Logged-Out</th>
							<th class="head0 center">Status</th>
							<th class="head0 center">Profile</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
						$sqlmk1 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mkid'");
						$rowmk1 = mysql_fetch_assoc($sqlmk1);
						
						$ServerIP1 = $rowmk1['ServerIP'];
						$Username1 = $rowmk1['Username'];
						$Pass1= openssl_decrypt($rowmk1['Pass'], $rowmk1['e_Md'], $rowmk1['secret_h']);
						$Port1 = $rowmk1['Port'];
						$API = new routeros_api();
						$API->debug = false;
						if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)) {
								$arrID = $API->comm('/ppp/active/getall');								
								foreach($arrID as $x => $x_value) {
									$aaaaa[] = $x_value['name'];
								}				
								$idList = implode("','",$aaaaa);
	$sqlcount = mysql_query("SELECT id FROM clients WHERE z_id = '$idz' AND sts = '0' AND c_id IN ('$idList')");
	$activ_count = mysql_num_rows($sqlcount);
	
	$sqlcounty = mysql_query("SELECT id FROM clients WHERE z_id = '$idz' AND sts = '0'");
	$inactiv_count = mysql_num_rows($sqlcounty);
								
	$sql44 = mysql_query("SELECT c.c_name, e.e_name AS resellername, c.c_id, c.mk_id, c.payment_deadline, c.p_id, p.p_name, p.bandwith, p.p_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN emp_info AS e ON e.e_id = z.e_id 
												
												WHERE z.z_id = '$idz' AND c.sts = '0' ORDER BY c.c_id ASC");

$x = 1;	
	while( $rows1 = mysql_fetch_assoc($sql44) ){
		
		if($rows1['con_sts'] == 'Active'){
		$clss = 'act';
		$dd = 'Inactive';
		$ee = 'Active';
		$collllr = 'border-radius: 3px;text-transform: uppercase;font-family: "RobotoLight", "Helvetica Neue", Helvetica, sans-serif;border: 1px solid green;color: green;font-size: 14px;';
		}
		if($rows1['con_sts'] == 'Inactive'){
		$clss = 'inact';
		$dd = 'Active';
		$ee = 'Inactive';
		$collllr = 'border-radius: 3px;text-transform: uppercase;font-family: "RobotoLight", "Helvetica Neue", Helvetica, sans-serif;border: 1px solid red;color: red;font-size: 11px;';
		}
		
		$idss = $rows1['c_id'];
		$API->write('/ppp/active/print', false);
		$API->write('?name='.$idss);
		$res=$API->read(true);

		$ppp_mac = $res[0]['caller-id'];
		$ppp_mac_replace = str_replace(":","-",$ppp_mac);
		$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);;
		
		$ppp_ip = $res[0]['address'];
		$ppp_uptime = $res[0]['uptime'];
		
		if($user_status == ''){
			if($ppp_uptime == ''){
				$online_sts =  "<button style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;border: 1px solid red;color: red;font-size: 12px;margin-top: 3px;' class='btn'>Offline</button>";
				
			$API->write('/ppp/secret/getall', false);
			$API->write('?name='.$idss);
			$resuu=$API->read(true);
			
			$lastloggedout = $resuu[0]['last-logged-out'];
			$mac_device = '';
			$ipcheck = '';
			}
			else{
				$online_sts =  "<button style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 13px;margin-top: 3px;' class='btn'>Online</button>";
				$lastloggedout = "";
			
			$macsearch = mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'");
			$macsearchaa = mysql_fetch_assoc($macsearch);
			$mac_device = $macsearchaa['info'];
			$ipcheck = "<form href='#myModal' data-toggle='modal' data-placement='top' data-rel='tooltip' title='Click for Ping'><button type='submit' value='{$ppp_ip}&mk_id={$rows1['mk_id']}' class='btn' onClick='getRoutePoint(this.value)'>{$ppp_ip}</button></form>";
			}
		}
		if($user_status == 'Online'){
			if($ppp_uptime != ''){
				$online_sts =  "<button style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 13px;margin-top: 3px;' class='btn'>Online</button>";
				$lastloggedout = "";
				$hideeeee = '';
				$ipcheck = "<form href='#myModal' data-toggle='modal' data-placement='top' data-rel='tooltip' title='Click for Ping'><button type='submit' value='{$ppp_ip}&mk_id={$rows1['mk_id']}' class='btn' onClick='getRoutePoint(this.value)'>{$ppp_ip}</button></form>";
			}
			else{
				$online_sts =  "";
				$lastloggedout = "";
				$hideeeee = "style='display: none;'";
				$ipcheck = '';
			}
			if($ppp_mac != ''){
				$macsearch = mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'");
				$macsearchaa = mysql_fetch_assoc($macsearch);
				$mac_device = $macsearchaa['info'];
			}
			else{
					$response = '';
				}
		}
		if($user_status == 'Offline'){
			if($ppp_uptime == ''){
				$online_sts =  "<button style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;border: 1px solid red;color: red;font-size: 12px;margin-top: 3px;' class='btn'>Offline</button>";
				$hideeeee = "";
				
			$API->write('/ppp/secret/getall', false);
			$API->write('?name='.$idss);
			$resuu=$API->read(true);
			
			$lastloggedout = $resuu[0]['last-logged-out'];
			$ipcheck = '';
			}
			else{
				$online_sts =  "";
				$lastloggedout = "";
				$hideeeee = "style='display: none;'";
				$ipcheck = '';
			}
		}
		echo
										"<tr class='gradeX'>
											<td $hideeeee>{$x}</td>
											<td $hideeeee><b>{$idss}</b><br><b>{$rows1['c_name']}</b><br>{$rows1['cell']}</td>
											<td $hideeeee>{$rows1['z_name']}<br>{$rows1['address']}</td>
											<td $hideeeee>{$rows1['p_name']}<br>{$rows1['bandwith']} ({$rows1['p_price']} tk)</td>
											<td $hideeeee><b>{$ppp_mac}<br>{$mac_device}</b></td>
											<td $hideeeee>{$ipcheck}</td>
											<td $hideeeee><b>{$ppp_uptime}{$lastloggedout}</b></td>
											<td $hideeeee><center><button class='btn {$clss}' style='{$collllr}' />{$ee}</button><br>{$online_sts}</center></td>
											<td $hideeeee><center><form action='ClientView' method='post' target='_blank'><input type='hidden' name='ids' value='{$rows1['c_id']}' /><button class='btn' style='border-radius: 3px;border: 1px solid #0866c6;color: #0866c6;padding: 6px 9px;' title='Profile'><i class='iconfa-eye-open'></i></button></form></center></td>
										</tr>\n";
										$x++;
	}
$API->disconnect();
						}
						else{echo 'Selected Network are not Connected.';}
							?>
							<td></td>
							<td style="text-align: right;font-weight: bold;color: green;font-size: 18px;"><b>ONLINE</b></td>
							<td style="text-align: left;font-weight: bold;color: green;font-size: 20px;"><b><?php echo $activ_count;?></b></td>
							<td style="text-align: right;font-weight: bold;color: red;font-size: 18px;"><b>OFFLINE</b></td>
							<td style="text-align: left;font-weight: bold;color: red;font-size: 20px;"><b><?php echo $inactiv_count - $activ_count;?></b></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
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
