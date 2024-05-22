<?php
extract($_POST);
$titel = "Edit Zone Information";
$Zone = 'active';
include('include/hader.php');

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Zone' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($company_division_id != '0'){
	$sqlss1 = mysql_query("SELECT id AS dis_id, name AS dis_name, bn_name AS dis_bn_name, lat, lon, url FROM `districts` WHERE `division_id` = '$company_division_id'");  
	
	if($company_district_id != '0'){
		$sqlss2 = mysql_query("SELECT id AS upz_id, name AS upz_name, bn_name AS upz_bn_name, url FROM `upazilas` WHERE `district_id` =  '$company_district_id'");
	}
}

$sql2 ="SELECT z.z_id, z.z_name, z.z_bn_name, e.e_name, z.e_id, z.emp_id, z.p_id, z.thana, z.latitude, z.longitude FROM zone AS z
LEFT JOIN emp_info AS e
ON e.e_id = z.e_id
WHERE z.z_id = '$zid'";

$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$zo_id = $row2['z_id'];
$zo_name = $row2['z_name'];
$zo_bn_name = $row2['z_bn_name'];
$ee_id = $row2['e_id'];
$ee_name = $row2['e_name'];
$eid_arry = explode(',', $row2['emp_id']);
$pid_arry = explode(',', $row2['p_id']);
$thana_arry = explode(',', $row2['thana']);

$latitude = $row2['latitude'];
$longitude = $row2['longitude'];
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Zone"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Edit Zone</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Zone Information Edit</h5>
				</div>
				<form id="form" class="stdform" method="post" action="ZoneEditQuery">
					<input type="hidden" name="zone_id" value="<?php echo $zo_id;?>">
					<div class="modal-body">
					<p>
						<label style="font-weight: bold;">Zone Name (English)*</label>
						<span class="field"><input style="text-align:center;height: 25px;font-size: 25px;font-weight: bold;width: 350px;" type="text" name="z_name" id="z_name" value="<?php echo $zo_name;?>" required=""></span>
					</p>
					<p>
						<label>Zone Name (Bangla)</label>
						<span class="field"><input style="text-align:center;height: 25px;font-size: 25px;font-weight: bold;width: 350px;" type="text" name="z_bn_name" value="<?php echo $zo_bn_name;?>"></span>
					</p>
					<?php if($ee_id == ''){ ?>
					<p>
						<label>Branch Manager</label>
						<select data-placeholder="Multiple Employee" name="emp_id[]" class="chzn-select" style="width: 360px;text-align:center;height: 25px;" multiple="multiple" tabindex="5">
							<?php $resultd=mysql_query("SELECT e.id, e.e_id, e.e_name FROM emp_info AS e LEFT JOIN login AS l ON l.e_id = e.e_id WHERE e.dept_id != '0' AND e.status = '0' AND l.user_type = 'billing' order by e.e_id");
							while ($rowd=mysql_fetch_array($resultd)) {?>			
								<option style="text-align:center;" value=<?php echo $rowd['e_id'];?> <?php if(in_array($rowd['e_id'], $eid_arry)){echo 'selected="selected"';}?>><?php echo $rowd['e_name'];?> - <?php echo $rowd['e_id'];?></option>		
							<?php } ?>
						</select>
					</p>
					<p>
						<label>Branch Packages</label>
						<select data-placeholder="Multiple Packages" name="p_id[]" class="chzn-select" style="width: 360px;text-align:center;height: 25px;" multiple="multiple" tabindex="5">
							<?php $resultds=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '' order by id ASC");
							while ($row1=mysql_fetch_array($resultds)) {?>			
								<option style="text-align:center;" value="<?php echo $row1['p_id']?>"<?php if(in_array($row1['p_id'], $pid_arry)){echo 'selected="selected"';}?>><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
							<?php } ?>
						</select>
					</p>
					<?php } else{ ?>
					<p>
						<label>MAC / Area Owner</label>
						<span class="field"><input style="text-align:center;" id="" type="text" readonly name="" class="input-xlarge" value="<?php echo $ee_name;?> - <?php echo $ee_id;?>"></span>
					</p>
						<input type="hidden" name="emp_id[]" value="">
					<?php } ?>
					<p>
						<label>Thana</label>
						<select data-placeholder="Multiple Thana" name="thana[]" class="chzn-select" style="width: 360px;text-align:center;height: 25px;" multiple="multiple" tabindex="5">
							<?php if($company_division_id == '0' && $company_district_id == '0' || $company_division_id != '0' && $company_district_id == '0'){ ?>
								<a style="font-size: 15px;color: red;font-weight: bold;vertical-align: middle;">[Please Setup Your Division & District First]</a><br>
								<a href="AppSettings?wayyy=Basic Informations" style="font-size: 15px;font-weight: bold;vertical-align: middle;">Go to Settings >> Basic.</a><br>
							<?php } else{ while ($row1ss=mysql_fetch_array($sqlss2)) { ?>			
								<option style="text-align:center;" value="<?php echo $row1ss['upz_name']?>"<?php if(in_array($row1ss['upz_name'], $thana_arry)){echo 'selected="selected"';}?>><?php echo $row1ss['upz_name']; ?> (<?php echo $row1ss['upz_bn_name'];?>)</option>
							<?php }} ?>
						</select>
					</p>
					<p>
						<label></label>
						<span class="field">
							<div class="input-append">
								<input type="text" id="latitude" name="latitude" readonly placeholder="Latitude" style="width: 168px;text-align: right;font-weight: bold;" value="<?php echo $latitude;?>">
								<input type="text" id="longitude" name="longitude" readonly style="margin-left: 4px;text-align: left;font-weight: bold;width: 168px;" placeholder="Longitude" value="<?php echo $longitude;?>">
							</div>
						</span>
					</p>
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
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false&amp;key=<?php echo $gapikey;?>&amp;libraries=places"></script>
<script>
google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
var input = document.getElementById('z_name');
var autocomplete = new google.maps.places.Autocomplete(input);
autocomplete.addListener('place_changed', function () {
var place = autocomplete.getPlace();
  document.getElementById("latitude").value = place.geometry['location'].lat();
  document.getElementById("longitude").value = place.geometry['location'].lng();
});
}
</script>