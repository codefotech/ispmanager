<?php
include("conn/connection.php");
session_start(); 
$e_id = $_SESSION['SESS_EMP_ID'];
$userr_typ = $_SESSION['SESS_USER_TYPE'];
extract($_POST); 

date_default_timezone_set('Etc/GMT-6');
$pay_del_date = date('Y-m-d H:i:s', time());

if (empty($py_id))
{}
else{
$result11z = mysql_query("SELECT id, c_id, pay_date, pay_amount, pay_mode, bill_discount, pay_desc, pay_ent_date, pay_ent_by FROM payment_mac_client WHERE id = '$py_id'");
$rowwww = mysql_fetch_array($result11z);

$pay_id = $rowwww['id'];
$c_id = $rowwww['c_id'];
$pay_date = $rowwww['pay_date'];
$pay_amount = $rowwww['pay_amount'];
$pay_mode = $rowwww['pay_mode'];
$bill_discount = $rowwww['bill_discount'];
$pay_desc = $rowwww['pay_desc'];
$pay_ent_date = $rowwww['pay_ent_date'];
$pay_ent_by = $rowwww['pay_ent_by'];

if($userr_typ == 'mreseller'){

$query2d ="insert into payment_mac_delete (pay_id, c_id, pay_date, pay_amount, pay_mode, bill_discount, pay_desc, pay_ent_date, pay_ent_by, pay_del_date, pay_del_by) VALUES ('$pay_id', '$c_id', '$pay_date', '$pay_amount', '$pay_mode', '$bill_discount', '$pay_desc', '$pay_ent_date', '$pay_ent_by', '$pay_del_date', '$e_id')";
$result2d = mysql_query($query2d) or die("inser_query failed: " . mysql_error() . "<br />");

if($query2d){
$query2dd ="DELETE FROM payment_mac_client WHERE id = '$py_id'";
$result2dd = mysql_query($query2dd) or die("inser_query failed: " . mysql_error() . "<br />");
}

?>

<html>
<body>
     <form action="BillPaymentView?id=<?php echo $c_id; ?>" method="post" name="ok">
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