<?php 
$mathod=$_GET['mathod'];

if($mathod == 'Bank' || $mathod == 'Online'){
?>


<p>
	<label>Check/Trx No</label>
	<span class="field"><input type="text" name="ck_trx_no" class="input-xlarge" required=""/></span>
</p>

<?php 
}else{?>
<?php }
?>