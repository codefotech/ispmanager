<?php
include("conn/connection.php") ;
extract($_POST);
$tbl_name1="login";

//echo $id;
//Start of image uploading script

$uploaddir = 'emp_images/';
		$uploadfile = $uploaddir . basename($_FILES['image']['name']);		
		move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);

//end of image uploading script

if($e_id != '')
{
	$query="UPDATE $tbl_name1 SET image = '$uploadfile' WHERE e_id= '$e_id'";
	
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
 echo 'Error!! Please Put Employee Id';
}	


mysql_close($con);

?>