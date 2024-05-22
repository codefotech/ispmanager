<?php
include("conn/connection.php");
session_start(); 
extract($_POST); 
$userr_typ = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];

date_default_timezone_set('Etc/GMT-6');
$pay_del_date = date('Y-m-d H:i:s', time());

if($py_id == '')
{}
else{
$result11z = mysql_query("SELECT z_id FROM payment_macreseller WHERE id = '$py_id'");
$rowwww = mysql_fetch_array($result11z);

$z_id = $rowwww['z_id'];

if($userr_typ == 'admin' || $userr_typ == 'superadmin'){

$query2dd ="DELETE FROM payment_macreseller WHERE id = '$py_id'";
$result2dd = mysql_query($query2dd) or die("inser_query failed: " . mysql_error() . "<br />");

if($commission_sts != '0'){
	$queryqq="UPDATE agent_commission SET sts = '1', delete_by = '$e_id', del_date_time = '$pay_del_date' WHERE payment_id = '$py_id'";
	$result2ad = mysql_query($queryqq) or die("inser_query failed: " . mysql_error() . "<br />");

}
?>

<html>
<body>
     <form action="MacResellerPayment?id=<?php echo $z_id; ?>" method="post" name="ok">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php }

else{
	echo 'Worning!! Dont try again.';
}
}

?>