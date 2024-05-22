<?php
include("conn/dbconfig.php");
extract($_POST); 
if($way == 'signup'){
					$query = "DELETE FROM bill_signup WHERE id = '$idd'";
}

if($way == 'extra'){
					$query = "DELETE FROM bill_extra WHERE id = '$idd'";
}
					if(!mysql_query($query))
					{
						die('Error: ' . mysql_error());
					}
					else{ ?>
<html>
<body>
<form action="SignupBill" method="post" name="ok">
	<input type="hidden" name="sts" value="delete">
</form>
<script language="javascript" type="text/javascript">
		document.ok.submit();
</script>
</body>
</html>
<?php } ?>

