<?php
include("conn/connection.php") ;
extract($_POST);
$tbl_name="emp_info";
$tbl_name1="emp_edu_info";
//date formate chenge

$date1 =$_POST['e_b_date'];
//$new_date1 = date("Y-m-d", strtotime($date1));

$date2 =$_POST['e_j_date'];
//$new_date2 = date("Y-m-d", strtotime($date2));

$date3 =$_POST['e_mar_date'];
//$new_date3 = date("Y-m-d", strtotime($date3));

$date4 =$_POST['e_s_date'];
//$new_date4 = date("Y-m-d", strtotime($date4));

$date5 =$_POST['e_c1_date'];
//$new_date5 = date("Y-m-d", strtotime($date5));

$date6 =$_POST['e_c2_date'];
//$new_date6 = date("Y-m-d", strtotime($date6));

$date7 =$_POST['e_c3_date'];
//$new_date7 = date("Y-m-d", strtotime($date7));

if($e_id != '')
{
$query="UPDATE $tbl_name SET 
		e_name = '$e_name', 
		dept_id = '$e_dept',
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
		exp1 = '$exp1',
		exp2 = '$exp2',
		exp3 = '$exp3',
		e_cont_per = '$e_cont_per',
		e_cont_office = '$e_cont_office',
		e_cont_family = '$e_cont_family',
		ref_contact1 = '$ref_contact1',
		ref_contact2 = '$ref_contact2',
		email = '$email',
		skype = '$skype',
		e_area = '$e_area',
		basic_salary = '$basic_salary',
		mobile_bill = '$mobile_bill',
		house_rent = '$house_rent',
		medical = '$medical',
		food = '$food',
		others = '$others',
		provident_fund = '$provident_fund',
		professional_tax = '$professional_tax',
		income_tax = '$income_tax',
		gross_total = '$gross_total'
		WHERE e_id = '$e_id' ";

$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
if(empty($_POST['e_id'])
||empty($_POST['a1'])
||(empty($_POST['b1'])
&&empty($_POST['c1']))
||empty($_POST['d1']))
{}
else
{
$query1= "UPDATE $tbl_name1 SET
edu_fild = '$a1',
edu_inst = '$b1',
edu_group = '$c1',
edu_result = '$d1'
WHERE id = '$id1' ";

$sql1 =mysql_query($query1);

}

if(empty($_POST['e_id'])
||empty($_POST['a2'])
||(empty($_POST['b2'])
&&empty($_POST['c2']))
||empty($_POST['d2']))
{}
else
{
$query2= "UPDATE $tbl_name1 SET
edu_fild = '$a2',
edu_inst = '$b2',
edu_group = '$c2',
edu_result = '$d2'
WHERE id = '$id2' ";

$sql2 =mysql_query($query2);

}

if(empty($_POST['e_id'])
||empty($_POST['a3'])
||(empty($_POST['b3'])
&&empty($_POST['c3']))
||empty($_POST['d3']))
{}
else
{
$query3= "UPDATE $tbl_name1 SET
edu_fild = '$a3',
edu_inst = '$b3',
edu_group = '$c3',
edu_result = '$d3'
WHERE id = '$id3' ";

$sql3 =mysql_query($query3);

}

if(empty($_POST['e_id'])
||empty($_POST['a4'])
||(empty($_POST['b4'])
&&empty($_POST['c4']))
||empty($_POST['d4']))
{}
else
{
$query4= "UPDATE $tbl_name1 SET
edu_fild = '$a4',
edu_inst = '$b4',
edu_group = '$c4',
edu_result = '$d4'
WHERE id = '$id4' ";

$sql4 =mysql_query($query4);

}

if(empty($_POST['e_id'])
||empty($_POST['a5'])
||(empty($_POST['b5'])
&&empty($_POST['c5']))
||empty($_POST['d5']))
{}
else
{
$query5= "UPDATE $tbl_name1 SET
edu_fild = '$a5',
edu_inst = '$b5',
edu_group = '$c5',
edu_result = '$d5'
WHERE id = '$id5' ";

$sql5 =mysql_query($query5);

}


if(empty($_POST['e_id'])
||empty($_POST['a6'])
||(empty($_POST['b6'])
&&empty($_POST['c6']))
||empty($_POST['d6']))
{}
else
{
$query6= "INSERT INTO $tbl_name1 (
e_id,
edu_fild,
edu_inst,
edu_group,
edu_result
)
VALUES (
'$e_id',
 '$a6',
 '$b6',
 '$c6', 
 '$d6'
)";

$sql6 =mysql_query($query6);

}

if(empty($_POST['e_id'])
||empty($_POST['a7'])
||(empty($_POST['b7'])
&&empty($_POST['c7']))
||empty($_POST['d7']))
{}
else
{
$query7= "INSERT INTO $tbl_name1 (
e_id,
edu_fild,
edu_inst,
edu_group,
edu_result
)
VALUES (
'$e_id',
 '$a7',
 '$b7',
 '$c7', 
 '$d7'
)";

$sql7 =mysql_query($query7);

}

if(empty($_POST['e_id'])
||empty($_POST['a8'])
||(empty($_POST['b8'])
&&empty($_POST['c8']))
||empty($_POST['d8']))
{}
else
{
$query8= "INSERT INTO $tbl_name1 (
e_id,
edu_fild,
edu_inst,
edu_group,
edu_result
)
VALUES (
'$e_id',
 '$a8',
 '$b8',
 '$c8', 
 '$d8'
)";

$sql8 =mysql_query($query8);

}


}

else
{
 echo 'Error!! Please Put Employee Id';
}

	
	
mysql_close($con);

?><html><body>     <form action="Employee" method="post" name="ok">       <input type="hidden" name="sts" value="edit">     </form>     <script language="javascript" type="text/javascript">		document.ok.submit();     </script></body></html>