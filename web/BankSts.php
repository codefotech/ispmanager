<?php
include("conn/connection.php");
extract($_POST);
date_default_timezone_set('Etc/GMT-6');
$delete_date_time = date('Y-m-d H:i:s', time());

	if($bank_id != '' && $bank_sts == '0'){
		$query ="UPDATE bank SET sts = '1' WHERE id = '$bank_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$query1 ="UPDATE payment_mathod SET online = '0' WHERE bank = '$bank_id'";
		$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
		$aaaa = 'Inactivated';
?>
<html>
<body>
     <form action="Bank" method="post" name="ok">
       <input type="hidden" name="sts" value="bsts">
       <input type="hidden" name="aaaa" value="<?php echo $aaaa;?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php	}
	elseif($bank_id != '' && $bank_sts == '1'){
		$query ="UPDATE bank SET sts = '0' WHERE id = '$bank_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$query1 ="UPDATE payment_mathod SET online = '1' WHERE bank = '$bank_id'";
		$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
		$aaaa = 'Activated';
?>
<html>
<body>
     <form action="Bank" method="post" name="ok">
       <input type="hidden" name="sts" value="bsts">
       <input type="hidden" name="aaaa" value="<?php echo $aaaa;?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php	}
	else{
				echo 'Error, Please try again';
		}
?>
