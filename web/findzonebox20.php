<?php $zid=$_GET['z_id'];
include("conn/connection.php");
mysql_query("SET NAMES 'utf8'");

$resultwww = mysql_query("SELECT * FROM box WHERE z_id ='$zid' AND sts = '0'");

?>
<select name="box_id" data-placeholder="Select Box" id="box_id" style="width:90%;height: 33px;text-align: center;font-weight: bold;color: #666;">
			<option value="all">All Boxs</option>
	<?php while ($rowrrrr = mysql_fetch_array($resultwww)) { ?>
			<option value="<?php echo $rowrrrr['box_id']?>"><?php echo $rowrrrr['box_id']?> - <?php echo $rowrrrr['b_name']; ?>  <?php echo $rowrrrr['location']; ?></option>
	<?php } ?>
</select>


