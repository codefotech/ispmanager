<?php 
$agent_id=$_GET['agent_id'];

if($agent_id != '0'){
?>

<p>
	<label>Manual Commission</label>
	<span class="field"><input type="text" name="com_percent" style="width:5%;" required="" value="0"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 15px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
</p>
<p>
	<label>Count Commission?</label>
	<span class="formwrapper">
		<input type="radio" name="count_commission" value="1" checked> Yes &nbsp; &nbsp;
		<input type="radio" name="count_commission" value="0"> No &nbsp; &nbsp;
	</span>
</p>
<?php 
}else{ }
?>