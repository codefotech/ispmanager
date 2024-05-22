<?php
include("conn/connection.php");
extract($_POST); 
$todayeeee = date('Y-m-d', time());

$result11z = mysql_query("SELECT id, c_id, end_date, start_date, days, p_price, bill_amount FROM billing_mac WHERE id = '$bill_id'");
$rowwww = mysql_fetch_array($result11z);

$pay_id = $rowwww['id'];
$c_id = $rowwww['c_id'];
$start_date = $rowwww['start_date']; //2020-03-16
$end_date = $rowwww['end_date']; // 2020-03-31
$p_price = $rowwww['p_price']; // 240.00
$days = $rowwww['days']; // 15day
$bill_amount = $rowwww['bill_amount']; // 120.00

$result11tz = mysql_query("SELECT id FROM billing_mac WHERE c_id = '$c_id' ORDER BY id DESC LIMIT 1");
$rowwwwdd = mysql_fetch_array($result11tz);
$pay_idddd = $rowwwwdd['id'];

if($pay_id == $pay_idddd && $usertype == 'superadmin' || $usertype == 'admin'){

if($todayeeee >= $start_date && $todayeeee < $end_date){
	
	if($todayeeee == $start_date){
$diff = 1;
$gdgdfdg = date('Y-m-d', strtotime($todayeeee . " + 1 day"));
	}else{
$diff = (abs(strtotime($todayeeee) - strtotime($start_date))/86400)+1; //9day
$gdgdfdg = date('Y-m-d', strtotime($todayeeee . " + 1 day"));	}
$new_amount = ($bill_amount/$days)*$diff;

$queryq ="UPDATE billing_mac SET end_date = '$gdgdfdg', days = '$diff', bill_amount = '$new_amount' WHERE id = '$bill_id'";
							if (!mysql_query($queryq))
							{
							die('Error: ' . mysql_error());
							}

$queryqww ="UPDATE clients SET termination_date = '$gdgdfdg', con_sts_date = '$todayeeee' WHERE c_id = '$c_id'";
							if (!mysql_query($queryqww))
							{
							die('Error: ' . mysql_error());
							}
?>
<html>
<body>
     <form action="MacResellerClientBillHistory" method="post" name="ok">
       <input type="hidden" name="sts" value="delete">
	   <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php }
else{
	
if($todayeeee < $start_date){
$diff = abs(strtotime($todayeeee) - strtotime($start_date))/86400; //9day
$new_amount = ($bill_amount/$days)*$diff;

$query2dd ="DELETE FROM billing_mac WHERE id = '$bill_id'";
$result2dd = mysql_query($query2dd) or die("inser_query failed: " . mysql_error() . "<br />");

$resuly1tz = mysql_query("SELECT end_date FROM billing_mac WHERE c_id = '$c_id' ORDER BY id DESC LIMIT 1");
$rowwwwttdd = mysql_fetch_array($resuly1tz);
$new_end_date = $rowwwwttdd['end_date'];


$queryqww ="UPDATE clients SET termination_date = '$new_end_date', con_sts_date = '$todayeeee' WHERE c_id = '$c_id'";
							if (!mysql_query($queryqww))
							{
							die('Error: ' . mysql_error());
							}
?>
<html>
<body>
     <form action="MacResellerClientBillHistory" method="post" name="ok">
       <input type="hidden" name="sts" value="delete">
	   <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php }
else{ ?>
<html>
<body>
     <form action="MacResellerClientBillHistory" method="post" name="ok">
       <input type="hidden" name="sts" value="sorry">
	   <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php }}}
else{ ?>
<html>
<body>
     <form action="MacResellerClientBillHistory" method="post" name="ok">
       <input type="hidden" name="sts" value="sorry">
	   <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php } ?>
