<?php
include("conn/connection.php") ;
extract($_POST);
$tbl_name="emp_info";
if($minimum_day > '0'){
$y = date("Y");
$m = date("m");
$dat = $y.$m;

$sql = ("SELECT id FROM emp_info ORDER BY id DESC LIMIT 1");
		$query2 = mysql_query($sql);
		$row = mysql_fetch_assoc($query2);
		$old_id = $row['id'];
		if($old_id == ''){
			$new_id = $dat.'1';
		}
		else{
			$new = $old_id + 1;
			$new_id = $dat.$new;
		}

if($_FILES['image']['tmp_name'] != ''){
$uploaddir = 'emp_images/';
		$uploadfile = $uploaddir . $new_id . '_' . basename($_FILES['image']['name']);		
		move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);

$query22="UPDATE emp_info SET e_image = '$uploadfile' WHERE id = '$id'";
$result2 = mysql_query($query22) or die("inser_query failed: " . mysql_error() . "<br />");

$query33 ="UPDATE login set image = '$uploadfile' WHERE e_id = '$e_id'";
$result233 = mysql_query($query33) or die("inser_query failed: " . mysql_error() . "<br />");

}
if($default_logo == '0'){
$uploadfilem = 'images/logo.png';

$query22m="UPDATE emp_info SET reseller_logo = '$uploadfilem', default_logo = '$default_logo' WHERE id = '$id'";
$result2m = mysql_query($query22m) or die("inser_query failed: " . mysql_error() . "<br />");
}
else{
if($_FILES['reseller_logo']['tmp_name'] != ''){
$uploaddirm = 'emp_images/';
		$uploadfilem = $uploaddirm . $new_id . '_' . basename($_FILES['reseller_logo']['name']);		
		move_uploaded_file($_FILES['reseller_logo']['tmp_name'], $uploadfilem);

$query22m="UPDATE emp_info SET reseller_logo = '$uploadfilem', default_logo = '1' WHERE id = '$id'";
$result2m = mysql_query($query22m) or die("inser_query failed: " . mysql_error() . "<br />");
}
else{
$uploadfilem = 'images/logo.png';

$query22m="UPDATE emp_info SET reseller_logo = '$uploadfilem', default_logo = '$default_logo' WHERE id = '$id'";
$result2m = mysql_query($query22m) or die("inser_query failed: " . mysql_error() . "<br />");
}
}

$minimum_dayss = implode(',', $_POST['minimum_days']);
$minimum_days_array = explode(',',$minimum_dayss);
$trimSpaces = array_map('trim',$minimum_days_array);
asort($trimSpaces);
$minimum_days_arrays = implode(',',$trimSpaces);

//echo $minimum_days_arrays;
 if($e_id != '')
{
$query="UPDATE emp_info SET 
		e_name = '$e_name',
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
		last_id = '$last_id',
		billing_type = '$billing_type',
		over_due = '$over_due',
		minimum_day = '$minimum_day',
		minimum_days = '$minimum_days_arrays',
		minimum_sts = '$minimum_sts',
		auto_recharge = '$auto_recharge',
		prefix = '$prefix',
		com_percent = '$com_percent',
		count_commission = '$count_commission',
		agent_id = '$agent_id'
		WHERE id = '$id'";

$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
}

else
{
 echo 'Error!! Please Put Employee Id';
}

	
	
mysql_close($con);

?><html><body>     <form action="MacReseller" method="post" name="ok">       <input type="hidden" name="sts" value="edit">     </form>     <script language="javascript" type="text/javascript">		document.ok.submit();     </script></body></html>
<?php } else{ echo 'Minimum Recharge Day are Invalid';}?>