<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

		$query ="insert into bank (bank_name, sort_name, emp_id) VALUES ('$bank_name', '$sort_name', '$emp_id')";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		if ($result){
			header('Location: Bank');
		}
		else{
			echo 'Error, Please try again';
		}	

mysql_close($con);
?>

<html>
<body>
     <form action="Bank" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>