<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

$e_Md = "AES-256-CBC";
$secret_h = sha1($add_date_time);

	$Password = openssl_encrypt($mk_pass, $e_Md, $secret_h);

		if ($ServerIP != '' || $mk_username != '' || $Password != '' || $Name != ''){
				if($web_port == ''){
					$graphhh = '0';
				}
				else{
					$graphhh = $graph;
				}
				$query2q ="insert into mk_con (Name, ServerIP, Username, Pass, Port, secret_h, e_Md, graph, web_port, auto_sync_sts, auto_client_mk_sts, note, add_date_time, add_by) VALUES ('$Name', '$ServerIP', '$mk_username', '$Password', '110', '$secret_h', '$e_Md', '$graphhh', '$web_port', '$auto_sync_sts', '$auto_client_mk_sts', '$note', '$add_date_time', '$add_by')";
					if (!mysql_query($query2q))
					{
					die('Error: ' . mysql_error());
					}
			}
			
mysql_close($con);
?>

<html>
<body>
     <form action="Network" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>