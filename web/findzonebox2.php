<?php $zid=$_GET['z_id'];
include("conn/connection.php");
mysql_query("SET NAMES 'utf8'");

$resultwww = mysql_query("SELECT * FROM box WHERE z_id ='$zid' AND  sts = '0'");
?>

<div class="inputwrapper animate_cus1">
<select data-placeholder="Choose a Box" name="box_id" class="chzn-select" style="width:345px;text-align: center;">
<option value="all">All Box</option>
<?php while ($rowrrrr = mysql_fetch_array($resultwww)) { ?>
<option value="<?php echo $rowrrrr['box_id']?>"><?php echo $rowrrrr['box_id']?> - <?php echo $rowrrrr['b_name']; ?>  <?php echo $rowrrrr['location']; ?></option>
<?php } ?>
</select>

</div>