<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
$e_id = $_SESSION['SESS_EMP_ID'];
$user_type = $_SESSION['SESS_USER_TYPE'];
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
date_default_timezone_set('Etc/GMT-6');
$delete_date_time = date('Y-m-d H:i:s', time());
$id = $_GET['id'];
extract($_POST); 

$queryaaaa = mysql_query("SELECT COUNT(id) AS packclientcount FROM clients WHERE p_id = '$id' AND sts = '0'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);
									$packclientcount = $rowaaaa['packclientcount'];
if($packclientcount == '0' && $user_type == 'admin' || $packclientcount == '0' && $user_type == 'superadmin'){

	if($id != ''){
		$query ="UPDATE package SET status = '1', delete_date_time = '$delete_date_time', delete_by = '$e_id' WHERE p_id = '$id'";
		
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	}
		else{
				echo 'Error, Please try again';
		}?>
<html>
<body>
     <form action="Package" method="post" name="ok">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>

<?php }
else{
	echo $packclientcount.' clients found in this package. Not possible to delete at this time.';
}
?>

