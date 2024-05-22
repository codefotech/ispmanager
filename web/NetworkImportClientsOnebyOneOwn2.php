<?php
$titel = "Import Own Clients One By One";
$Network = 'active';
include('include/hader.php');
include("mk_api.php");
$mk_id = isset($_GET['id']) ? $_GET['id'] : '';
$z_id = isset($_GET['zid']) ? $_GET['zid'] : '';
extract($_POST); 

ini_alter('date.timezone','Asia/Almaty');
$f_date = date('Y-m-01', time());
//$t_date = date('Y-m-t', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Network' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
if($z_id != '' && $mk_id != ''){
$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h, Name FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$mk_name = $rowmk['Name'];
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;
if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
								$arrID = $API->comm('/ppp/secret/getall');
								$ssss = count($arrID);
}

$queryaaaa = mysql_query("SELECT COUNT(id) AS totlclients FROM clients WHERE mk_id = '$mk_id'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$totlclients = $rowaaaa['totlclients'];
}
$resultsdfg=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id = '' order by e.e_name");
$resultsdfg1=mysql_query("SELECT c.mk_id, m.Name, m.ServerIP FROM clients AS c LEFT JOIN mk_con AS m ON m.id = c.mk_id WHERE c.sts = '0' AND c.mac_user = '0' GROUP BY c.mk_id");

