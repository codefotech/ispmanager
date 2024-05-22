<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

extract($_POST);

$query = "DELETE FROM loan_receive WHERE id = '$loan_id'";
					if(!mysql_query($query))
					{
						die('Error: ' . mysql_error());
					}

mysql_close($con);
?>
<html>
<body>
     <form action="Loan" method="post" name="ok">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>