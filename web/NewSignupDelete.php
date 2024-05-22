<?php
include("conn/connection.php");
extract($_POST);

	if($signupid != ''){
		$query ="DELETE FROM clients_signup WHERE id = '$signupid'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	}
		else{
				echo 'Error, Please try again';
			}
?>

<html>
<body>
     <form action="NewSignup" method="post" name="ok">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>