<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

extract($_POST);

	$Password = openssl_encrypt($mk_pass, 'AES-256-CBC', $secret_h);

if ($ServerIP != '' || $mk_username != '' || $Password != ''){
	if($web_port == ''){
		$graphhh = '0';
	}
	else{
		$graphhh = $graph;
	}
	
	$query ="update mk_con set Name = '$Name', ServerIP = '$ServerIP', Username = '$mk_username', auto_client_mk_sts = '$auto_client_mk_sts', auto_sync_sts = '$auto_sync_sts', Pass = '$Password', note = '$note', edit_by = '$edit_by', edit_date_time = '$edit_date_time', graph = '$graphhh', web_port = '$web_port', tx_rx_count_sts = '$tx_rx_count_sts', online_count_sts = '1' WHERE id = '$mk_id'";
	$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
}
mysql_close($con);
?>

<html>
	<body> 
		<form action="Network" method="post" name="ok">
			<input type="hidden" name="sts" value="edit">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>