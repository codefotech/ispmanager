<?php
include("conn/connection.php");
extract($_POST);

$sqlmk = mysql_query("SELECT e_id, user_type FROM login WHERE e_id = '$e_id'");
$rowmk = mysql_fetch_array($sqlmk);
$e_iddd = $rowmk['e_id'];
$user_typeee = $rowmk['user_type'];

if($user_typeee=='admin' || $user_typeee=='superadmin'){
		$query ="UPDATE vendor_bill SET sts = '1', delete_by = '$e_id' WHERE id = '$vp_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result){
				?>
						<html>
							<body>
							<form action="VendorBill" method="post" name="ok">
								<input type="hidden" name="sts" value="delete">
							</form>
							<script language="javascript" type="text/javascript">
								document.ok.submit();
							</script>
							</body>
						</html>
			<?php }
		else
			{
				echo 'Error Code 101';
			}
}
mysql_close($con);
?>