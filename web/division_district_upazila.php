<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$division_id = isset($_POST['division_id']) ? $_POST['division_id'] : '';
$district_id = isset($_POST['district_id']) ? $_POST['district_id'] : '';
$upazila_id = isset($_POST['upazila_id']) ? $_POST['upazila_id'] : '';
$union_id = isset($_POST['union_id']) ? $_POST['union_id'] : '';


if($division_id != ''){
	$sqlss1 = mysql_query("SELECT id AS dis_id, name AS dis_name, bn_name AS dis_bn_name, lat, lon, url FROM `districts` WHERE `division_id` = '$division_id'");  
	
	if($district_id != ''){
		$sqlss2 = mysql_query("SELECT id AS upz_id, name AS upz_name, bn_name AS upz_bn_name, url FROM `upazilas` WHERE `district_id` =  '$district_id'");  
		
		if($upazila_id != ''){
			$sqlss3 = mysql_query("SELECT id AS uni_id, name AS uni_name, bn_name AS uni_bn_name, url FROM `unions` WHERE `upazilla_id` =  '$upazila_id'");
		}
	}
}

if($division_id != ''){ ?>
<p>
	<label style="font-weight: bold;"></label>
	<select name="district_id" id="district_id" data-placeholder="District" class="chzn-select" style="font-weight: bold;width: 360px;">
		<option></option>
		<?php while ($rdowdst1 = mysql_fetch_array($sqlss1)) { ?>
			<option value="<?php echo $rdowdst1['dis_id'];?>" <?php if ($rdowdst1['dis_id'] == $district_id) echo 'selected="selected"';?>><?php echo $rdowdst1['dis_name'];?> (<?php echo $rdowdst1['dis_bn_name'];?>)</option>		
		<?php } ?>
	</select>
</p>

<?php if($district_id != '' && $division_id != ''){ ?>
<p>
	<label style="font-weight: bold;"></label>
	<select name="upazila_id" id="upazila_id" data-placeholder="Upazila/Thana" class="chzn-select" style="font-weight: bold;width: 178px;">
		<option></option>
		<?php while ($rdowdst2 = mysql_fetch_array($sqlss2)) { ?>
			<option value="<?php echo $rdowdst2['upz_id'];?>" <?php if ($rdowdst2['upz_id'] == $upazila_id) echo 'selected="selected"';?>><?php echo $rdowdst2['upz_name'];?> (<?php echo $rdowdst2['upz_bn_name'];?>)</option>		
		<?php } ?>
	</select>

<?php if($upazila_id != '' && $district_id != '' && $division_id != ''){ ?>
	<select name="union_id" id="union_id" data-placeholder="Union" class="chzn-select" style="font-weight: bold;width: 178px;">
		<option></option>
		<?php while ($rdowdst3 = mysql_fetch_array($sqlss3)) { ?>
			<option value="<?php echo $rdowdst3['uni_id'];?>" <?php if ($rdowdst3['uni_id'] == $union_id) echo 'selected="selected"';?>><?php echo $rdowdst3['uni_name'];?> (<?php echo $rdowdst3['uni_bn_name'];?>)</option>		
		<?php } ?>
	</select>

<?php }}} ?>
	</p>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />

<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="js/elements.js"></script>
