<?php
include("conn/connection.php") ;
extract($_POST);
$pass = sha1($passid);

$results = mysql_query("SELECT id FROM login WHERE user_id='$username'");
$username_exist = mysql_num_rows($results);
if($username_exist == 0) {
		if($e_id != '')
		{
		$query="insert into login (user_name, user_id, password, user_type, e_id, email) VALUES ('$emp_name', '$username', '$pass', '$u_type', '$e_id', '$email')";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		$cashbank = 'Cash-'.$username;
		$cashbank1 = 'C-'.$username;
	$querysss="insert into bank (bank_name, sort_name, emp_id) VALUES ('$cashbank', '$cashbank1', '$e_id')";
	$resultsss = mysql_query($querysss) or die("inser_query failed: " . mysql_error() . "<br />");

		
?>
<html>
<body>
     <form action="Users" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>

		<?php
		}
		else
		{
		 echo 'Error!! Please Put Employee Id';
		}
			
		mysql_close($con);
	}
else
	{
		echo 'User Name Already Used. Please Try Another';
	}
?>