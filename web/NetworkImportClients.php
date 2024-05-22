<?php
$titel = "Import Clients";
$Network = 'active';
include('include/hader.php');
include("mk_api.php");
$mk_id = isset($_GET['id']) ? $_GET['id'] : '';
$input = isset($_GET['input']) ? $_GET['input'] : '';
$z_id = isset($_GET['zid']) ? $_GET['zid'] : '';
extract($_POST); 

ini_alter('date.timezone','Asia/Almaty');
$f_date = date('Y-m-01', time());
$t_date = date('Y-m-t', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Network' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
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

$resultsdfg=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE e.mk_id = '$mk_id' AND z.status = '0' AND z.e_id != '' order by e.e_name");

?>
	<div class="pageheader">
		<div class="searchbar" style="width: 50%;">
			<div style="font-weight: bold;">
			<?php if($limit_accs == 'Yes'){ ?>
				<form id="" name="form" class="stdform" style="float: right;width: 70%;" method="GET" action="<?php echo $PHP_SELF;?>">
					<input type='hidden' name='id' value='<?php echo $_GET['id'];?>'/> 
					<input type='hidden' name='input' value='reseller'/> 
					<select name="zid"  onchange="submit();" style="border: 1px solid #317eac;color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 20px;border-radius: 5px;width: 97%;height: 35px;">
							<option value="" style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;">Choose Reseller</option>
						<?php while ($row345=mysql_fetch_array($resultsdfg)) { ?>
							<option style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;" value="<?php echo $row345['z_id']?>"<?php if ($row345['z_id'] == $z_id) echo 'selected="selected"';?>><?php echo $row345['resellername']; ?> - <?php echo $row345['z_name'];?></option>
						<?php } ?>
					</select>
				</form>
				<?php } else{ ?>
					<div style='font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;padding: 30px;font-size: 30px;text-align: center;'>[User Limit Exceeded]</div>
				<?php } ?>
			</div>
        </div>
        <div class="pageicon" style="padding: 2px;"><i class="iconfa-download-alt"></i></div>
        <div class="pagetitle">
             <h3 style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;">Import Reseller Clients From Mikrotik</h3>
        </div>
    </div><!--pageheader-->		
		
		<div class="box box-primary">
		<?php if($limit_accs == 'Yes'){ ?>
		<form name="form" class="" method="POST" action="NetworkImportClientsQuery" enctype="multipart/form-data">	
		<input type="hidden" name="input" value="<?php echo $input;?>"/>
		<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>"/>
		<input type="hidden" name="z_id" value="<?php echo $z_id;?>"/> 
		<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 8px 0px 8px 15px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">
				<input type='hidden' name='z_id' value='<?php echo $_GET['zid'];?>'/> 
				<input type='hidden' name='mk_id' value='<?php echo $_GET['id'];?>'/> 
				<input type="text" name="f_date" id="f_date" style="border: 1px solid red;color: red;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;border-radius: 3px;width: 10%;padding: 4px 15px;font-weight: bold;" onChange="myFun()" placeholder="Recharge From" class="surch_emp datepicker" value="<?php echo $f_date;?>" readonly required=""/>
				<input type="text" name="t_date" id="t_date" style="border: 1px solid red;color: red;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;border-radius: 3px;width: 10%;padding: 4px 15px;font-weight: bold;margin-left: 3px;" onChange="myFun()" placeholder="Recharge Till" class="surch_emp datepicker" readonly required=""/>
				<input type="text" name="duration" id="duration" style="border: 1px solid red;color: red;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;border-radius: 3px;width: 40px;margin-left: 3px;font-weight: bold;font-size: 15px;height: 18px;" placeholder="days" class="surch_emp" readonly required=""/>
				&nbsp; &nbsp;&nbsp; &nbsp;
				<input type="radio" name="radiofield" value="day_calculation" checked='checked'/>Day Calculation &nbsp; &nbsp;
				<input type="radio" name="radiofield" value="without_recharge"/>Without Recharge &nbsp; &nbsp;
				<input type="radio" name="radiofield" value="but_disable"/>Add But Disable &nbsp; &nbsp;
		</div>	
		
			<div class="box-header" style="font-size: 14px;padding: 12px 0px 0px 15px;font-weight: bold;">
				[ Mikrotik:  <i style='color: #317EAC'><?php echo $ssss;?></i> ]    
				[ Application:  <i style='color: #317EAC'><?php echo $totlclients;?></i> ]&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
			</div>
			<div class="box-body">
			<?php if($input == 'reseller' && $z_id != ''){ ?>
			<table id="dyntable2" class="table table-bordered responsive">
				<colgroup>
                        <col class="con0 center" style="width: 2%;" />
                        <col class="con1" style='width: 20px;'/>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
						<col class="con1" />
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr class="newThead">
							<th class="head0 center"></th>
							<th class="head1 center" style='width: 20px;'>S/L</th>
							<th class="head0">PPPoE ID/PASS</th>
							<th class="head1">PROFILE/PRICE</th>
							<th class="head0">IP/MAC Address</th>
							<th class="head1 center">STATUS</th>
							<th class="head0 center">App ID</th>
                        </tr>
                    </thead>
					
                    <tbody>
						<?php
						$aaa = 1;
							if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
								$arrID = $API->comm('/ppp/secret/getall');
								foreach($arrID as $x => $x_value) {
									
									$mk_cid = $x_value['name'];
									$mk_profile = $x_value['profile'];
									$sqlcl = mysql_query("SELECT c.c_id, z.z_name, c.cell FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.c_id = '$mk_cid'");
									$rowcll = mysql_fetch_assoc($sqlcl);
									$c_id = $rowcll['c_id'];
									$z_name = $rowcll['z_name'];
									$cell = $rowcll['cell'];
									
									$sqlclp = mysql_query("SELECT p_id, p_price, p_price_reseller FROM package WHERE status = '0' AND mk_profile = '$mk_profile' AND z_id = '$z_id'");
									$rowcllp = mysql_fetch_assoc($sqlclp);
									$p_id = $rowcllp['p_id'];
									$p_price_reseller = $rowcllp['p_price_reseller'];
									
									if($p_id == ''){
										$possible = ' - NO';
										$colooor = "style='color: red;'";
									}
									else{
										$possible = ' - '.$rowcllp['p_price'].'TK - OK';
										$colooor = "style='color: green;'";
									}

									if($p_id != '' && $c_id == ''){
										$readytoadd = 'Ready to Add';
										$checkdisableee = '';
										$angleee = "color: green;";
									}
									else{
										$readytoadd = '';
										$checkdisableee = 'disabled="disabled"';
										$angleee = "color: #ff00009e;";
									}
									
									if($x_value['disabled'] == 'false'){
										$fhfhhfh = 'Active';
										$fhfhhfhss = "<spen class='label label-success' style='font-weight: bold;border-radius: 5px;font-size: 15px;padding: 5px;'>Enabled</spen>";
									}
									else{
										$fhfhhfh = 'Inactive';
										$fhfhhfhss = "<spen class='label label-important' style='font-weight: bold;border-radius: 5px;font-size: 15px;padding: 5px;'>Disabled</spen>";
									}
									echo "<tr>
											<td class='center' style='vertical-align: middle;'><a style='font-size: 13px;font-weight: bold;padding-left:border: 1px solid #ff00001c;border-radius: 3px;'><input type='checkbox' name='slno[]' value='".$aaa."'".$checkdisableee."/></a>
											<td class='center' style='width: 18px;font-weight: bold;font-size: 18px;vertical-align: middle;".$angleee."'>" . $aaa ."</td>
											<td><input type='hidden' name='c_id[".$aaa."]' value='".$x_value['name']."'/><b style='font-size: 13px;'>" . $x_value['name'] ."</b><br><input type='hidden' name='password[".$aaa."]' value='".$x_value['password']."'/>" . $x_value['password'] ."<br>" . $cell . "</td>
											<td><input type='hidden' name='p_id[".$aaa."]' value='".$p_id."'><input type='hidden' name='p_price[".$aaa."]' value='".$rowcllp['p_price']."'/><input type='hidden' name='p_price_reseller[".$aaa."]' value='".$p_price_reseller."'/><input type='hidden' name='con_sts[".$aaa."]' value='".$fhfhhfh."'><b ".$colooor."/>" . $x_value['profile'] .$possible."</b><br>" . $x_value['last-logged-out'] . "<br><b>" . $z_name . "</b></td>
											<td><input type='hidden' name='ip[".$aaa."]' value='".$x_value['remote-address']."'/>" . $x_value['remote-address'] ."<br><input type='hidden' name='mac[".$aaa."]' value='".$x_value['caller-id']."'/>" . $x_value['caller-id'] ."</td>
											<td class='center' style='vertical-align: middle;'>".$fhfhhfhss."</td>
											<td class='center' style='font-weight: bold;font-size: 13px;vertical-align: middle;".$angleee."'>" . $readytoadd ."</td>
										</tr>";
										$aaa++;
								}
							}
							else{echo 'Selected Network are not Connected.';} ?>
					</tbody>
			</table>
			<?php } ?>
			</div>
			<div class="modal-footer" style="text-align: center;">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>    
			</div>	
		
			</form><?php } else{ ?><div style='font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;padding: 30px;font-size: 30px;text-align: center;'>[User Limit Exceeded]</div><?php } ?></div>
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

function myFun() {
var x2=document.getElementById("t_date").value;
var x3=document.getElementById("f_date").value;
var msPerDay = 1000*60*60*24;
d1=new Date(x2);
d2=new Date(x3);
var x4=document.getElementById("duration");
var dd=( (((d1 - d2) / msPerDay)+1).toFixed(0) );
    x4.value=dd;
    }
</script>
<style>
div.checker{
	margin-right: 0;
}
</style>