<?php 
include("conn/connection.php");
$p_id=$_GET['p_id'];
$resultwwdd=mysql_query("SELECT id, sl_sts, pro_name, unit FROM product WHERE sts = '0' AND id = '$p_id'");
$rowmkdd = mysql_fetch_assoc($resultwwdd);
$sl_sts = $rowmkdd['sl_sts'];
$p_name = $rowmkdd['pro_name'];
$unit = $rowmkdd['unit'];


if($sl_sts == '1'){ 
$resultww=mysql_query("SELECT s.id, s.slno, s.in_id, i.unite_price, i.p_sts, i.brand FROM store_instruments_sl AS s
LEFT JOIN store_in_instruments AS i ON s.in_id = i.in_id

WHERE s.out_sts = '0' AND s.sts = '0' AND i.p_id = '$p_id' AND s.p_id = '$p_id' ORDER BY s.id ASC");
?>
<p>	
	<label style="font-weight: bold;"><?php echo $p_name;?> S/L No*</label>
	<select data-placeholder="" name="p_sl_no" class="chzn-select" required="" style="width:400px;" >
		<option value=""></option>
			<?php $aa = '1'; while ($rowee=mysql_fetch_array($resultww)) { ?>
		<option value="<?php echo $rowee['slno'];?>"><?php echo $aa; ?>. <?php echo $rowee['slno'];?> - <?php echo $rowee['brand'];?> (<?php echo $rowee['p_sts'];?>) <?php echo $rowee['unite_price'];?>TK</option>
			<?php $aa++;} ?>
	</select>
</p>

<p>
	<label style="font-weight: bold;">Quantity*</label>
	<span class="field"><input type="text" name="qty" style="width: 50px;" id="" readonly value="1" required="" class="input-large" />&nbsp;&nbsp;<b><?php echo $unit;?></b></span>
</p>

<?php } else{ ?>

<p>
	<label style="font-weight: bold;">Quantity*</label>
	<span class="field"><input type="text" name="qty" style="width: 100px;" id="" required="" class="input-large" />&nbsp;&nbsp;<b><?php echo $unit;?></b></span>
</p>
<?php } ?>