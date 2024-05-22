<?php
$titel = "Package";
$Package = 'active';
include('include/hader.php');
include("mk_api.php");
$p_id = $_GET['id'];
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Package' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql2 ="SELECT p_id, p_name, p_price, change_sts, bandwith, z_id, mk_profile, p_price_reseller, signup_sts, p_name_reseller, mk_id FROM package WHERE p_id = '$p_id'";
$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$p_id = $row2['p_id'];
$p_name = $row2['p_name'];
$p_price = $row2['p_price'];
$bandwith = $row2['bandwith'];
$z_id = $row2['z_id'];
$mk_profile = $row2['mk_profile'];
$p_price_reseller = $row2['p_price_reseller'];
$signup_stssss = $row2['signup_sts'];
$change_sts = $row2['change_sts'];
$p_mk_id = $row2['mk_id'];


if($z_id != '0'){
$queryd=mysql_query("SELECT z.z_id, e.mk_id, z.z_name, z.z_bn_name, e.e_name, z.`status` FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.e_id != '' AND z.`status` = '0' AND z.z_id = '$z_id'");
$rowd = mysql_fetch_assoc($queryd);
$z_name = $rowd['z_name'];
$e_name = $rowd['e_name'];
$mk_id = $rowd['mk_id'];

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
}
else{
$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$p_mk_id'");
}

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
			<a class="btn ownbtn2" href="Package"><i class="iconfa-arrow-left"></i> All Packages</a>
        </div>
        <div class="pageicon"><i class="iconfa-tasks"></i></div>
        <div class="pagetitle">
            <h1>Edit Package</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Package Informations</h5>
				</div>
				<form id="form" class="stdform" method="post" action="PackageEditQuery">
					<input type="hidden" readonly name="p_id" value="<?php echo $p_id;?>">
					<div class="modal-body">
					<?php if($userr_typ == 'mreseller'){ ?>
					<input type="hidden" class="input-large" name="way" value="macreseller">
					<p>
						<label style="font-weight: bold;">Package Name*</label>
						<span class="field"><input id="" type="text" name="p_name" class="input-xlarge" style="font-weight: bold;" value="<?php echo $p_name;?>" required=""></span>
					</p>
					
					<p>
						<label>Bandwith</label>
						<span class="field"><input id="" type="text" readonly style="width: 105px;font-weight: bold;" value="<?php echo $bandwith;?>" required=""></span>
					</p>
					<?php if($change_sts == '0'){ ?>
					<p>
						<label>Package Price</label>
						<span class="field"><input type="text" name="p_price_reseller" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width:80px;font-size: 18px;font-weight: bold;color: #47755e;text-align: right;" value="<?php echo $p_price_reseller;?>" /><input type="text" name="" id="" style="width:15px; color:#47755e; font-weight: bold;font-size: 18px;" value='৳' readonly /></span>
					</p>
					<?php } else{?>
					<p>
						<label>Package Price</label>
						<span class="field"><input type="text" name="p_price_reseller" readonly onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width:80px;font-size: 18px;font-weight: bold;color: #47755e;text-align: right;" value="<?php echo $p_price_reseller;?>" /><input type="text" name="" id="" style="width:15px; color:#47755e; font-weight: bold;font-size: 18px;" value='৳' readonly /></span>
					</p>
					<?php } ?>
					<p>
						<label>Company Price</label>
						<span class="field"><input type="text" name="" readonly onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width:80px;font-size: 18px;font-weight: bold;color: darkblue;text-align: right;" required="" value="<?php echo $p_price;?>" /><input type="text" name="" id="" style="width:15px; color:darkblue; font-weight: bold;font-size: 18px;" value='৳' readonly /></span>
					</p>
					<?php } else{ ?>
					<input type="hidden" class="input-large" name="way" value="main">
					<?php if($z_id == '0'){ ?>
					<p>
						<label style="font-weight: bold;">Network*</label>
						<select name="mk_id" id="mk_id" style="font-weight: bold;width: 280px;" required="">	
							<option></option>
							<?php 
								$querydt="SELECT * FROM mk_con WHERE sts = '0'";
								$resultdt=mysql_query($querydt);
							while ($rowdt=mysql_fetch_array($resultdt)) { ?>
								<option value=<?php echo $rowdt['id'];?> <?php if ($rowdt['id'] == $p_mk_id) echo 'selected="selected"';?> ><?php echo $rowdt['Name'];?> (<?php echo $rowdt['ServerIP'];?>)</option>		
							<?php } ?>
						</select>
					</p>
					<?php } else{ ?>
						<input type="hidden" name="mk_id" value="<?php echo $p_mk_id;?>">
					<?php } ?>
					<p id='resultpack'>
						<label style="font-weight: bold;">Profile Name*</label>
						<span class="field">
						<select style="font-weight: bold;width: 280px;" name="mk_profile" onChange="getRoutePoint1(this.value)" required="">
							<option value="">Choose Package Profile</option>
							<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
										$arrID = $API->comm('/ppp/profile/getall');
										foreach($arrID as $x => $x_value){
										$profile_name = $x_value['name'];
										$localaddress = $x_value['local-address'];
										$remoteaddress = $x_value['remote-address'];
										if($mk_profile == $profile_name){$selecfgh = 'selected="selected"';} else{$selecfgh = '';};
							echo '<option value="'.$profile_name.'"'.$selecfgh.'>'.$profile_name.' - '.$localaddress.'</option>';}
							}
							else{echo 'Selected Network are not Connected.';}
							?>
						</select>
						</span>
					</p>
					<p id='Pointdiv1'>
						<label style="font-weight: bold;">Package Name*</label>
						<span class="field"><input id="" type="text" name="p_name" class="input-xlarge" style="font-weight: bold;" value="<?php echo $p_name;?>" required=""></span>
					</p>
					<p>
						<label style="font-weight: bold;">Bandwith*</label>
						<span class="field"><input id="" type="text" name="bandwith" style="width: 105px;font-weight: bold;" value="<?php echo $bandwith;?>" required=""></span>
					</p>
					<p>
						<label style="font-weight: bold;">Package Price*</label>
						<span class="field"><input type="text" name="p_price" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width:80px;font-size: 18px;font-weight: bold;color: darkblue;text-align: right;" required="" value="<?php echo $p_price;?>" /><input type="text" name="" id="" style="width:15px; color:darkblue; font-weight: bold;font-size: 18px;" value='৳' readonly /></span>
					</p>
					
					<?php if($z_id != '0'){ ?>
					<p>
						<label>Reseller Selling Price</label>
						<span class="field"><input type="text" name="p_price_reseller" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="width:80px;font-size: 18px;font-weight: bold;color: #47755e;text-align: right;" value="<?php echo $p_price_reseller;?>" /><input type="text" name="" id="" style="width:15px; color:#47755e; font-weight: bold;font-size: 18px;" value='৳' readonly /></span>
					</p>
					<p>
						<label>Reseller Can Modify?</label>
						<span class="formwrapper" style="margin-left: 0px;">
							<input type="radio" name="change_sts" value="0" <?php if ('0' == $change_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
							<input type="radio" name="change_sts" value="1" <?php if ('1' == $change_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
						</span>
					</p>
					<p>
						<label>Mac Reseller</label>
						<span class="field" style="font-size: 18px;padding: 5px 20px 0 0;"><?php echo $z_name;?> (<?php echo $e_name;?>)</span>
					</p>
					<?php } if($z_id == '0'){ ?>
					<p>
						<label>Show On New SineUp</label>
						<span class="formwrapper" style="margin-left: 0px;">
							<input type="radio" name="signup_sts" value="1" <?php if ('1' == $signup_stssss) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
							<input type="radio" name="signup_sts" value="0" <?php if ('0' == $signup_stssss) echo 'checked="checked"';?>> No &nbsp; &nbsp;
						</span>
					</p>
					<?php }} ?>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
				</form>			
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
		
		var strURL="mk-packagename.php?mk_profile="+afdId;
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
<script type="text/javascript">
jQuery(document).ready(function(){  
    jQuery('#mk_id').on('change',function(){ 
        var mk_id = jQuery('#mk_id').val();
        jQuery.ajax({  
				type: 'POST',
                url: "mk-allpack-check.php",
                data:{mk_id:mk_id},
                success:function(data){
                    jQuery('#resultpack').html(data);
                }
        });  
    });  
});
</script>