<?php
extract($_POST);
include("conn/connection.php");
include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

if($sms_id != '' || $e_id != ''){
$query5 = mysql_query("SELECT * FROM sms_send WHERE id = '$sms_id'");
$row5 = mysql_fetch_assoc($query5);
		$sms_body= $row5['sms_body'];
		$c_idd= $row5['c_id'];
		$cell= $row5['c_cell'];
		$from_pageee= $row5['from_page'];
		
		
$send_by= $e_id;
$from_page = $from_page.'<br>[Re-Send]';

include('include/smsapicore.php');

$query ="update sms_send set status = '1' WHERE id = '$sms_id'";
$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>

<html>
<body>
     <form action="SMS" method="post" name="done">
       <input type="hidden" name="sts" value="smsresent">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>
<?php } else{ echo 'Wrong Entry!!';} ?>