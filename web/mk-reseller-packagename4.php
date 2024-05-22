<?php 
include("conn/connection.php");
$mk_profile=$_GET['mk_profile'];

if($mk_profile != ''){
?>
	<input type="text" name="p_name4" id="" placeholder="Ex: Package-1" style="width: 90%;font-weight: bold;" required="" value="<?php echo $_GET['mk_profile'];?>"/>
<?php 
}else{?>
	<input type="hidden" name="p_name4" class="input-xlarge" value="" required=""/>
<?php }
?>