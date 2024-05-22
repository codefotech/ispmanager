
<?php
session_start();
include("conn/connection.php");
include('company_info.php');

if($external_online_link == '1'){
$cid = isset($_GET['cid']) ? $_GET['cid'] : '';

if($cid != ''){
?>
<html>
	<body>
	<form action="PaymentOnlineExternal" method="post" name="ok">
		<input type="hidden" name="clientid" value="<?php echo $cid;?>">
	</form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
	</body>
</html>
<?php }} else{echo 'File not found.';} ?>