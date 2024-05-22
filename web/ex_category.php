<?php 
include("conn/connection.php");
$category=$_GET['category'];
$vendorrr = mysql_query("SELECT id, v_name, cell, location FROM vendor WHERE sts = 0 ORDER BY v_name");
$agenttt = mysql_query("SELECT e_id, e_name, e_cont_per, com_percent FROM agent WHERE sts = 0 ORDER BY e_name");

if($category == '1'){
?>
<p>	
<label style="font-weight: bold;">Vendor*</label>
	<select name="v_id" class="chzn-select"  style="width:400px !important;" required="">
		<option value="">Choose Vendor</option>
			<?php while ($row1=mysql_fetch_array($vendorrr)) {?>
		<option value="<?php echo $row1['id']; ?>"><?php echo $row1['v_name'];?> (<?php echo $row1['cell']; ?>) <?php echo $row1['location']; ?></option>
			<?php } ?>
	</select>
</p>

<?php 
}
elseif($category == '2'){?>
<p>	
<label style="font-weight: bold;">Agent*</label>
	<select name="agent_id" class="chzn-select"  style="width:400px !important;" required="">
		<option value="">Choose Agent</option>
			<?php while ($row111=mysql_fetch_array($agenttt)) {?>
		<option value="<?php echo $row111['e_id']; ?>"><?php echo $row111['e_name'];?> <?php echo $row111['e_cont_per']; ?> (<?php echo $row111['com_percent']; ?>%)</option>
			<?php } ?>
	</select>
</p>
<?php } else {}?>