<?php $zid=$_GET['z_id'];
include("conn/connection.php");
mysql_query("SET NAMES 'utf8'");

$resultwww = mysql_query("SELECT * FROM package WHERE z_id ='$zid' AND  `status` = '0'");
//}
?>


<select style="width:250px;" name="p_id" id="p_id" required="" >
<option value=""></option>
<?php while ($rowrrrr = mysql_fetch_array($resultwww)) { ?>
<option value="<?php echo $rowrrrr['p_id']?>"><?php echo $rowrrrr['p_name']; ?> (<?php echo $rowrrrr['p_price']; ?> - <?php echo $rowrrrr['bandwith']; ?>)</option>
<?php } ?>

</select>