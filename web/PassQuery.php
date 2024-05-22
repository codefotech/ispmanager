<?php
include("conn/connection.php") ;
extract($_POST);
$pass = sha1($new_pass);
$pass1 = sha1($conf_pass);

$tbl_name1="login";

//echo $id;

if($pass == $pass1)
{
	$query="UPDATE $tbl_name1 SET password = '$pass' WHERE e_id= '$e_id'";
	$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	if ($result)
		{
			header('Location: EditProfile');
		}
	else
		{
			echo 'Error, Please try again';
		}
}
else
{
 echo 'Opps!! Password does not Match Please Try Again';
}	


mysql_close($con);

?>