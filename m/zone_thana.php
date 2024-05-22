<?php
include("../web/conn/connection.php");
$z_id = isset($_POST['z_id']) ? $_POST['z_id'] : '';
$for = isset($_POST['for']) ? $_POST['for'] : '';
$old_thana = isset($_POST['old_thana']) ? $_POST['old_thana'] : '';

if($z_id != ''){
	$sql2 = mysql_query("SELECT z_id, thana FROM zone WHERE z_id = '$z_id'");

$row2 = mysql_fetch_assoc($sql2);
$zthana = $row2['thana'];
$thana_arry = explode(',', $row2['thana']);
}

if($for == 'add'){
if($zthana != ''){
?>
	<p>
		<label style="width: 130px;">Thana</label>
		<span class="field" style="margin-left: 0px;">
			<select data-placeholder="Choose a Package" name="thana" class="chzn-select" style="width:250px;">
				<?php foreach ($thana_arry as $option) {
					echo '<option value="' . $option . '">' . $option . '</option>';
					}?>
			</select>
		</span>
	</p>
<?php } else{ ?>
<p>
	<label style="width: 130px;">Thana</label>
	<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="thana" placeholder="" id="" class="input-xxlarge" /></span>
</p>
<?php }} if($for == 'edit'){ if($zthana != ''){ ?>
	<p>
		<label style="width: 130px;">Thana</label>
		<span class="field" style="margin-left: 0px;">
			<select data-placeholder="Choose a Package" name="thana" class="chzn-select" style="width:250px;">
				<?php foreach ($thana_arry as $option) {
					$selected = ($option == $old_thana) ? 'selected' : '';
					echo '<option value="' . $option . '"' . $selected . '>' . $option . '</option>';
					}?>
			</select>
		</span>
	</p>
<?php } else{ ?>
	
<p>
	<label style="width: 130px;">Thana</label>
	<span class="field" style="margin-left: 0px;"><input type="text" name="thana" id="" style="width:240px;" class="input-xxlarge" value="<?php echo $old_thana;?>" /></span>
</p>
	
<?php }} ?>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />

<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="js/elements.js"></script>
