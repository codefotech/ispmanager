<?php 
$mk_profile=$_GET['mk_profile'];

if($mk_profile != ''){
?>
<p>
	<label style="font-weight: bold;">Package Name*</label>
	<span class="field"><input style="font-weight: bold;" id="" type="text" name="p_name" class="input-xlarge" value="<?php echo $_GET['mk_profile'];?>" required=""></span>
</p>
<?php 
}else{?>
<p>
	<label style="font-weight: bold;">Package Name*</label>
	<span class="field"><input style="font-weight: bold;" id="" type="text" name="p_name" class="input-xlarge" required=""></span>
</p>
<?php } ?>