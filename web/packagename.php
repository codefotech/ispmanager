<?php 
include("conn/connection.php");
$mk_profile=$_GET['mk_profile'];

if($mk_profile != ''){
?>
<p>
	<label style="font-weight: bold;">Package Name*</label>
	<span class="field">
		<input type="text" name="p_name" id="" placeholder="Ex: Package-1" class="input-xlarge" required="" value="<?php echo $_GET['mk_profile'];?>"/>
	</span>
</p>

<?php 
}else{?>
	<input type="hidden" name="p_name" class="input-xlarge" value="" required=""/>
<?php }
?>