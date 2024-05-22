<?php 
include("conn/connection.php");
$z_id = isset($_GET['z_id']) ? $_GET['z_id'] : ''; 
$resultsdfg=mysql_query("SELECT c.mk_id, m.Name, m.ServerIP FROM clients AS c LEFT JOIN mk_con AS m ON m.id = c.mk_id WHERE c.sts = '0' AND c.mac_user = '0' GROUP BY c.mk_id");

if($z_id != ''){
?>
<input type="hidden" name="z_id" value="<?php echo $z_id;?>"/>
<select name="mk_id" style="border: 1px solid red;color: #0866c6e0;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 15px;border-radius: 5px;width: 30%;margin-right: 10px;">
	<option value="" style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;">Choose Network</option>
<?php while ($row345=mysql_fetch_array($resultsdfg)) { ?>
	<option style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;" value="<?php echo $row345['mk_id']?>"<?php if ($row345['mk_id'] == $mk_id) echo 'selected="selected"';?>><?php echo $row345['mk_id']; ?> - <?php echo $row345['Name']; ?> (<?php echo $row345['ServerIP'];?>)</option>
<?php } ?>
</select>

<button class="btn ownbtn4" type="submit" style="float: right;margin-right: 15px;">Submit</button>
<?php } else{} ?>