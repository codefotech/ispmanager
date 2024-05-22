<?php
extract($_POST);
include("conn/connection.php");
include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

if($send_date != '' || $send_by != ''){
		
$send_by= $send_by;
$from_pageee = '[Re-Send]';

$query5 = mysql_query("SELECT id, sms_body, c_id, c_cell, from_page FROM sms_send WHERE send_date = '$send_date' AND api_id = '' AND status = '0'");
								
while( $row5 = mysql_fetch_assoc($query5) ){
$sms_body = $row5['sms_body'];
$c_idd = $row5['c_id'];
$cell = $row5['c_cell'];
$sms_id = $row5['id'];
$from_page = '['.$row5['from_page'].']<br>'.$from_pageee;

$queryd = "UPDATE sms_send SET status = '1' WHERE id = '$sms_id'";
if (!mysql_query($queryd)){die('Error: ' . mysql_error());}

include('include/smsapicore.php');
}
?>


<html>
<body>
     <form action="SMS" method="post" name="done">
       <input type="hidden" name="sts" value="multismsresent">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>
<?php } else{ echo 'Wrong Entry!!';} ?>