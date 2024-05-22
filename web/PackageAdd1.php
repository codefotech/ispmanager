<?php
$titel = "Add Package";
$Package = 'active';
include('include/hader.php');
include("mk_api.php");
$mk_id = $_GET['mk_id'];
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Package' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
if($userr_typ == 'superadmin' || $userr_typ == 'admin'){
	
$sql2 ="SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1";
$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$idz = $row2['p_id'];
$pid = $idz + 1;

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" onclick="history.back()" ><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-tasks"></i></div>
        <div class="pagetitle">
            <h1>Add Package</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add New Package</h5>
				</div>
					<form id="form" class="stdform" method="post" action="PackageAddQuery">
						<input type="hidden" name="p_id" value="<?php echo $pid;?>"/>
						<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>"/>
							<div class="modal-body">
								
								<p>
									<label style="font-weight: bold;">Profile Name*</label>
									<span class="field">
										<select style="width:40%;" class="select-large chzn-select" name="mk_profile" required="" onChange="getRoutePoint1(this.value)"/>
											<option value="">Choose Package Profile</option>
											<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
														$arrID = $API->comm('/ppp/profile/getall');
														foreach($arrID as $x => $x_value){
														$profile_name = $x_value['name'];
														$localaddress = $x_value['local-address'];
														$remoteaddress = $x_value['remote-address'];
											echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
											}
											else{echo 'Selected Network are not Connected.';}
											?>
										</select> 
									</span>
								</p>
								<div id="Pointdiv">
								<p>
									<label style="font-weight: bold;">Package Name*</label>
									<span class="field">
										<input type="text" name="p_name" id="" placeholder="Ex: Package-1" class="input-xlarge" required=""/>
									</span>
								</p>
								</div>
								<p>
									<label style="font-weight: bold;">Package Price*</label>
									<span class="field">
										<input type="text" name="p_price" id="" placeholder="Ex: 5000" style="width: 15%;" class="input-xlarge" required="" /><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
									</span>
								</p>
								<p>
									<label style="font-weight: bold;">Package Bandwith*</label>
									<span class="field">
										<input type="text" name="bandwith" id="" style="width: 15%;" placeholder="Ex: 2MB" class="input-xlarge" required="" />
									</span>
								</p>
								<p>
									<label>MAC Reseller Area</label>
									<span class="field">
										<select class="select-ext-large chzn-select" style="width:40%;" name="z_id">
											<option value="">Choose MAC Owner </option>
											<?php 	$emp_n="SELECT z.z_id, z.z_name, z.z_bn_name, e.e_name, z.`status` FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.e_id != '' AND z.`status` = '0' ORDER BY z.z_name ASC";	$e_n_ro=mysql_query($emp_n); ?>
											<?php while ($e_n_r=mysql_fetch_array($e_n_ro)) { ?>
											<option value="<?php echo $e_n_r['z_id'];?>"> <?php echo $e_n_r['z_name'];?> - <?php echo $e_n_r['e_name'];?></option>
											<?php } ?>
										</select>
									</span>
								</p>
								<span class="field"><div id="charNum"></div></span>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn">Reset</button>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
					</form>			
			</div>
		</div>
	</div>
<?php
}
else{echo "Sorry to say, You are not authorized. Don't try again.";}
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
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
	

	function getRoutePoint1(afdId) {		
		
		var strURL="packagename.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv').innerHTML=req.responseText;						
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