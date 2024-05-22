<?php 
$mathod=$_GET['mathod'];
if($mathod == 'Bank'){
?>
	<input type="text" name="ck_trx_no" placeholder="Check No" style="font-weight: bold;width:94%;" required="">
<?php 
} elseif($mathod == 'Online'){ ?>
	<input type="text" name="ck_trx_no" placeholder="Payment TrxID" style="font-weight: bold;width:94%;" required="">
<?php } else{}?>