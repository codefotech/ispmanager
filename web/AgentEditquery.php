<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index");
		exit();
	}
	
include("conn/connection.php") ;
extract($_POST);
$tbl_name="agent";

if($e_name != '')
{
$query="UPDATE $tbl_name SET 
		e_name = '$e_name', 
		com_percent = '$com_percent',
		e_f_name = '$e_f_name',
		e_m_name = '$e_m_name',
		e_gender = '$e_gender',
		e_b_date = '$e_b_date',
		e_des = '$e_des',
		pre_address = '$pre_address',
		per_address = '$per_address',
		e_j_date = '$e_j_date',
		married_stu = '$married_stu',
		bgroup = '$bgroup',
		n_id = '$n_id',
		e_cont_per = '$e_cont_per',
		e_cont_office = '$e_cont_office',
		e_cont_family = '$e_cont_family',
		ref_contact1 = '$ref_contact1',
		ref_contact2 = '$ref_contact2',
		email = '$email',
		skype = '$skype',
		e_area = '$e_area'
		WHERE e_id = '$e_id'";

$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
}

else
{
 echo 'Error!! Please Put Employee Id';
}

	
	
mysql_close($con);

?><html><body>     <form action="Agent" method="post" name="ok">       <input type="hidden" name="sts" value="edit">     </form>     <script language="javascript" type="text/javascript">		document.ok.submit();     </script></body></html>