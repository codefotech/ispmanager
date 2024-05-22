<?php
include("conn/connection.php") ;
$z_id = isset($_GET['z_id']) ? $_GET['z_id'] : '';

if($z_id != ''){
	$sql2 = mysql_query("SELECT z_id, p_id FROM zone WHERE z_id = '$z_id'");

$row2 = mysql_fetch_assoc($sql2);
$zp_id = $row2['p_id'];
$pid_arry = explode(',', $row2['p_id']);

$resultds=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '' AND p_id IN ($zp_id) order by id ASC");
}
if($zp_id != ''){
?>

	<p>
		<label style="width: 130px;font-weight: bold;">Package*</label>
		<span class="field" style="margin-left: 0px;">
			<select data-placeholder="Choose a Package" id="p_id" name="p_id" class="chzn-select" style="width:250px;" required="" >
				<option value=""></option>
					<?php while ($row1=mysql_fetch_array($resultds)) {?>			
				<option value="<?php echo $row1['p_id'];?>"><?php echo $row1['p_name'];?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
					<?php } ?>
			</select>
		</span>
	</p>
<?php } else{ 
$resultdss=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '' order by id ASC");
?>
<p>
	<label style="width: 130px;font-weight: bold;">Package*</label>
	<span class="field" style="margin-left: 0px;">
		<select data-placeholder="Choose a Package" id="p_id" name="p_id" class="chzn-select" style="width:250px;" required="" >
			<option value=""></option>
				<?php while ($row1=mysql_fetch_array($resultdss)) { ?>
			<option value="<?php echo $row1['p_id']?>"<?php if($row1['p_id'] == $p_id) echo 'selected="selected"';?>><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
				<?php } ?>
		</select>
	</span>
</p>
<?php } ?>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />

<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="js/elements.js"></script>
