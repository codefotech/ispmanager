<?php $zid=$_GET['z_id'];
include("conn/connection.php");
mysql_query("SET NAMES 'utf8'");

$resultwww = mysql_query("SELECT * FROM box WHERE z_id ='$zid' AND sts = '0'");
?>

<select data-placeholder="Choose a Box" name="box_id" id="box_id" class="chzn-select" style="width:250px;">
<option value=""></option>
<?php while ($rowrrrr = mysql_fetch_array($resultwww)) { ?>
<option value="<?php echo $rowrrrr['box_id']?>"><?php echo $rowrrrr['box_id']?> - <?php echo $rowrrrr['b_name']; ?>  <?php echo $rowrrrr['location']; ?></option>
<?php } ?>
</select>

