<?php $zid=$_GET['z_id'];
include("conn/connection.php");
mysql_query("SET NAMES 'utf8'");

//$sss1 = mysql_query("SELECT * FROM package WHERE z_id ='$zid' AND `status` = '0' LIMIT 1");
//$sssw1 = mysql_fetch_assoc($sss1);
//$pak_id = $sssw1['p_id'];

//if($pak_id == ''){
//	$result = mysql_query("SELECT * FROM package WHERE `status` = '0'");
//}
//else{
$resultwww = mysql_query("SELECT * FROM package WHERE z_id ='$zid' AND  `status` = '0'");
//}
?>


<select data-placeholder="Choose a Package" name="p_id" class="chzn-select" style="width:540px;"  required="">
<option value=""></option>
<?php while ($rowrrrr = mysql_fetch_array($resultwww)) { ?>
<option value="<?php echo $rowrrrr['p_id']?>"><?php echo $rowrrrr['p_name']; ?> (<?php echo $rowrrrr['p_price']; ?> - <?php echo $rowrrrr['bandwith']; ?>)</option>
<?php } ?>
</select>

