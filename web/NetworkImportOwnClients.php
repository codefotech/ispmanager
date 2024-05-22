<?php
$titel = "Import Clients";
$Network = 'active';
include('include/hader.php');
include("mk_api.php");
$mk_id = isset($_GET['id']) ? $_GET['id'] : '';
$input = isset($_GET['input']) ? $_GET['input'] : '';
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

?>
	<div class="pageheader">
        <div class="pageicon" style="padding: 2px;"><i class="iconfa-download-alt"></i></div>
        <div class="pagetitle">
            <h3 style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;">Import Own Clients From Mikrotik</h3>
        </div>
    </div><!--pageheader-->
		<div class="box box-primary">
	<form name="form" class="" method="POST" action="NetworkImportClientsQuery" enctype="multipart/form-data">	
		<input type="hidden" name="input" value="<?php echo $input;?>">
		<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>">
		<input type="hidden" name="z_id" value="<?php echo $z_id;?>"> 
		<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 8px 0px 8px 15px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">
			<b style="font-size: 15px;">THIS MONTH BILL</b>&nbsp; &nbsp;&nbsp; &nbsp;
			<input type="radio" name="radiofield" value="without_bill"><b style="color: red;">Without Bill</b> &nbsp; &nbsp; &nbsp;
			<input type="radio" name="radiofield" value="pack_price" checked='checked'><b style="color: red;">Package Price as Bill</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
			<b style="font-size: 15px;">Deadline &nbsp;</b>
			<select name='payment_deadline1' style="border: 1px solid #317eac;color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: right;font-size: 14px;border-radius: 5px;width: 60px;height: 28px;margin-right: 5px;vertical-align: baseline;">
				<option value=''>NO</option>
				<option value='01'>01</option>
				<option value='02'>02</option>
				<option value='03'>03</option>
				<option value='04'>04</option>
				<option value='05'>05</option>
				<option value='06'>06</option>
				<option value='07'>07</option>
				<option value='08'>08</option>
				<option value='09'>09</option>
				<option value='10'>10</option>
				<option value='11'>11</option>
				<option value='12'>12</option>
				<option value='13'>13</option>
				<option value='14'>14</option>
				<option value='15'>15</option>
				<option value='16'>16</option>
				<option value='17'>17</option>
				<option value='18'>18</option>
				<option value='19'>19</option>
				<option value='20'>20</option>
				<option value='21'>21</option>
				<option value='22'>22</option>
				<option value='23'>23</option>
				<option value='24'>24</option>
				<option value='25'>25</option>
				<option value='26'>26</option>
				<option value='27'>27</option>
				<option value='28'>28</option>
				<option value='29'>29</option>
				<option value='30'>30</option>
				<option value='31'>31</option>
			</select>
	
			<select name="z_id" required="" style="border: 1px solid #317eac;color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;border-radius: 5px;width: 22%;height: 30px;float: right;margin-right: 5px;">
				<option value="">Choose Zone</option>
					<?php $querydd=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
					while ($row=mysql_fetch_array($querydd)) { ?>
				<option value="<?php echo $row['z_id']?>"<?php if ($row['z_id'] == $z_id) echo 'selected="selected"';?>><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
					<?php } ?>
			</select>
		</div>	
		<div class="box-header" style="font-size: 14px;padding: 12px 0px 0px 15px;font-weight: bold;">
			[ Mikrotik:  <i style='color: #317EAC'><?php echo $ssss; ?></i> ]    
			[ Application:  <i style='color: #317EAC'><?php echo $totlclients; ?></i> ]&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
		</div>
		<div class="box-body">
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
                    </colgroup>
                    <thead>
                        <tr class="newThead">
							<th class="head0 center"></th>
							<th class="head1 center" style='width: 20px;'>S/L</th>
							<th class="head0">PPPoE ID/PASS</th>
							<th class="head1">PROFILE/PRICE</th>
							<th class="head0">IP/MAC Address</th>
							<th class="head1 center">STATUS</th>
							<th class="head0 center">B.P.DEADLINE</th>
							<th class="head1 center">App MSG</th>
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
									$sqlcl = mysql_query("SELECT c.c_id, c.payment_deadline, z.z_name, c.cell FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.c_id = '$mk_cid'");
									$rowcll = mysql_fetch_assoc($sqlcl);
									$c_id = $rowcll['c_id'];
									$payment_deadline = $rowcll['payment_deadline'];
									$z_name = $rowcll['z_name'];
									$cell = $rowcll['cell'];
									
									$sqlclp = mysql_query("SELECT p_id, p_price FROM package WHERE status = '0' AND mk_profile = '$mk_profile' AND z_id = '0'");
									$rowcllp = mysql_fetch_assoc($sqlclp);
									$p_id = $rowcllp['p_id'];
									
									if($x_value['disabled'] == 'false'){
										$fhfhhfh = 'Active';
										$fhfhhfhss = "<spen class='label label-success' style='font-weight: bold;border-radius: 5px;font-size: 15px;padding: 5px;'>Enabled</spen>";
									}
									else{
										$fhfhhfh = 'Inactive';
										$fhfhhfhss = "<spen class='label label-important' style='font-weight: bold;border-radius: 5px;font-size: 15px;padding: 5px;'>Disabled</spen>";
									}
									
									if($p_id == ''){
										$possible = ' - NO';
										$colooor = "style='color: red;'";
									}
									else{
										$possible = ' - '.$rowcllp['p_price'].'TK - OK';
										$colooor = "style='color: green;'";
									}
									if($c_id == '' && $p_id != ''){
										$checkdisableee = '';
										$angleee = "color: green;";
									}
									else{
										$checkdisableee = 'disabled="disabled"';
										$angleee = "color: #ff00009e;";
									}
									if($p_id != '' && $c_id == ''){
										$readytoadd = 'Ready to Add';
										$deaddd = "<select name='payment_deadline[".$aaa."]' style='width: 60px;border-radius: 5px;'>
													<option value=''>NO</option>
													<option value='01'>01</option>
													<option value='02'>02</option>
													<option value='03'>03</option>
													<option value='04'>04</option>
													<option value='05'>05</option>
													<option value='06'>06</option>
													<option value='07'>07</option>
													<option value='08'>08</option>
													<option value='09'>09</option>
													<option value='10'>10</option>
													<option value='11'>11</option>
													<option value='12'>12</option>
													<option value='13'>13</option>
													<option value='14'>14</option>
													<option value='15'>15</option>
													<option value='16'>16</option>
													<option value='17'>17</option>
													<option value='18'>18</option>
													<option value='19'>19</option>
													<option value='20'>20</option>
													<option value='21'>21</option>
													<option value='22'>22</option>
													<option value='23'>23</option>
													<option value='24'>24</option>
													<option value='25'>25</option>
													<option value='26'>26</option>
													<option value='27'>27</option>
													<option value='28'>28</option>
													<option value='29'>29</option>
													<option value='30'>30</option>
													<option value='31'>31</option>
												</select>";
									}
									else{
										$readytoadd = '';
										$deaddd = $payment_deadline;
									}
									echo "<tr class='gradeX'>
											<td class='center' style='vertical-align: middle;'><a style='font-size: 13px;font-weight: bold;padding-left:border: 1px solid #ff00001c;border-radius: 3px;'><input type='checkbox' name='slno[]' value='".$aaa."'".$checkdisableee."></a>
											<td class='center' style='width: 18px;font-weight: bold;font-size: 18px;vertical-align: middle;".$angleee."'>" . $aaa ."</td>
											<td><input type='hidden' name='c_id[".$aaa."]' value='".$x_value['name']."'><b style='font-size: 13px;'>" . $x_value['name'] ."</b><br><input type='hidden' name='password[".$aaa."]' value='".$x_value['password']."'>" . $x_value['password'] ."<br>" . $cell . "</td>
											<td><input type='hidden' name='p_id[".$aaa."]' value='".$p_id."'><input type='hidden' name='p_price[".$aaa."]' value='".$rowcllp['p_price']."'><input type='hidden' name='con_sts[".$aaa."]' value='".$fhfhhfh."'><b ".$colooor.">" . $x_value['profile'] .$possible."</b><br>" . $x_value['last-logged-out'] . "<br><b>" . $z_name . "</b></td>
											<td><input type='hidden' name='ip[".$aaa."]' value='".$x_value['remote-address']."'>" . $x_value['remote-address'] ."<br><input type='hidden' name='mac[".$aaa."]' value='".$x_value['caller-id']."'>" . $x_value['caller-id'] ."</td>
											<td class='center' style='vertical-align: middle;'>".$fhfhhfhss."</td>
											<td class='center' style='font-weight: bold;font-size: 15px;vertical-align: middle;'>".$deaddd."</td>
											<td class='center' style='font-weight: bold;font-size: 13px;vertical-align: middle;".$angleee."'>" . $readytoadd ."</td>
										</tr>";
										$aaa++;
								}
							}
							else{echo 'Selected Network are not Connected.';} ?>
					</tbody>
			</table>
		</div>
		<div class="modal-footer" style="text-align: center;">
			<button type="reset" class="btn ownbtn11">Reset</button>
			<button class="btn ownbtn2" type="submit">Submit</button>    
		</div>	
	</form>
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
			"aaSorting": [[7,'desc']],
            "sScrollY": "1100px"
        });
    });
</script>
<style>
div.checker{
	margin-right: 0;
}
</style>