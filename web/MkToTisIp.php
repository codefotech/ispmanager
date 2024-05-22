<?php
include("conn/connection.php") ;
extract($_POST);

		if($c_id != ''){
			$query="UPDATE clients SET ip = '$ip' WHERE c_id = '$c_id'";
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		}
		else{
			echo 'Invilade Id';
		}
echo '<script type="text/javascript">window.close()</script>';
?>
