<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index");
		exit();
	}
	
include("conn/connection.php");
extract($_POST);
$date2 =$_POST['e_j_date'];
$pass = sha1($passid);
$iddd = date('His');

$results = mysql_query("SELECT id FROM login WHERE user_id='$username'");
$username_exist = mysql_num_rows($results);
if($username_exist == 0){
	if($e_name != '' && $com_percent > 0){
	$sqlc = mysql_query("SELECT id FROM login ORDER BY id DESC LIMIT 1");
	$rowc = mysql_fetch_assoc($sqlc);
	$ee_id = $rowc['id']+5;

	 $queryff="insert into agent (e_id, e_name, com_percent, e_f_name, e_m_name, e_gender, e_b_date, e_des, e_pe_div, e_pe_dis, e_pe_tha, e_pr_div, e_pr_dis, e_pr_tha, e_j_date, married_stu, e_mar_date, exp1, exp2, exp3, e_cont_per,	e_cont_office, e_cont_family, ref_contact1, ref_contact2, email, skype, bgroup, n_id, pre_address, per_address)
			 VALUES
			 ('$ee_id', '$e_name', '$com_percent', '$e_f_name', '$e_m_name', '$e_gender', '$date1', '$e_des', '$e_pe_div', '$e_pe_dis', '$e_pe_tha', '$e_pr_div', '$e_pr_dis', '$e_pr_tha', '$date2', '$married_stu', '$date3', '$exp1', '$exp2', '$exp3', '$e_cont_per', '$e_cont_office', '$e_cont_family', '$ref_contact1', '$ref_contact2', '$email', '$skype', '$bgroup', '$n_id', '$pre_address', '$per_address')";
			 
	 $result = mysql_query($queryff) or die("inser_query failed: " . mysql_error() . "<br />");
	 
	 if($result){
		$queryaa="insert into login (user_name, user_id, password, pw, user_type, e_id, email) VALUES ('$e_name', '$username', '$pass', '$passid', 'agent', '$ee_id', '$email')";
		$resultaa = mysql_query($queryaa) or die("inser_query failed: " . mysql_error() . "<br />");
	 }
	
mysql_close($con);
?>
<html>
<body>
     <form action="Agent" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php
	}
	else{
		echo 'Error!! Please Put Employee Id';
	}
}
else{
	echo 'User Name Already Use Please Try Another';
}?>