<?php 
include("conn/connection.php");
$check_type=$_GET['check_type'];
$treeid=$_GET['tree_id'];

$result11=mysql_query("SELECT ip FROM network_tree WHERE tree_id = '$treeid'");
$row11=mysql_fetch_assoc($result11);

if($check_type == '1'){
?>
						<p>
							<label style="font-weight: bold;">Device Local IP*</label>
							<span class="field"><input type="text" name="ip" value="<?php echo $row11['ip'];?>" id="" style="width:15%;" required=""/></span>
						</p>
<?php } else { ?>
						<p>
							<label>Device Local IP</label>
							<span class="field"><input type="text" name="ip" value="<?php echo $row11['ip'];?>" style="width:15%;"/></span>
						</p>
<?php } ?>