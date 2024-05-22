<?php 
$agent_id=$_GET['agent_id'];

if($agent_id != '0'){
?>

<p>
	<label style="width: 130px;">Manual Commission</label>
	<span class="field" style="margin-left: 0px;"><input type="text" name="com_percent" style="width:10%;" required="" value="0"/><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
</p>
<p>
	<label style="width: 130px;">Count Commission?</label>
	<span class="field" style="margin-left: 0px;">
		<input type="radio" name="count_commission" value="1" checked> Yes &nbsp; &nbsp;
		<input type="radio" name="count_commission" value="0"> No &nbsp; &nbsp;
	</span>
</p>
<?php 
}else{ }
?>