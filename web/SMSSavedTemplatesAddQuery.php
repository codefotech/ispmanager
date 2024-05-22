<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

		if ($sms_msg != '' && $template_way == 'add'){
			$query2q ="insert into sms_msg (template_name, template_for, sms_msg, saved_template, date, time) VALUES ('$template_name', '$template_for', '$sms_msg', '1', '$entry_date', '$entry_time')";
					if (!mysql_query($query2q))
					{
					die('Error: ' . mysql_error());
					}
			}
			
		if ($sms_msg != '' && $template_way == 'edit'){
			$queryq ="update sms_msg set template_name = '$template_name', template_for = '$template_for', sms_msg = '$sms_msg' WHERE id = '$tempid'";
					if (!mysql_query($queryq))
					{
					die('Error: ' . mysql_error());
					}
		}

mysql_close($con);
?>

<html>
<body>
     <form action="SMSSavedTemplates" method="post" name="ok">
	 <?php if($template_way == 'edit'){ ?>
       <input type="hidden" name="sts" value="edit">
	 <?php } else{ ?>
       <input type="hidden" name="sts" value="add">
	 <?php }?>
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>