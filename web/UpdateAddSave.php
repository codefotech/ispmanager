<?php
include("conn/connection.php");
include('include/smsapi.php');
include('company_info.php');

mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

if ($publish_status=='Yes'){
$sql2 ="SELECT id, position FROM updates order by id desc limit 1";
$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$pos = $row2['position'];
if ($pos=='0'){$pos='1';} else{$pos='0';};}
else{$pos='0';}

$query ="insert into updates (update_subject, update_desc, update_time, update_by, publish_time, position, new, version, publish_status) VALUES ('$update_subject', '$update_desc', '$update_time', '$update_by', '$publish_time', '$pos', '$new', '$version', '$publish_status')";
$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");


//SMS Start....
if($sentsms=='Yes'){
	
$send_date = date("Y-m-d");
$send_time = date("H:i:s");
		
$sms_body='Version v'.$version.'.
New update has been made in your application.

Update: '.$update_subject.' at '.$update_time.'.

Please check & find bugs.

Thanks
'.$update_by.'
Admin';

$from_page = 'Admin Update';
$c_idd = $tis_id;
$cell = $copmaly_boss;

include('include/smsapicore.php');
}

//SMS END....
?>

<html>
<body>
     <form action="Update" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>