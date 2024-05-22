<?php $zid=$_GET['z_id'];
include("conn/connection.php");
mysql_query("SET NAMES 'utf8'");

$resultwww = mysql_query("SELECT * FROM box WHERE z_id ='$zid' AND  sts = '0'");
if($zid != 'all'){
?>


<select name="box_id" class="chzn-select" style="width:345px;">
<option value="allbox">All Box</option>
<?php while ($rowrrrr = mysql_fetch_array($resultwww)) { ?>
<option value="<?php echo $rowrrrr['box_id']?>"><?php echo $rowrrrr['b_name']; ?> (<?php echo $rowrrrr['location']; ?> - <?php echo $rowrrrr['b_port']; ?>)</option>
<?php } ?>
</select>

<?php } else{?> 
<select data-placeholder="Choose a Box" class="chzn-select" name="box_id"  style="width:345px;" >
		<option value="all">All Box</option>
</select>
<?php } ?>