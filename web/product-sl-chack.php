<?php 

if($_POST) 
{
include("conn/connection.php");
$slno = $_POST['duration'];
$sqlmk = mysql_query("SELECT id FROM store_instruments_sl WHERE slno = '$slno'");
$rowmk = mysql_fetch_assoc($sqlmk);

		$id = $rowmk['id'];
		if($id == ''){
			$slsts = 'ok';
			echo '<i class="iconfa-ok" style="color: #09c409;margin-left: 5px;margin-top: 4px;"></i>';
//			echo '<img src="images/loaders/loader2.gif" alt="" width="40px" height="20px">';
		}
		else{
			$slsts = 'no';
			echo '<div>
			<select name="" style="height: 1px;border: 0px solid transparent;" required="">
					<option value=""></option>
			</select><i class="iconfa-remove" style="color: red;position: absolute;margin-top: 2px;font-size: 16px;"></i></div>';
		}
}

?>
