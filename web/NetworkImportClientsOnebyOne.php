<?php
$titel = "Import Reseller Clients One By One";
$Network = 'active';
include('include/hader.php');
include("mk_api.php");
$mk_id = isset($_GET['id']) ? $_GET['id'] : '';
$input = isset($_GET['input']) ? $_GET['input'] : '';
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
$resultsdfg=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by e.e_name");

?>
	<div class="pageheader">
		<div class="searchbar" style="width: 50%;">
        </div>
        <div class="pageicon" style="padding: 2px;"><i class="iconfa-download-alt"></i></div>
        <div class="pagetitle">
             <h3 style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;">Import Reseller Clients One By One From Mikrotik</h3>
        </div>
    </div><!--pageheader-->		
		
		<div class="box box-primary">
		<?php if($limit_accs == 'Yes'){?>
		<form name="form" class="" method="POST" action="<?php echo $PHP_SELF;?>" enctype="multipart/form-data">	
		
			<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 8px 0px 10px 15px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);overflow: auto;">
				<div style="float: left;">
				<select name="z_id" style="border: 1px solid red;color: #0866c6e0;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 15px;border-radius: 5px;width: 20%;margin-right: 10px;float: left;" onChange="getRoutePoint(this.value)">
						<option value="" style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;">Choose Reseller</option>
					<?php while ($row345=mysql_fetch_array($resultsdfg)) { ?>
						<option style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;" value="<?php echo $row345['z_id']?>"<?php if ($row345['z_id'] == $z_id) echo 'selected="selected"';?>><?php echo $row345['resellername']; ?> - <?php echo $row345['z_name'];?></option>
					<?php } ?>
				</select>
				<input type="text" name="f_date" id="f_date" style="border: 1px solid red;color: #0866c6e0;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;border-radius: 3px;width: 10%;padding: 4px 15px;font-weight: bold;" placeholder="Recharge From" onChange="myFun()" class="surch_emp datepicker" value="<?php echo $f_date;?>" readonly required=""/>
				<input type="text" name="t_date" id="t_date" style="border: 1px solid red;color: #0866c6e0;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;border-radius: 3px;width: 10%;padding: 4px 15px;font-weight: bold;margin-left: 3px;" onChange="myFun()" placeholder="Recharge Till" class="surch_emp datepicker" value="<?php if($f_date <= $t_date) {echo $t_date;}?>" required=""/>
				<input type="text" name="duration" id="duration" style="border: 1px solid red;color: red;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;border-radius: 3px;width: 40px;margin-left: 3px;font-weight: bold;font-size: 15px;height: 18px;" placeholder="days" class="surch_emp" value="<?php if($duration >= '0'){echo $duration;}?>" readonly required=""/>
				&nbsp; &nbsp;&nbsp; &nbsp;
				<input type="radio" name="radiofield" value="day_calculation" <?php if ($radiofield == 'day_calculation' || $radiofield == '') echo 'checked="checked"';?>/>Day Calculation &nbsp; &nbsp;
				<input type="radio" name="radiofield" value="without_recharge" <?php if ($radiofield == 'without_recharge') echo 'checked="checked"';?>/>Without Recharge &nbsp; &nbsp;
				<input type="radio" name="radiofield" value="but_disable" <?php if ($radiofield == 'but_disable') echo 'checked="checked"';?>/>Add But Disable &nbsp; &nbsp;
				</div>
				<div id="Pointdiv1" style="float: right;">
					<?php if($z_id != '' && $mk_id != '' && $user_type != ''){?>
					<input type="hidden" name="input" value="<?php echo $input;?>"/>
					<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>"/>
					<input type="hidden" name="z_id" value="<?php echo $z_id;?>"/> 
					<button class="btn ownbtn4" type="submit" style="float: right;margin-right: 15px;">Submit</button><?php } ?>
				</div>
			</div>
		</form>
		<?php if($input == 'reseller' && $z_id != '' && $duration != '' && $f_date != '' && $t_date != '' && $mk_id != '' && $duration > '0'){ ?>
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
                    </colgroup>
                    <thead>
                        <tr class="newThead">
							<th class="head1 center" style='width: 20px;'>S/L</th>
							<th class="head0">PPPoE ID/PASS</th>
							<th class="head1">PROFILE/PRICE</th>
							<th class="head0">IP/MAC ADDRESS</th>
							<th class="head1 center">STATUS</th>
							<th class="head0 center">ACTION</th>
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
									$sqlcl = mysql_query("SELECT c.c_id, z.z_name, e.e_name AS resellernamee, c.cell FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN emp_info AS e ON e.z_id = c.z_id WHERE c.c_id = '$mk_cid'");
									$rowcll = mysql_fetch_assoc($sqlcl);
									$c_id = $rowcll['c_id'];
									$z_name = $rowcll['z_name'];
									$resellernamee = $rowcll['resellernamee'];
									$cell = $rowcll['cell'];
									
									$sqlclp = mysql_query("SELECT p_id, p_price, p_price_reseller FROM package WHERE status = '0' AND mk_profile = '$mk_profile' AND z_id = '$z_id' AND status = '0'");
									$rowcllp = mysql_fetch_assoc($sqlclp);
									$p_id = $rowcllp['p_id'];
									$p_price = $rowcllp['p_price'];
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
										$addbttn = "<button class='btn' id = 'addbttn".$aaa."' style='border-radius: 3px;border: 1px solid green;color: green;padding: 6px 9px;margin: 2px 0 0 0;'>ADD</button>";
										$addbttn1 = "";
									}
									else{
										$readytoadd = '';
										$checkdisableee = 'disabled="disabled"';
										$angleee = "color: #ff00009e;";
										$addbttn = "";
										$addbttn1 = $resellernamee.' - '.$z_name;
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
											<td class='center' style='width: 18px;font-weight: bold;font-size: 18px;vertical-align: middle;".$angleee."'>" . $aaa ."</td>
											<td><b style='font-size: 13px;'>" . $x_value['name'] ."</b><br>" . $x_value['password'] ."<br>" . $cell . "</td>
											<td><b ".$colooor."/>" . $x_value['profile'] .$possible."</b><br>" . $x_value['last-logged-out'] . "<br><div id='olddatee".$aaa."'><b>" . $addbttn1 . "</b></div></td>
											<td>" . $x_value['remote-address'] ."<br>" . $x_value['caller-id'] ."</td>
											<td class='center' style='vertical-align: middle;'>".$fhfhhfhss."</td>
											<td class='center' style='font-weight: bold;font-size: 13px;vertical-align: middle;".$angleee."'><div id='olddate".$aaa."'>" . $addbttn ."</div></td>
										</tr>"; ?>
									<script>
										$(document).ready(function(){  
											$("#addbttn<?php echo $aaa;?>").on('click',function(){
												var duration = $('#duration').val();
												var c_id = '<?php echo $x_value["name"];?>';
												var password = '<?php echo $x_value["password"];?>';
												var p_id = '<?php echo $p_id;?>';
												var p_price = '<?php echo $p_price;?>';
												var p_price_reseller = '<?php echo $p_price_reseller;?>';
												var z_id = '<?php echo $z_id;?>';
												var mk_id = '<?php echo $mk_id;?>';
												var f_date = $('#f_date').val();
												var t_date = $('#t_date').val();
												var radiofield = '<?php echo $radiofield;?>';
												var con_sts = '<?php echo $fhfhhfh;?>';
												var ip = '<?php echo $x_value["remote-address"];?>';
												var mac = '<?php echo $x_value["caller-id"];?>';
												if(duration > 0){
												$.ajax({  
														type: 'POST',
														url: "mac-client-import-one-by-one",
														data:{duration:duration,c_id:c_id,password:password,p_id:p_id,p_price:p_price,p_price_reseller:p_price_reseller,z_id:z_id,mk_id:mk_id,f_date:f_date,t_date:t_date,radiofield:radiofield,con_sts:con_sts,ip:ip,mac:mac},
														success:function(data){
															data = JSON.parse(data);
															$('#olddate<?php echo $aaa;?>').html("<b>"+data.errormsg+"</b>");
															$('#olddatee<?php echo $aaa;?>').html("<b>"+data.resellernamee+" - "+data.z_name+"</b>");
														}
												});
												return false;

												}
												else{
													$('#olddate<?php echo $aaa;?>').html("");
												}
											});  
										});
										
									</script>
								<?php		
								
								$aaa++;
								}
							}
							else{echo 'Selected Network are not Connected.';} ?>
					</tbody>
			</table>
		
			</div>
		<?php } } else{ ?>
					<div style='font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;padding: 30px;font-size: 30px;text-align: center;'>[User Limit Exceeded]</div>
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
			"aaSorting": [[5,'desc']],
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
    x4.value=dd-1;
}

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
		var strURL="import-reseller-client-one-by-one.php?z_id="+afdId;
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
		document.getElementById("t_date").value = ''		
		document.getElementById("duration").value = ''	
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