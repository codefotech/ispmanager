<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

if($wayyy == 'add'){
	if(empty($_POST['ex_type']) || empty($_POST['ex_des']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
			$query="insert into expanse_type (ex_type, ex_des)
					VALUES ('$ex_type', '$ex_des')";
					
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
			if ($result){ ?>
<html>
<body>
     <form action="ExpenseType" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
				<?php }
			else{
					echo 'Error, Please try again';
				}
		}
mysql_close($con);
}

if($wayyy == 'delete'){
		if(empty($_POST['e_id'])){
			echo 'Sorry... You are not permitted.';
		}
else{
		$query ="UPDATE expanse_type SET status = '1', delete_by = '$e_id' WHERE id = '$ex_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	if($result){ ?>
<html>
<body>
     <form action="ExpenseType" method="post" name="ok">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
				<?php }
			else{
					echo 'Error, Please try again';
				}
}}

if($wayyy == 'edit_type'){
		if(empty($_POST['edit_by']) || empty($_POST['old_expence_type']) || empty($_POST['ex_type'])){
			echo 'Sorry... You are not permitted.';
		}
else{
		$query ="UPDATE expanse_type SET ex_type = '$ex_type', ex_des = '$ex_des', edit_by = '$edit_by', old_expence_type = '$old_expence_type' WHERE id = '$ex_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	if($result){ ?>
<html>
<body>
     <form action="ExpenseType" method="post" name="ok">
       <input type="hidden" name="sts" value="edit">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
				<?php }
			else{
					echo 'Error, Please try again';
				}
}}
?>