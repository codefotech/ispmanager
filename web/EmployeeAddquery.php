<?php
include("conn/connection.php");
extract($_POST);
$tbl_name1="emp_edu_info";
$date2 =$_POST['e_j_date'];
 //end of image uploading script
 if($e_id != '')
 {	
 if($_FILES['image']['tmp_name'] != ''){ $uploaddir = 'emp_images/'; $uploadfile = $uploaddir . $e_id . '_' . basename($_FILES['image']['name']); move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);}else {	$uploadfile = '';} 
	 $query="insert into emp_info (e_id, e_name, dept_id, e_f_name, e_m_name, e_gender, e_b_date, e_des, e_pe_div, e_pe_dis, e_pe_tha, e_pr_div, e_pr_dis, e_pr_tha, e_j_date, married_stu, e_mar_date, exp1, exp2, exp3, e_cont_per,	e_cont_office, e_cont_family, ref_contact1, ref_contact2, email, skype, e_image, bgroup, n_id, pre_address, per_address, basic_salary, mobile_bill, house_rent, medical, food, others, provident_fund, professional_tax, income_tax, gross_total)
			 VALUES
			 ('$e_id', '$e_name', '$e_dept', '$e_f_name', '$e_m_name', '$e_gender', '$date1', '$e_des', '$e_pe_div', '$e_pe_dis', '$e_pe_tha', '$e_pr_div', '$e_pr_dis', '$e_pr_tha', '$date2', '$married_stu', '$date3', '$exp1', '$exp2', '$exp3', '$e_cont_per', '$e_cont_office', '$e_cont_family', '$ref_contact1', '$ref_contact2', '$email', '$skype', '$uploadfile', '$bgroup', '$n_id', '$pre_address', '$per_address', '$basic_salary', '$mobile_bill', '$house_rent', '$medical', '$food', '$others', '$provident_fund', '$professional_tax', '$income_tax', '$gross_total')";
			 
	 $result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	
	if(empty($_POST['e_id'])||empty($_POST['a'])||(empty($_POST['b'])&&empty($_POST['c']))||empty($_POST['d'])){}
	else
		{
			$query0= "INSERT INTO $tbl_name1 (e_id,edu_fild,edu_inst,edu_group,edu_result)VALUES ('$e_id', '$a', '$b', '$c',  '$d')";
			$sql0 = mysql_query($query0);
		}
	if(empty($_POST['e_id'])||empty($_POST['a1'])||(empty($_POST['b1'])&&empty($_POST['c1']))||empty($_POST['d1'])){}
	
	else
		{
			$query1= "INSERT INTO $tbl_name1 (e_id,edu_fild,edu_inst,edu_group,edu_result)VALUES ('$e_id', '$a1', '$b1', '$c1',  '$d1')";
			$sql1 = mysql_query($query1);
		}
	if(empty($_POST['e_id'])||empty($_POST['a2'])||(empty($_POST['b2'])&&empty($_POST['c2']))||empty($_POST['d2'])){}
	else
		{
			$query2 = "INSERT INTO $tbl_name1 (e_id,edu_fild,edu_inst,edu_group,edu_result)VALUES ('$e_id', '$a2', '$b2', '$c2',  '$d2')";
			$sql2 = mysql_query($query2);
		}
	if(empty($_POST['e_id'])||empty($_POST['a3'])||(empty($_POST['b3'])&&empty($_POST['c3']))||empty($_POST['d3'])){}
	else
		{
			$query3= "INSERT INTO $tbl_name1 (e_id,edu_fild,edu_inst,edu_group,edu_result)VALUES ('$e_id', '$a3', '$b3', '$c3',  '$d3')";
			$sql3 =mysql_query($query3);}
	if(empty($_POST['e_id'])||empty($_POST['a4'])||(empty($_POST['b4'])&&empty($_POST['c4']))||empty($_POST['d4'])){}
	else
		{
			$query4= "INSERT INTO $tbl_name1 (e_id,edu_fild,edu_inst,edu_group,edu_result)VALUES ('$e_id', '$a4', '$b4', '$c4',  '$d4')";
			$sql4 = mysql_query($query4);
		}
	if(empty($_POST['e_id'])||empty($_POST['a5'])||(empty($_POST['b5'])&&empty($_POST['c5']))||empty($_POST['d5'])){}
	else
		{
			$query5= "INSERT INTO $tbl_name1 (e_id,edu_fild,edu_inst,edu_group,edu_result)VALUES ('$e_id', '$a5', '$b5', '$c5',  '$d5')";
			$sql5 = mysql_query($query5);
		}
	if(empty($_POST['e_id'])||empty($_POST['a6'])||(empty($_POST['b6'])&&empty($_POST['c6']))||empty($_POST['d6'])){}
	else
		{
			$query6= "INSERT INTO $tbl_name1 (e_id,edu_fild,edu_inst,edu_group,edu_result)VALUES ('$e_id', '$a6', '$b6', '$c6',  '$d6')";
			$sql6 = mysql_query($query6);
		}
	if(empty($_POST['e_id'])||empty($_POST['a7'])||(empty($_POST['b7'])&&empty($_POST['c7']))||empty($_POST['d7'])){}
	else
		{
			$query7= "INSERT INTO $tbl_name1 (e_id,edu_fild,edu_inst,edu_group,edu_result)VALUES ('$e_id', '$a7', '$b7', '$c7',  '$d7')";
			$sql7 = mysql_query($query7);
		}
	if(empty($_POST['e_id'])||empty($_POST['a8'])||(empty($_POST['b8'])&&empty($_POST['c8']))||empty($_POST['d8'])){}
	else
		{
			$query8= "INSERT INTO $tbl_name1 (e_id,edu_fild,edu_inst,edu_group,edu_result)VALUES ('$e_id', '$a8', '$b8', '$c8',  '$d8')";
			$sql8 = mysql_query($query8);
		}
}
	else
		{
			echo 'Error!! Please Put Employee Id';
		}		
mysql_close($con);
?>


<html>
<body>
     <form action="Employee" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>