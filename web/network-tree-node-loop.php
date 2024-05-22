<?php
include("conn/connection.php");
$node1 = isset($_GET['node1']) ? $_GET['node1'] : '';

$sql3s60 = mysql_query("SELECT t.tree_id, t.device_type, t.name AS devicename, t.parent_id, z.z_name, t.location, t.in_color, d.d_name, d.icon, a.distance_km, a.distance_miles FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type LEFT JOIN zone AS z ON z.z_id = t.z_id LEFT JOIN network_tree_polyline AS a ON a.tree_id = t.tree_id WHERE t.sts = '0' AND t.parent_id = '$node1'");

while($row = mysqli_fetch_assoc($sql3s60)) {
	$options = "<option value='" . $row['tree_id'] . "'>" . $row['devicename'] . "</option>";
}
echo $options;
?>

									<?php while ($rowz=mysql_fetch_array($sql3s60)) { ?>
										<option style="text-align: Left;" value="<?php echo $rowz['tree_id']?>"><?php echo $rowz['tree_id']?> - <?php echo $rowz['devicename']; echo ' - '.$rowz['d_name']; echo ' - '.$rowz['z_name'];?></option>
									<?php } ?>