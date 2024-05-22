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
		<?php if($limit_accs == 'Yes'){ ?>
		<form name="form" class="" method="POST" action="<?php echo $PHP_SELF;?>" enctype="multipart/form-data">	
			<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 15px 0px 10px 15px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);overflow: auto;">
				<select name="z_id" style="border: 1px solid red;color: #0866c6e0;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 15px;border-radius: 5px;width: 30%;margin-right: 10px;float: left;" onChange="getRoutePoint(this.value)">
						<option value="" style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;">Choose Zone</option>
					<?php while ($row345=mysql_fetch_array($resultsdfg)) { ?>
						<option style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;" value="<?php echo $row345['z_id']?>"<?php if ($row345['z_id'] == $z_id) echo 'selected="selected"';?>><?php echo $row345['z_name']; ?></option>
					<?php } ?>
				</select>
				<div>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
				<b style="color: red;font-size: 14px;">THIS MONTH BILL</b>
				&nbsp; &nbsp;&nbsp; &nbsp;
				<input type="radio" name="radiofield" value="without_bill" <?php if ($radiofield == 'without_bill' || $radiofield == '') echo 'checked="checked"';?>/>Without Bill &nbsp; &nbsp;
				<input type="radio" name="radiofield" value="package_bill" <?php if ($radiofield == 'package_bill') echo 'checked="checked"';?>/>Package Price as Bill &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				<b style="color: red;font-size: 14px;">Deadline &nbsp;</b>
				<select name='payment_deadline' id='payment_deadline' style="border: 1px solid #317eac;color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: right;font-size: 14px;border-radius: 5px;width: 60px;height: 28px;margin-right: 5px;vertical-align: baseline;">
					<option value=''>NO</option>
					<option value='01'<?php if ($payment_deadline == '01') echo 'selected="selected"';?>>01</option>
					<option value='02'<?php if ($payment_deadline == '02') echo 'selected="selected"';?>>02</option>
					<option value='03'<?php if ($payment_deadline == '03') echo 'selected="selected"';?>>03</option>
					<option value='04'<?php if ($payment_deadline == '04') echo 'selected="selected"';?>>04</option>
					<option value='05'<?php if ($payment_deadline == '05') echo 'selected="selected"';?>>05</option>
					<option value='06'<?php if ($payment_deadline == '06') echo 'selected="selected"';?>>06</option>
					<option value='07'<?php if ($payment_deadline == '07') echo 'selected="selected"';?>>07</option>
					<option value='08'<?php if ($payment_deadline == '08') echo 'selected="selected"';?>>08</option>
					<option value='09'<?php if ($payment_deadline == '09') echo 'selected="selected"';?>>09</option>
					<option value='10'<?php if ($payment_deadline == '10') echo 'selected="selected"';?>>10</option>
					<option value='11'<?php if ($payment_deadline == '11') echo 'selected="selected"';?>>11</option>
					<option value='12'<?php if ($payment_deadline == '12') echo 'selected="selected"';?>>12</option>
					<option value='13'<?php if ($payment_deadline == '13') echo 'selected="selected"';?>>13</option>
					<option value='14'<?php if ($payment_deadline == '14') echo 'selected="selected"';?>>14</option>
					<option value='15'<?php if ($payment_deadline == '15') echo 'selected="selected"';?>>15</option>
					<option value='16'<?php if ($payment_deadline == '16') echo 'selected="selected"';?>>16</option>
					<option value='17'<?php if ($payment_deadline == '17') echo 'selected="selected"';?>>17</option>
					<option value='18'<?php if ($payment_deadline == '18') echo 'selected="selected"';?>>18</option>
					<option value='19'<?php if ($payment_deadline == '19') echo 'selected="selected"';?>>19</option>
					<option value='20'<?php if ($payment_deadline == '20') echo 'selected="selected"';?>>20</option>
					<option value='21'<?php if ($payment_deadline == '21') echo 'selected="selected"';?>>21</option>
					<option value='22'<?php if ($payment_deadline == '22') echo 'selected="selected"';?>>22</option>
					<option value='23'<?php if ($payment_deadline == '23') echo 'selected="selected"';?>>23</option>
					<option value='24'<?php if ($payment_deadline == '24') echo 'selected="selected"';?>>24</option>
					<option value='25'<?php if ($payment_deadline == '25') echo 'selected="selected"';?>>25</option>
					<option value='26'<?php if ($payment_deadline == '26') echo 'selected="selected"';?>>26</option>
					<option value='27'<?php if ($payment_deadline == '27') echo 'selected="selected"';?>>27</option>
					<option value='28'<?php if ($payment_deadline == '28') echo 'selected="selected"';?>>28</option>
					<option value='29'<?php if ($payment_deadline == '29') echo 'selected="selected"';?>>29</option>
					<option value='30'<?php if ($payment_deadline == '30') echo 'selected="selected"';?>>30</option>
					<option value='31'<?php if ($payment_deadline == '31') echo 'selected="selected"';?>>31</option>
				</select>
				<div id="Pointdiv1" style="float: right;">
					<?php if($mk_id != '' && $z_id != '' && $user_type != ''){?>
					<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>"/>
					<input type="hidden" name="z_id" value="<?php echo $z_id;?>"/> 
					<button class="btn ownbtn4" type="submit" style="float: right;margin-right: 15px;">Submit</button>
					<?php } ?>
				</div>
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
								$arrID = $API->comm('/ppp/secret/getall');
								foreach($arrID as $x => $x_value) {
									
									$mk_cid = $x_value['name'];
									$comment = $x_value['comment'];
									$mk_profile = $x_value['profile'];
									$sqlcl = mysql_query("SELECT c.c_id, z.z_name, c.cell, payment_deadline, b_date FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.c_id = '$mk_cid'");
									$rowcll = mysql_fetch_assoc($sqlcl);
									$c_id = $rowcll['c_id'];
									$z_name = $rowcll['z_name'];
									$payment_deadline = $rowcll['payment_deadline'];
									$b_date = $rowcll['b_date'];
									
									$sqlclp = mysql_query("SELECT p_id, p_price FROM package WHERE status = '0' AND mk_profile = '$mk_profile' AND z_id = '0' AND status = '0'");
									$rowcllp = mysql_fetch_assoc($sqlclp);
									$p_id = $rowcllp['p_id'];
									$p_price = $rowcllp['p_price'];
									
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
										$addbttn1 = $z_name;
									}
									
									if($x_value['disabled'] == 'false'){
										$fhfhhfh = 'Active';
										$fhfhhfhss = "<spen class='label label-success' style='font-weight: bold;border-radius: 5px;font-size: 15px;padding: 5px;'>Enabled</spen>";
									}
									else{
										$fhfhhfh = 'Inactive';
										$fhfhhfhss = "<spen class='label label-important' style='font-weight: bold;border-radius: 5px;font-size: 15px;padding: 5px;'>Disabled</spen>";
									}
									
									if($payment_deadline !='' || $b_date != ''){
										$deaddd = $payment_deadline.' | '.$b_date;
									}
									else{
										$deaddd = '';
									}
									
									echo "<tr>
											<td class='center' style='width: 18px;font-weight: bold;font-size: 18px;vertical-align: middle;".$angleee."'>" . $aaa ."</td>
											<td><b style='font-size: 13px;'>" . $x_value['name'] ."</b><br>" . $x_value['password'] ."<br>" . $cell . "</td>
											<td><b ".$colooor."/>" . $x_value['profile'] .$possible."</b><br>" . $x_value['last-logged-out'] . "<br><div id='olddatee".$aaa."'><b>" . $addbttn1 . "</b></div></td>
											<td>" . $x_value['remote-address'] ."<br>" . $x_value['caller-id'] ."<br>". $comment ."</td>
											<td class='center' style='vertical-align: middle;'>".$fhfhhfhss."</td>
											<td class='center' style='font-weight: bold;font-size: 15px;vertical-align: middle;'><div id='olddateline".$aaa."'>" . $deaddd ."</div></td>
											<td class='center' style='font-weight: bold;font-size: 13px;vertical-align: middle;".$angleee."'><b><div id='olddate".$aaa."'>" . $addbttn ."</div></b></td>
										</tr>"; ?>
									<script>
										$(document).ready(function(){  
											$("#addbttn<?php echo $aaa;?>").on('click',function(){
												var payment_deadline = $('#payment_deadline').val();
												var c_id = '<?php echo $x_value["name"];?>';
												var comment = '<?php echo $comment;?>';
												var password = '<?php echo $x_value["password"];?>';
												var p_id = '<?php echo $p_id;?>';
												var p_price = '<?php echo $p_price;?>';
												var z_id = '<?php echo $z_id;?>';
												var mk_id = '<?php echo $mk_id;?>';
												var radiofield = '<?php echo $radiofield;?>';
												var con_sts = '<?php echo $fhfhhfh;?>';
												var ip = '<?php echo $x_value["remote-address"];?>';
												var mac = '<?php echo $x_value["caller-id"];?>';
												if(mk_id > 0){
												$.ajax({  
														type: 'POST',
														url: "own-client-import-one-by-one",
														data:{payment_deadline:payment_deadline,c_id:c_id,password:password,p_id:p_id,p_price:p_price,z_id:z_id,mk_id:mk_id,radiofield:radiofield,con_sts:con_sts,ip:ip,mac:mac,comment:comment},
														success:function(data){
															data = JSON.parse(data);
															$('#olddate<?php echo $aaa;?>').html("<b>"+data.errormsg+"</b>");
															$('#olddateline<?php echo $aaa;?>').html("<b>"+data.payment_deadline+" | "+data.payment_deadline+"</b>");
															$('#olddatee<?php echo $aaa;?>').html("<b>"+data.z_name+"</b>");
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
		<?php }} else{ ?>
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
		var strURL="import-own-client-one-by-one.php?z_id="+afdId+"&mk_id=<?php echo $mk_id;?>";
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