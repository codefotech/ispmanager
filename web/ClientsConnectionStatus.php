<?php
$titel = "Clients Connection Status";
$Client = 'active';
include('include/hader.php');
include("conn/connection.php");
include("mk_api.php");
extract($_POST);

ini_alter('date.timezone','Asia/Almaty');
$todaydate = date('Y-m-d', time());
$f_date = date('Y-m-01', time());
$t_date = date('Y-m-d', time());
$thismonth = date('M-Y', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$queryaaaa = mysql_query("SELECT COUNT(id) AS activeclient FROM clients WHERE con_sts = 'Active' AND sts = '0'");
$rowaaaa = mysql_fetch_assoc($queryaaaa);
$activeclient = $rowaaaa['activeclient'];

$queryiiiii = mysql_query("SELECT COUNT(id) AS inactiveclient FROM clients WHERE con_sts = 'Inactive' AND sts = '0'");
$rowiii = mysql_fetch_assoc($queryiiiii);
$inactiveclient = $rowiii['inactiveclient'];
$totalclients = $activeclient + $inactiveclient;

$result1z = mysql_query("SELECT (SUM(p.pay_amount) + SUM(p.bill_discount)) AS totalmonthcollection, SUM(p.pay_amount) AS thismonth_pay_amount, SUM(p.bill_discount) AS thismonth_bill_discount
								FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id
								WHERE MONTH(p.pay_date) = MONTH('$t_date') AND YEAR(p.pay_date) = YEAR('$t_date') AND c.mac_user = '0'");
$rowiiiy = mysql_fetch_assoc($result1z);
$pay_amount = $rowiiiy['thismonth_pay_amount'];
$paydiscount = $rowiiiy['thismonth_bill_discount'];
$totalmonthcollection = $rowiiiy['totalmonthcollection'];

$result1zb = mysql_query("SELECT z.z_id, z.z_name, z.z_bn_name, SUM(p.bill_amount) AS bill_amount, SUM(p.discount) AS TotalDiscount FROM billing AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id 
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								WHERE MONTH(p.bill_date) = MONTH('$f_date') AND YEAR(p.bill_date) = YEAR('$f_date')"); 
$rowiiiyb = mysql_fetch_assoc($result1zb);
$bill_amount = $rowiiiyb['bill_amount'];
$discount = $rowiiiyb['TotalDiscount'];

$zonedue = $bill_amount - $totalmonthcollection;


$result1zt = mysql_query("SELECT (SUM(pay_amount)+SUM(bill_discount)) AS totalpaid FROM payment"); 
$rowiiiyt = mysql_fetch_assoc($result1zt);
$totalpaid = $rowiiiyt['totalpaid'];

$result1zbb = mysql_query("SELECT SUM(bill_amount) AS totalbill FROM billing"); 
$rowiiiybb = mysql_fetch_assoc($result1zbb);
$totalbill = $rowiiiybb['totalbill'];

$intotaldue = $totalbill - $totalpaid;

	$mkid = '1';


	?>
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
            <h1>Informations </h1>
        </div>
    </div><!--pageheader-->
		
	<div class="box box-primary">
		<div class="box-header" style="font-size: 20px;padding: 15px 0px 2px 15px;">
		</div>
		<div class="box-body">
		<div id="divid">
			<div id="hd">
			<div class="row" style="margin-top: 2px;margin-right: 0px;">
								<div style="padding-left: 15px; width: 100%;">
									<table class="table table-bordered table-invoice" style="width: 47%; float: left;margin-right: 3%;">
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;">Active</td>
											<td class="width70" style="font-family: gorgia;"><?php echo $activeclient; ?></td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Inactive</td>
											<td><?php echo $inactiveclient; ?></td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Total</td>
											<td><?php echo $totalclients; ?></td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">In Total Due</td>
											<td style="color: red;font-weight: bold;"><?php echo $intotaldue;?> ৳</td>
										</tr>
									</table>

									<table class="table table-bordered table-invoice" style="width: 47%; float: left;">
										<tr>
											<td style="text-align: right;font-weight: bold;"><?php echo $thismonth;?> Bill </td>
											<td><?php echo $bill_amount; ?> ৳</td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;"><?php echo $thismonth;?> Collection </td>
											<td class="width70" ><?php echo $totalmonthcollection; ?> ৳</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;"><?php echo $thismonth;?> Discount</td>
											<td><?php echo $paydiscount; ?> ৳</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;"><?php echo $thismonth;?> Due</td>
											<td><?php echo $zonedue.'.00'; ?> ৳</td>
										</tr>
									</table>
								</div><!--col-md-6-->
							</div><br>
			<?php if($mkid != ''){?>
		
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
							<th class="head0">Package</th>
							<th class="head1">Mac Address</th>
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
	$sqlcount = mysql_query("SELECT id FROM clients WHERE sts = '0' AND c_id IN ('$idList')");
	$activ_count = mysql_num_rows($sqlcount);
	
	$sqlcounty = mysql_query("SELECT id FROM clients WHERE sts = '0'");
	$inactiv_count = mysql_num_rows($sqlcounty);
								
	$sql44 = mysql_query("SELECT c.c_name, e.e_name AS resellername, c.c_id, c.payment_deadline, c.cable_type, c.p_id, p.p_name, p.bandwith, p.p_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN emp_info AS e ON e.e_id = z.e_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id 
												
												WHERE c.sts = '0' ORDER BY c.c_id ASC");

$x = 1;	
	while( $rows1 = mysql_fetch_assoc($sql44) ){
		
		$idss = $rows1['c_id'];
		$API->write('/ppp/active/print', false);
		$API->write('?name='.$idss);
		$res=$API->read(true);

		$ppp_mac = $res[0]['caller-id'];
		$ppp_ip = $res[0]['address'];
		$ppp_uptime = $res[0]['uptime'];
		$ppp_ip = $res[0]['address'];
		
		if($user_status == ''){
			if($ppp_uptime == ''){
				$online_sts =  "<a data-placement='top' data-rel='tooltip' style='font-weight: bold;' class='btn inact'>Offline</a>";
				
			$API->write('/ppp/secret/getall', false);
			$API->write('?name='.$idss);
			$resuu=$API->read(true);
			
			$lastloggedout = $resuu[0]['last-logged-out'];
			$response = '';
			
				if($rows1['con_sts'] == 'Active'){
					$colorr = 'style="color: red;"';
				}
				else{
					$colorr = '';
				}
			}
			else{
				$online_sts =  "<a data-placement='top' data-rel='tooltip' style='font-weight: bold;' class='btn act'>Online</a>";
				$lastloggedout = "";
					$ppp_mac_replace = str_replace(":","-",$ppp_mac);
					$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);
					$macsearch = mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'");
					$macsearchaa = mysql_fetch_assoc($macsearch);
					$response = $macsearchaa['info'];
				if($rows1['con_sts'] == 'Active'){
					$colorr = 'style="color: green;"';
				}
				else{
					$colorr = '';
				}
			}

		}
		if($user_status == 'Online'){
			if($ppp_uptime != ''){
				$online_sts =  "<a data-placement='top' data-rel='tooltip' style='font-weight: bold;' class='btn act'>Online</a>";
				$lastloggedout = "";
				$hideeeee = 'style="color: green;"';
			}
			else{
				$online_sts =  "";
				$lastloggedout = "";
				$hideeeee = "style='display: none;'";
			}
			if($ppp_mac != ''){
				$ppp_mac_replace = str_replace(":","-",$ppp_mac);
				$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);
				$macsearch = mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'");
				$macsearchaa = mysql_fetch_assoc($macsearch);
				$response = $macsearchaa['info'];
			}
			else{
					$response = '';
				}
		}
		if($user_status == 'Offline'){
			if($ppp_uptime == ''){
				$online_sts =  "<a data-placement='top' data-rel='tooltip' style='font-weight: bold;' class='btn inact'>Offline</a>";
				$hideeeee = 'style="color: red;"';
				
			$API->write('/ppp/secret/getall', false);
			$API->write('?name='.$idss);
			$resuu=$API->read(true);
			
			$lastloggedout = $resuu[0]['last-logged-out'];
			}
			else{
				$online_sts =  "";
				$lastloggedout = "";
				$hideeeee = "style='display: none;'";
			}
		}
		echo
										"<tr class='gradeX'>
											<td $colorr $hideeeee>{$x}</td>
											<td $colorr $hideeeee><b>{$idss}</b><br><b>{$rows1['c_name']}</b><br>{$rows1['cell']}<br>{$rows1['z_name']}<br><b>{$rows1['cable_type']}<br>{$rows1['onu_mac']}</b></td>
											<td $colorr $hideeeee>{$rows1['p_name']}<br>{$rows1['bandwith']} ({$rows1['p_price']} tk)</td>
											<td $colorr $hideeeee><b>{$ppp_mac}<br>{$ppp_ip}<br>{$response}</b><br>{$ppp_uptime}{$lastloggedout}</td>
											<td $colorr $hideeeee><center>{$online_sts}</center></td>
											<td $colorr $hideeeee><center><a data-placement='top' data-rel='tooltip' target='_blank' href='ClientView?id={$rows1['c_id']}' data-original-title='View Client' class='btn col1'><i class='fa iconfa-eye-open'></i></a></center></td>
										</tr>\n ";
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
					</tbody>
				</table>
					</div>
				</div>
			</div>
		</div>
<?php
}}
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
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<style>
#dyntable_length{display: none;}
</style>