?>
	<div class="pageheader">
		<div class="searchbar" style="width: 50%;">
        </div>
        <div class="pageicon" style="padding: 2px;"><i class="iconfa-download-alt"></i></div>
        <div class="pagetitle">
             <h3 style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;">Import Own Clients One By One From Mikrotik</h3>
        </div>
    </div><!--pageheader-->		
		
		<div class="box box-primary">
		<form name="form" class="" method="POST" action="<?php echo $PHP_SELF;?>" enctype="multipart/form-data">	
			<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 15px 0px 10px 15px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);overflow: auto;">
				<select name="z_id" style="border: 1px solid red;color: #0866c6e0;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 15px;border-radius: 5px;width: 30%;margin-right: 10px;float: left;" onChange="getRoutePoint(this.value)">
						<option value="" style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;">Choose Zone</option>
					<?php while ($row345=mysql_fetch_array($resultsdfg)) { ?>
						<option style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;" value="<?php echo $row345['z_id']?>"<?php if ($row345['z_id'] == $z_id) echo 'selected="selected"';?>><?php echo $row345['z_name']; ?></option>
					<?php } ?>
				</select>
				
				<div id="Pointdiv1">
					
					<?php if($mk_id != '' && $z_id != ''){?>
					<select name="mk_id" style="border: 1px solid red;color: #0866c6e0;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 15px;border-radius: 5px;width: 30%;margin-right: 10px;">
						<option value="" style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;">Choose Network</option>
					<?php while ($row34d5=mysql_fetch_array($resultsdfg1)) { ?>
						<option style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;" value="<?php echo $row34d5['mk_id']?>"<?php if ($row34d5['mk_id'] == $mk_id) echo 'selected="selected"';?>><?php echo $row34d5['Name']; ?> (<?php echo $row34d5['ServerIP'];?>)</option>
					<?php } ?>
					</select>
					
					<button class="btn ownbtn4" type="submit" style="margin-left: 15px;">Submit</button>
					<?php } ?>
				</div>
			</div>
		</form>
		<?php if($z_id != '' && $mk_id != ''){ ?>
			<div class="box-header" style="font-size: 14px;padding: 12px 0px 0px 15px;font-weight: bold;">
				[ Mikrotik:  <i style='color: #317EAC'><?php echo $ssss;?></i> ]    
				[ Application:  <i style='color: #317EAC'><?php echo $totlclients;?></i> ]&nbsp; &nbsp; &nbsp;
				[ <i style='color: #317EAC'><?php echo $mk_name;?> - <?php echo $ServerIP;?> </i> ]&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
			</div>
			<div class="box-body" id="etheah">
			
			<table id="dyntable2" class="table table-bordered responsive">
				<colgroup>
                        <col class="con1" style='width: 20px;'/>
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
                        <tr class="newThead">
							<th class="head1 center" style='width: 20px;'>S/L</th>
							<th class="head0">PPPoE ID/PASS</th>
							<th class="head1">PROFILE/PRICE/ZONE</th>
							<th class="head0">IP/MAC ADDRESS</th>
							<th class="head1 center">STATUS</th>
							<th class="head0 center">PD | BD</th>
							<th class="head1 center">ACTION</th>
                        </tr>
                    </thead>
					
                    <tbody>
						<?php
						$aaa = 1;
							if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
								$arrID = $API->comm('/ppp/active/getall');
								foreach($arrID as $x => $x_value) {
									
									$mk_cid = $x_value['name'];
									$uptime = $x_value['uptime'];
									$address = $x_value['address'];
									$sqlcl = mysql_query("SELECT c.c_id, c.c_name, z.z_name, c.cell, c.payment_deadline, c.b_date, c.p_id, p.p_price, p.p_name FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c.c_id = '$mk_cid' AND c.z_id = '$z_id' NAD c.mac_user = '0'");
									$rowcll = mysql_fetch_assoc($sqlcl);
									$c_id = $rowcll['c_id'];
									$z_name = $rowcll['z_name'];
									$payment_deadline = $rowcll['payment_deadline'];
									$b_date = $rowcll['b_date'];
									$p_id = $rowcll['p_id'];
									$p_price = $rowcll['p_price'];
									$p_name = $rowcll['p_name'];
									$c_name = $rowcll['c_name'];
									
									if($payment_deadline !='' || $b_date != ''){
										$deaddd = $payment_deadline.' | '.$b_date;
									}
									else{
										$deaddd = '';
									}
									if($x_value['caller-id'] != ''){
										$ppp_mac_replace = str_replace(":","-",$x_value['caller-id']);
										$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);
											
										$macsearch = mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'");
										$macsearchaa = mysql_fetch_assoc($macsearch);
										$devicename = $macsearchaa['info'];
									}
									else{
										$devicename = '';
									}
									
									echo "<tr>
											<td class='center' style='width: 18px;font-weight: bold;font-size: 18px;vertical-align: middle;".$angleee."'>" . $aaa ."</td>
											<td><b style='font-size: 13px;'>" . $x_value['name'] ."</b><br>" . $c_name ."<br>" . $cell . "</td>
											<td><b>" . $p_name ."</b><br>" . $x_value['last-logged-out'] . "<br><div id='olddatee".$aaa."'><b>" . $z_name . "</b></div></td>
											<td>" . $x_value['address'] ."<br>" . $x_value['caller-id'] ."<br>". $uptime ."</td>
											<td class='center' style='vertical-align: middle;'>".$devicename."</td>
											<td class='center' style='font-weight: bold;font-size: 15px;vertical-align: middle;'><div id='olddateline".$aaa."'>" . $deaddd ."</div></td>
											<td class='center' style='font-weight: bold;font-size: 13px;vertical-align: middle;".$angleee."'><b><div id='olddate".$aaa."'>" . $addbttn ."</div></b></td>
										</tr>"; ?>
								<?php		
								
								$aaa++;
								}
							}
							else{echo 'Selected Network are not Connected.';} ?>
					</tbody>
			</table>
		
			</div>
		<?php } ?>
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

		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 200,
			"aaSorting": [[6,'desc']],
            "sScrollY": "1100px"
        });
    });

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
		var strURL="import-own-client-one-by-one1.php?z_id="+afdId;
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
	

$(document).ready(function()
{
$('select[name="z_id"]').on('change',function(){
 {  
  var name = $(this).val(); 
  if(name.length < 50)
  {
   $("#etheah").html('');
   $(".box-header").html('');
  }
 }
 });
 });
</script>
<style>
div.checker{
	margin-right: 0;
}
</style>