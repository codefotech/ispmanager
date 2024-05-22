<?php 
$mathod=$_GET['mathod'];

if($mathod == 'Bank'){
?>
<p>
	<label>Check No*</label>
	<span class="field"><input type="text" placeholder="Check No" name="ck_trx_no" style="width:19.2%;" required=""/></span>
</p>

<?php 
}
elseif($mathod == 'Online'){ ?>
<p>
<label>Gateway*</label>
<span class="field">
	<select class="chzn-select" name="gateway" style="width:20%;" required=""> 
		<option value="bKash">bKash</option>
		<option value="Rocket">Rocket</option>
		<option value="Nagad">Nagad</option>
		<option value="iPay">iPay</option>
		<option value="uCash">uCash</option>
	</select>
</span>
</p>
<p>
	<label>Sender No*</label>
	<span class="field"><input type="text" placeholder="Sender No" name="sender_no"  style="width:10%;" required=""/><input type="text" placeholder="TrxID" name="ck_trx_no"  style="width:10%;margin-left: 1%;" required=""/></span>
</p>

<?php } else{}?>